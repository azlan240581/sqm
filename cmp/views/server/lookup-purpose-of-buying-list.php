<?php
/* 
member points
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
$logapi = Yii::$app->AccessMod->LogAPI('', 'lookup-purpose-of-buying-list', $request, '', '');
if(isset($logapi['error']))
$data['error'] = '0000-'.$logapi['error'];

//validate
if(!strlen($data['error']) and empty($_REQUEST['site_password']))
$data['error'] = '0001-Invalid request';
else
{
	if($_REQUEST['site_password'] != $_SESSION['settings']['SITE_PASSWORD'])
	$data['error'] = '0002-Invalid request';
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

//process
if(!strlen($data['error']))
{
	$result = Yii::$app->AccessMod->getLookupData('lookup_purpose_of_buying');
	$data['data'] = $result;
	
	if(!$result)
	$data['error'] = '0008-'.Yii::$app->AccessMod->errorMessage;
}


//update log api
if(!strlen($data['error']))
{
$logapi = Yii::$app->AccessMod->LogAPI($logapi['logAPI']['id'], 'lookup-purpose-of-buying-list', $request, json_encode($data), 1);
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