<?php
/* 
member email verification
*/

use yii\base\ErrorException;
use app\models\Users;
use app\models\UserGroups;
use app\models\MemberLeads;


/*** initialize ***/
$data = array();
$data['error'] = '';
$request = array();
$request['server'] = json_encode($_SERVER);
$request['get'] = json_encode($_GET);
$request['post'] = json_encode($_POST);
$inputs = array();

/*** create Log API ***/
$logapi = Yii::$app->AccessMod->LogAPI('', 'member-email-verification', $request, '', '');
if(isset($logapi['error']))
$data['error'] = '0000-'.$logapi['error'];

/*** validate inputs and capture ***/
if(!strlen($data['error']))
{
	try
	{
		if(empty($_REQUEST['firstname']))
		throw new ErrorException("First name is required.");
		else
		$inputs['firstname'] = $_REQUEST['firstname'];
		
		if(empty($_REQUEST['lastname']))
		throw new ErrorException("Last name is required.");
		else
		$inputs['lastname'] = $_REQUEST['lastname'];
		
		if(empty($_REQUEST['email']))
		throw new ErrorException("Email is required.");
		else
		$inputs['email'] = $_REQUEST['email'];
	}
	catch(ErrorException $e)
	{
		$data['error'] = '0001-Invalid input. '.$e->getMessage();
	}
}

//process
if(!strlen($data['error']))
{
	$result = Yii::$app->MemberMod->memberEmailVerificationCode($inputs);
	
	if(!$result)
	$data['error'] = '0002-'.Yii::$app->MemberMod->errorMessage;
}


//format response
if(!strlen($data['error']))
{
	$data['success'] = true;
	$data['firstname'] = $result['firstname'];
	$data['lastname'] = $result['lastname'];
	$data['email'] = $result['email'];
	$data['verification_code'] = $result['verification_code'];
}

//update log api
if(!strlen($data['error']))
{
	$logapi = Yii::$app->AccessMod->LogAPI($logapi['logAPI']['id'], 'member-email-verification', $request, json_encode($data), '');
	if(isset($logapi['error']))
	$data['error'] = '0000-'.$logapi['error'];
}

//debug mode
if(isset($_REQUEST['debug_mode']))
{
	if(strtolower($_REQUEST['debug_mode'])=='true')
	{
		echo '<pre>';
		//print_r($user);
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
