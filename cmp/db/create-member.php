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
	
	$agentArray = array(3,4,5);
	
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
				//$salt = md5(time());
				//$str = md5($key.trim(strtolower($value['email'])).date("Y-m-d H:i:s"));
				//$uuid = substr($str,0,8).'-'.substr($str,8,4).'-'.substr($str,12,4).'-'.substr($str,16,4).'-'.substr($str,20,12);
				
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
					if($referrer->num_rows==0)
					{
						$referrer = mysqli_fetch_array($referrer);
						$referrer_id = $referrer['id'];
					}
				}
				
				//insert users
				$sqlUser = "INSERT INTO users SET ";
				$sqlUser .= "uuid = '".$value['uuid']."', ";
				$sqlUser .= "username = '".$value['username']."', ";
				$sqlUser .= "password = '".$value['password']."', ";
				$sqlUser .= "password_salt = '".$value['password_salt']."', ";
				$sqlUser .= "email = '".$value['email']."', ";
				$sqlUser .= "firstname = '".$value['firstname']."', ";
				$sqlUser .= "lastname = '".$value['lastname']."', ";
				$sqlUser .= "name = '".$value['name']."', ";
				$sqlUser .= "country_code = '".$value['country_code']."', ";
				$sqlUser .= "contact_number = '".$value['contact_number']."', ";
				if(!empty($value['dob']))
				$sqlUser .= "dob = '".$value['dob']."', ";
				if(!empty($value['gender']))
				$sqlUser .= "gender = '".$value['gender']."', ";
				if(!empty($value['avatar']))
				$sqlUser .= "avatar = '".$value['avatar']."', ";
				$sqlUser .= "avatar_id = 1, ";
				$sqlUser .= "status = 1, ";
				$sqlUser .= "createdby = '".$agent_id."', ";
				$sqlUser .= "createdat = '".$value['createdat']."' ";
				if(!mysqli_query($db_connect,$sqlUser))
				throw new Exception(mysqli_error($db_connect));
				
				$user_id = mysqli_insert_id($db_connect);				
				
				//save sqm id (member reference code)
				$sqlUserSQMID = "UPDATE users SET ";
				$sqlUserSQMID .= "sqm_id = 'SQM".(date('md',strtotime($value['createdat']))."0".$user_id)."' ";
				$sqlUserSQMID .= "WHERE  id = '".$user_id."' ";
				if(!mysqli_query($db_connect,$sqlUserSQMID))
				throw new Exception(mysqli_error($db_connect));
								
				//directory path
				$directory_path = '../contents/associate/'.$user_id;
				//create directory based on id
				if(!file_exists($directory_path))
				mkdir($directory_path, 0777, true);
				
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
				if(!mysqli_query($db_connect,$sqlUserAssociateDetails))
				throw new Exception(mysqli_error($db_connect));

				//save member log registration approval
				$sqlLogAssociateApproval = "INSERT INTO log_associate_approval SET ";
				$sqlLogAssociateApproval .= "user_id = '".$user_id."', ";
				$sqlLogAssociateApproval .= "status = '1', ";
				$sqlLogAssociateApproval .= "remarks = 'New Associate Registered', ";
				$sqlLogAssociateApproval .= "createdby = '".$agent_id."', ";
				$sqlLogAssociateApproval .= "createdat = '".$value['createdat']."' ";
				if(!mysqli_query($db_connect,$sqlLogAssociateApproval))
				throw new Exception(mysqli_error($db_connect));

				//insert user_groups
				$sqluser_groups = "INSERT INTO user_groups SET ";
				$sqluser_groups .= "user_id = '".$user_id."', ";
				$sqluser_groups .= "groupaccess_id = '11' ";
				if(!mysqli_query($db_connect,$sqluser_groups))
				throw new Exception(mysqli_error($db_connect));
								
				//insert user points
				$sqluser_points = "INSERT INTO user_points SET ";
				$sqluser_points .= "user_id = '".$user_id."', ";
				$sqluser_points .= "total_points_value = '0', ";
				$sqluser_points .= "createdby = '".$agent_id."', ";
				$sqluser_points .= "createdat = '".$value['createdat']."' ";
				if(!mysqli_query($db_connect,$sqluser_points))
				throw new Exception(mysqli_error($db_connect));
								
				//update agent dashboard user
				$sqlDashboardUser = "UPDATE dashboard_user SET ";
				$sqlDashboardUser .= "total_normal = total_normal+1 ";
				$sqlDashboardUser .= "WHERE  user_id = '".$agent_id."' ";
				if(!mysqli_query($db_connect,$sqlDashboardUser))
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