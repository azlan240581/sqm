<?php
/* 
member-redeem-rewards
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
$logapi = Yii::$app->AccessMod->LogAPI('', 'member-redeem-rewards', $request, '', '');
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
		if(empty($_REQUEST['rewardIDList']))
		throw new Exception("Rewards ID is required.");
		else
		$inputs['rewardIDList'] = $_REQUEST['rewardIDList'];
		
		if(empty($_REQUEST['firstname']))
		throw new Exception("First name is required.");
		else
		$inputs['firstname'] = $_REQUEST['firstname'];
		
		if(empty($_REQUEST['lastname']))
		throw new Exception("Last name is required.");
		else
		$inputs['lastname'] = $_REQUEST['lastname'];
		
		if(empty($_REQUEST['email']))
		throw new Exception("Email is required.");
		else
		$inputs['email'] = $_REQUEST['email'];
		
		if(empty($_REQUEST['country_code']))
		throw new Exception("Country code is required.");
		else
		$inputs['country_code'] = $_REQUEST['country_code'];
		
		if(empty($_REQUEST['contact_number']))
		throw new Exception("Contact number is required.");
		else
		$inputs['contact_number'] = $_REQUEST['contact_number'];
		
		if(empty($_REQUEST['address_1']))
		throw new Exception("Address 1 is required.");
		else
		$inputs['address_1'] = $_REQUEST['address_1'];
		
		$inputs['address_2'] = isset($_REQUEST['address_2'])?$_REQUEST['address_2']:'';
		$inputs['address_3'] = isset($_REQUEST['address_3'])?$_REQUEST['address_3']:'';
		
		if(empty($_REQUEST['city']))
		throw new Exception("City is required.");
		else
		$inputs['city'] = $_REQUEST['city'];
		
		if(empty($_REQUEST['postcode']))
		throw new Exception("Postcode is required.");
		else
		$inputs['postcode'] = $_REQUEST['postcode'];
		
		if(empty($_REQUEST['state']))
		throw new Exception("State is required.");
		else
		$inputs['state'] = $_REQUEST['state'];
		
		if(empty($_REQUEST['country_id']))
		throw new Exception("Country is required.");
		else
		$inputs['country_id'] = $_REQUEST['country_id'];
	}
	catch(ErrorException $e)
	{
		$data['error'] = '0008-Invalid input. '.$e->getMessage();
	}
}

//process
if(!strlen($data['error']))
{	
	$result = Yii::$app->MemberMod->memberRedeemRewards($inputs,$user['id']);
	
	if(!$result)
	$data['error'] = '0009-'.Yii::$app->MemberMod->errorMessage;
}


//format response
if(!strlen($data['error']))
{
	$data['success'] = true;
}

//update log api
if(!strlen($data['error']))
{
$logapi = Yii::$app->AccessMod->LogAPI($logapi['logAPI']['id'], 'member-redeem-rewards', $request, json_encode($data), $user['id']);
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