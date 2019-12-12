<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property integer $id
 * @property string $uuid
 * @property string $username
 * @property string $password
 * @property string $password_salt
 * @property string $email
 * @property string $firstname
 * @property string $lastname
 * @property string $name
 * @property string $contact_number
 * @property string $dob
 * @property string $gender
 * @property string $address_1
 * @property string $address_2
 * @property string $address_3
 * @property string $city
 * @property string $postcode
 * @property string $state
 * @property string $country
 * @property string $profile_description
 * @property string $avatar
 * @property integer $avatar_id
 * @property integer $fb_info
 * @property integer $gmail_info
 * @property integer $twitter_info
 * @property integer $lastloginat
 * @property integer $status
 * @property integer $createdby
 * @property string $createdat
 * @property integer $updatedby
 * @property string $updatedat
 * @property integer $deletedby
 * @property string $deletedat
 *
 * @property Usergroups[] $usergroups
 */
class Users extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
	public $errorMessage, $password_repeat, $generate_password, $photo;

    public static function tableName()
    {
        return 'users';
    }

    public function rules()
    {
        return [
			[['email', 'firstname', 'lastname', 'name', 'country_code', 'contact_number', 'avatar_id', 'status'], 'required'],
			[['username'], 'required', 'on' => 'create'],
			[['photo','password','password_repeat'], 'required', 'on' => 'create', ],
			[['email'], 'required'],
			[['email'], 'email'],
			['password_repeat', 'compare', 'compareAttribute'=>'password', 'skipOnEmpty' => false, 'message'=>"Passwords don't match"],
		    [['id', 'contact_number', 'createdby', 'updatedby', 'deletedby', 'avatar_id', 'status'], 'integer'],
            [['dob', 'lastloginat', 'createdat', 'updatedat', 'deletedat'], 'safe'],
            [['profile_description', 'fb_info', 'gmail_info', 'twitter_info'], 'string'],
            [['username', 'email', 'firstname', 'lastname', 'name', 'contact_number'], 'string', 'max' => 100],
            [['address_1', 'address_2', 'address_3', 'city', 'postcode', 'state', 'country', 'avatar'], 'string', 'max' => 255],
            [['uuid', 'sqm_id', 'password', 'password_salt', 'country_code', 'gender'], 'string', 'max' => 50],
			[['avatar_id'], 'exist', 'skipOnError' => true, 'targetClass' => LookupAvatars::className(), 'targetAttribute' => ['avatar_id' => 'id']],
			[['firstname','lastname'], 'required', 'on' => 'memberaddupdate'],
			[['photo'], 'file', 'extensions' => ['png','jpg','jpeg'], 'mimeTypes' => 'image/jpeg,image/jpg,image/png', 'maxFiles' => 1],
		];
    }

    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'uuid' => 'UUID',
            'sqm_id' => 'SQM ID',
            'username' => 'Username',
            'password' => 'Password',
            'password_repeat' => 'Password Confirmation',
            'generate_password' => 'Generate Password',
            'password_salt' => 'Password salt',
            'email' => 'Email',
            'firstname' => 'First Name',
            'lastname' => 'Last Name',
            'name' => 'Name',
            'firstname' => 'First Name',
            'lastname' => 'Last Name',
            'country_code' => 'Country Code',
            'contact_number' => 'Contact Number',
            'dob' => 'Date of Birth',
            'gender' => 'Gender',
            'address_1' => 'Address 1',
            'address_2' => 'Address 2',
            'address_3' => 'Address 3',
            'city' => 'City',
            'postcode' => 'Postcode',
            'state' => 'State',
            'country' => 'Country',
            'profile_description' => 'Profile Description',
            'Avatar' => 'Avatar',
            'avatar_id' => 'Avatar ID',
            'fb_info' => 'Facebook Info',
            'gmail_info' => 'Gmail Info',
            'twitter_info' => 'Twitter Info',
            'lastloginat' => 'Last Login At',
            'status' => 'Status',
            'createdby' => 'Created by',
            'createdat' => 'Created at',
            'updatedby' => 'Updated by',
            'updatedat' => 'Updated at',
            'deletedby' => 'Deleted by',
            'deletedat' => 'Deleted at',
        );
    }

    public static function findIdentity($id)
    {
		$user = Users::find()->where(["id" => $id])->one();
		if ($user==NULL) {
			return null;
		}
		
		return new static($user);
    }

    public static function findIdentityByAccessToken($password_salt, $type = null)
    {
		throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
	public function getLookupAvatar()
    {
        return $this->hasOne(LookupAvatars::className(), ['id' => 'avatar_id']);
    }

	public function getUserGroups()
    {
        return $this->hasMany(UserGroups::className(), ['user_id' => 'id']);
    }

	public function getUserModules()
    {
        return $this->hasMany(UserModules::className(), ['user_id' => 'id']);
    }

	public function getLogUsers()
    {
        return $this->hasMany(LogUsers::className(), ['user_id' => 'id']);
    }
	
	public function getLookupPosition()
	{		
		return $this->hasOne(LookupPositions::className(), ['id' => 'position_id'])
				->viaTable(UserPosition::tableName(), ['user_id' => 'id']);
	}	

	public function getGroupAccess()
	{		
		return $this->hasOne(GroupAccess::className(), ['id' => 'groupaccess_id'])
				->viaTable(UserGroups::tableName(), ['user_id' => 'id']);
	}	

	public function getMemberDetails()
    {
        return $this->hasOne(UserMemberDetails::className(), ['user_id' => 'id']);
    }

	public function getLookupMemberStatus()
	{		
		return $this->hasOne(LookupMemberStatus::className(), ['id' => 'approval_status'])->via('memberDetails');
	}	

	public function getLeads()
	{		
		return $this->hasOne(MemberLeads::className(), ['member_id' => 'id']);
	}
	
	public function getManager()
	{		
		return $this->hasOne(LeadsManager::className(), ['leads_id' => 'leads_id'])->via('leads');
	}

	public function getDirector()
	{		
		return $this->hasOne(ManagerDirector::className(), ['manager_id' => 'manager_id'])->via('manager');
	}

	public function getProductivityStatus()
	{		
		return $this->hasOne(UserMemberDetails::className(), ['user_id' => 'id'])->from(['productivityStatus' => UserMemberDetails::tableName()]);
	}
	
	public function getLookupCountry()
    {
		return $this->hasOne(LookupCountry::className(), ['id' => 'country']);
    }
	
	//*****************//
    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->password;
    }

    public function getSaltByUsername($username)
    {
		$user = Users::find()->where(['username' => $username, 'status' => 1])->one();
		
		if($user == null)
        return null;
		
		return $user->password_salt;
    }

    public function validateAuthKey($password)
    {
        return $this->getAuthKey() === md5($password.$this->password_salt);
    }

    public function getUsername($id)
    {
		$user = Users::find()->where(['id' => $id])->one();

		if($user == null)
        return null;

		return $user->username; 
    }
	
	public static function findByUsername($username)
	{
		$user = Users::find()->where(['username' => $username])->one();
		
		if($user == null)
        return null;
		
		return new static($user);
	}
	
	public function CheckActiveUserByUsername($username)
	{
		$user = Users::find()->where(['username' => $username , 'status' => 1])->one();
		
		if($user == null)
		{
			$this->errorMessage = 'User is not active. Please contact administrator for more information.';
        	return false;
		}
		else
		return new static($user);
	}

	public function CheckActiveUserByEmail($email)
	{
		$user = Users::find()->where(['email' => $email , 'status' => 1])->one();
		
		if($user == null)
		{
			$this->errorMessage = 'User is not active. Please contact administrator for more information.';
        	return false;
		}
		else
		return new static($user);
	}

	public function CheckActiveUserByContactNumber($contact_number)
	{
		$user = Users::find()->where(['contact_number' => $contact_number , 'status' => 1])->one();
		
		if($user == null)
		{
			$this->errorMessage = 'User is not active. Please contact administrator for more information.';
        	return false;
		}
		else
		return new static($user);
	}

	public function CheckActiveUserByUUID($uuid)
	{
		$user = Users::find()->where(['uuid' => $uuid , 'status' => 1])->one();
		
		
		if($user == null)
		{
			$this->errorMessage = 'User is not active. Please contact administrator for more information.';
        	return false;
		}
		else
		return new static($user);
	}

	public function getUserByUUIDorSQMID($value)
	{
		$sql = "SELECT * ";
		$sql .= "FROM users ";
		$sql .= "WHERE 0=0 ";
		$sql .= "AND (uuid = '".$value."' OR sqm_id = '".$value."') ";
		$sql .= "AND status = 1 ";
		$sql .= "AND deletedby IS NULL ";
		$sql .= "AND deletedat IS NULL ";
		$user = Yii::$app->db->createCommand($sql)->queryOne();
		
		return $user;
	}

	public function getUserProfiles($username,$password)
	{
		$tmpUser = $this->CheckActiveUserByUsername($username);
		if(!$tmpUser)
		{
			$this->errorMessage = 'Incorrect uuid.';
			return false;
		}
		else
		{
			if($tmpUser->id==1)
			{
				$result = Users::find()->where(array('id'=>1))->asArray()->one();
				return $result;
			}
		}
		
		$sql = "SELECT u.id, u.uuid, u.sqm_id, u.username, u.email, u.firstname, u.lastname, u.name, u.country_code, u.contact_number, u.profile_description, u.dob, u.gender, u.address_1, u.address_2, u.address_3, u.city, u.postcode, u.state, ";
		$sql .= "(SELECT lookup_country.name FROM lookup_country WHERE lookup_country.id=u.country) as country, ";
		$sql .= "u.avatar, u.status as account_status, createdby, createdat, ";
		$sql .= "g.id as groupaccess_id, g.group_access_name, ";
		$sql .= "(SELECT user_points.total_points_value FROM user_points WHERE user_points.user_id=u.id) as total_points_value, ";
		$sql .= "(SELECT lookup_avatars.image FROM lookup_avatars WHERE lookup_avatars.id=u.avatar_id) as app_avatar ";
		$sql .= "FROM users u, group_access g, user_groups ug ";
		$sql .= "WHERE 0=0 ";
		$sql .= "AND u.id=ug.user_id ";
		$sql .= "AND ug.groupaccess_id=g.id ";
		$sql .= "AND u.status=1 ";
		$sql .= "AND u.deletedat IS NULL ";
		$sql .= "AND u.deletedby IS NULL ";
		$sql .= "AND u.username='".$username."' ";
		$sql .= "AND u.password='".md5($password.$this->getSaltByUsername($username))."' ";
		$connection = Yii::$app->getDb();
		$query = $connection->createCommand($sql);
		$result = $query->queryOne();
				
		if(!$result)
		{
			$this->errorMessage = 'Incorrect username and password.';
			return false;
		}
		elseif(count($result)==0)
		{
			$this->errorMessage = 'Incorrect username and password.';
			return false;
		}
		else
		{
			$result['profile_photo'] = $result['avatar'];
			$result['app_avatar'] = ((strlen($result['app_avatar'])) ? ((isset($_SERVER['HTTPS'])) ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'].$result['app_avatar'] : '');
			$result['qrcode'] = ((isset($_SERVER['HTTPS'])) ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'].'/cmp/contents/qrcodes/user/'.$result['uuid'].'.png';
			
			if($result['groupaccess_id']==11)
			{
				//get user member details
				$sql = "SELECT agent_id, referrer_id, assistant_id, approval_status, productivity_status, id_number, tax_license_number, bank_id, account_name, account_number, domicile, occupation, industry_background, ";
				$sql .= "(SELECT lookup_associate_approval_status.name FROM lookup_associate_approval_status WHERE lookup_associate_approval_status.id=user_associate_details.approval_status) as approval_status_text, ";
				$sql .= "(SELECT lookup_associate_productivity_status.name FROM lookup_associate_productivity_status WHERE lookup_associate_productivity_status.id=user_associate_details.productivity_status) as productivity_status_text, ";
				$sql .= "(SELECT lookup_banks.name FROM lookup_banks WHERE lookup_banks.id=user_associate_details.bank_id) as bank_text, ";
				$sql .= "(SELECT lookup_domicile.name FROM lookup_domicile WHERE lookup_domicile.id=user_associate_details.domicile) as domicile_text, ";
				$sql .= "(SELECT lookup_occupation.name FROM lookup_occupation WHERE lookup_occupation.id=user_associate_details.occupation) as occupation_text, ";
				$sql .= "(SELECT lookup_industry_background.name FROM lookup_industry_background WHERE lookup_industry_background.id=user_associate_details.industry_background) as industry_background_text, ";
				$sql .= "nricpass, tax_license, bank_account ";
				$sql .= "FROM user_associate_details ";
				$sql .= "WHERE 0=0 ";
				$sql .= "AND user_id='".$result['id']."' ";
				$connection = Yii::$app->getDb();
				$query = $connection->createCommand($sql);
				$userAssociateDetails = $query->queryOne();
				
				$result['productivity_status'] = $userAssociateDetails['productivity_status'];
				$result['productivity_status_text'] = $userAssociateDetails['productivity_status_text'];
				$result['approval_status'] = $userAssociateDetails['approval_status'];
				$result['approval_status_text'] = $userAssociateDetails['approval_status_text'];
				$result['id_number'] = $userAssociateDetails['id_number'];
				$result['tax_license_number'] = $userAssociateDetails['tax_license_number'];
				$result['bank_id'] = $userAssociateDetails['bank_id'];
				$result['bank_text'] = $userAssociateDetails['bank_text'];
				$result['account_name'] = $userAssociateDetails['account_name'];
				$result['account_number'] = $userAssociateDetails['account_number'];
				$result['domicile'] = $userAssociateDetails['domicile'];
				$result['domicile_text'] = $userAssociateDetails['domicile_text'];
				$result['occupation'] = $userAssociateDetails['occupation'];
				$result['occupation_text'] = $userAssociateDetails['occupation_text'];
				$result['industry_background'] = $userAssociateDetails['industry_background'];
				$result['industry_background_text'] = $userAssociateDetails['industry_background_text'];
				$result['nricpass'] = $userAssociateDetails['nricpass'];
				$result['tax_license'] = $userAssociateDetails['tax_license'];
				
				//get total prospect
				/*$sql = "SELECT COUNT(id) as total_prospect FROM prospects WHERE createdby='".$result['id']."' OR member_id='".$result['id']."' ";
				$connection = Yii::$app->getDb();
				$query = $connection->createCommand($sql);
				$associateProspects = $query->queryOne();
				
				if($associateProspects['total_prospect']>=2)
				$result['member_status'] = 'Active';*/
				
				$result['agent_id'] = '';
				$result['agent_name'] = '';
				$result['agent_email'] = '';
				$result['agent_contact_number'] = '';
				$result['agent_profile_description'] = '';
				//get member agent
				$sql = "SELECT u.id, u.name, u.email, u.country_code, u.contact_number, u.profile_description ";
				$sql .= "FROM users u ";
				$sql .= "WHERE 0=0 ";
				$sql .= "AND u.id='".$userAssociateDetails['agent_id']."' ";
				$connection = Yii::$app->getDb();
				$query = $connection->createCommand($sql);
				$associateAgent = $query->queryOne();
				if($associateAgent)
				{
					$result['agent_id'] = $associateAgent['id'];
					$result['agent_name'] = $associateAgent['name'];
					$result['agent_email'] = $associateAgent['email'];
					$result['agent_contact_number'] = $associateAgent['country_code'].$associateAgent['contact_number'];
					$result['agent_profile_description'] = $associateAgent['profile_description'];
				}
			}
			
			return $result;
		}
	}
	
	public function getUserProfilesByUsername($username)
	{
		$tmpUser = $this->CheckActiveUserByUsername($username);
		if(!$tmpUser)
		{
			$this->errorMessage = 'Incorrect uuid.';
			return false;
		}
		else
		{
			if($tmpUser->id==1)
			{
				$result = Users::find()->where(array('id'=>1))->asArray()->one();
				return $result;
			}
		}
		
		$sql = "SELECT u.id, u.uuid, u.sqm_id, u.username, u.email, u.firstname, u.lastname, u.name, u.country_code, u.contact_number, u.profile_description, u.dob, u.gender, u.address_1, u.address_2, u.address_3, u.city, u.postcode, u.state, ";
		$sql .= "(SELECT lookup_country.name FROM lookup_country WHERE lookup_country.id=u.country) as country, ";
		$sql .= "u.avatar, u.status as account_status, createdby, createdat, ";
		$sql .= "g.id as groupaccess_id, g.group_access_name, ";
		$sql .= "(SELECT user_points.total_points_value FROM user_points WHERE user_points.user_id=u.id) as total_points_value, ";
		$sql .= "(SELECT lookup_avatars.image FROM lookup_avatars WHERE lookup_avatars.id=u.avatar_id) as app_avatar ";
		$sql .= "FROM users u, group_access g, user_groups ug ";
		$sql .= "WHERE 0=0 ";
		$sql .= "AND u.id=ug.user_id ";
		$sql .= "AND ug.groupaccess_id=g.id ";
		$sql .= "AND u.status=1 ";
		$sql .= "AND u.deletedat IS NULL ";
		$sql .= "AND u.deletedby IS NULL ";
		$sql .= "AND u.username='".$username."' ";
		$connection = Yii::$app->getDb();
		$query = $connection->createCommand($sql);
		$result = $query->queryOne();
				
		if(!$result)
		{
			$this->errorMessage = 'Incorrect username and password.';
			return false;
		}
		elseif(count($result)==0)
		{
			$this->errorMessage = 'Incorrect username and password.';
			return false;
		}
		else
		{
			$result['profile_photo'] = $result['avatar'];
			$result['app_avatar'] = ((strlen($result['app_avatar'])) ? ((isset($_SERVER['HTTPS'])) ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'].$result['app_avatar'] : '');
			$result['qrcode'] = ((isset($_SERVER['HTTPS'])) ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'].'/cmp/contents/qrcodes/user/'.$result['uuid'].'.png';
			
			if($result['groupaccess_id']==11)
			{
				//get user member details
				$sql = "SELECT agent_id, referrer_id, assistant_id, approval_status, productivity_status, id_number, tax_license_number, bank_id, account_name, account_number, domicile, occupation, industry_background, ";
				$sql .= "(SELECT lookup_associate_approval_status.name FROM lookup_associate_approval_status WHERE lookup_associate_approval_status.id=user_associate_details.approval_status) as approval_status_text, ";
				$sql .= "(SELECT lookup_associate_productivity_status.name FROM lookup_associate_productivity_status WHERE lookup_associate_productivity_status.id=user_associate_details.productivity_status) as productivity_status_text, ";
				$sql .= "(SELECT lookup_banks.name FROM lookup_banks WHERE lookup_banks.id=user_associate_details.bank_id) as bank_text, ";
				$sql .= "(SELECT lookup_domicile.name FROM lookup_domicile WHERE lookup_domicile.id=user_associate_details.domicile) as domicile_text, ";
				$sql .= "(SELECT lookup_occupation.name FROM lookup_occupation WHERE lookup_occupation.id=user_associate_details.occupation) as occupation_text, ";
				$sql .= "(SELECT lookup_industry_background.name FROM lookup_industry_background WHERE lookup_industry_background.id=user_associate_details.industry_background) as industry_background_text, ";
				$sql .= "nricpass, tax_license, bank_account ";
				$sql .= "FROM user_associate_details ";
				$sql .= "WHERE 0=0 ";
				$sql .= "AND user_id='".$result['id']."' ";
				$connection = Yii::$app->getDb();
				$query = $connection->createCommand($sql);
				$userAssociateDetails = $query->queryOne();
				
				$result['productivity_status'] = $userAssociateDetails['productivity_status'];
				$result['productivity_status_text'] = $userAssociateDetails['productivity_status_text'];
				$result['approval_status'] = $userAssociateDetails['approval_status'];
				$result['approval_status_text'] = $userAssociateDetails['approval_status_text'];
				$result['id_number'] = $userAssociateDetails['id_number'];
				$result['tax_license_number'] = $userAssociateDetails['tax_license_number'];
				$result['bank_id'] = $userAssociateDetails['bank_id'];
				$result['bank_text'] = $userAssociateDetails['bank_text'];
				$result['account_name'] = $userAssociateDetails['account_name'];
				$result['account_number'] = $userAssociateDetails['account_number'];
				$result['domicile'] = $userAssociateDetails['domicile'];
				$result['domicile_text'] = $userAssociateDetails['domicile_text'];
				$result['occupation'] = $userAssociateDetails['occupation'];
				$result['occupation_text'] = $userAssociateDetails['occupation_text'];
				$result['industry_background'] = $userAssociateDetails['industry_background'];
				$result['industry_background_text'] = $userAssociateDetails['industry_background_text'];
				$result['nricpass'] = $userAssociateDetails['nricpass'];
				$result['tax_license'] = $userAssociateDetails['tax_license'];
				
				//get total prospect
				/*$sql = "SELECT COUNT(id) as total_prospect FROM prospects WHERE createdby='".$result['id']."' OR member_id='".$result['id']."' ";
				$connection = Yii::$app->getDb();
				$query = $connection->createCommand($sql);
				$associateProspects = $query->queryOne();
				
				if($associateProspects['total_prospect']>=2)
				$result['member_status'] = 'Active';*/
				
				$result['agent_id'] = '';
				$result['agent_name'] = '';
				$result['agent_email'] = '';
				$result['agent_contact_number'] = '';
				$result['agent_profile_description'] = '';
				//get member agent
				$sql = "SELECT u.id, u.name, u.email, u.country_code, u.contact_number, u.profile_description ";
				$sql .= "FROM users u ";
				$sql .= "WHERE 0=0 ";
				$sql .= "AND u.id='".$userAssociateDetails['agent_id']."' ";
				$connection = Yii::$app->getDb();
				$query = $connection->createCommand($sql);
				$associateAgent = $query->queryOne();
				if($associateAgent)
				{
					$result['agent_id'] = $associateAgent['id'];
					$result['agent_name'] = $associateAgent['name'];
					$result['agent_email'] = $associateAgent['email'];
					$result['agent_contact_number'] = $associateAgent['country_code'].$associateAgent['contact_number'];
					$result['agent_profile_description'] = $associateAgent['profile_description'];
				}
			}
			
			return $result;
		}
	}

	public function getUserProfilesByUUID($uuid)
	{
		$tmpUser = $this->CheckActiveUserByUUID($uuid);
		if(!$tmpUser)
		{
			$this->errorMessage = 'Incorrect uuid.';
			return false;
		}
		else
		{
			if($tmpUser->id==1)
			{
				$result = Users::find()->where(array('id'=>1))->asArray()->one();
				return $result;
			}
		}
		
		$sql = "SELECT u.id, u.uuid, u.sqm_id, u.username, u.email, u.firstname, u.lastname, u.name, u.country_code, u.contact_number, u.profile_description, u.dob, u.gender, u.address_1, u.address_2, u.address_3, u.city, u.postcode, u.state, ";
		$sql .= "(SELECT lookup_country.name FROM lookup_country WHERE lookup_country.id=u.country) as country, ";
		$sql .= "u.avatar, u.status as account_status, createdby, createdat, ";
		$sql .= "g.id as groupaccess_id, g.group_access_name, ";
		$sql .= "(SELECT user_points.total_points_value FROM user_points WHERE user_points.user_id=u.id) as total_points_value, ";
		$sql .= "(SELECT lookup_avatars.image FROM lookup_avatars WHERE lookup_avatars.id=u.avatar_id) as app_avatar ";
		$sql .= "FROM users u, group_access g, user_groups ug ";
		$sql .= "WHERE 0=0 ";
		$sql .= "AND u.id=ug.user_id ";
		$sql .= "AND ug.groupaccess_id=g.id ";
		$sql .= "AND u.status=1 ";
		$sql .= "AND u.uuid='".$uuid."' ";
		$connection = Yii::$app->getDb();
		$query = $connection->createCommand($sql);
		$result = $query->queryOne();
		
		if(!$result)
		{
			$this->errorMessage = 'Incorrect uuid.';
			return false;
		}
		elseif(count($result)==0)
		{
			$this->errorMessage = 'Incorrect uuid.';
			return false;
		}
		else
		{	
			$result['profile_photo'] = $result['avatar'];
			$result['app_avatar'] = ((strlen($result['app_avatar'])) ? ((isset($_SERVER['HTTPS'])) ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'].$result['app_avatar'] : '');
			$result['qrcode'] = ((isset($_SERVER['HTTPS'])) ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'].'/cmp/contents/qrcodes/user/'.$result['uuid'].'.png';
			
			if($result['groupaccess_id']==11)
			{
				//get user member details
				$sql = "SELECT agent_id, referrer_id, assistant_id, approval_status, productivity_status, id_number, tax_license_number, bank_id, account_name, account_number, domicile, occupation, industry_background, ";
				$sql .= "(SELECT lookup_associate_approval_status.name FROM lookup_associate_approval_status WHERE lookup_associate_approval_status.id=user_associate_details.approval_status) as approval_status_text, ";
				$sql .= "(SELECT lookup_associate_productivity_status.name FROM lookup_associate_productivity_status WHERE lookup_associate_productivity_status.id=user_associate_details.productivity_status) as productivity_status_text, ";
				$sql .= "(SELECT lookup_banks.name FROM lookup_banks WHERE lookup_banks.id=user_associate_details.bank_id) as bank_text, ";
				$sql .= "(SELECT lookup_domicile.name FROM lookup_domicile WHERE lookup_domicile.id=user_associate_details.domicile) as domicile_text, ";
				$sql .= "(SELECT lookup_occupation.name FROM lookup_occupation WHERE lookup_occupation.id=user_associate_details.occupation) as occupation_text, ";
				$sql .= "(SELECT lookup_industry_background.name FROM lookup_industry_background WHERE lookup_industry_background.id=user_associate_details.industry_background) as industry_background_text, ";
				$sql .= "nricpass, tax_license, bank_account ";
				$sql .= "FROM user_associate_details ";
				$sql .= "WHERE 0=0 ";
				$sql .= "AND user_id='".$result['id']."' ";
				$connection = Yii::$app->getDb();
				$query = $connection->createCommand($sql);
				$userAssociateDetails = $query->queryOne();
				
				$result['productivity_status'] = $userAssociateDetails['productivity_status'];
				$result['productivity_status_text'] = $userAssociateDetails['productivity_status_text'];
				$result['approval_status'] = $userAssociateDetails['approval_status'];
				$result['approval_status_text'] = $userAssociateDetails['approval_status_text'];
				$result['id_number'] = $userAssociateDetails['id_number'];
				$result['tax_license_number'] = $userAssociateDetails['tax_license_number'];
				$result['bank_id'] = $userAssociateDetails['bank_id'];
				$result['bank_text'] = $userAssociateDetails['bank_text'];
				$result['account_name'] = $userAssociateDetails['account_name'];
				$result['account_number'] = $userAssociateDetails['account_number'];
				$result['domicile'] = $userAssociateDetails['domicile'];
				$result['domicile_text'] = $userAssociateDetails['domicile_text'];
				$result['occupation'] = $userAssociateDetails['occupation'];
				$result['occupation_text'] = $userAssociateDetails['occupation_text'];
				$result['industry_background'] = $userAssociateDetails['industry_background'];
				$result['industry_background_text'] = $userAssociateDetails['industry_background_text'];
				$result['nricpass'] = $userAssociateDetails['nricpass'];
				$result['tax_license'] = $userAssociateDetails['tax_license'];
				
				//get total prospect
				/*$sql = "SELECT COUNT(id) as total_prospect FROM prospects WHERE createdby='".$result['id']."' OR member_id='".$result['id']."' ";
				$connection = Yii::$app->getDb();
				$query = $connection->createCommand($sql);
				$associateProspects = $query->queryOne();
				
				if($associateProspects['total_prospect']>=2)
				$result['member_status'] = 'Active';*/
				
				$result['agent_id'] = '';
				$result['agent_name'] = '';
				$result['agent_email'] = '';
				$result['agent_contact_number'] = '';
				$result['agent_profile_description'] = '';
				//get member agent
				$sql = "SELECT u.id, u.name, u.email, u.country_code, u.contact_number, u.profile_description ";
				$sql .= "FROM users u ";
				$sql .= "WHERE 0=0 ";
				$sql .= "AND u.id='".$userAssociateDetails['agent_id']."' ";
				$connection = Yii::$app->getDb();
				$query = $connection->createCommand($sql);
				$associateAgent = $query->queryOne();
				if($associateAgent)
				{
					$result['agent_id'] = $associateAgent['id'];
					$result['agent_name'] = $associateAgent['name'];
					$result['agent_email'] = $associateAgent['email'];
					$result['agent_contact_number'] = $associateAgent['country_code'].$associateAgent['contact_number'];
					$result['agent_profile_description'] = $associateAgent['profile_description'];
				}
			}
			
			return $result;
		}
	}

    public function validatePassword($password)
    {
        return $this->password === md5($password.$this->password_salt);
    }
			
	//get name of user
    public function getCustomersData($userID)
    {
		$sql = "SELECT name FROM `users` WHERE id = ".$userID;
		$user = Yii::$app->db->createCommand($sql)->queryOne();
		
		return $user;
    }
	
	public function getUsersData($username='',$name='',$groupAccess='',$lookupPosition='',$status='',$createdatrange='',$directorID='',$managerID='')
	{
		$sql = "SELECT u.*, ";
		$sql .= "(SELECT group_access.group_access_name FROM group_access, user_groups WHERE group_access.id=user_groups.groupaccess_id AND user_groups.user_id=u.id) as system_group, ";
		$sql .= "(SELECT lookup_positions.name FROM lookup_positions, user_position WHERE lookup_positions.id=user_position.position_id AND user_position.user_id=u.id) as position ";
		$sql .= "FROM users u ";
		$sql .= "WHERE 0=0 ";
		$sql .= "AND u.id <> 1 ";
		$sql .= "AND u.id <> ".$_SESSION['user']['id']." ";
		
		if(strlen($username))
		$sql .= "AND LOWER(u.username) LIKE '%".strtolower($username)."%' ";
		if(strlen($name))
		$sql .= "AND LOWER(u.name) LIKE '%".strtolower($name)."%' ";
		if(strlen($groupAccess))
		$sql .= "AND u.id IN (SELECT user_groups.user_id FROM user_groups, group_access WHERE user_groups.groupaccess_id=group_access.id AND LOWER(group_access.group_access_name) LIKE '%".strtolower($groupAccess)."%' ) ";
		if(strlen($lookupPosition))
		$sql .= "AND u.id IN (SELECT user_position.user_id FROM user_position, lookup_positions WHERE user_position.position_id=lookup_positions.id AND LOWER(lookup_positions.name) LIKE '%".strtolower($lookupPosition)."%' ) ";
		if(strlen($status))
		$sql .= "AND u.status = '".$status."' ";
		if(strlen($createdatrange))
		{
			list($start_date, $end_date) = explode(' - ', $createdatrange);
			$sql .= "AND u.createdat >= '".$start_date."' ";
			$sql .= "AND u.createdat <= '".$end_date."' ";
		}
		if(strlen($directorID))
		{
			$allDownline = array();
			$managersID = array();
			$leadsID = array();
			$membersID = array();
			$managersID = Yii::$app->AccessMod->getUserDownlineID($_SESSION['user']['id']);	
			if(count($managersID)!=0)
			{
				foreach($managersID as $manager_id)
				{
					$leadsIDArray = Yii::$app->AccessMod->getUserDownlineID($manager_id);
					if(count($leadsIDArray)!=0)
					$leadsID = array_merge($leadsID, $leadsIDArray);
				}
			}
			$allDownline = array_merge($managersID, $membersID, $membersIDArray);
			$sql .= "AND u.id IN (".implode(',',$allDownline).") ";
		}
		if(strlen($managerID))
		{
			$allDownline = Yii::$app->AccessMod->getUserDownlineID($managerID);
			if(count($allDownline)!=0)
			$sql .= "AND u.id IN (".implode(',',$allDownline).") ";
			else
			$sql .= "AND u.id IN (".implode(',',array()).") ";
		}
		
		$sql .= "ORDER BY u.name ";
		$staffEmployer = Yii::$app->db->createCommand($sql)->queryAll();
		
		if(count($staffEmployer)==0)
		return false;
		else		
		return $staffEmployer;
	}
				
	public function getUserAvatarImage($avatarID)
	{
		$sql = "SELECT image FROM `lookup_avatars` WHERE id = ".$avatarID;
		$avatarImage = Yii::$app->db->createCommand($sql)->queryOne();
		
		return $avatarImage['image'];
	}
	
	public function user_sync_fb_account($user_id,$fb_id)
	{
		//$sql = "UPDATE users SET fb_info = '".$fb_id."' WHERE id = '".$user_id."' ";
		//$result = Yii::$app->db->createCommand($sql)->update();
		
		$modelUsers = Users::find()->where(array('id' => $user_id))->one();
		$modelUsers->country_code=62;
		unset($modelUsers->password);
		$modelUsers->fb_info = $fb_id;
		$modelUsers->save();
				
		if(count($modelUsers->errors)!=0)
		{
			$this->errorMessage = 'Fail to sync fb id';
			return false;
		}
		else
		return $modelUsers;
	}
	
	public function getUserProfilesByFBid($fb_id)
	{
		$user = Users::find()->where(['fb_info' => $fb_id])->one();

		if($user==null)
		$this->errorMessage = 'FB account is not sync.';
		
		if(!strlen($this->errorMessage))
		$user = $this->getUserProfilesByUUID($user->uuid);
		
		return $user;
	}
	
	public function memberViewCreatedBy($user_id)
	{		
		if($user_id==1)
		{
			$value = Yii::$app->AccessMod->getUsername($user_id);
			$value .= '&nbsp;&nbsp;';
			$value .= '(Self Registered)';
			return $value;
		}
		else
		{
			$groups = Yii::$app->AccessRule->getUserGroups($user_id);
			
			$value = Yii::$app->AccessMod->getName($user_id);
			$value .= '&nbsp;&nbsp;';
			$value .= '('.Yii::$app->AccessRule->getGroupName($groups[0]).')';
			return $value;
		}
	}
	
	public function memberViewUpdatedBy($user_id)
	{		
		if($user_id==1)
		{
			$value = Yii::$app->AccessMod->getUsername($user_id);
			return $value;
		}
		else
		{
			$groups = Yii::$app->AccessRule->getUserGroups($user_id);
			
			$value = Yii::$app->AccessMod->getName($user_id);
			return $value;
		}
	}
	
}

