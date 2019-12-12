<?php 
namespace app\components;

use Yii;
use app\models\LookupAction;
use app\models\SettingsRules;
use app\models\Users;
use app\models\GroupAccess;
use app\models\UserGroups;
use app\models\UserDevices;
use app\models\GroupListsTopics;
use app\models\LoginForm;
use app\models\ProductListing;
use app\models\LogUsers;
use app\models\WhatsNew;
use yii\base\ErrorException;

class AccessRule extends \yii\base\Component{
	
	private $userID;
	public $errorMessage;
	
    public function init() {
		//server settings
		date_default_timezone_set('Europe/London');

		$GLOBALS['successMessage'] = '';
		$GLOBALS['errorMessage'] = '';

		
		//session settings
		$session = Yii::$app->session;
		$settings_rules = $this->get_settings_rules($this->userID);
		$session->set('settings', $settings_rules);		

		if(!Yii::$app->user->isGuest)
		{
			if(strpos($_SERVER['REQUEST_URI'],"/login") !== false)
			{
				if(count($_POST)!=0)
				throw new \yii\web\HttpException(400, "You can't login multiple accounts to the same browser! Please close this browser's tab and continue with the existing session. Thank you!");
			}
			
			//get user id
			$this->userID = Yii::$app->user->getId();

			//session settings
			$settings_rules = $this->get_settings_rules($this->userID);
			$session->set('settings', $settings_rules);
		}
		else
		{
			//if(strpos($_SERVER['REQUEST_URI'],"login") === false and $_SERVER['REQUEST_URI'] != '/' and strpos($_SERVER['REQUEST_URI'],"/server/api/") === false and strpos($_SERVER['REQUEST_URI'],"/contents/") === false)
			if(strpos($_SERVER['REQUEST_URI'],"login") === false and strpos($_SERVER['REQUEST_URI'],"/server/api/") === false and strpos($_SERVER['REQUEST_URI'],"/contents/") === false and strpos($_SERVER['REQUEST_URI'],"/server/backoffice/") === false)
			{
				$browse_history = $_SERVER['REQUEST_URI'];
				$session = Yii::$app->session;
				$session->set('browse_history', $browse_history);			
				header('Location: /cmp/login');
				exit();
			}
		}
		
        parent::init();
    }

	public function get_settings_rules($user_id='')
	{
		/*
		//employer
		$employer_id = 1;
		
		//get employer_id
		if(strlen($user_id))
		{
	        $modelUserEmployer = new UserEmployer();
			$get_employer_id = $modelUserEmployer->getEmployerByUserID($user_id);
			$employer_id = strlen($get_employer_id)?$get_employer_id:$employer_id;
		}
		*/

		
		//process
		$sql = "SELECT r.settings_rules_key, rv.value as settings_rules_value FROM settings_rules r,settings_rules_value rv WHERE r.id=rv.settings_rules_id ";
		$connection = Yii::$app->getDb();
		$query = $connection->createCommand($sql);
		$result = $query->queryAll();

		if(count($result)==0)
		return false;
		else
		{
			$data = array();
			$data['SITE_URL'] = (isset($_SERVER['HTTPS'])?'https':'http') . '://' . $_SERVER['HTTP_HOST'].'/cmp';
	
			foreach($result as $rule)
			{
				$data[$rule['settings_rules_key']] = $rule['settings_rules_value'];
			}
			
			return $data;
		}
	}	

	public function get_permission()
	{
		//initialize
		global $config;
		$accessRule = array();
		$permission = array();
		
		//get record
		if($config['as beforeRequest']['rules'][0]['allow'] and in_array(Yii::$app->controller->id,$config['as beforeRequest']['rules'][0]['actions']))
		{
		return true;
		}
		elseif($this->userID==1)
		{
			$lookupPermission = Yii::$app->AccessMod->getAllControllerActions(Yii::$app->controller->id);
			
			foreach($lookupPermission as $lp)
			{
				$permission[]=$lp;
			}
		
			return $permission;
		}
		else
		{
			$sql = "SELECT DISTINCT m.id, m.name, m.parentid, m.controller, m.class, m.sort, mg.permission ";
			$sql .= "FROM users u, user_groups ug, modules m, module_groups mg ";
			$sql .= "WHERE 0=0 ";
			$sql .= "AND u.id=ug.user_id ";
			$sql .= "AND ug.groupaccess_id=mg.groupaccess_id ";
			$sql .= "AND mg.module_id=m.id ";
			$sql .= "AND u.id='".$this->userID."' ";
			$sql .= "AND m.controller='".Yii::$app->controller->id."' ";
			$connection = Yii::$app->getDb();
			$query = $connection->createCommand($sql);
			$result = $query->queryAll();

			if(count($result)==0)
			return false;
			else
			{
				foreach($result as $record)
				{
					$rawPermission = unserialize($record['permission']);
					foreach($rawPermission as $dataPermission)
					{
						if(!in_array($dataPermission,$permission))
						$permission[] = $dataPermission;
					}
				}
							
				return $permission;
			}
		}
	}
	
	public function get_default_action_by_controller($controller)
	{
		if(!isset($_SESSION['user']['id']))
		return false;

		if($_SESSION['user']['id'] == 1)
		return 'index';		
		
		$sql = "SELECT DISTINCT m.id, m.name, m.parentid, m.controller, m.class, m.sort, mg.permission ";
		$sql .= "FROM users u, user_groups ug, modules m, module_groups mg ";
		$sql .= "WHERE 0=0 ";
		$sql .= "AND u.id=ug.user_id ";
		$sql .= "AND ug.groupaccess_id=mg.groupaccess_id ";
		$sql .= "AND mg.module_id=m.id ";
		$sql .= "AND u.id='".$_SESSION['user']['id']."' ";
		$sql .= "AND m.controller='".$controller."' ";
		$connection = Yii::$app->getDb();
		$query = $connection->createCommand($sql);
		$result = $query->queryAll();

		if(count($result)==0)
		return false;
		else
		{
			$rawPermission = unserialize($result[0]['permission']);
			return $rawPermission[0];
		}
	}

	public static function get_modules()
	{
		if($this->userID==1)
		{
		$sql = "SELECT modules.* ";
		$sql .= "FROM modules ";
		$sql .= "WHERE 0=0 ";
		$sql .= "AND modules.status=1 ";
		}
		else
		{
		$sql = "SELECT modules.* ";
		$sql .= "FROM modulegroups,modules,groupaccesses,users,usergroups ";
		$sql .= "WHERE 0=0 ";
		$sql .= "AND modulegroups.module_id=modules.id ";
		$sql .= "AND modulegroups.groupaccess_id=groupaccesses.id ";
		$sql .= "AND usergroups.groupaccess_id=groupaccesses.id ";
		$sql .= "AND usergroups.user_id=users.id ";
		$sql .= "AND users.id='" . $this->userID . "' ";
		$sql .= "AND modules.status=1 ";
		}
		$data = Yii::app()->db->createCommand($sql)->queryAll();

		return $data;
	}


	public static function dateFormat($timeStamp,$format='')
	{
		//Yii::$app->AccessRule->dateFormat();
		
		if(is_int($timeStamp))
		return gmdate(strlen($format)?$format:$_SESSION['settings']['SITE_DATE_FORMAT'],$timeStamp+(60*60*$_SESSION['settings']['SITE_DATE_GMT']));
		else
		return false;
	}

	public function validateUserID($user_id)
	{
		$user = Users::find()
				->select(array('users.*','GROUP_CONCAT(user_groups.groupaccess_id) as groups'))
				->where(array('users.id'=>$user_id,'users.status'=>1,'deletedby'=>NULL,'deletedat'=>NULL))
				->leftJoin('user_groups', 'user_groups.user_id=users.id')
				->asArray()
				->one();
		if($user==NULL)
		{
			$this->errorMessage = 'User not active.';
			return false;
		}
		else
		return $user;
	}
	
	public function getUserGroups($user_id='')
	{
		//initialize
		$modelUserGroups = new UserGroups();
		$result = array();
		
		$connection = \Yii::$app->db;
		$transaction = $connection->beginTransaction();
		try
		{
			if(!strlen($user_id))
			throw new ErrorException("Invalid user id");
			
			$userGroups = UserGroups::find()->select(array('groupaccess_id'))->where(array('user_id'=>$user_id))->asArray()->all();
			
			if($userGroups==NULL)
			throw new ErrorException("Invalid group access");
			else
			{
				if(count($userGroups)!=0)
				{
					foreach($userGroups as $key => $user_group)
					{
						$result[$key] = $user_group['groupaccess_id'];
					}
				}
			}
			
			$transaction->commit();
		}
		catch (ErrorException $e) 
		{
			$transaction->rollBack();
			$this->errorMessage = $e->getMessage();
			return false;
		}
		
		if(strlen($this->errorMessage))
		return false;
		else
		return $result;
	}
	
	public function getGroupName($group_id='')
	{
		//initialize
		$modelGroupAccess = new GroupAccess();
		
		$connection = \Yii::$app->db;
		$transaction = $connection->beginTransaction();
		try
		{
			if(!strlen($group_id))
			throw new ErrorException("Invalid group id");
			
			$groupAccess = GroupAccess::find()->where(array('id'=>$group_id))->asArray()->one();

			$transaction->commit();
		}
		catch (ErrorException $e) 
		{
			$transaction->rollBack();
			$this->errorMessage = $e->getMessage();
			return false;
		}
		
		if(strlen($this->errorMessage))
		return false;
		else
		return $groupAccess['group_access_name'];
	}
		
	public function authenticateUser($username,$password,$log=true,$device_token='',$device_os='')
	{
		//initialize
		$modelUser = new Users();
		
		$connection = \Yii::$app->db;
		$transaction = $connection->beginTransaction();
		try
		{
			//check active user by username
			$userCA = $modelUser->CheckActiveUserByUsername($username);
								
			if(strlen($modelUser->errorMessage))
			throw new ErrorException($modelUser->errorMessage);
						
			if(!strlen($modelUser->errorMessage))
			{
				$user = $modelUser->getUserProfiles($username,$password);
				
				if(strlen($modelUser->errorMessage))
				throw new ErrorException($modelUser->errorMessage);
			}
									
			//create User devices
			if(strlen($device_token) and strlen($device_os))
			{
				$device = $this->userDevices($user['id'], $device_token, $device_os);
				if(!$device)
				throw new ErrorException($this->errorMessage);
			}
			
			//create log for successful authentication
			if($log)
			{				
				if(!strlen($modelUser->errorMessage))
				{
					$modelLoginForm = new LoginForm();
					$modelLoginForm->updateLastLogin($userCA->id,'Successful Login');
				}
				else
				{
					$modelLoginForm = new LoginForm();
					$modelLoginForm->updateLastLogin($userCA->id,'Login Failed');
				}
			}
			
			$transaction->commit();
		}
		catch (ErrorException $e) 
		{
			$transaction->rollBack();
			$this->errorMessage = $e->getMessage();
		}
		
		if(strlen($this->errorMessage))
		return false;
		else
		return $user;
	}
	
	public function socialAuth($username,$log=true,$device_token='',$device_os='')
	{
		//initialize
		$modelUser = new Users();
		
		$connection = \Yii::$app->db;
		$transaction = $connection->beginTransaction();
		try
		{
			//check active user by username
			$userCA = $modelUser->CheckActiveUserByUsername($username);
								
			if(strlen($modelUser->errorMessage))
			throw new ErrorException($modelUser->errorMessage);
						
			if(!strlen($modelUser->errorMessage))
			{
				$user = $modelUser->getUserProfilesByUsername($username);
				
				if(strlen($modelUser->errorMessage))
				throw new ErrorException($modelUser->errorMessage);
			}
									
			//create User devices
			if(strlen($device_token) and strlen($device_os))
			{
				$device = $this->userDevices($user['id'], $device_token, $device_os);
				if(!$device)
				throw new ErrorException($this->errorMessage);
			}
			
			//create log for successful authentication
			if($log)
			{				
				if(!strlen($modelUser->errorMessage))
				{
					$modelLoginForm = new LoginForm();
					$modelLoginForm->updateLastLogin($userCA->id,'Successful Login');
				}
				else
				{
					$modelLoginForm = new LoginForm();
					$modelLoginForm->updateLastLogin($userCA->id,'Login Failed');
				}
			}
			
			$transaction->commit();
		}
		catch (ErrorException $e) 
		{
			$transaction->rollBack();
			$this->errorMessage = $e->getMessage();
		}
		
		if(strlen($this->errorMessage))
		return false;
		else
		return $user;
	}

	public function authenticateUserByUUID($uuid,$log=true,$device_token='',$device_os='')
	{
		//check active user
		$modelUser = new Users();
		
		$connection = \Yii::$app->db;
		$transaction = $connection->beginTransaction();
		try
		{
			$userCA = $modelUser->CheckActiveUserByUUID($uuid);
			
			if(strlen($modelUser->errorMessage))
			throw new ErrorException($modelUser->errorMessage);
				
			if(!strlen($modelUser->errorMessage))
			{
				$user = $modelUser->getUserProfilesByUUID($uuid);
				
				if(strlen($modelUser->errorMessage))
				throw new ErrorException($modelUser->errorMessage);
			}
			
			//create User devices
			if(strlen($device_token) and strlen($device_os))
			{
				$device = $this->userDevices($user['id'], $device_token, $device_os);
				if(!$device)
				throw new ErrorException($this->errorMessage);
			}
		
			//create log for successful authentication
			if($log)
			{
				if(!strlen($modelUser->errorMessage))
				{
					$modelLoginForm = new LoginForm();
					$modelLoginForm->updateLastLogin($userCA->id,'Successful Login');
				}
				else
				{
					$modelLoginForm = new LoginForm();
					$modelLoginForm->updateLastLogin($userCA->id,'Login Failed');
				}
			}
			
			$transaction->commit();
		}
		catch (ErrorException $e) 
		{
			$transaction->rollBack();
			$this->errorMessage = $e->getMessage();
		}
		
		if(strlen($this->errorMessage))
		return false;
		else
		return $user;
	}

	public function authenticateUserFB($fb_id='',$fb_token='',$log=true,$device_token='',$device_os='')
	{
		//validate token
		if(!strlen($fb_id) and !strlen($fb_token))
		$this->errorMessage = 'Invalid fb information';
		
		if(!strlen($this->errorMessage))
		{
			$data = Yii::$app->AccessMod->httpRequest('https://graph.facebook.com/me',array('access_token'=>$fb_token),'GET');
			$data = json_decode($data);
			if(!$data)
			$this->errorMessage = Yii::$app->AccessMod->errorMessage;
			else
			{
				if(isset($data->error->message))
				$this->errorMessage = $data->error->message;
				else
				{
					if(isset($data->id))
					{
						if($data->id != $fb_id)
						$this->errorMessage = 'FB ID is not valid';
					}
				}
			}
		}

		//check active user
		if(!strlen($this->errorMessage))
		{
			$modelUser = new Users();
	
			$connection = \Yii::$app->db;
			$transaction = $connection->beginTransaction();
			try
			{				
				$user = $modelUser->getUserProfilesByFBid($fb_id);
				
				if(strlen($modelUser->errorMessage))
				throw new ErrorException($modelUser->errorMessage);
				
				//create User devices
				if(strlen($device_token) and strlen($device_os))
				{
					$device = $this->userDevices($user['id'], $device_token, $device_os);
					if(!$device)
					throw new ErrorException($this->errorMessage);
				}
								
				//create log for successful authentication
				if($log)
				{
					if(!strlen($modelUser->errorMessage))
					{
						$modelLoginForm = new LoginForm();
						$modelLoginForm->updateLastLogin($user['id'],'Successful Login');
					}
					else
					{
						$modelLoginForm = new LoginForm();
						$modelLoginForm->updateLastLogin($user['id'],'Login Failed');
					}
				}
				
				$transaction->commit();
			}
			catch (ErrorException $e) 
			{
				$transaction->rollBack();
				$this->errorMessage = $e->getMessage();
			}
		}
		
		if(strlen($this->errorMessage))
		return false;
		else
		return $user;
	}

	public function logHistory($user_id,$recordNo='')
	{
		$modelLogUsers = new LogUsers();
		
		$connection = \Yii::$app->db;
		$transaction = $connection->beginTransaction();
		try
		{
			$log = $modelLogUsers->getLoginHistory($user_id,$recordNo);
				
			if(strlen($modelLogUsers->errorMessage))
			throw new ErrorException($modelLogUsers->errorMessage);
			
			$transaction->commit();
		}
		catch (ErrorException $e) 
		{
			$transaction->rollBack();
			$this->errorMessage = $e->getMessage();
		}
		if(strlen($this->errorMessage))
		return false;
		else
		return $log;
	}
	
	public function userForgotPassword($email='')
	{
		//initialize
		$modelUser = new Users();
		$result = array();
		
		//validate
		try
		{
			if(!strlen($email))
			throw new ErrorException("Email is required.");

			if(strlen($email))
			{
				if(preg_match("/^([\w\.-]{1,50}+[@]{1}+[\w-]{1,50})+?([\.\w]{1,50})?([\.][\w]{1,50})$/",$email) == 0)
				throw new ErrorException("Invalid email format.");
			}
		}
		catch(ErrorException $e)
		{
			$this->errorMessage = $e->getMessage();
			return false;
		}
		
		$connection = \Yii::$app->db;
		$transaction = $connection->beginTransaction();
		try
		{
			//check active user
			$user = $modelUser->CheckActiveUserByEmail($email);
			
			if(strlen($modelUser->errorMessage))
			throw new ErrorException($modelUser->errorMessage);
			else
			{		
				//reset password
				$new_password = Yii::$app->AccessMod->generatePassword();
				
				$modelUser = Users::findOne($user->id);
				$modelUser->password = md5($new_password.$user->password_salt);
				$modelUser->password_repeat = $modelUser->password;
				$modelUser->save();
								
				if(count($modelUser->errors)!=0)
				throw new ErrorException("Failed to update password");
				else
				{
					//send email
					$mailTemplate = Yii::$app->AccessMod->getMailTemplate('MEMBER_FORGOT_PASSWORD');
					if(!$mailTemplate)
					throw new ErrorException(Yii::$app->AccessMod->errorMessage);
					else
					{
						$from = array();
						$from[0] = $_SESSION['settings']['SITE_EMAIL_USERNAME'];
						$from[1] = $_SESSION['settings']['SITE_NAME'];
						$to = array($modelUser->email);
						
						$subject = $_SESSION['settings']['SITE_NAME'].' : '.$mailTemplate['subject'];
						$message = $mailTemplate['template'];
						
						$message = Yii::$app->AccessMod->multipleReplace($message,array('site_url'=>$_SESSION['settings']['SITE_URL'],'name'=>$modelUser->name,'password'=>$new_password,'year'=>Yii::$app->AccessRule->dateFormat(time(), 'Y')));
						$sendEmail = Yii::$app->AccessMod->sendEmail($from, $to, $subject, $message);
						
						if(!$sendEmail)
						throw new ErrorException(Yii::$app->AccessMod->errorMessage);
					}
				}
			}
						
			$transaction->commit();
		}
		catch (ErrorException $e) 
		{
			$transaction->rollBack();
			$this->errorMessage = $e->getMessage();
			return false;
		}
		
		if(!strlen($this->errorMessage))
		{
			$result['user_id'] = $modelUser->id;
			$result['name'] = $modelUser->name;
			$result['email'] = $modelUser->email;
			$result['new_password'] = $new_password;
		}
		
		if(strlen($this->errorMessage))
		return false;
		else
		return $result;
	}		

	public function sync_fb_account($user_id,$fb_id='',$fb_token='')
	{
		if(!strlen($this->errorMessage) and !strlen($fb_id))
		$this->errorMessage = 'Invalid fb id';
		
		if(!strlen($this->errorMessage) and !strlen($fb_token))
		$this->errorMessage = 'Invalid fb token';
		
		//validate token
		if(!strlen($this->errorMessage))
		{
			$data = Yii::$app->AccessMod->httpRequest('https://graph.facebook.com/me',array('access_token'=>$fb_token),'GET');
			$data = json_decode($data);
			if(!$data)
			$this->errorMessage = Yii::$app->AccessMod->errorMessage;
			else
			{
				if(isset($data->error->message))
				$this->errorMessage = $data->error->message;
				else
				{
					if(isset($data->id))
					{
						if($data->id != $fb_id)
						$this->errorMessage = 'FB ID is not valid';
					}
				}
			}
		}
		
		//snyc process
		if(!strlen($this->errorMessage))
		{
			$modelUsers = new Users();
			$result = $modelUsers->user_sync_fb_account($user_id,$fb_id);
			if(!$result)
			$this->errorMessage = $modelUsers->errorMessage;
			else
			{
				$result = $result->fb_info;
			}
		}
			
		//return
		if(strlen($this->errorMessage))
		return false;
		else
		return $result;
	}		

	public function userDevices($user_id, $device_token='', $device_os='')
	{
		$modelUserDevices = new UserDevices();
		$modelGroupListsTopics = new GroupListsTopics();
		
		//check device exist
		$userDevice = $modelUserDevices->getUserDevices($user_id, $device_token);

		//add customer devices
		if(!$userDevice)
		{
			$connection = \Yii::$app->db;
			$transaction = $connection->beginTransaction();
			try
			{
				$modelUserDevices = new UserDevices();
				$modelUserDevices->user_id = $user_id;
				$modelUserDevices->device_token = trim($device_token);
				$modelUserDevices->device_os = $device_os;
				$modelUserDevices->save();
				
				if(count($modelUserDevices->errors)!=0)
				throw new ErrorException('Failed to create customer device.');
				
				//register device to all topic
				if(!strlen($this->errorMessage))
				{
					$devices = array();
					$devices[] = $modelUserDevices->device_token;
					$registerDevice = Yii::$app->AccessMod->pushNotificationRegisterDeviceToTopic('all', $devices);
					
					if(!$registerDevice)
					throw new ErrorException(Yii::$app->AccessMod->errorMessage);
				}
				
				//get topic list
				$otherTopicObj = $modelGroupListsTopics->getAllTopicListExceptAll();
				
				if(count($otherTopicObj)!=0)
				{
					$devices = array();
					$devices[] = $modelUserDevices->device_token;
					
					foreach($otherTopicObj as $topic)
					{
						//register device to other topic
						if(in_array($user_id, Json::decode($topic['user_id'])))
						$registerDevice = Yii::$app->AccessMod->pushNotificationRegisterDeviceToTopic($topic['topic_name'], $devices);
						
						if(!$registerDevice)
						throw new ErrorException(Yii::$app->AccessMod->errorMessage);
					}
				}
				
				$transaction->commit();
			}
			catch (ErrorException $e) 
			{
				$transaction->rollBack();
				$this->errorMessage = $e->getMessage();
			}
		}
		
		if(!strlen($this->errorMessage))
		{
			//get device
			$modelUserDevices = new UserDevices();
			$userDevice = $modelUserDevices->getUserDevices($user_id, $device_token);
		}
							
		if(strlen($this->errorMessage))
		return false;
		else
		return $userDevice;
	}

	public function getTemplateActions()
	{
		$template = array();
		
		foreach($_SESSION['user']['permission'] as $action)
		{
			$template[] = '{'.$action.'}';
		}
		
		$template = implode(' ',$template);
		
		return $template;
	}

	/*public function getLeadsProductTemplateActions($product_id)
	{
		$template = array();
		$template[] = '{view}';
		
		$productDetails = ProductListing::find()->where(array('id'=>$product_id))->asArray()->one();
		
		if($productDetails['status']==1)
		$template[] = '{update}';
		
		$template[] = '{delete}';
		$template = implode(' ',$template);
		
		return $template;
	}*/
	
	

}
?>