<?php
/* 
user-authentication
*/

//initialize
$data = array();
$data['error'] = '';
$request = array();
$request['server'] = json_encode($_SERVER);
$request['get'] = json_encode($_GET);
$request['post'] = json_encode($_POST);

//create Log API
$logapi = Yii::$app->AccessMod->LogAPI('', 'user-authentication', $request, '', '');
if(isset($logapi['error']))
$data['error'] = '0000-'.$logapi['error'];

//validate
if(!strlen($data['error']) && (!isset($_REQUEST['username']) or !isset($_REQUEST['password'])))
$data['error'] = '0001-Incorrect username or password.';

if(!strlen($data['error']) and (!strlen($_REQUEST['username']) or !strlen($_REQUEST['password'])) )
$data['error'] = '0002-Incorrect username or password.';

//process
/* get user profiles */
if(!strlen($data['error']))
{
	$user = Yii::$app->AccessRule->authenticateUser($_REQUEST['username'],$_REQUEST['password'],true,isset($_REQUEST['device_token'])?$_REQUEST['device_token']:'',isset($_REQUEST['device_os'])?$_REQUEST['device_os']:'');
	
	if(!$user)
	$data['error'] = '0003-'.Yii::$app->AccessRule->errorMessage;
}

//check user group
if(!strlen($data['error']))
{
	$groups = Yii::$app->AccessRule->getUserGroups($user['id']);
	
	if(!$groups)
	$data['error'] = '0004-'.Yii::$app->AccessRule->errorMessage;
	else
	{
		if(count($groups)==0)
		$data['error'] = '0005-Invalid group';
		else
		{
			if(!array_intersect(array(7,8,9,10,11), $groups))
			$data['error'] = '0006-Invalid group';
		}
	}
}

//get user commission
if(!strlen($data['error']))
{
	$commission = Yii::$app->CommissionMod->getUserCommissions($user['id']);
	
	if(!$commission)
	$data['error'] = '0007-'.Yii::$app->CommissionMod->errorMessage;
}

/* get user log history */
if(!strlen($data['error']))
{
	$userhistory = Yii::$app->AccessRule->logHistory($user['id'],10);
	
	if(!$userhistory)
	$data['error'] = '0008-'.Yii::$app->CatalogMod->errorMessage;
}

//format response
if(!strlen($data['error']))
{
	$data['user_profiles'] = array();
	foreach($user as $uKey=>$uVal)
	{
		$data['user_profiles'][$uKey] = $uVal;
	}
	
	if(strlen($data['user_profiles']['profile_description']))
	$data['user_profiles']['profile_description'] = html_entity_decode($data['user_profiles']['profile_description']);
	
	if(!strlen($data['user_profiles']['total_points_value']))
	$data['user_profiles']['total_points_value'] = 0;

	$data['commission'] = $commission;
	
	$data['user_log_history'] = array();
	foreach($userhistory as $uKey=>$uVal)
	{
		$data['user_log_history'][$uKey] = $uVal;
	}
}

//update log api
if(!strlen($data['error']))
{
$logapi = Yii::$app->AccessMod->LogAPI($logapi['logAPI']['id'], 'user-authentication', $request, json_encode($data), $user['id']);
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

//return response
echo json_encode($data);