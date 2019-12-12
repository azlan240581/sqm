<?php
ini_set('display_errors', 1);
require_once 'class/PHPExcel.php';
$objPHPExcel = new PHPExcel();
$objPHPExcel = PHPExcel_IOFactory::load('data/sqm-members-edited.xls');
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
			$data[$x]['agent'] = trim($value[0])=='NULL'?'':trim($value[0]);
			if(trim($value[1])=='NULL')
			$referrer_username = '';
			elseif(trim($value[1])=='ffsadmin')
			$referrer_username = '';
			elseif(trim($value[1])=='administrator')
			$referrer_username = '';
			else
			$referrer_username = trim($value[1]);
			$data[$x]['referrer'] = $referrer_username;
			$data[$x]['total_points'] = empty($value[2])?'':trim($value[2]);
			$data[$x]['uuid'] = trim($value[3]);
			$data[$x]['username'] = trim($value[4]);
			$data[$x]['password'] = trim($value[5]);
			$data[$x]['password_salt'] = trim($value[6]);
			$data[$x]['email'] = trim($value[7]);
			
			
			$nameArray = array();
			$nameArray = explode(' ',trim($value[8]));
			if(count($nameArray)==1)
			{
				$data[$x]['firstname'] = trim($value[8]);
				$data[$x]['lastname'] = trim($value[8]);
			}
			else
			{
				$data[$x]['firstname'] = trim($nameArray[0]);
				unset($nameArray[0]);
				$data[$x]['lastname'] = trim(implode(' ',$nameArray));
			}
			$data[$x]['name'] = trim($value[8]);
			
			if(substr(trim($value[9]),0,2)==62)
			{
				$data[$x]['country_code'] = substr(trim($value[9]),0,2);
				$data[$x]['contact_number'] = substr(trim($value[9]),2);
			}
			else
			{
				$data[$x]['country_code'] = 62;
				$data[$x]['contact_number'] = trim($value[9]);
			}
			$data[$x]['dob'] = trim($value[10])=='NULL'?'':trim($value[10]);
			$data[$x]['gender'] = trim($value[11])=='NULL'?'':trim($value[11]);
			$data[$x]['avatar'] = trim($value[12])=='NULL'?'':trim($value[12]);
			$data[$x]['avatar_id'] = trim($value[13]);
			$data[$x]['nricpass'] = trim($value[14])=='NULL'?'':trim($value[14]);
			$data[$x]['tax_license'] = trim($value[15])=='NULL'?'':trim($value[15]);
			$data[$x]['bank_account'] = trim($value[16])=='NULL'?'':trim($value[16]);
			$data[$x]['createdat'] = date('Y-m-d H:i:s', strtotime("+2 months", strtotime(trim($value[17]))));
		}
		$x++;
	}
	
	$agentArray = array(3,4,5);
	
	/*echo '<pre>';
	print_r($agentArray);
	print_r($nameArray);
	print_r($data);
	echo '</pre>';
	exit();*/
	
	function throw_ex($er)
	{
		throw new Exception($er);  
	}	
	
	$error='';
	$i=0;
	$agent_number=0;
	try
	{
		//start transaction	
		if(mysqli_query($db_connect,"START TRANSACTION") === false)
		throw new Exception('Failed to start transaction');
	
		foreach($data as $key=>$value)
		{
			if($key!=0)
			{				
				$sql = "UPDATE users SET ";
				$sql .= "firstname = '".$value['firstname']."', ";
				$sql .= "lastname = '".$value['lastname']."', ";
				$sql .= "name = '".$value['name']."' ";
				$sql .= "WHERE username = '".$value['username']."' ";
				if(!mysqli_query($db_connect,$sql))
				throw new Exception(mysqli_error($db_connect));
				
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