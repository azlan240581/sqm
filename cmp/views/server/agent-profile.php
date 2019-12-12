<?php
/* 
agent-profile
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
$logapi = Yii::$app->AccessMod->LogAPI('', 'agent-profile', $request, '', '');
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
			if(!array_intersect(array(7,8,9,10), $groups))
			$data['error'] = '0007-Invalid agent group';
		}
	}
}

/*** validate inputs and capture ***/
if(!strlen($data['error']))
{
	try
	{
		if(isset($_REQUEST['action']))
		$inputs['action'] = $_REQUEST['action'];
		else
		$inputs['action'] = 'list';
		
		if($inputs['action']=='update')
		{
			$inputs['sqm_id'] = isset($_REQUEST['sqm_id'])?$_REQUEST['sqm_id']:'';
			$inputs['email'] = isset($_REQUEST['email'])?$_REQUEST['email']:'';
			$inputs['firstname'] = isset($_REQUEST['firstname'])?$_REQUEST['firstname']:'';
			$inputs['lastname'] = isset($_REQUEST['lastname'])?$_REQUEST['lastname']:'';
			$inputs['country_code'] = isset($_REQUEST['country_code'])?$_REQUEST['country_code']:'';
			$inputs['contact_number'] = isset($_REQUEST['contact_number'])?$_REQUEST['contact_number']:'';
			$inputs['profile_description'] = isset($_REQUEST['profile_description'])?$_REQUEST['profile_description']:'';
			$inputs['profile_photo'] = isset($_REQUEST['profile_photo'])?$_REQUEST['profile_photo']:'';
			$inputs['dob'] = isset($_REQUEST['dob'])?$_REQUEST['dob']:'';
			$inputs['gender'] = isset($_REQUEST['gender'])?$_REQUEST['gender']:'';
			$inputs['address_1'] = isset($_REQUEST['address_1'])?$_REQUEST['address_1']:'';
			$inputs['address_2'] = isset($_REQUEST['address_2'])?$_REQUEST['address_2']:'';
			$inputs['address_3'] = isset($_REQUEST['address_3'])?$_REQUEST['address_3']:'';
			$inputs['city'] = isset($_REQUEST['city'])?$_REQUEST['city']:'';
			$inputs['postcode'] = isset($_REQUEST['postcode'])?$_REQUEST['postcode']:'';
			$inputs['state'] = isset($_REQUEST['state'])?$_REQUEST['state']:'';
			$inputs['country'] = isset($_REQUEST['country'])?$_REQUEST['country']:'';
		}
		elseif($inputs['action']=='updatepassword')
		{
			if(!isset($_REQUEST['password']))
			throw new ErrorException("Password is required.");
			else
			$inputs['password'] = $_REQUEST['password'];
			
			if(!isset($_REQUEST['password_repeat']))
			throw new ErrorException("Password repeat is required.");
			else
			$inputs['password_repeat'] = $_REQUEST['password_repeat'];
			
			if($inputs['password']!=$inputs['password_repeat'])
			throw new ErrorException("Password and password repeat not match.");
		}
	}
	catch(ErrorException $e)
	{
		$data['error'] = '0008-Invalid input. '.$e->getMessage();
	}
}

//process
if(!strlen($data['error']))
{
	$result = Yii::$app->AgentMod->agentProfile($inputs,$user['id'],$user['id']);
	
	if(!$result)
	$data['error'] = '0009-'.Yii::$app->MemberMod->errorMessage;
}

//get user commission
if(!strlen($data['error']))
{
	$commission = Yii::$app->CommissionMod->getUserCommissions($user['id']);
	
	if(!$commission)
	$data['error'] = '00010-'.Yii::$app->CommissionMod->errorMessage;
}

//format response
if(!strlen($data['error']))
{
	$data['success'] = true;
	$data['profile'] = $result;
	foreach($data as $key=>$value)
	{
		if($key=='profile_description')
		$data['profile']['profile_description'] = html_entity_decode($data['profile']['profile_description']);
	}
	$data['commission'] = $commission;
}

//update log api
if(!strlen($data['error']))
{
$logapi = Yii::$app->AccessMod->LogAPI($logapi['logAPI']['id'], 'member-profile', $request, json_encode($data), $user['id']);
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