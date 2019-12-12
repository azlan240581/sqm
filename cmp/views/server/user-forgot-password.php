<?php
/* 
user forgot password
*/

use app\models\Users;

//initialize
$data = array();
$data['error'] = '';
$request = array();
$request['server'] = json_encode($_SERVER);
$request['get'] = json_encode($_GET);
$request['post'] = json_encode($_POST);

//create Log API
$logapi = Yii::$app->AccessMod->LogAPI('', 'user-forgot-password', $request, '', '');
if(isset($logapi['error']))
$data['error'] = '0000-'.$logapi['error'];

//validate user
if(!strlen($data['error']) && !isset($_REQUEST['email']))
$data['error'] = '0001-Email is required.';

if(!strlen($data['error']) and !strlen($_REQUEST['email']))
$data['error'] = '0002-Email is required.';

if(!strlen($data['error']) and preg_match("/^([\w\.-]{1,50}+[@]{1}+[\w-]{1,50})+?([\.\w]{1,50})?([\.][\w]{1,50})$/",$_REQUEST['email']) == 0)
$data['error'] = '0003-Invalid email address.';

//process
if(!strlen($data['error']))
{
	$result = Yii::$app->AccessRule->userForgotPassword($_REQUEST['email']);
	
	if(!$result)
	$data['error'] = '0004-'.Yii::$app->AccessRule->errorMessage;
}

//format response
if(!strlen($data['error']))
{
	$data['success'] = true;
}

//update log api
if(!strlen($data['error']))
{
	$logapi = Yii::$app->AccessMod->LogAPI($logapi['logAPI']['id'], 'user-forgot-password', $request, json_encode($data), $result['user_id']);
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


?>