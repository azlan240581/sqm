<?php
/* 
public news feeds
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
$logapi = Yii::$app->AccessMod->LogAPI('', 'public-news-feeds', $request, '', '');
if(isset($logapi['error']))
$data['error'] = '0000-'.$logapi['error'];

//capture
if(!strlen($data['error']))
{
	$filter['project'] = isset($_REQUEST['project'])?$_REQUEST['project']:'';
	$filter['category'] = isset($_REQUEST['category'])?$_REQUEST['category']:'';
	$filter['news_feed_id'] = isset($_REQUEST['news_feed_id'])?$_REQUEST['news_feed_id']:'';
	$filter['permalink'] = isset($_REQUEST['permalink'])?$_REQUEST['permalink']:'';
}

//process
if(!strlen($data['error']))
{
	$result = Yii::$app->NewsFeedMod->getNewsFeeds($filter);
	
	if(!$result)
	$data['error'] = '0008-'.Yii::$app->NewsFeedMod->errorMessage;
}


//format response
if(!strlen($data['error']))
{
	$data['success'] = true;
	$data['news_feed'] = $result;
}

//update log api
if(!strlen($data['error']))
{
$logapi = Yii::$app->AccessMod->LogAPI($logapi['logAPI']['id'], 'public-news-feeds', $request, json_encode($data), '');
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