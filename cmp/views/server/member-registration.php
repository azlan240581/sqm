<?php
/* 
member registration
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
$logapi = Yii::$app->AccessMod->LogAPI('', 'member-registration', $request, '', '');
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
		
		if(empty($_REQUEST['password']))
		throw new ErrorException("Password is required.");
		else
		$inputs['password'] = $_REQUEST['password'];
		
		if(empty($_REQUEST['password_repeat']))
		throw new ErrorException("Password Repeat is required.");
		else
		$inputs['password_repeat'] = $_REQUEST['password_repeat'];
		
		if($inputs['password'] != $inputs['password_repeat'])
		throw new ErrorException("Password and Password Repeat not match.");
		
		if(empty($_REQUEST['country_code']))
		throw new ErrorException("Country code is required.");
		else
		$inputs['country_code'] = $_REQUEST['country_code'];
		
		if(empty($_REQUEST['contact_number']))
		throw new ErrorException("Contact number is required.");
		else
		$inputs['contact_number'] = $_REQUEST['contact_number'];
		
		if(empty($_REQUEST['dob']))
		$inputs['dob'] = '';
		else
		$inputs['dob'] = $_REQUEST['dob'];
		
		if(empty($_REQUEST['gender']))
		$inputs['gender'] = '';
		else
		$inputs['gender'] = $_REQUEST['gender'];
		
		if(empty($_REQUEST['sqm_account_manager_id']))
		$inputs['sqm_account_manager_id'] = '';
		else
		$inputs['sqm_account_manager_id'] = trim($_REQUEST['sqm_account_manager_id']);

		if(empty($_REQUEST['preferred_project_id']))
		$inputs['preferred_project_id'] = '';
		else
		$inputs['preferred_project_id'] = trim($_REQUEST['preferred_project_id']);
		
		if(!strlen($inputs['sqm_account_manager_id']) and !strlen($inputs['preferred_project_id']))
		throw new ErrorException("Either SQM Account Manager ID or Preferred Project is required.");
		
		if(empty($_REQUEST['reference_code']))
		$inputs['reference_code'] = '';
		else
		$inputs['reference_code'] = trim($_REQUEST['reference_code']);
		
		if(empty($_REQUEST['verification_code']))
		throw new ErrorException("Verification code is required.");
		else
		$inputs['verification_code'] = $_REQUEST['verification_code'];
	}
	catch(ErrorException $e)
	{
		$data['error'] = '0001-Invalid input. '.$e->getMessage();
	}
}

//process
if(!strlen($data['error']))
{
	$user = Yii::$app->MemberMod->memberRegistration($inputs);
	
	if(!$user)
	$data['error'] = '0002-'.Yii::$app->MemberMod->errorMessage;
}


//format response
if(!strlen($data['error']))
{
	$data['success'] = true;
	$data['member_registered'] = $user;
}

//update log api
if(!strlen($data['error']))
{
	$logapi = Yii::$app->AccessMod->LogAPI($logapi['logAPI']['id'], 'member-registration', $request, json_encode($data), $user['id']);
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
