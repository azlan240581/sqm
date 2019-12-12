<?php
ini_set('display_errors', 1);
require_once 'class/PHPExcel.php';
$objPHPExcel = new PHPExcel();
$objPHPExcel = PHPExcel_IOFactory::load('data/sqm-members.xls');
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
			$data[$x]['firstname'] = trim($value[8]);
			$data[$x]['lastname'] = trim($value[8]);
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
	
	$agentArray = array(5,6,7);
	
	echo '<pre>';
	print_r($agentArray);
	print_r($data);
	echo '</pre>';
	exit();
	
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
				//select user by username
				$query = "SELECT id FROM users WHERE username='".trim($value['username'])."' AND id NOT IN (SELECT uad.user_id FROM user_associate_details uad) ";
				$userQuery = mysqli_query($db_connect,$query);
				$user = mysqli_fetch_array($userQuery);
				$user_id = $user['id'];
				
				//select user_associate_details by user_id
				$query = "SELECT id FROM user_associate_details WHERE user_id='".$user_id."' ";
				$userAssociateDetailQuery = mysqli_query($db_connect,$query);
				if($userAssociateDetailQuery->num_rows==0)
				{
					//get agent id
					if(empty($value['agent']))
					{
						$agent_id = $agentArray[$agent_number];
						if($agent_number!=2)
						$agent_number++;
						else
						$agent_number = 0;
					}
					else
					{
						$query = "SELECT id FROM users WHERE username='".trim($value['agent'])."' ";
						$agent = mysqli_query($db_connect,$query);
						$agent = mysqli_fetch_array($agent);
						$agent_id = $agent['id'];
					}
				
					$referrer_id = '';
					if(!empty($value['referrer']))
					{
						$query = "SELECT id FROM users WHERE username='".trim($value['referrer'])."' ";
						$referrer = mysqli_query($db_connect,$query);
						$referrer = mysqli_fetch_array($referrer);
						$referrer_id = $referrer['id'];
					}
								
					//nrcipass
					$nricpass = '';
					if(!empty($value['nricpass']))
					{
						$nricpass_name = basename($value['nricpass']);
						//if(file_put_contents("../contents/associate/".$user_id."/".$nricpass_name, fopen($value['nricpass'], 'r')))
						$nricpass = (isset($_SERVER['HTTPS'])?'https':'http') . '://' . $_SERVER['HTTP_HOST'].'/cmp/contents/associate/'.$user_id.'/'.$nricpass_name;
					}
					
					//tax_license
					$tax_license = '';
					if(!empty($value['tax_license']))
					{
						$tax_license_name = basename($value['tax_license']);
						//if(file_put_contents("../contents/associate/".$user_id."/".$tax_license_name, fopen($value['tax_license'], 'r')))
						$tax_license = (isset($_SERVER['HTTPS'])?'https':'http') . '://' . $_SERVER['HTTP_HOST'].'/cmp/contents/associate/'.$user_id.'/'.$tax_license_name;
					}
					
					//bank_account
					$bank_account = '';
					if(!empty($value['bank_account']))
					{
						$bank_account_name = basename($value['bank_account']);
						//if(file_put_contents("../contents/associate/".$user_id."/".$bank_account_name, fopen($value['bank_account'], 'r')))
						$bank_account = (isset($_SERVER['HTTPS'])?'https':'http') . '://' . $_SERVER['HTTP_HOST'].'/cmp/contents/associate/'.$user_id.'/'.$bank_account_name;
					}
				
					//insert user associate details
					$sqlUserAssociateDetails = "INSERT INTO user_associate_details SET ";
					$sqlUserAssociateDetails .= "user_id = '".$user_id."', ";
					
					if(!empty($referrer_id))
					$sqlUserAssociateDetails .= "referrer_id = '".$referrer_id."', ";
					else
					$sqlUserAssociateDetails .= "referrer_id = NULL, ";
					
					$sqlUserAssociateDetails .= "agent_id = '".$agent_id."', ";
					
					$sqlUserAssociateDetails .= "approval_status = '1', ";
					$sqlUserAssociateDetails .= "productivity_status = '1', ";
					
					if(!empty($nricpass))
					$sqlUserAssociateDetails .= "nricpass = '".$nricpass."', ";
					else
					$sqlUserAssociateDetails .= "nricpass = NULL, ";
					
					if(!empty($tax_license))
					$sqlUserAssociateDetails .= "tax_license = '".$tax_license."', ";
					else
					$sqlUserAssociateDetails .= "tax_license = NULL, ";
					
					if(!empty($bank_account))
					$sqlUserAssociateDetails .= "bank_account = '".$bank_account."' ";
					else
					$sqlUserAssociateDetails .= "bank_account = NULL ";
					
					//mysqli_query($db_connect,$sqlUserAssociateDetails);
					if(!mysqli_query($db_connect,$sqlUserAssociateDetails))
					throw new Exception(mysqli_error($db_connect));
	
					/*//save member log registration approval
					$sqlLogAssociateApproval = "INSERT INTO log_associate_approval SET ";
					$sqlLogAssociateApproval .= "user_id = '".$user_id."', ";
					$sqlLogAssociateApproval .= "status = '1', ";
					$sqlLogAssociateApproval .= "remarks = 'New Associate Registered', ";
					$sqlLogAssociateApproval .= "createdby = '".$agent_id."', ";
					$sqlLogAssociateApproval .= "createdat = '".$value['createdat']."' ";
					//mysqli_query($db_connect,$sqlLogAssociateApproval);
					if(!mysqli_query($db_connect,$sqlLogAssociateApproval))
					throw new Exception(mysqli_error($db_connect));*/
				}
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