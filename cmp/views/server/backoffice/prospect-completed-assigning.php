<?php
/* 
scheduler delete old log api
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
$logapi = Yii::$app->AccessMod->LogAPI('', 'prospect-completed-assigning', $request, '', '');
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
		$sql = "SELECT * FROM prospects WHERE status = 2 ";
		$prospects = Yii::$app->db->createCommand($sql)->queryAll();
		
		if(count($prospects) == 0)
		throw new ErrorException('No records in prospect.');

		foreach($prospects as $prospect)
		{
			$sql = "SELECT * FROM prospect_bookings WHERE prospect_id = '".$prospect['id']."' ";
			$prospectBookings = Yii::$app->db->createCommand($sql)->queryAll();

			if(count($prospectBookings) == 0)
			continue;

			$flagCompleted = true;
			foreach($prospectBookings as $prospectBooking)
			{
				if(!in_array($prospectBooking['status'],array(9,12)))
				{
					$flagCompleted = false;
					break;
				}
			}
			
			if($flagCompleted)
			{
				Yii::$app->db->createCommand("UPDATE prospects SET status=4 WHERE id='".$prospect['id']."'")->execute();
				$data['prospect'][] = $prospect;
			}
		}
		
		$transaction->commit();
	}
	catch (ErrorException $e) 
	{
		$transaction->rollBack();
		$data['error'] = '0001-'.$e->getMessage();
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
$logapi = Yii::$app->AccessMod->LogAPI($logapi['logAPI']['id'], 'prospect-completed-assigning', $request, json_encode($data),1);
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