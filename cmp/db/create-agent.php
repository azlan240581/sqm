<?php
ini_set('display_errors', 1);
require_once 'class/PHPExcel.php';
$objPHPExcel = new PHPExcel();
$objPHPExcel = PHPExcel_IOFactory::load('data/sqm-agents.xls');
$objPHPExcel->setActiveSheetIndex(0);
$excelRecord = $objPHPExcel->getActiveSheet()->toArray();
$excelRecord = array_map('array_filter', $excelRecord);
$excelRecord = array_filter($excelRecord);

/*echo '<pre>';
print_r($excelRecord);
echo '</pre>';
exit();*/


if($_GET['execpassword'] == 'ffs12345')
{
	$db_connect = mysqli_connect("localhost","root","Ff-1943s","sqmproperty.dev");

	if (mysqli_connect_errno()) {
		die('Could not connect: ' . mysqli_connect_error());
	}

	/*echo '<pre>';
	print_r($excelRecord);
	echo '</pre>';
	exit();*/

	$data = array();
	$x=0;
	foreach($excelRecord as $key=>$value)
	{
		if($key!=0)
		{
			$data[$x]['uuid'] = trim($value[0]);
			$data[$x]['username'] = trim($value[1]);
			$data[$x]['password'] = trim($value[2]);
			$data[$x]['password_salt'] = trim($value[3]);
			$data[$x]['email'] = trim($value[4]);
			$data[$x]['firstname'] = trim($value[5]);
			$data[$x]['lastname'] = trim($value[6]);
			if(substr(trim($value[7]),0,2)==62)
			{
				$data[$x]['country_code'] = substr(trim($value[7]),0,2);
				$data[$x]['contact_number'] = substr(trim($value[7]),2);
			}
			else
			{
				$data[$x]['country_code'] = 62;
				$data[$x]['contact_number'] = trim($value[7]);
			}
			$data[$x]['createdby'] = trim($value[8]);
			$data[$x]['createdat'] = trim($value[9]);
		}
		$x++;
	}
	
	echo '<pre>';
	print_r($data);
	echo '</pre>';
	exit();
	
	function throw_ex($er)
	{  
		throw new Exception($er);  
	}	
	
	$error='';
	$i=0;
	try
	{
		//start transaction	
		if(mysqli_query($db_connect,"START TRANSACTION") === false)
		throw new Exception('Failed to start transaction');
	
		foreach($data as $key=>$value)
		{
			if($key!=0)
			{
				//$salt = md5(time());
				//$str = md5($key.trim(strtolower($value['email'])).date("Y-m-d H:i:s"));
				//$uuid = substr($str,0,8).'-'.substr($str,8,4).'-'.substr($str,12,4).'-'.substr($str,16,4).'-'.substr($str,20,12);
				
				//insert users
				$sqlUser = "INSERT INTO users SET ";
				$sqlUser .= "uuid = '".$value['uuid']."', ";
				$sqlUser .= "username = '".$value['username']."', ";
				$sqlUser .= "password = '".$value['password']."', ";
				$sqlUser .= "password_salt = '".$value['password_salt']."', ";
				$sqlUser .= "email = '".$value['email']."', ";
				$sqlUser .= "firstname = '".$value['firstname']."', ";
				$sqlUser .= "lastname = '".$value['lastname']."', ";
				$sqlUser .= "name = '".$value['firstname'].' '.$value['lastname']."', ";
				$sqlUser .= "country_code = '".$value['country_code']."', ";
				$sqlUser .= "contact_number = '".$value['contact_number']."', ";
				$sqlUser .= "avatar_id = 1, ";
				$sqlUser .= "status = 1, ";
				$sqlUser .= "createdby = '".$value['createdby']."', ";
				$sqlUser .= "createdat = '".$value['createdat']."' ";
				mysqli_query($db_connect,$sqlUser);
				
				$user_id = mysqli_insert_id($db_connect);				
								
				//insert user_groups
				$sqluser_groups = "INSERT INTO user_groups SET ";
				$sqluser_groups .= "user_id = '".$user_id."', ";
				$sqluser_groups .= "groupaccess_id = '7' ";
				mysqli_query($db_connect,$sqluser_groups);
				
				//insert dashboard_user
				$sqldashboard_user = "INSERT INTO dashboard_user SET ";
				$sqldashboard_user .= "user_id = '".$user_id."' ";
				mysqli_query($db_connect,$sqldashboard_user);
			}
			$i++;
		}
		mysqli_query($db_connect,"COMMIT");
	}
	catch (Exception $e) 
	{
		mysqli_query($db_connect,"ROLLBACK");
		$error = $e->getMessage();
	}
	
	if(strlen($error))
	echo $error;
	else
	echo "Successfully updated";

}
?>