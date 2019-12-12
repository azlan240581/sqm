<?php
namespace app\components;

use Yii;
use yii\helpers\Html;
use yii\base\ErrorException;
use app\models\SettingsRules;
use app\models\LoginForm;
use yii\helpers\Json;
use yii\helpers\FileHelper;

use app\models\Users;
use app\models\UserGroups;
use app\models\UserAssociateDetails;
use app\models\UserMessages;
use app\models\UserPoints;
use app\models\PotentialAssociates;
use app\models\PotentialProspects;
use app\models\AssociateEmailVerification;

use app\models\Projects;
use app\models\ProjectAgents;
use app\models\UserCommissions;

use app\models\Rewards;
use app\models\UserRewardRedemptions;
use app\models\LogUserRewardRedemptions;

use app\models\LogUsers;
use app\models\LogUserPoints;
use app\models\LogAssociateApproval;
use app\models\LookupAvatars;
use app\models\LookupCountry;
use app\models\LookupPositions;

use app\models\DashboardUser;
use app\models\SystemEmailTemplate;


class MemberMod extends \yii\base\Component{

	public $errorMessage;

    public function init() {
        parent::init();
    }
		
	public function memberInvitation($inputs=array(),$inviterID='')
	{
		$modelUser = new Users();
		
		//validate
		try
		{
			if(!is_array($inputs))
			throw new ErrorException("Invalid inputs(1).");

			if(count($inputs)==0)
			throw new ErrorException("Invalid inputs(2).");
			
			if(empty($inviterID))
			throw new ErrorException("Invalid inviter id.");
			
			//get inviter group id
			$inviterGroupID = Yii::$app->AccessMod->getUserGroupID($inviterID);
			if($inviterGroupID == 11)
			{
				//get associate user
				$user = Users::find()->where(array('id'=>$inviterID))->asArray()->one();
			}
			else
			{
				if(empty($inputs['upline']))
				throw new ErrorException("Upline is required.");
				else
				{
					//get sqm account manager user
					$user = Users::find()->where(array('id'=>$inputs['upline']))->asArray()->one();
				}
			}
			
			if(empty($inputs['firstname']))
			throw new ErrorException("First name is required.");
						
			if(empty($inputs['lastname']))
			throw new ErrorException("Last name is required.");
						
			if(empty($inputs['email']))
			throw new ErrorException("Email is required.");
			
			if(strlen($inputs['email']))
			{
				if(preg_match("/^([\w\.-]{1,50}+[@]{1}+[\w-]{1,50})+?([\.\w]{1,50})?([\.][\w]{1,50})$/",$inputs['email']) == 0)
				throw new ErrorException("Incorrect email format.");
			}
			
			if(strlen($inputs['email']))
			{
				//check email already exist
				$checkUserByEmail = $modelUser->CheckActiveUserByEmail($inputs['email']);
				if($checkUserByEmail)
				throw new ErrorException("Email address ".$inputs['email']." already register in SQM Property.");
			}
			
			$potential_associate = PotentialAssociates::find()
									->where(['email'=>$inputs['email']])
									->andWhere(['between','createdat', Yii::$app->AccessRule->dateFormat(strtotime("-7 day"), 'Y-m-d'), Yii::$app->AccessRule->dateFormat(strtotime("+1 day"), 'Y-m-d')])
									->asArray()
									->all();
			
			if(count($potential_associate)!=0)
			throw new ErrorException("Associate already been invited.");			
						
			if(empty($inputs['country_code']))
			throw new ErrorException("Country code is required.");
			
			if(strlen($inputs['country_code']))
			{
				if(preg_match("/^([0-9]{1,10})$/",$inputs['country_code']) == 0)
				throw new ErrorException("Incorrect country code format.");
			}
			
			if(empty($inputs['contact_no']))
			throw new ErrorException("Contact number is required.");
			
			if(strlen($inputs['contact_no']))
			{
				if(preg_match("/^([0-9]{5,20})$/",$inputs['contact_no']) == 0)
				throw new ErrorException("Incorrect contact number format.");
			}
		}
		catch(ErrorException $e)
		{
			$this->errorMessage = $e->getMessage();
			return false;
		}
		
		//process
		$connection = Yii::$app->db;
		$transaction = $connection->beginTransaction();
		try 
		{
			//save potential associates
			$modelPotentialAssociates = PotentialAssociates::find()->where(array('email'=>$inputs['email']))->one();
			if($modelPotentialAssociates!=NULL)
			{
				$modelPotentialAssociates->inviter_id = $inviterID;
				$modelPotentialAssociates->name = trim($inputs['firstname']).' '.trim($inputs['lastname']);
				$modelPotentialAssociates->email = $inputs['email'];
				$modelPotentialAssociates->contactno = $inputs['country_code'].$inputs['contact_no'];
				$modelPotentialAssociates->createdat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
			}
			else
			{
				$modelPotentialAssociates = new PotentialAssociates();
				$modelPotentialAssociates->inviter_id = $inviterID;
				$modelPotentialAssociates->name = trim($inputs['firstname']).' '.trim($inputs['lastname']);
				$modelPotentialAssociates->email = $inputs['email'];
				$modelPotentialAssociates->contactno = $inputs['country_code'].$inputs['contact_no'];
				$modelPotentialAssociates->createdat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
			}
			$modelPotentialAssociates->save();
			if(count($modelPotentialAssociates->errors)!=0)
			throw new ErrorException("Create potential associate failed.");
			
			$mailTemplate = Yii::$app->AccessMod->getMailTemplate('MEMBER_INVITATION_TEMPLATE');
			if(!$mailTemplate)
			throw new ErrorException(Yii::$app->AccessMod->errorMessage);
			else
			{
				$from = array();
				$from[0] = $_SESSION['settings']['SITE_EMAIL_USERNAME'];
				$from[1] = $_SESSION['settings']['SITE_NAME'];
				$to = array(array($inputs['email'],trim($inputs['firstname']).' '.trim($inputs['lastname'])));
				
				$subject = $mailTemplate['subject'];
				$message = $mailTemplate['template'];
				
				if($inviterID==1)
				{
					$inviter_name = 'Administrator';
					$inviter_group_name = 'Administrator';
				}
				else
				{
					$inviter_name = Yii::$app->AccessMod->getName($inviterID);
					$inviter_group_name = Yii::$app->AccessMod->getUserGroupName(Yii::$app->AccessMod->getUserGroupID($inviterID));
				}
				
				$modelUser = Users::find()->where(array('id'=>$inviterID))->one();
				if(!empty($modelUser->avatar))
				$profile_image = $modelUser->avatar;
				else
				$profile_image = str_replace('/cmp','',$_SESSION['settings']['SITE_URL']).''.$modelUser->getUserAvatarImage($modelUser->avatar_id);
				
				if($inviterGroupID == 11)
				$sqm_id_reference_code_title = 'Associate Reference Code';
				else
				$sqm_id_reference_code_title = 'SQM Account Manager ID';
				
				$subject = Yii::$app->AccessMod->multipleReplace($subject,array('inviter_name'=>$inviter_name));
				$message = Yii::$app->AccessMod->multipleReplace($message,array('site_url'=>$_SESSION['settings']['SITE_URL'],'site_url_no_cmp'=>str_replace('/cmp','',$_SESSION['settings']['SITE_URL']),'inviter_name'=>$inviter_name,'inviter_group_name'=>$inviter_group_name,'profile_image'=>$profile_image,'sqm_id_reference_code_title'=>$sqm_id_reference_code_title,'sqm_id_reference_code_value'=>(strlen($user['sqm_id'])?$user['sqm_id']:$user['uuid']),'site_name'=>'SQM Property','year'=>Yii::$app->AccessRule->dateFormat(time(), 'Y')));

				$sendInvitation = Yii::$app->AccessMod->sendEmail($from, $to, $subject, $message);
				
				if(!$sendInvitation)
				throw new ErrorException("Failed to send invitation email.");
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
			$result['success'] = true;
			
			if($inviterGroupID == 11)
			$result['reference_code'] = $user['uuid'];
			else
			$result['sqm_account_manager_id'] = $user['uuid'];
			
			return $result;
		}
	}
	
	public function getVerficationCode()
	{
		$verification_code = Yii::$app->AccessMod->generateVerificationCode();
		
		//check exist
		$associateEmailVerification = AssociateEmailVerification::find()->where(array('verification_code'=>$verification_code))->asArray()->all();
		if(count($associateEmailVerification)!=0)
		$this->getVerficationCode();
		else
		return $verification_code;
	}
	
	public function memberEmailVerificationCode($inputs=array())
	{
		$modelUser = new Users();
		$modeAssociateEmailVerification = new AssociateEmailVerification();
		
		//validate
		try
		{
			if(!is_array($inputs))
			throw new ErrorException("Invalid inputs(1).");

			if(count($inputs)==0)
			throw new ErrorException("Invalid inputs(2).");
						
			if(empty($inputs['firstname']))
			throw new ErrorException("First name is required.");
			
			if(empty($inputs['lastname']))
			throw new ErrorException("Last name is required.");
			
			if(empty($inputs['email']))
			throw new ErrorException("Email is required.");
			
			if(strlen($inputs['email']))
			{
				if(preg_match("/^([\w\.-]{1,50}+[@]{1}+[\w-]{1,50})+?([\.\w]{1,50})?([\.][\w]{1,50})$/",$inputs['email']) == 0)
				throw new ErrorException("Incorrect email format.");
			}
		}
		catch(ErrorException $e)
		{
			$this->errorMessage = $e->getMessage();
			return false;
		}
		
		//process
		$connection = Yii::$app->db;
		$transaction = $connection->beginTransaction();
		try 
		{
			$verification_code = $this->getVerficationCode();
			
			//save associate email verification
			$modeAssociateEmailVerification = AssociateEmailVerification::find()->where(array('email'=>trim($inputs['email'])))->one();
			if($modeAssociateEmailVerification!=NULL)
			{
				$modeAssociateEmailVerification->firstname = $inputs['firstname'];
				$modeAssociateEmailVerification->lastname = $inputs['lastname'];
				$modeAssociateEmailVerification->verification_code = $verification_code;
				$modeAssociateEmailVerification->createdat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
			}
			else
			{
				$modeAssociateEmailVerification = new AssociateEmailVerification();
				$modeAssociateEmailVerification->firstname = $inputs['firstname'];
				$modeAssociateEmailVerification->lastname = $inputs['lastname'];
				$modeAssociateEmailVerification->email = $inputs['email'];
				$modeAssociateEmailVerification->verification_code = $verification_code;
				$modeAssociateEmailVerification->createdat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
			}
			$modeAssociateEmailVerification->save();
			if(count($modeAssociateEmailVerification->errors)!=0)
			throw new ErrorException("Create associate verification code failed.");
			
			$mailTemplate = Yii::$app->AccessMod->getMailTemplate('MEMBER_EMAIL_VERIFICATION');
			if(!$mailTemplate)
			throw new ErrorException(Yii::$app->AccessMod->errorMessage);
			else
			{
				$from = array();
				$from[0] = $_SESSION['settings']['SITE_EMAIL_USERNAME'];
				$from[1] = $_SESSION['settings']['SITE_NAME'];
				$to = array(array($inputs['email'],$inputs['firstname'].' '.$inputs['lastname']));
				
				$subject = $mailTemplate['subject'];
				
				$message = $mailTemplate['template'];
				$message = Yii::$app->AccessMod->multipleReplace($message,array('site_url'=>$_SESSION['settings']['SITE_URL'],'firstname'=>$inputs['firstname'],'lastname'=>$inputs['lastname'],'verification_code'=>$verification_code,'site_name'=>'SQM Property','year'=>Yii::$app->AccessRule->dateFormat(time(), 'Y')));
				$sendInvitation = Yii::$app->AccessMod->sendEmail($from, $to, $subject, $message);
				
				if(!$sendInvitation)
				throw new ErrorException("Send email verification code failed.");
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
			$result['success'] = true;
			$result['firstname'] = $inputs['firstname'];
			$result['lastname'] = $inputs['lastname'];
			$result['email'] = $inputs['email'];
			$result['verification_code'] = $verification_code;
			
			return $result;
		}
	}
	
	public function getAgentTotalMember($agentIDs=array())
	{
		//validate
		try
		{
			if(!is_array($agentIDs))
			throw new ErrorException("Invalid agent ID(1).");

			if(count($agentIDs)==0)
			throw new ErrorException("Invalid agent ID(2).");
			
			$sql = "SELECT u.id as agent_id, ";
			$sql .= "if((SELECT count(uad.id) FROM user_associate_details uad WHERE uad.agent_id=u.id GROUP BY uad.agent_id) >= 1, (SELECT count(uad.id) FROM user_associate_details uad WHERE uad.agent_id=u.id GROUP BY uad.agent_id), 0) as total_member ";
			$sql .= "FROM users u ";
			$sql .= "WHERE 0=0 ";
			$sql .= "AND u.status = 1 ";
			$sql .= "AND u.deletedby IS NULL ";
			$sql .= "AND u.deletedat IS NULL ";
			$sql .= "AND u.id IN (".implode(',',$agentIDs).") ";
			$sql .= "ORDER BY total_member ASC ";
			
			$connection = Yii::$app->getDb();
			$query = $connection->createCommand($sql);
			$records = $query->queryAll();
						
			if(count($records)==0)
			throw new ErrorException("Invalid agent ID(3).");
			else
			return $records;
			
		}
		catch(ErrorException $e)
		{
			$this->errorMessage = $e->getMessage();
			return false;
		}
	}
		
	public function memberRegistration($inputs=array())
	{
		//initialize
        $result = array();
        $modelUser = new Users();
        $modelUserGroups = new UserGroups();
        $modelUserAssociateDetails = new UserAssociateDetails();
        $modelUserPoints = new UserPoints();
        $modelLogUserPoints = new LogUserPoints();
        $modelLogAssociateApproval = new LogAssociateApproval();
        $modelAssociateEmailVerification = new AssociateEmailVerification();
		$modelDashboardUser = new DashboardUser();
		
		//validate
		try
		{
			if(!is_array($inputs))
			throw new ErrorException("Invalid inputs(1).");

			if(count($inputs)==0)
			throw new ErrorException("Invalid inputs(2).");
			
			//validate firstname
			if(empty($inputs['firstname']))
			throw new ErrorException("First name is required.");
			
			//validate lastname
			if(empty($inputs['lastname']))
			throw new ErrorException("Last name is required.");
			
			//validate email
			if(empty($inputs['email']))
			throw new ErrorException("Email is required.");
						
			if(strlen($inputs['email']))
			{
				if(preg_match("/^([\w\.-]{1,50}+[@]{1}+[\w-]{1,50})+?([\.\w]{1,50})?([\.][\w]{1,50})$/",$inputs['email']) == 0)
				throw new ErrorException("Incorrect email format.");
			}
			
			if(strlen($inputs['email']))
			{
				//check email already exist
				$checkUserByEmail = $modelUser->CheckActiveUserByEmail($inputs['email']);
				if($checkUserByEmail)
				throw new ErrorException("Email address ".$inputs['email']." already been used.");
			}
			
			//validate password
			if(empty($inputs['password']))
			throw new ErrorException("Password is required");
						
			//validate password repeat
			if(empty($inputs['password_repeat']))
			throw new ErrorException("Password Repeat is required");
						
			//validate password and password repeat
			if($inputs['password'] != $inputs['password_repeat'])
			throw new ErrorException("Password and Password Repeat not match");
			
			//validate country code
			if(empty($inputs['country_code']))
			throw new ErrorException("Country code is required.");
			
			if(strlen($inputs['country_code']))
			{
				if(preg_match("/^([0-9]{1,5})$/",$inputs['country_code']) == 0)
				throw new ErrorException("Incorrect country code format.");
			}
			
			//validate contact number
			if(empty($inputs['contact_number']))
			throw new ErrorException("Contact number is required.");
			
			if(strlen($inputs['contact_number']))
			{
				if(preg_match("/^([0-9]{5,20})$/",$inputs['contact_number']) == 0)
				throw new ErrorException("Incorrect contact number format.");
			}
			
			//validate contact number
			if(empty($inputs['verification_code']))
			throw new ErrorException("Verification code is required.");
			
			if(strlen($inputs['verification_code']))
			{
				//check verification code
				$associateEmailVerification = AssociateEmailVerification::find()
												->where(['email'=>$inputs['email'],'verification_code'=>$inputs['verification_code']])
												->asArray()
												->all();
				if(count($associateEmailVerification)==0)
				throw new ErrorException("Invalid verification code.");			
			}
			
			//validate sqm account manager id and preferred project id
			if(!strlen($inputs['sqm_account_manager_id']) and !strlen($inputs['preferred_project_id']))
			throw new ErrorException("Either SQM Account Manager ID or Preferred Project is required.");
			
			//validate sqm account manager id
			if(strlen($inputs['sqm_account_manager_id']))
			{
				$sqmAccountManager = $modelUser->getUserByUUIDorSQMID($inputs['sqm_account_manager_id']);;
				if(!$sqmAccountManager)
				throw new ErrorException("Invalid SQM Account Manager ID.");
				else
				{
					//validate sqm account manager group
					$sqmAccountManagerGroupID = Yii::$app->AccessMod->getUserGroupID($sqmAccountManager['id']);
					if(!in_array($sqmAccountManagerGroupID,array(7,8,9,10)))
					throw new ErrorException("Invalid SQM Account Manager ID.");
				}
			}

			if(!strlen($inputs['sqm_account_manager_id']) and strlen($inputs['preferred_project_id']))
			{
				//check project id
				$project = Projects::find()->where(array('id'=>$inputs['preferred_project_id'],'status'=>1,'deletedby'=>NULL,'deletedat'=>NULL))->one();
				if($project==NULL)
				throw new ErrorException("Invalid preferred project.");

				//get sqm account manager by project id
				$projectAgents = ProjectAgents::find()->where(array('project_id'=>$inputs['preferred_project_id']))->asArray()->all();
				if($projectAgents==NULL)
				throw new ErrorException("No SQM Account Manager assign to this project referred project.");
				else
				{
					if(count($projectAgents)==0)
					throw new ErrorException("No SQM Account Manager for the project preferred.");
					elseif(count($projectAgents)==1)
					$sqmAccountManager = Users::find()->where(array('id'=>$projectAgents[0]['agent_id'],'status'=>1,'deletedby'=>NULL,'deletedat'=>NULL))->asArray()->one();
					else
					{
						$tmp = $this->getAgentTotalMember(array_column($projectAgents,'agent_id'));
						//randomize process not set yet
						$sqmAccountManager = Users::find()->where(array('id'=>$tmp[0]['agent_id'],'status'=>1,'deletedby'=>NULL,'deletedat'=>NULL))->asArray()->one();
					}
				}
			}
			
			if(strlen($inputs['reference_code']))
			{
				$associate = $modelUser->getUserByUUIDorSQMID($inputs['reference_code']);;
				if(!$associate)
				throw new ErrorException("Invalid reference code.");
				else
				{
					//validate reference code group
					$associateGroupID = Yii::$app->AccessMod->getUserGroupID($associate['id']);
					if($associateGroupID!=11)
					throw new ErrorException("Invalid reference code.");
				}
			}
			
			$member = Users::find()
						->select('id')
						->where(['email'=>$inputs['email'],'name'=>$inputs['firstname'].' '.$inputs['lastname'],'country_code'=>$inputs['country_code'],'contact_number'=>$inputs['contact_number'],'status'=>1])
						->andWhere(['between','createdat',Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d'), Yii::$app->AccessRule->dateFormat(strtotime("+1 day"), 'Y-m-d')])
						->asArray()
						->all();
			if(count($member)!=0)
			throw new ErrorException("This member already been registered.");			
		}
		catch(ErrorException $e)
		{
			$this->errorMessage = $e->getMessage();
			return false;
		}
					
		//process
		$connection = Yii::$app->db;
		$transaction = $connection->beginTransaction();
		try 
		{
			//delete associate email verification
			AssociateEmailVerification::findOne($associateEmailVerification[0]['id'])->delete();
			
			//save user
			$modelUser = new Users();
			$modelUser->username = strtolower(trim($inputs['email']));
			$modelUser->email = strtolower(trim($inputs['email']));
			$modelUser->firstname = trim($inputs['firstname']);
			$modelUser->lastname = trim($inputs['lastname']);
			$modelUser->name = trim($modelUser->firstname.' '.$modelUser->lastname);
			$modelUser->country_code = trim($inputs['country_code']);
			$modelUser->contact_number = trim($inputs['contact_number']);
			$modelUser->password_salt = Yii::$app->AccessMod->getSalt();
			$modelUser->password = trim($inputs['password']);
			$modelUser->password = md5($modelUser->password.$modelUser->password_salt);
			$modelUser->password_repeat = $modelUser->password;
			if(strlen($inputs['dob']))
			$modelUser->dob = $inputs['dob'];
			if(strlen($inputs['gender']))
			$modelUser->gender = $inputs['gender'];
			$modelUser->avatar_id = 1;
			$modelUser->status = 1;
			$modelUser->createdby = 1;
			$modelUser->createdat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
			$modelUser->save();

			if(count($modelUser->errors)!=0)
			{
				foreach($modelUser->errors as $key=>$model_error)
				{
					if($key!='username')
					throw new ErrorException($model_error[0]);
				}
			}

			//save sqm id
			$modelUser->sqm_id = 'SQM'.date('md').'0'.$modelUser->id;
			$modelUser->save();
			if(count($modelUser->errors)!=0)
			throw new ErrorException("Create user sqm id failed.");

			//save user uuid
			$modelUser->uuid = Yii::$app->AccessMod->get_uuid($modelUser->id.$modelUser->username.$modelUser->createdat);
			$modelUser->save();
			if(count($modelUser->errors)!=0)
			throw new ErrorException("Create user uuid failed.");
									
			//create qrcode
			Yii::$app->AccessMod->QRcode('user',$modelUser->uuid);

			//save group
			$modelUserGroups = new UserGroups();
			$modelUserGroups->user_id = $modelUser->id;
			$modelUserGroups->groupaccess_id = 11;
			$modelUserGroups->save();
			if(count($modelUserGroups->errors)!=0)
			throw new ErrorException("Failed to create user group.");
			
			//save user associate details
			$modelUserAssociateDetails = new UserAssociateDetails();
			$modelUserAssociateDetails->user_id = $modelUser->id;
			
			if(strlen($inputs['reference_code']))
			$modelUserAssociateDetails->referrer_id = $associate['id'];
			
			$modelUserAssociateDetails->agent_id = $sqmAccountManager['id'];
			$modelUserAssociateDetails->approval_status = 1;
			$modelUserAssociateDetails->productivity_status = 1;
			$modelUserAssociateDetails->save();
			if(count($modelUserAssociateDetails->errors)!=0)
			throw new ErrorException("Create associate details failed.");
			
			//dashboard user
			$modelDashboardUser = DashboardUser::find()->where(array('user_id'=>$sqmAccountManager['id']))->one();
			if($modelDashboardUser==NULL)
			{
				$modelDashboardUser = new DashboardUser();
				$modelDashboardUser->user_id = $sqmAccountManager['id'];
				$modelDashboardUser->total_normal = 1;
				$modelDashboardUser->save();
				if(count($modelDashboardUser->errors)!=0)
				throw new ErrorException("Create dashboard user failed.");
			}
			else
			{
				$modelDashboardUser->total_normal = $modelDashboardUser->total_normal+1;
				$modelDashboardUser->save();
				if(count($modelDashboardUser->errors)!=0)
				throw new ErrorException("Update dashboard user failed.");
			}
						
			//save member points
			$modelUserPoints = new UserPoints();
			$modelUserPoints->user_id = $modelUser->id;
			$modelUserPoints->total_points_value = 0;
			$modelUserPoints->createdby = 1;
			$modelUserPoints->createdat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
			$modelUserPoints->save();
			if(count($modelUserPoints->errors)!=0)
			throw new ErrorException("Create user points failed.");
						
			//directory path
			$directory_path = 'contents/associate/'.$modelUser->id;
			//create directory based on id
			Yii::$app->AccessMod->createDirectory($directory_path);
			
			//send welcome message to member
			$subject = 'Welcome to SQM Property';
			$message = 'Hello '.$modelUser->name.'. Welcome to SQM Property.';
			$sendMessage = Yii::$app->AccessMod;
			if(!$sendMessage->sendMessage($modelUser->id,$subject,$message,1,1))
			throw new ErrorException($sendMessage->errorMessage);
										
			//give points for activity - New Associate Registered
			$memberPointsActivities = Yii::$app->PointsMod;
			if(!($memberPointsActivities = $memberPointsActivities->memberPointsActivities($modelUser->id,'ASSOCIATE_REGISTRATION',1)))
			throw new ErrorException($memberPointsActivities->errorMessage);
										
			//save log member registration approval
			$modelLogAssociateApproval = new LogAssociateApproval();
			$modelLogAssociateApproval->user_id = $modelUser->id;
			$modelLogAssociateApproval->remarks = 'New Associate Registered';
			$modelLogAssociateApproval->status = '1';
			$modelLogAssociateApproval->createdby = 1;
			$modelLogAssociateApproval->createdat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
			$modelLogAssociateApproval->save();
			if(count($modelLogAssociateApproval->errors)!=0)
			throw new ErrorException("Create log associte approval failed.");
						
			if(strlen($inputs['reference_code']))
			{
				//give points to member for member get member activity
				$memberPointsActivities = Yii::$app->PointsMod;
				if(!($memberPointsActivities = $memberPointsActivities->memberPointsActivities($associate['id'],'ASSOCIATE_GET_ASSOCIATE',1)))
				throw new ErrorException($memberPointsActivities->errorMessage);
			}
						
			//send message to agent about associate registered
			$subject = 'New Associate '.$modelUser->name.' Registered';
			$message = 'Associate name '.$modelUser->name.' has successful registered. Click <a href="'.$_SESSION['settings']['SITE_URL'].'/associates/view-agent/?id='.$modelUser->id.'">here</a> to view the associate.';
			$sendMessage = Yii::$app->AccessMod;
			if(!$sendMessage->sendMessage($sqmAccountManager['id'],$subject,$message,1,2))
			throw new ErrorException($sendMessage->errorMessage);
			
			//check new potential associate
			$potentialAssociatesArray = PotentialAssociates::find()->where(array('email'=>$inputs['email']))->asArray()->all();
			if($potentialAssociatesArray != NULL)
			{
				if(count($potentialAssociatesArray)!=0)
				{
					foreach($potentialAssociatesArray as $key=>$value)
					{
						$modelPotentialAssociates = PotentialAssociates::find()->where(array('id'=>$value['id']))->one();
						$modelPotentialAssociates->status = 1;
						$modelPotentialAssociates->register_at = $modelUser->createdat;
						$modelPotentialAssociates->user_id = $modelUser->id;
						$modelPotentialAssociates->save();
						if(count($modelPotentialAssociates->errors)!=0)
						{
							throw new ErrorException("Update potential associate failed.");
							break;
						}
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
			$result['id'] = $modelUser->id;
			$result['uuid'] = $modelUser->uuid;
			$result['username'] = $modelUser->username;
			$result['name'] = $modelUser->name;
			$result['email'] = $modelUser->email;
			$result['contact_number'] = $modelUser->contact_number;
			$result['dob'] = $modelUser->dob;
			
			return $result;
		}
	}
		
	public function memberProfile($inputs=array(),$member_id,$user_id)
	{		
		//initialize
        $result = array();
        $modelUser = new Users();
        $modelUserAssociateDetails = new UserAssociateDetails();
        $modelLogAssociateApproval = new LogAssociateApproval();
		
		//validate
		try
		{
			if(!is_array($inputs))
			throw new ErrorException("Invalid inputs(1).");

			if(count($inputs)==0)
			{
				$inputs['action']='list';
				//throw new ErrorException("Invalid inputs(2).");
			}
			
			if(!isset($inputs['action']))
			throw new ErrorException("Invalid action.");
			
			if($inputs['action']=='updatepassword')
			{
				if(!isset($inputs['password']))
				throw new ErrorException("Password is required.");
				
				if(!isset($inputs['password_repeat']))
				throw new ErrorException("Password repeat is required.");
				
				if($inputs['password']!=$inputs['password_repeat'])
				throw new ErrorException("Password and password repeat not match.");
			}
			elseif($inputs['action']=='update')
			{
				if(isset($inputs['email']))
				{
					if(strlen($inputs['email']))
					{
						if(preg_match("/^([\w\.-]{1,50}+[@]{1}+[\w-]{1,50})+?([\.\w]{1,50})?([\.][\w]{1,50})$/",$inputs['email']) == 0)
						throw new ErrorException("Incorrect email format.");
					}
				}
		
				if(isset($inputs['email']))
				{
					if(strlen($inputs['email']))
					{
						$checkUserByEmail = $modelUser->CheckActiveUserByEmail($inputs['email']);
						if($checkUserByEmail)
						{
							if($checkUserByEmail->id!=$member_id)
							throw new ErrorException("Email address ".$inputs['email']." already been used.");
						}
					}
				}
			
				if(strlen($inputs['sqm_id']))
				{
					$tmpUser = Users::find()->where(array('sqm_id'=>$inputs['sqm_id'],'status'=>1,'deletedby'=>NULL,'deletedat'=>NULL))->one();
					if($tmpUser!=NULL)
					{
						if($tmpUser->id != $member_id)
						throw new ErrorException("SQM ID '".$inputs['sqm_id']."' has already been taken.");
					}
					
					if(preg_match('/^[a-zA-Z0-9-]+$/i', $inputs['sqm_id'])==0)
					throw new ErrorException("SQM ID '".$inputs['sqm_id']."' is invalid. Alphanumeric and hyphen only.");
				}
			
				if(isset($inputs['country_code']))
				{
					if(strlen($inputs['country_code']))
					{
						if(preg_match("/^([0-9]{1,5})$/",$inputs['country_code']) == 0)
						throw new ErrorException("Incorrect country code format.");
					}
				}
				
				if(isset($inputs['contact_number']))
				{
					if(strlen($inputs['contact_number']))
					{
						if(preg_match("/^([0-9]{5,20})$/",$inputs['contact_number']) == 0)
						throw new ErrorException("Incorrect contact number format.");
					}
				}
			}
		}
		catch(ErrorException $e)
		{
			$this->errorMessage = $e->getMessage();
			return false;
		}
				
		//process
		$connection = Yii::$app->db;
		$transaction = $connection->beginTransaction();
		try 
		{
			if($inputs['action']=='update')
			{	
				//update user
				$modelUser = Users::find()->where(array('id'=>$member_id))->one();
				if(!empty($inputs['sqm_id']))
				$modelUser->sqm_id = trim($inputs['sqm_id']);
				unset($modelUser->password);
				if(!empty($inputs['email']))
				{
					$modelUser->username = strtolower(trim($inputs['email']));
					$modelUser->email = strtolower(trim($inputs['email']));
				}
				
				if(!empty($inputs['firstname']))
				$modelUser->firstname = trim($inputs['firstname']);
				if(!empty($inputs['lastname']))
				$modelUser->lastname = trim($inputs['lastname']);

				$modelUser->name = trim($modelUser->firstname.' '.$modelUser->lastname);
				if(!empty($inputs['country_code']))
				$modelUser->country_code = trim($inputs['country_code']);
				if(!empty($inputs['contact_number']))
				$modelUser->contact_number = trim($inputs['contact_number']);
				if(!empty($inputs['dob']))
				$modelUser->dob = trim($inputs['dob']);
				if(!empty($inputs['gender']))
				$modelUser->gender = trim($inputs['gender']);
				if(!empty($inputs['address_1']))
				$modelUser->address_1 = trim($inputs['address_1']);
				if(!empty($inputs['address_2']))
				$modelUser->address_2 = trim($inputs['address_2']);
				if(!empty($inputs['address_3']))
				$modelUser->address_3 = trim($inputs['address_3']);
				if(!empty($inputs['city']))
				$modelUser->city = trim($inputs['city']);
				if(!empty($inputs['postcode']))
				$modelUser->postcode = trim($inputs['postcode']);
				if(!empty($inputs['state']))
				$modelUser->state = trim($inputs['state']);
				if(!empty($inputs['country']))
				$modelUser->country = trim($inputs['country']);
				if(!empty($inputs['profile_photo']))
				$modelUser->avatar = trim($inputs['profile_photo']);

				$modelUser->updatedby = $user_id;
				$modelUser->updatedat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
				$modelUser->save();
				
				if(count($modelUser->errors)!=0)
				throw new ErrorException("Update user failed.");
		
				//update member details
				$modelUserAssociateDetails = UserAssociateDetails::find()->where(array('user_id'=>$member_id))->one();
				if(!empty($inputs['id_number']))
				$modelUserAssociateDetails->id_number = trim($inputs['id_number']);
				if(!empty($inputs['tax_license_number']))
				$modelUserAssociateDetails->tax_license_number = trim($inputs['tax_license_number']);
				if(!empty($inputs['bank_id']))
				$modelUserAssociateDetails->bank_id = trim($inputs['bank_id']);
				if(!empty($inputs['account_name']))
				$modelUserAssociateDetails->account_name = trim($inputs['account_name']);
				if(!empty($inputs['account_number']))
				$modelUserAssociateDetails->account_number = trim($inputs['account_number']);
				if(!empty($inputs['domicile']))
				$modelUserAssociateDetails->domicile = trim($inputs['domicile']);
				if(!empty($inputs['occupation']))
				$modelUserAssociateDetails->occupation = trim($inputs['occupation']);
				if(!empty($inputs['industry_background']))
				$modelUserAssociateDetails->industry_background = trim($inputs['industry_background']);
				if(!empty($inputs['nricpass']))
				$modelUserAssociateDetails->nricpass = trim($inputs['nricpass']);
				if(!empty($inputs['tax_license']))
				$modelUserAssociateDetails->tax_license = trim($inputs['tax_license']);
				if(!empty($inputs['bank_account']))
				$modelUserAssociateDetails->bank_account = trim($inputs['bank_account']);
				if(!empty($inputs['associate_hold_id']))
				$modelUserAssociateDetails->udf1 = trim($inputs['associate_hold_id']);
				$modelUserAssociateDetails->save();
				if(count($modelUserAssociateDetails->errors)!=0)
				throw new ErrorException("Update associate details failed.");
				
				
				//update associate approval status
				if($modelUserAssociateDetails->approval_status==1 and strlen($modelUserAssociateDetails->domicile) and strlen($modelUserAssociateDetails->occupation) and strlen($modelUserAssociateDetails->industry_background) and strlen($modelUserAssociateDetails->nricpass) and strlen($modelUserAssociateDetails->tax_license))
				{
					$modelUserAssociateDetails->assistant_approval = 1;
					$modelUserAssociateDetails->agent_approval = 1;
					$modelUserAssociateDetails->admin_approval = 0;
					$modelUserAssociateDetails->approval_status = 2;
					$modelUserAssociateDetails->save();
					if(count($modelUserAssociateDetails->errors)!=0)
					throw new ErrorException("Update asscociate approval status failed.");
					
					//create log member registration approval
					$modelLogAssociateApproval = new LogAssociateApproval();
					$modelLogAssociateApproval->user_id = $member_id;
					$modelLogAssociateApproval->status = 2;
					$modelLogAssociateApproval->remarks = 'Completed profile details';
					$modelLogAssociateApproval->createdby = $user_id;
					$modelLogAssociateApproval->createdat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
					$modelLogAssociateApproval->save();
					if(count($modelLogAssociateApproval->errors)!=0)
					throw new ErrorException("Create log associate approval failed.");
				}
				elseif($modelUserAssociateDetails->approval_status==3 and strlen($modelUserAssociateDetails->domicile) and strlen($modelUserAssociateDetails->occupation) and strlen($modelUserAssociateDetails->industry_background) and strlen($modelUserAssociateDetails->nricpass) and strlen($modelUserAssociateDetails->tax_license))
				{
					$modelUserAssociateDetails->assistant_approval = 1;
					$modelUserAssociateDetails->agent_approval = 1;
					$modelUserAssociateDetails->admin_approval = 0;
					$modelUserAssociateDetails->approval_status = 2;
					$modelUserAssociateDetails->save();
					if(count($modelUserAssociateDetails->errors)!=0)
					throw new ErrorException("Update associate approval status failed.");
					
					//create log member registration approval
					$modelLogAssociateApproval = new LogAssociateApproval();
					$modelLogAssociateApproval->user_id = $member_id;
					$modelLogAssociateApproval->status = 2;
					$modelLogAssociateApproval->remarks = 'Associate Update Document';
					$modelLogAssociateApproval->createdby = $user_id;
					$modelLogAssociateApproval->createdat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
					$modelLogAssociateApproval->save();
				
					if(count($modelLogAssociateApproval->errors)!=0)
					throw new ErrorException("Create log associate approval failed.");
				}
			}
			elseif($inputs['action']=='updatepassword')
			{
				$modelUser = Users::find()->where(array('id'=>$member_id))->one();
				$modelUser->password = md5($inputs['password'].$modelUser->password_salt);
				$modelUser->password_repeat = $modelUser->password;
				$modelUser->updatedby = $user_id; 
				$modelUser->updatedat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
				$modelUser->save();
				
				if(count($modelUser->errors)!=0)
				throw new ErrorException("Update password failed.");						
			}
			
			$transaction->commit();
		}
		catch (ErrorException $e) 
		{
			$transaction->rollBack();
			$this->errorMessage = $e->getMessage();
			return false;
		}
		
		$modelUser = Users::find()->where(array('id'=>$member_id))->one();
		$result = $modelUser->getUserProfilesByUUID($modelUser->uuid);
	
		return $result;
	}
	
	public function setApprovalStatus($inputs=array())
	{
		//initialize
		$result = '';
		$errors = '';
		
		//validate inputs
		try
		{
			if(!is_array($inputs))
			throw new ErrorException("Invalid inputs(1).");

			if(count($inputs)==0)
			throw new ErrorException("Invalid inputs(2).");

			if(!isset($inputs['user_id']))
			throw new ErrorException("Invalid user id.");
			
			if(!isset($inputs['status']))
			throw new ErrorException("Invalid status.");
			
			if(!isset($inputs['remarks']))
			throw new ErrorException("Invalid remarks.");
			
			if(!isset($inputs['createdby']))
			throw new ErrorException("Invalid createdby.");
		}
		catch(ErrorException $e)
		{
			$this->errorMessage = $e->getMessage();
			return false;
		}
		
		//process
		$connection = Yii::$app->db;
		$transaction = $connection->beginTransaction();
		try 
		{		
			//update user member details status
			$modelUserAssociateDetails = UserAssociateDetails::find()->where(array('user_id'=>$inputs['user_id']))->one();
			
			if($inputs['status'] == 4)
			$modelUserAssociateDetails->admin_approval = 1;
			
			$modelUserAssociateDetails->approval_status = $inputs['status'];
			$modelUserAssociateDetails->save();
			if(count($modelUserAssociateDetails->errors)!=0)
			throw new ErrorException("Update associate approval status failed.");
			
			//save log member registration approval
			$modelLogAssociateApproval = new LogAssociateApproval();
			$modelLogAssociateApproval->user_id = $inputs['user_id'];
			$modelLogAssociateApproval->status = $inputs['status'];
			$modelLogAssociateApproval->remarks = $inputs['remarks'];
			$modelLogAssociateApproval->createdby = $inputs['createdby'];
			$modelLogAssociateApproval->createdat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
			$modelLogAssociateApproval->save();
			if(count($modelLogAssociateApproval->errors)!=0)
			throw new ErrorException("Create log associate approval failed.");
			
			if($inputs['status'] = 4)
			{	
				//send message to associate about approved status
				$subject = 'Verification Details Approved';
				$message = 'Your verification details has been approved.';
				$sendMessage = Yii::$app->AccessMod;
				if(!$sendMessage->sendMessage($inputs['user_id'],$subject,$message,1,2))
				throw new ErrorException($sendMessage->errorMessage);
			}
			elseif($inputs['status'] = 3)
			{	
				//send message to associate about rejected status
				$subject = 'Verification Details Rejected';
				$message = 'Your verification details has been rejected. '.$inputs['remarks'];
				$sendMessage = Yii::$app->AccessMod;
				if(!$sendMessage->sendMessage($inputs['user_id'],$subject,$message,1,2))
				throw new ErrorException($sendMessage->errorMessage);
			}
			
			$transaction->commit();
		}
		catch (ErrorException $e) 
		{
			$transaction->rollBack();
			$this->errorMessage = $e->getMessage();
			return false;
		}
		
		return true;
	}
	
	public function changeMemberAgent($agent_id,$member_ids = array())
	{
		//initialize
		$result = '';
		$errors = '';
		
		//validate inputs
		try
		{
			if(empty($agent_id))
			throw new ErrorException("Invalid agent id.");
			
			if(!is_array($member_ids))
			throw new ErrorException("Invalid member id(1).");

			if(count($member_ids)==0)
			throw new ErrorException("Invalid member id(2).");
		}
		catch(ErrorException $e)
		{
			$this->errorMessage = $e->getMessage();
			return false;
		}
		
		//process
		$connection = Yii::$app->db;
		$transaction = $connection->beginTransaction();
		try 
		{
			foreach($member_ids as $member_id)
			{
				$modelUserAssociateDetails = UserAssociateDetails::find()->where(array('id'=>$member_id))->one();
				if($modelUserAssociateDetails==NULL)
				throw new ErrorException("Invalid member id(3).");
				else
				{
					$oldAgentID = $modelUserAssociateDetails->agent_id;
					$modelUserAssociateDetails->agent_id = $agent_id;
					$modelUserAssociateDetails->save();
					if(count($modelUserAssociateDetails->errors)!=0)
					throw new ErrorException("Update user associate details failed.");
					
					//update old agent dashboard user
					$modelDashboardUser = DashboardUser::find()->where(array('user_id'=>$oldAgentID))->one();
					if($modelDashboardUser!=NULL)
					{
						if($modelUserAssociateDetails->productivity_status == 1)
						{
							if($modelDashboardUser->total_normal!=0)
							$modelDashboardUser->total_normal = $modelDashboardUser->total_normal-1;
						}
						if($modelUserAssociateDetails->productivity_status == 2)
						{
							if($modelDashboardUser->total_active!=0)
							$modelDashboardUser->total_active = $modelDashboardUser->total_active-1;
						}
						if($modelUserAssociateDetails->productivity_status == 3)
						{
							if($modelDashboardUser->total_productive!=0)
							$modelDashboardUser->total_productive = $modelDashboardUser->total_productive-1;
						}
						$modelDashboardUser->save();
						if(count($modelDashboardUser->errors)!=0)
						throw new ErrorException("Update old agent dashboard user failed.");
					}
					
					//update new agent dashboard user
					$modelDashboardUser = DashboardUser::find()->where(array('user_id'=>$agent_id))->one();
					if($modelDashboardUser!=NULL)
					{
						if($modelUserAssociateDetails->productivity_status == 1)
						$modelDashboardUser->total_normal = $modelDashboardUser->total_normal+1;
						if($modelUserAssociateDetails->productivity_status == 2)
						$modelDashboardUser->total_active = $modelDashboardUser->total_active+1;
						if($modelUserAssociateDetails->productivity_status == 3)
						$modelDashboardUser->total_productive = $modelDashboardUser->total_productive+1;
						$modelDashboardUser->save();
						if(count($modelDashboardUser->errors)!=0)
						throw new ErrorException("Update new agent dashboard user failed.");
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
		
		return true;
	}
		
	public function deleteMemberAccount($member_ids = array())
	{
		//initialize
		$result = '';
		$errors = '';
		
		//validate inputs
		try
		{
			if(!is_array($member_ids))
			throw new ErrorException("Invalid member id(1).");

			if(count($member_ids)==0)
			throw new ErrorException("Invalid member id(2).");
		}
		catch(ErrorException $e)
		{
			$this->errorMessage = $e->getMessage();
			return false;
		}
		
		//process
		$connection = Yii::$app->db;
		$transaction = $connection->beginTransaction();
		try 
		{
			foreach($member_ids as $member_id)
			{
				$modelUserAssociateDetails = UserAssociateDetails::find()->where(array('id'=>$member_id))->one();
				if($modelUserAssociateDetails==NULL)
				throw new ErrorException("Invalid member id(3).");
				
				//delete user account
				$modelUser = Users::find()->where(array('id'=>$modelUserAssociateDetails->user_id))->one();
				unset($modelUser->password);
				$modelUser->status = 0;
				$modelUser->deletedby = $_SESSION['user']['id'];
				$modelUser->deletedat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
				$modelUser->save();
				if(count($modelUser->errors)!=0)
				throw new ErrorException("Delete associate failed.");
				
				//update agent dashboard user
				$modelDashboardUser = DashboardUser::find()->where(array('user_id'=>$modelUserAssociateDetails->agent_id))->one();
				if($modelDashboardUser!=NULL)
				{
					if($modelUserAssociateDetails->productivity_status == 1)
					{
						if($modelDashboardUser->total_normal!=0)
						$modelDashboardUser->total_normal = $modelDashboardUser->total_normal-1;
					}
					if($modelUserAssociateDetails->productivity_status == 2)
					{
						if($modelDashboardUser->total_active!=0)
						$modelDashboardUser->total_active = $modelDashboardUser->total_active-1;
					}
					if($modelUserAssociateDetails->productivity_status == 3)
					{
						if($modelDashboardUser->total_productive!=0)
						$modelDashboardUser->total_productive = $modelDashboardUser->total_productive-1;
					}
					$modelDashboardUser->save();
					if(count($modelDashboardUser->errors)!=0)
					throw new ErrorException("Update agent dashboard user failed.");
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
		
		return true;
	}
		
	public function memberPoints($user_id)
	{
		//initialize
		$error = '';
		$result = array();
		$modelUserPoints = new UserPoints();
		$modelLogUserPoints = new LogUserPoints();

		try
		{
			//get member points
			$UserPoints = UserPoints::find()->select(array('total_points_value'))->where(array('user_id'=>$user_id))->asArray()->one();
			if($UserPoints==NULL)
			throw new ErrorException("Invalid associate points. Associate points not exist");
			else
			{				
				//get log member points
				$logUserPoints = $modelLogUserPoints->getLogUserPoints($user_id,10);
			}
		}
		catch(ErrorException $e)
		{
			$this->errorMessage = $e->getMessage();
			return false;
		}
		
		if(!strlen($this->errorMessage))
		{
			$result['total_points_value'] = $UserPoints['total_points_value'];
			$result['log_points'] = $logUserPoints;
			return $result;
		}
	}
	
	public function memberRedeemRewards($inputs,$user_id)
	{
		$modelRewards = new Rewards();
		$modelUserPoints = new UserPoints();
		$modelLogUserPoints = new LogUserPoints();
		$modelUserRewardRedemptions = new UserRewardRedemptions();
		$modelLogUserRewardRedemptions = new LogUserRewardRedemptions();
		
		//initialize
		$result = '';
		$errors = '';
		
		//validate inputs
		try
		{
			if(!is_array($inputs))
			throw new ErrorException("Invalid inputs(1).");

			if(count($inputs)==0)
			throw new ErrorException("Invalid inputs(2).");

			if(empty($user_id))
			throw new ErrorException("Invalid user id.");
			
			if(empty($inputs['rewardIDList']))
			throw new ErrorException("Reward ID is required.");
			
			if(empty($inputs['firstname']))
			throw new ErrorException("First name is required.");
			
			if(empty($inputs['lastname']))
			throw new ErrorException("Last name is required.");
			
			
			if(empty($inputs['email']))
			throw new ErrorException("Email is required.");
			
			if(strlen($inputs['email']))
			{
				if(preg_match("/^([\w\.-]{1,50}+[@]{1}+[\w-]{1,50})+?([\.\w]{1,50})?([\.][\w]{1,50})$/",$inputs['email']) == 0)
				throw new ErrorException("Incorrect email format.");
			}
				
			if(empty($inputs['country_code']))
			throw new ErrorException("Country code is required.");
			
			if(strlen($inputs['country_code']))
			{
				if(preg_match("/^([0-9]{1,10})$/",$inputs['country_code']) == 0)
				throw new ErrorException("Incorrect country code format.");
			}
			
			if(empty($inputs['contact_number']))
			throw new ErrorException("Contact number is required.");
			
			if(strlen($inputs['contact_number']))
			{
				if(preg_match("/^([0-9]{5,20})$/",$inputs['contact_number']) == 0)
				throw new ErrorException("Incorrect contact number format.");
			}
			
			if(empty($inputs['address_1']))
			throw new ErrorException("Address 1 is required.");
			
			if(empty($inputs['city']))
			throw new ErrorException("City is required.");
			
			if(empty($inputs['postcode']))
			throw new ErrorException("Postcode is required.");
			
			if(empty($inputs['state']))
			throw new ErrorException("State is required.");
			
			if(empty($inputs['country_id']))
			throw new ErrorException("Country is required.");
			
			//get member total points
			$memberPoints = $this->memberPoints($user_id);
			if(!$memberPoints)
			throw new ErrorException($this->errorMessage);
			
			//get total rewards points
			$total_rewards_points = 0;
			$rewardsIDArray = explode(',',$inputs['rewardIDList']);
			$rewardIDs = array_count_values($rewardsIDArray);
			foreach($rewardIDs as $rewardID => $quantity)
			{
				$tmpReward = $modelRewards->getRewardsList('',$rewardID);
				if(!$tmpReward)
				throw new ErrorException("Invalid reward ID.");
				else
				{
					if($tmpReward[0]['quantity']<$quantity)
					throw new ErrorException("Insufficient quatity for reward ".$tmpReward[0]['name'].".");
					else
					$total_rewards_points = $total_rewards_points+($tmpReward[0]['points']*$quantity);
				}
			}
			
			if($memberPoints['total_points_value']<$total_rewards_points)
			throw new ErrorException("Insufficient points.");
		}
		catch(ErrorException $e)
		{
			$this->errorMessage = $e->getMessage();
			return false;
		}
		
		//process
		$connection = Yii::$app->db;
		$transaction = $connection->beginTransaction();
		try 
		{	
			foreach($rewardIDs as $rewardID => $quantity)
			{
				$modelRewards = Rewards::find()->where(array('id'=>$rewardID))->one();
				if($modelRewards==NULL)
				throw new ErrorException("Invalid reward ID.");
				else
				{
					//update reward quantity quantity
					$modelRewards->quantity = $modelRewards->quantity-$quantity;
					$modelRewards->save();
					if(count($modelRewards->errors)!=0)
					throw new ErrorException("Update reward quantity failed.");
				
					//update user points
					$modelUserPoints = UserPoints::find()->where(array('user_id'=>$user_id))->one();
					$modelUserPoints->total_points_value = $modelUserPoints->total_points_value-($modelRewards->points*$quantity);
					$modelUserPoints->updatedby = $user_id;
					$modelUserPoints->updatedat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
					$modelUserPoints->save();
					if(count($modelUserPoints->errors)!=0)
					throw new ErrorException("Update user points failed.");
					
					//create log user points status 3
					$modelLogUserPoints = new LogUserPoints();
					$modelLogUserPoints->user_id = $user_id;
					$modelLogUserPoints->points_value = $modelRewards->points*$quantity;
					$modelLogUserPoints->status = 3;
					$modelLogUserPoints->createdby = $user_id;
					$modelLogUserPoints->createdat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
					$modelLogUserPoints->save();
					if(count($modelLogUserPoints->errors)!=0)
					throw new ErrorException("Create log user points failed.");
					
					//create user reward redemptions
					$modelUserRewardRedemptions = new UserRewardRedemptions();
					$modelUserRewardRedemptions->reward_id = $rewardID;
					$modelUserRewardRedemptions->user_id = $user_id;
					$modelUserRewardRedemptions->receiver_name = trim($inputs['firstname']).' '.trim($inputs['lastname']);
					$modelUserRewardRedemptions->receiver_email = trim($inputs['email']);
					$modelUserRewardRedemptions->receiver_country_code = trim($inputs['country_code']);
					$modelUserRewardRedemptions->receiver_contact_no = trim($inputs['contact_number']);
					$modelUserRewardRedemptions->address_1 = trim($inputs['address_1']);
					$modelUserRewardRedemptions->address_2 = trim($inputs['address_2']);
					$modelUserRewardRedemptions->address_3 = trim($inputs['address_3']);
					$modelUserRewardRedemptions->city = trim($inputs['city']);
					$modelUserRewardRedemptions->postcode = trim($inputs['postcode']);
					$modelUserRewardRedemptions->state = trim($inputs['state']);
					$modelUserRewardRedemptions->country = trim($inputs['country_id']);
					$modelUserRewardRedemptions->quantity = $quantity;
					$modelUserRewardRedemptions->points_value = $modelRewards->points*$quantity;
					$modelUserRewardRedemptions->status = 1;
					$modelUserRewardRedemptions->createdby = $user_id;
					$modelUserRewardRedemptions->createdat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
					$modelUserRewardRedemptions->save();
					if(count($modelUserRewardRedemptions->errors)!=0)
					throw new ErrorException("Create user reward redemption failed.");
					
					//create log user reward redemption
					$modelLogUserRewardRedemptions = new LogUserRewardRedemptions();
					$modelLogUserRewardRedemptions->user_id = $modelUserRewardRedemptions->user_id;
					$modelLogUserRewardRedemptions->reward_id = $modelUserRewardRedemptions->reward_id;
					$modelLogUserRewardRedemptions->associate_reward_redemption_id = $modelUserRewardRedemptions->id;
					$modelLogUserRewardRedemptions->points_value = $modelUserRewardRedemptions->points_value;
					$modelLogUserRewardRedemptions->status = $modelUserRewardRedemptions->status;
					$modelLogUserRewardRedemptions->createdby = $user_id;
					$modelLogUserRewardRedemptions->createdat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
					$modelLogUserRewardRedemptions->save();
					if(count($modelLogUserRewardRedemptions->errors)!=0)
					throw new ErrorException("Create log user reward redemption failed.");
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
		
		return true;
	}
	
	public function memberGetAgentDetails($member_id,$agent_id)
	{
		//initialize
		$result = array();
		$errors = '';
		$modelUsers = new Users();
		
		//validate inputs
		try
		{			
			if(empty($member_id))
			throw new ErrorException("Invalid member id.");
			
			if(empty($agent_id))
			throw new ErrorException("Invalid agent id (1).");
			
			$groups = Yii::$app->AccessRule->getUserGroups($agent_id);
			if(!$groups)
			throw new ErrorException('Invalid agent group (1).');
			else
			{
				if(count($groups)==0)
				throw new ErrorException('Invalid agent group (2).');
				else
				{
					if(!array_intersect(array(7,8,9,10), $groups))
					throw new ErrorException('Invalid agent group (3).');
				}
			}
			
			//get agent details
			$agentDetails = Users::find()->where(array('id'=>$agent_id,'status'=>1,'deletedby'=>NULL,'deletedat'=>NULL))->one();
			if($agentDetails==NULL)
			throw new ErrorException('Invalid agent id (2)');
		
		}
		catch(ErrorException $e)
		{
			$this->errorMessage = $e->getMessage();
			return false;
		}
		
		$result['id'] = $agentDetails->id;
		$result['uuid'] = $agentDetails->uuid;
		$result['sqm_id'] = $agentDetails->sqm_id;
		//$result['firstname'] = $agentDetails->firstname;
		//$result['lastname'] = $agentDetails->lastname;
		$result['name'] = $agentDetails->name;
		$result['email'] = $agentDetails->email;
		//$result['country_code'] = $agentDetails->country_code;
		//$result['contact_number'] = $agentDetails->contact_number;
		$result['contact_number'] = $agentDetails->country_code.$agentDetails->contact_number;
		$result['profile_description'] = html_entity_decode($agentDetails->profile_description);
		$result['profil_photo'] = $agentDetails->avatar;
		
		return $result;
	}
	
	public function memberDailyActiveManager($member_id,$action)
	{
		//initialize
		$result = array();
		$error = '';
		$result['today_availability'] = TRUE;
		$result['weekly_claimed'] = FALSE;
		$result['total_day_claimed'] = 0;
		
		//validate inputs
		try
		{			
			if(empty($member_id))
			throw new ErrorException("Invalid member id.");
			
			if(empty($action))
			throw new ErrorException("Invalid action (1).");
			
			if(!in_array($action,array('list','redeem')))
			throw new ErrorException("Invalid action (2).");
		}
		catch(ErrorException $e)
		{
			$this->errorMessage = $e->getMessage();
			return false;
		}
				
		// ASSOCIATE_DAILY_ACTIVE_POINTS
		// Yii::$app->PointsMod->memberPointsActivities($member_id,'ASSOCIATE_DAILY_ACTIVE_POINTS',1);
		
		// ASSOCIATE_7_DAYS_ACTIVE_POINTS
		// Yii::$app->PointsMod->memberPointsActivities($member_id,'ASSOCIATE_7_DAYS_ACTIVE_POINTS',1);

		//process
		if($action=='redeem')
		{
			$connection = \Yii::$app->db;
			$transaction = $connection->beginTransaction();
			try
			{
				//validate redeem today points
				$sql = "SELECT * ";
				$sql .= "FROM log_associate_activities ";
				$sql .= "WHERE 0=0 ";
				$sql .= "AND activity_id = 10 ";
				$sql .= "AND associate_id = '".$member_id."' ";
				$sql .= "AND createdat >= '".date('Y-m-d 00:00:00', time())."' ";
				$sql .= "AND createdat < '".date("Y-m-d 00:00:00", strtotime("+1 days",strtotime(Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s'))))."' ";
				$connection = Yii::$app->getDb();
				$query = $connection->createCommand($sql);
				$tmpResult = $query->queryOne();
				if($tmpResult)
				throw new ErrorException("Today points already been redeemed.");
				
				//redeem today points
				$redeemTodayPoints = Yii::$app->PointsMod->memberPointsActivities($member_id,'ASSOCIATE_DAILY_ACTIVE_POINTS',1);
				if(!$redeemTodayPoints)
				throw new ErrorException(Yii::$app->PointsMod->errorMessage);
		
				//get last bonus points
				$sql = "SELECT * ";
				$sql .= "FROM log_associate_activities ";
				$sql .= "WHERE 0=0 ";
				$sql .= "AND activity_id = 11 ";
				$sql .= "AND associate_id = '".$member_id."' ";
				$sql .= "AND createdat > '".date("Y-m-d 00:00:00", strtotime("-6 days",strtotime(Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s'))))."' ";
				$connection = Yii::$app->getDb();
				$query = $connection->createCommand($sql);
				$tmpResult1 = $query->queryOne();
					
				if($tmpResult1)
				$dateStart = date("Y-m-d 00:00:00", strtotime("+1 days",strtotime($tmpResult1['createdat'])));
				else
				$dateStart = date("Y-m-d 00:00:00", strtotime("-6 days",strtotime(Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s'))));
						
				//get total active days
				$sql = "SELECT * ";
				$sql .= "FROM log_associate_activities ";
				$sql .= "WHERE 0=0 ";
				$sql .= "AND activity_id = 10 ";
				$sql .= "AND associate_id = '".$member_id."' ";
				$sql .= "AND createdat > '".$dateStart."' ";
				$sql .= "AND createdat < '".date("Y-m-d 00:00:00", strtotime("+1 days",strtotime(Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s'))))."' ";
				$connection = Yii::$app->getDb();
				$query = $connection->createCommand($sql);
				$tmpResult2 = $query->queryAll();
				
				if(count($tmpResult2)==7)
				{
					//redeem bonus points
					$redeemBonusPoints = Yii::$app->PointsMod->memberPointsActivities($member_id,'ASSOCIATE_7_DAYS_ACTIVE_POINTS',1);
					if(!$redeemBonusPoints)
					throw new ErrorException(Yii::$app->PointsMod->errorMessage);
				}
				
				$transaction->commit();
			}
			catch (ErrorException $e) 
			{
				$transaction->rollBack();
				$this->errorMessage = $e->getMessage();
				return false;
			}
		}
		
		//get total active days
		$sql = "SELECT * ";
		$sql .= "FROM log_associate_activities ";
		$sql .= "WHERE 0=0 ";
		$sql .= "AND activity_id = 10 ";
		$sql .= "AND associate_id = '".$member_id."' ";
		$sql .= "AND createdat >= '".date('Y-m-d 00:00:00', time())."' ";
		$sql .= "AND createdat < '".date("Y-m-d 00:00:00", strtotime("+1 days",strtotime(Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s'))))."' ";
		$connection = Yii::$app->getDb();
		$query = $connection->createCommand($sql);
		$tmpResult = $query->queryOne();
		if($tmpResult)
		$result['today_availability'] = FALSE;
		
		//get last bonus points
		$sql = "SELECT * ";
		$sql .= "FROM log_associate_activities ";
		$sql .= "WHERE 0=0 ";
		$sql .= "AND activity_id = 11 ";
		$sql .= "AND associate_id = '".$member_id."' ";
		$sql .= "AND createdat > '".date("Y-m-d 00:00:00", strtotime("-6 days",strtotime(Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s'))))."' ";
		$connection = Yii::$app->getDb();
		$query = $connection->createCommand($sql);
		$tmpResult1 = $query->queryOne();
		
		$flags = array();
		$flagStartDate = '';
		$flagStartDateCount = 0;
		$flag7Days = 0;
		for($i=6;$i>0;$i--)
		{
			$processingDate = date("Y-m-d", strtotime("-".$i." days",strtotime(Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s'))));
			$sql = "SELECT * ";
			$sql .= "FROM log_associate_activities ";
			$sql .= "WHERE 0=0 ";
			$sql .= "AND activity_id = 10 ";
			$sql .= "AND associate_id = '".$member_id."' ";
			$sql .= "AND createdat >= '".date("Y-m-d 00:00:00", strtotime($processingDate))."' ";
			$sql .= "AND createdat < '".date("Y-m-d 00:00:00", strtotime("+1 days",strtotime($processingDate)))."' ";
			$connection = Yii::$app->getDb();
			$query = $connection->createCommand($sql);
			$tmpResult3 = $query->queryOne();
			if(!$tmpResult3)
			{
				$flags[] = false;
				$flagStartDate = '';
				$flag7Days = 0;
			}
			else
			{
				$flags[] = true;
				if(empty($flagStartDate))
				$flagStartDate = $tmpResult3['createdat'];
				$flag7Days++;
			}
		}
		
		//get total active days
		$sql = "SELECT * ";
		$sql .= "FROM log_associate_activities ";
		$sql .= "WHERE 0=0 ";
		$sql .= "AND activity_id = 10 ";
		$sql .= "AND associate_id = '".$member_id."' ";
		$sql .= "AND createdat >= '".date('Y-m-d 00:00:00', strtotime(Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s')))."' ";
		$sql .= "AND createdat < '".date("Y-m-d 00:00:00", strtotime("+1 days",strtotime(Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s'))))."' ";
		$connection = Yii::$app->getDb();
		$query = $connection->createCommand($sql);
		$tmpResult = $query->queryOne();
		if($tmpResult)
		{
			$result['today_availability'] = false;
			if(empty($flagStartDate))
			$flagStartDate = $tmpResult['createdat'];
			$flag7Days = $flag7Days+1;
		}
		else
		{
			$result['today_availability'] = true;
		}
		$result['weekly_claimed'] = $flag7Days==7?true:false;
		$result['total_day_claimed'] = $flag7Days;
		
		return $result;
	}
	
}
?>
