<?php
/* 
member update profile
*/

use yii\base\ErrorException;


/*** initialize ***/
$data = array();
$data['error'] = '';
$request = array();
$request['server'] = json_encode($_SERVER);
$request['get'] = json_encode($_GET);
$request['post'] = json_encode($_POST);
$inputs = array();

//Yii::$app->AccessMod->sendEmail('notification@sqmproperty.co.id', array('support@forefront.com.my'), 'SQM Debug', var_export($_POST,true));


/*** create Log API ***/
$logapi = Yii::$app->AccessMod->LogAPI('', 'get-default-sqm-associate', $request, '', '');
if(isset($logapi['error']))
$data['error'] = '0000-'.$logapi['error'];

//get default sqm associate
if(!strlen($data['error']))
{
	$user = Yii::$app->AccessRule->authenticateUserByUUID($_SESSION['settings']['AUTO_ASSIGN_PROSPECT_TO_MEMBER'],false);

	if(!$user)
	$data['error'] = '0001-Please set Auto Assign Prospect To Associate. For more information please contact system administrator. (Error - '.Yii::$app->AccessRule->errorMessage.')';
}

//check user group
if(!strlen($data['error']))
{
	$groups = Yii::$app->AccessRule->getUserGroups($user['id']);
	
	if(!$groups)
	$data['error'] = '0002-'.Yii::$app->AccessRule->errorMessage;
	else
	{
		if(count($groups)==0)
		$data['error'] = '0003-Invalid group';
		else
		{
			if(!in_array(11, $groups))
			$data['error'] = '0004-Invalid associate group';
		}
	}
}

//process
if(!strlen($data['error']))
{
	$result = Yii::$app->MemberMod->memberProfile($inputs,$user['id'],$user['id']);
	
	if(!$result)
	$data['error'] = '0005-'.Yii::$app->MemberMod->errorMessage;
}


//format response
if(!strlen($data['error']))
{
	$data['success'] = true;
	$data['profile'] = $result;
}

//update log api
if(!strlen($data['error']))
{
$logapi = Yii::$app->AccessMod->LogAPI($logapi['logAPI']['id'], 'get-default-sqm-associate', $request, json_encode($data), $user['id']);
if(isset($logapi['error']))
$data['error'] = '0000-'.$logapi['error'];
}

//debug mode
if(isset($_REQUEST['debug_mode']))
{
	if(strtolower($_REQUEST['debug_mode'])=='true')
	{
		echo '<pre>';
		print_r($data);
		echo '</pre>';
		exit();
	}
}
/*
if(strlen($data['error']))
{
	ob_start();
	echo '<pre>';
	print_r($_REQUEST);
	print_r($data);
	echo '</pre>';
	$message = ob_get_clean();

	Yii::$app->AccessMod->sentNotification($_SESSION['settings']['SITE_NAME'].' Error : Customer Points History Notification', $message);
}
*/
//return response
header("Content-type:application/json");
echo json_encode($data);


?>