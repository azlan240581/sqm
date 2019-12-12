<?php
/* 
public banners
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
$logapi = Yii::$app->AccessMod->LogAPI('', 'public-banners', $request, '', '');
if(isset($logapi['error']))
$data['error'] = '0000-'.$logapi['error'];

//capture
if(!strlen($data['error']))
{
	$banner_category = !empty($_REQUEST['banner_category'])?$_REQUEST['banner_category']:'';
	$banner_id = !empty($_REQUEST['banner_id'])?$_REQUEST['banner_id']:'';
	$permalink = !empty($_REQUEST['permalink'])?$_REQUEST['permalink']:'';
}

//process
if(!strlen($data['error']))
{
	$result = Yii::$app->CatalogMod->getBanners($banner_category,$banner_id,$permalink);
	
	if(!$result)
	$data['error'] = '0008-'.Yii::$app->CatalogMod->errorMessage;
}


//format response
if(!strlen($data['error']))
{
	$data['banners'] = $result;
}

//update log api
if(!strlen($data['error']))
{
$logapi = Yii::$app->AccessMod->LogAPI($logapi['logAPI']['id'], 'public-banners', $request, json_encode($data), '');
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