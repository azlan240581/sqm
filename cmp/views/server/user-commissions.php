<?php
/* 
user-commissions
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

/*** create Log API ***/
$logapi = Yii::$app->AccessMod->LogAPI('', 'user-commissions', $request, '', '');
if(isset($logapi['error']))
$data['error'] = '0000-'.$logapi['error'];

//validate access
if(isset($_REQUEST['uuid']))
{
	if(!strlen($data['error']) && !strlen($_REQUEST['uuid']))
	$data['error'] = '0001-Unauthorized access.';
}
else
{
	if(!strlen($data['error']) && (!isset($_REQUEST['username']) or !isset($_REQUEST['password'])))
	$data['error'] = '0002-Unauthorized access.';
	
	if(!strlen($data['error']) and (!strlen($_REQUEST['username']) or !strlen($_REQUEST['password'])) )
	$data['error'] = '0003-Unauthorized access.';
}

if(!strlen($data['error']))
{
	if(isset($_REQUEST['uuid']))
	$user = Yii::$app->AccessRule->authenticateUserByUUID($_REQUEST['uuid'],false);
	else
	$user = Yii::$app->AccessRule->authenticateUser($_REQUEST['username'],$_REQUEST['password'],false);
	
	if(!$user)
	$data['error'] = '0004-'.Yii::$app->AccessRule->errorMessage;
}

//check user group
if(!strlen($data['error']))
{
	$groups = Yii::$app->AccessRule->getUserGroups($user['id']);
	
	if(!$groups)
	$data['error'] = '0005-'.Yii::$app->AccessRule->errorMessage;
	else
	{
		if(count($groups)==0)
		$data['error'] = '0006-Invalid group';
		else
		{
			if(!array_intersect(array(7,8,9,10,11), $groups))
			$data['error'] = '0007-Invalid group';
		}
	}
}

//process
if(!strlen($data['error']))
{
	$result = Yii::$app->CommissionMod->getUserCommissions($user['id']);
	
	if(!$result)
	$data['error'] = '0008-'.Yii::$app->CommissionMod->errorMessage;
}

//process
if(!strlen($data['error']))
{
	$transactions = Yii::$app->CommissionMod->getUserCommissionsTransaction($user['id']);
	
	//if(!$result2)
	//$data['error'] = '0009-'.Yii::$app->CommissionMod->errorMessage;
}

//format response
if(!strlen($data['error']))
{
	$data['commissions'] = $result;
	$data['transactions'] = $transactions;
}

//update log api
if(!strlen($data['error']))
{
$logapi = Yii::$app->AccessMod->LogAPI($logapi['logAPI']['id'], 'user-commissions', $request, json_encode($data), $user['id']);
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