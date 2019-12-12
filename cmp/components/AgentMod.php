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
use app\models\UserMessages;

use app\models\Projects;
use app\models\ProjectAgents;
use app\models\UserCommissions;

use app\models\LogUsers;
use app\models\LookupAvatars;
use app\models\LookupCountry;
use app\models\LookupPositions;

use app\models\SystemEmailTemplate;


class AgentMod extends \yii\base\Component{

	public $errorMessage;

    public function init() {
        parent::init();
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
		
	public function agentProfile($inputs=array(),$agent_id,$user_id)
	{
		//initialize
        $result = array();
        $modelUser = new Users();
		
		//validate
		try
		{
			if(!is_array($inputs))
			throw new ErrorException("Invalid inputs(1).");

			if(count($inputs)==0)
			$inputs['action']='list';
			
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
							if($checkUserByEmail->id!=$agent_id)
							throw new ErrorException("Email address ".$inputs['email']." already been used.");
						}
					}
				}
			
				if(strlen($inputs['sqm_id']))
				{
					$tmpUser = Users::find()->where(array('sqm_id'=>$inputs['sqm_id'],'status'=>1,'deletedby'=>NULL,'deletedat'=>NULL))->one();
					if($tmpUser!=NULL)
					{
						if($tmpUser->id != $agent_id)
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
				$modelUser = Users::find()->where(array('id'=>$agent_id))->one();
				if(strlen($inputs['sqm_id']))
				$modelUser->sqm_id = trim($inputs['sqm_id']);
				unset($modelUser->password);
				if(strlen($inputs['email']))
				{
					$modelUser->username = strtolower(trim($inputs['email']));
					$modelUser->email = strtolower(trim($inputs['email']));
				}
				if(strlen($inputs['firstname']))
				$modelUser->firstname = trim($inputs['firstname']);
				if(strlen($inputs['lastname']))
				$modelUser->lastname = trim($inputs['lastname']);
				$modelUser->name = trim($modelUser->firstname.' '.$modelUser->lastname);
				if(strlen($inputs['country_code']))
				$modelUser->country_code = trim($inputs['country_code']);
				if(strlen($inputs['contact_number']))
				$modelUser->contact_number = trim($inputs['contact_number']);
				if(strlen($inputs['profile_description']))
				$modelUser->profile_description = htmlentities($inputs['profile_description']);
				if(strlen($inputs['profile_photo']))
				$modelUser->avatar = trim($inputs['profile_photo']);
				if(strlen($inputs['dob']))
				$modelUser->dob = trim($inputs['dob']);
				if(strlen($inputs['gender']))
				$modelUser->gender = trim($inputs['gender']);
				if(strlen($inputs['address_1']))
				$modelUser->address_1 = trim($inputs['address_1']);
				if(strlen($inputs['address_2']))
				$modelUser->address_2 = trim($inputs['address_2']);
				if(strlen($inputs['address_3']))
				$modelUser->address_3 = trim($inputs['address_3']);
				if(strlen($inputs['city']))
				$modelUser->city = trim($inputs['city']);
				if(strlen($inputs['postcode']))
				$modelUser->postcode = trim($inputs['postcode']);
				if(strlen($inputs['state']))
				$modelUser->state = trim($inputs['state']);
				if(strlen($inputs['country']))
				$modelUser->country = trim($inputs['country']);
				$modelUser->updatedby = $user_id;
				$modelUser->updatedat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
				$modelUser->save();
				if(count($modelUser->errors)!=0)
				throw new ErrorException("Update user failed.");
			}
			elseif($inputs['action']=='updatepassword')
			{
				$modelUser = Users::find()->where(array('id'=>$agent_id))->one();
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
		
		$modelUser = Users::find()->where(array('id'=>$agent_id))->one();
		$result = $modelUser->getUserProfilesByUUID($modelUser->uuid);
	
		return $result;
	}
			





}
?>
