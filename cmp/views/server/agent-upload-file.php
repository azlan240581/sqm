<?php
/*
agent upload file
*/

//initialize
$data = array();
$data['error'] = '';
$serverRoot = $_SERVER['DOCUMENT_ROOT'];
$http_host = ((isset($_SERVER['HTTPS'])) ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'];
$filePath = 'contents/users/';
$request = array();
$request['server'] = json_encode($_SERVER);
$request['get'] = json_encode($_GET);
$request['post'] = json_encode($_POST);

//create Log API
$logapi = Yii::$app->AccessMod->LogAPI('', 'agent-upload-file', $request, '', '');
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

if(!strlen($data['error']) and !isset($_FILES['file']))
$data['error'] = '0008-Invalid file';

/*echo '<pre>';
print_r($_REQUEST);
print_r($user);
print_r($data);
echo '</pre>';
exit();*/


/*
$data['filePath'] = $filePath;
$data['name'] = $_FILES['file']['name'];
$data['tmp_name'] = $_FILES['file']['tmp_name'];
$data['tmp'] = $user['id'].'_'.$_FILES['file']['name'];
$data['filePathname'] = $filePath.$user['id'].'_'.$_FILES['file']['name'];
*/

//process
if(!strlen($data['error']))
{
	//upload files
	if(!strlen($data['error']) and isset($_FILES['file']))
	{
		if($_FILES['file']['error']!=0)
		$data['error'] = '0009-Invalid file.';
		else
		{
			//directory path
			$directory_path = $filePath.$user['id'].'/';
			if(($path = Yii::$app->AccessMod->createDirectory($directory_path)))
			{
				$filename = $user['id'].session_id().'_'.str_replace(' ','_',$_FILES['file']['name']);
				if(!move_uploaded_file($_FILES['file']['tmp_name'], $serverRoot.'/cmp/'.$directory_path.'/'.$filename))
				$data['error'] = '0010-Uploading failed.';
				else
				$data['filepath'] = $http_host.'/cmp/'.$directory_path.'/'.$filename;
			}
			else
			$data['error'] = '0011-'.$path->errorMessage.'.';
		}
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
	$logapi = Yii::$app->AccessMod->LogAPI($logapi['logAPI']['id'], 'agent-upload-file', $request, json_encode($data), $user['id']);
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
