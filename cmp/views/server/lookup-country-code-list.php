<?php
/* 
member points
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
$countryCodeList = array();

/*** create Log API ***/
$logapi = Yii::$app->AccessMod->LogAPI('', 'lookup-country-code-list', $request, '', '');
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
	$result = Yii::$app->AccessMod->readExcel('contents/others/countries.xls');
	$countryCodeList[0]['name'] = 'Indonesia (+62)';
	$countryCodeList[0]['value'] = '62';
	$countryCodeList[1]['name'] = '------------------------------------------------';
	$countryCodeList[1]['value'] = '';
	if(count($result)!=0)
	{
		$i=2;
		foreach($result as $key => $country)
		{
			if($key!=0)
			{
				if($country[0]!='+62')
				{
					$countryCodeList[$i]['name'] = $country[1].' ('.$country[0].')';
					$countryCodeList[$i]['value'] = str_replace('+','',$country[0]);
					$i++;
				}
			}
		}
	}
	$data['data'] = $countryCodeList;
}


//update log api
if(!strlen($data['error']))
{
$logapi = Yii::$app->AccessMod->LogAPI($logapi['logAPI']['id'], 'lookup-country-code-list', $request, json_encode($data), 1);
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