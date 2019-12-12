<?php
/* 
scheduler delete old log api
*/

//initialize
$data = array();
$data['error'] = '';
$request = array();
$request['server'] = json_encode($_SERVER);
$request['get'] = json_encode($_GET);
$request['post'] = json_encode($_POST);

//create Log API
$logapi = Yii::$app->AccessMod->LogAPI('', 'delete-old-log-api', $request, '', '');
if(isset($logapi['error']))
$data['error'] = '0000-'.$logapi['error'];

//validate
if(!strlen($data['error']) and empty($_REQUEST['site_password']))
$data['error'] = '0001-Invalid request';
else
{
	if($_REQUEST['site_password'] != $_SESSION['settings']['SITE_PASSWORD'])
	$data['error'] = '0002-Invalid request';
}

//process
if(!strlen($data['error']))
{
	$connection = \Yii::$app->db;
	$transaction = $connection->beginTransaction();
	try 
	{
		$sql = "DELETE FROM log_api WHERE createdat < DATE_SUB(NOW(), INTERVAL 30 DAY)";
		$records = Yii::$app->db->createCommand($sql)->execute();
		
		$transaction->commit();
	}
	catch (ErrorException $e) 
	{
		$transaction->rollBack();
		$error = '0001-'.$e->getMessage();
	}
}

//format response
if(!strlen($data['error']))
{
	$data['success'] = true;
}

//update log api
if(!strlen($data['error']))
{
$logapi = Yii::$app->AccessMod->LogAPI($logapi['logAPI']['id'], 'scheduler-delete-old-log-api', $request, json_encode($data),1);
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