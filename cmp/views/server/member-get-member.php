<?php
/* 
member get member
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
$logapi = Yii::$app->AccessMod->LogAPI('', 'member-get-member', $request, '', '');
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
			if(!in_array(11, $groups))
			$data['error'] = '0007-Invalid associate group';
		}
	}
}

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
				
		if(empty($_REQUEST['country_code']))
		throw new ErrorException("Country code is required.");
		else
		$inputs['country_code'] = $_REQUEST['country_code'];
				
		if(empty($_REQUEST['contact_no']))
		throw new ErrorException("Contact number is required.");
		else
		$inputs['contact_no'] = $_REQUEST['contact_no'];
	}
	catch(ErrorException $e)
	{
		$data['error'] = '0008-Invalid input. '.$e->getMessage();
	}
}

//register new member process
if(!strlen($data['error']))
{
	$result = Yii::$app->MemberMod->memberInvitation($inputs,$user['id']);
	
	if(!$result)
	$data['error'] = '0009-'.Yii::$app->MemberMod->errorMessage;
}

//format response
if(!strlen($data['error']))
{
	$data['success'] = true;
	$data['invited_associate']['firstname'] = $inputs['firstname'];
	$data['invited_associate']['lastname'] = $inputs['lastname'];
	$data['invited_associate']['email'] = $inputs['email'];
	$data['invited_associate']['country_code'] = $inputs['country_code'];
	$data['invited_associate']['contact_no'] = $inputs['contact_no'];
	if(isset($result['sqm_account_manager_id']))
	$data['invited_associate']['sqm_account_manager_id'] = $result['sqm_account_manager_id'];
	if(isset($result['reference_code']))
	$data['invited_associate']['reference_code'] = $result['reference_code'];
}


//update log api
if(!strlen($data['error']))
{
	$logapi = Yii::$app->AccessMod->LogAPI($logapi['logAPI']['id'], 'member-get-member', $request, json_encode($data), $user['id']);
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