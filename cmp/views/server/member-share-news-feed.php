<?php
/* 
member share news feed
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
$filter = array();

/*** create Log API ***/
$logapi = Yii::$app->AccessMod->LogAPI('', 'member-share-news-feed', $request, '', '');
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
		if(empty($_REQUEST['news_feed_id']))
		throw new ErrorException("News Feed ID is required.");
		else
		{
			$inputs['action_name'] = 'SHARE_NEWS_FEED';
			$inputs['news_feed_id'] = $_REQUEST['news_feed_id'];
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
	$result = Yii::$app->PointsMod->memberPointsActivities($user['id'],'NEWS_FEED_SHARE_SOCIAL_MEDIA',1,$inputs);
	
	if(!$result)
	$data['error'] = '0009-'.Yii::$app->PointsMod->errorMessage;
}

//format response
if(!strlen($data['error']))
{
	$data['success'] = true;
}

//update log api
if(!strlen($data['error']))
{
$logapi = Yii::$app->AccessMod->LogAPI($logapi['logAPI']['id'], 'member-share-news-feed', $request, json_encode($data), $user['id']);
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