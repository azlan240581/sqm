<?php
/* 
member sync fb account
*/

use app\models\Users;

//initialize
$data = array();
$data['error'] = '';
$filter = array();
$sortby = '';
$request = array();
$request['server'] = json_encode($_SERVER);
$request['get'] = json_encode($_GET);
$request['post'] = json_encode($_POST);

//create Log API
$logapi = Yii::$app->AccessMod->LogAPI('', 'member-sync-fb-account', $request, '', '');
if(isset($logapi['error']))
$data['error'] = '0000-'.$logapi['error'];

//validate user
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
			if(!in_array(8, $groups))
			$data['error'] = '0007-Invalid member group';
		}
	}
}

//validate request input
if(!strlen($data['error']) and !isset($_REQUEST['fb_id']))
$data['error'] = '0008-Invalid fb id.';

if(!strlen($data['error']) and !isset($_REQUEST['fb_token']))
$data['error'] = '0009-Invalid fb token.';

if(!strlen($data['error']) and !strlen($_REQUEST['fb_id']))
$data['error'] = '0010-Invalid fb id.';

if(!strlen($data['error']) and !strlen($_REQUEST['fb_token']))
$data['error'] = '0011-Invalid fb token.';

echo '<pre>';
print_r($_REQUEST);
print_r($user);
print_r($data);
echo '</pre>';
exit();

//process
if(!strlen($data['error']))
{
	$result = Yii::$app->AccessRule->sync_fb_account($user['id'],$_REQUEST['fb_id'],$_REQUEST['fb_token']);
	if(!$result)
	$data['error'] = '0012-'.Yii::$app->AccessRule->errorMessage;
}

//format data
if(!strlen($data['error']))
{
	$data['fb_info'] = $result;
}

//update log api
if(!strlen($data['error']))
{
	$logapi = Yii::$app->AccessMod->LogAPI($logapi['logAPI']['id'], 'member-sync-fb-account', $request, json_encode($data), $user['id']);
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

	Yii::$app->AccessMod->sentNotification($_SESSION['settings']['SITE_NAME'].' Error : Sync FB Account Notification', $message);
}
*/
//return output
echo json_encode($data);
?>
