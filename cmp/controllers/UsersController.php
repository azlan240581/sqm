<?php
namespace app\controllers;

use Yii;
use app\models\Users;
use app\models\UsersSearch;
use app\models\GroupAccess;
use app\models\UserGroups;
use app\models\Banks;
use app\models\UserBank;
use app\models\Developers;
use app\models\UserDeveloper;
use app\models\Fintechs;
use app\models\UserFintech;
use app\models\Projects;
use app\models\ProjectAgents;
use app\models\UserPosition;
use app\models\AssistantUpline;
use app\models\UserAssociateBrokerDetails;

use app\models\LookupAvatars;
use app\models\LookupCountry;
use app\models\LookupPositions;

use app\models\DashboardUser;

use app\models\Modules;
use app\models\LogAudit;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\base\ErrorException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\helpers\Html;
use yii\helpers\Json;

class UserException extends ErrorException { }
class UserGroupsException extends ErrorException { }

//require php mailer
$file_phpmailer = Yii::getAlias("@vendor/phpmailer/library/class.phpmailer.php");
require_once($file_phpmailer);

/**
 * UsersController implements the CRUD actions for Users model.
 */
class UsersController extends Controller
{
	public function init()
	{
		$this->defaultAction = Yii::$app->AccessRule->get_default_action_by_controller($this->id);
	}
	
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new UsersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		$dataProvider->pagination  = false;
		
		$systemGroupArray = GroupAccess::find()->where(array('status'=>1))->andWhere(['<>','id',11])->asArray()->all();
		$positionArray = LookupPositions::find()->where(array('deleted'=>0))->asArray()->all();
		$statusArray = array(array('name'=>'Active','value'=>1),array('name'=>'Inactive','value'=>0));
		
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'statusArray' => $statusArray,
            'systemGroupArray' => $systemGroupArray,
            'positionArray' => $positionArray,
        ]);
    }

    public function actionView($id)
    {
		if($id==1 and $_SESSION['user']['id']!=1)
		throw new \yii\web\HttpException(401, 'Unauthorized: Can\'t update Superadmin.');		
		
		$model = $this->findModel($id);
		
		$modelProjectAgents = ProjectAgents::find()->where(array('agent_id'=>$model->id))->asArray()->all();
		$modelUserAssociateBrokerDetails = UserAssociateBrokerDetails::find()->where(array('user_id'=>$model->id))->one();
		
		
		if(isset($_REQUEST['ajaxView']))
		{
			return $this->renderAjax('view', [
				'model' => $model,
				'modelProjectAgents' => $modelProjectAgents,
				'modelUserAssociateBrokerDetails' => $modelUserAssociateBrokerDetails,
			]);
		}
		else
		{
			return $this->render('view', [
				'model' => $model,
				'modelProjectAgents' => $modelProjectAgents,
				'modelUserAssociateBrokerDetails' => $modelUserAssociateBrokerDetails,
			]);
		}
    }

    public function actionCreate()
    {
		//initialize
        $modelUser = new Users();
		$modelUser->scenario = 'create';
		$modelUser->status = 1;
        $modelUserGroups = new UserGroups();
        $modelUserPosition = new UserPosition();
        $modelUserBank = new UserBank();
        $modelUserDeveloper = new UserDeveloper();
        $modelUserFintech = new UserFintech();
        $modelLookupCountry = new LookupCountry();
		$modelAssistantUpline = new AssistantUpline();
        $modelProjects = new Projects();
		$modelProjectAgents = new ProjectAgents();
		$modelUserAssociateBrokerDetails = new UserAssociateBrokerDetails();
		$modelUserAssociateBrokerDetails->scenario = 'create';
		$modelDashboardUser = new DashboardUser();
						
		//get group access list
        if($_SESSION['user']['id']==1)
		$groupAccessObjs = GroupAccess::find()->where(array('id'=>array(1,2,3,4,5,6,7,8,9,10),'status'=>1))->all();
		elseif($_SESSION['user']['groups']!=NULL and in_array(1,$_SESSION['user']['groups']))
		$groupAccessObjs = GroupAccess::find()->where(array('id'=>array(2,3,4,5,6,7,8,9,10),'status'=>1))->all();
		elseif($_SESSION['user']['groups']!=NULL and in_array(2,$_SESSION['user']['groups']))
		$groupAccessObjs = GroupAccess::find()->where(array('id'=>array(7,8,9,10),'status'=>1))->all();
		elseif($_SESSION['user']['groups']!=NULL and in_array(7,$_SESSION['user']['groups']))
		$groupAccessObjs = GroupAccess::find()->where(array('id'=>array(9),'status'=>1))->all();
		elseif($_SESSION['user']['groups']!=NULL and in_array(8,$_SESSION['user']['groups']))
		$groupAccessObjs = GroupAccess::find()->where(array('id'=>array(10),'status'=>1))->all();
		$groupAccess = array();
		foreach($groupAccessObjs as $groupAccessObj)
		{
			$groupAccess[$groupAccessObj->id] = $groupAccessObj->group_access_name;
		}
		
		//get avatar list
        $avatarObjs = LookupAvatars::find()->where(array('deleted'=>0))->all();
		$avatar = array();
		foreach($avatarObjs as $avatarObj)
		{
			if($avatarObj->id!=1)
			$avatar[$avatarObj->id] = Html::img($avatarObj->image,['width'=>'100']);
		}
		//$avatar[$avatarObjs[0]->id] = '<span>Other</span>'.Html::img($avatarObjs[0]->image,['width'=>'100']);
		$avatar[$avatarObjs[0]->id] = '<span>Other</span>';
		
		//get country list
        $countryList = Yii::$app->AccessMod->getLookupData('lookup_country');
		
		//get position list
        $positionObjs = LookupPositions::find()->where(array('deleted'=>0))->all();
		$positionList = array();
		foreach($positionObjs as $positionObj)
		{
			$positionList[$positionObj->id]['id'] = $positionObj->id;
			$positionList[$positionObj->id]['name'] = $positionObj->name;
		}
		
		//get country code list
		$countryCodeList = array();
		$countryRecord = Yii::$app->AccessMod->readExcel('contents/others/countries.xls');
		$countryCodeList[0]['name'] = 'Indonesia (+62)';
		$countryCodeList[0]['value'] = '62';
		$countryCodeList[1]['name'] = '------------------------------------------------';
		$countryCodeList[1]['value'] = '';
		
		if(count($countryRecord)!=0)
		{
			$i=2;
			foreach($countryRecord as $key => $country)
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
		
		//get bank list
		$bankList = Banks::find()->where(array('status'=>1,'deletedby'=>NULL,'deletedat'=>NULL))->asArray()->all();
				
		//get developer list
		$developerList = Developers::find()->where(array('status'=>1,'deletedby'=>NULL,'deletedat'=>NULL))->asArray()->all();
		
		//get fintech list
		$fintechList = Fintechs::find()->where(array('status'=>1,'deletedby'=>NULL,'deletedat'=>NULL))->asArray()->all();
		
		//get project list
		$projectList = Projects::find()->where(array('status'=>1,'deletedby'=>NULL,'deletedat'=>NULL))->asArray()->all();
		$projectObj = array();
		if(count($projectList)!=0)
		{
			foreach($projectList as $project)
			{
				$projectObj[] = (object)$project;
			}
		}
		
		
		//get upline list
		$uplineArray = Yii::$app->AccessMod->getAgentList();
		$uplineList = array();
		if(count($uplineArray)!=0)
		{
			$i=0;
			foreach($uplineArray as $upline)
			{
				$uplineList[$i]['id'] = $upline['id'];
				$uplineList[$i]['name'] = $upline['name'].' ('.$upline['group_access_name'].')';
				$i++;
			}
		}
				
        if(count($_POST)!=0)
		{
			$error = '';
			$connection = Yii::$app->db;
			$transaction = $connection->beginTransaction();
			try 
			{
				//save user
				$modelUser->load(Yii::$app->request->post());

				//validate username
				$checkUserByUsername = $modelUser->CheckActiveUserByUsername($modelUser->username);
				if($checkUserByUsername)
				throw new ErrorException("Username '".$modelUser->username."' has already been taken.");
				
				//validate email
				$checkUserByEmail = $modelUser->CheckActiveUserByEmail($modelUser->email);
				if($checkUserByEmail)
				throw new ErrorException("Email '".$modelUser->email."' has already been taken.");
				
				//validate sqm id
				if(strlen($modelUser->sqm_id))
				{
					$tmpUser = Users::find()->where(array('sqm_id'=>$modelUser->sqm_id,'status'=>1,'deletedby'=>NULL,'deletedat'=>NULL))->one();
					if($tmpUser!=NULL)
					throw new ErrorException("SQM ID '".$modelUser->sqm_id."' has already been taken.");
				
					if(preg_match('/^[a-zA-Z0-9-]+$/i', $modelUser->sqm_id)==0)
					throw new ErrorException("SQM ID '".$modelUser->sqm_id."' is invalid. Alphanumeric and hyphen only.");
				}
				
				$modelUser->username = trim($modelUser->username);
				$modelUser->sqm_id = trim($modelUser->sqm_id);
				$modelUser->email = trim($modelUser->email);
				$modelUser->firstname = trim($modelUser->firstname);
				$modelUser->lastname = trim($modelUser->lastname);
				$modelUser->name = trim($modelUser->firstname.' '.$modelUser->lastname);
				
				$modelUser->password = trim($modelUser->password);
				$modelUser->password_salt = Yii::$app->AccessMod->getSalt();
				$modelUser->password = md5($modelUser->password.$modelUser->password_salt);
				$modelUser->password_repeat = $modelUser->password;
				
				$modelUser->photo = 'test';
				$modelUser->profile_description = htmlentities($modelUser->profile_description);
				
				$modelUser->createdby = $_SESSION['user']['id'];
				$modelUser->createdat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
				$modelUser->save();

				if(count($modelUser->errors)!=0)
				throw new ErrorException("Create user failed.");

				//save user uuid
				$modelUser->uuid = Yii::$app->AccessMod->get_uuid($modelUser->id.$modelUser->username.$modelUser->createdat);
				$modelUser->save();

				if(count($modelUser->errors)!=0)
				throw new ErrorException("Create user uuid failed.");
				
				//create qrcode
				Yii::$app->AccessMod->QRcode('user',$modelUser->uuid);

				//save avatar
				if(!empty($_FILES['Users']))
				{
					if($_FILES['Users']['error']['photo']!=4)
					{					
						//directory path
						$directory_path = 'contents/users/'.$modelUser->id.'/';
						if(($path = Yii::$app->AccessMod->createDirectory($directory_path)))
						{
							//get the instance of uploaded photo
							$modelUser->photo = UploadedFile::getInstance($modelUser,'photo');	
													
							//validate image size
							if($modelUser->photo->size > 10000000)
							throw new ErrorException("Photo size cannot larger than 10MB");
												
							$file_name = session_id().str_replace(' ','_',$modelUser->photo->name);
							$modelUser->photo->saveAs($directory_path.$file_name,false);
							if(!$modelUser->photo->saveAs($directory_path.$file_name,false))
							throw new ErrorException("Upload photo failed.");
		
							//save path to db column
							$modelUser->avatar = ((isset($_SERVER['HTTPS'])) ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'].'/cmp/'.$directory_path.$file_name;
							$modelUser->save();
							if(count($modelUser->errors)!=0)
							throw new ErrorException("Save photo failed.");
						}
						else
						throw new ErrorException($path->errorMessage);
					}
				}

				//save group
				$postModelUserGroups = Yii::$app->request->post('UserGroups');
				
				if(!is_array($postModelUserGroups['groupaccess_id']))
				$postModelUserGroups['groupaccess_id'] = array($postModelUserGroups['groupaccess_id']);
				
				foreach($postModelUserGroups['groupaccess_id'] as $groupaccess_id)
				{
					$modelUserGroups = new UserGroups();
					$modelUserGroups->user_id = $modelUser->id;
					$modelUserGroups->groupaccess_id = $groupaccess_id;
					$modelUserGroups->save();
					if(count($modelUserGroups->errors)!=0)
					{
						throw new ErrorException("Create user group failed.");
						break;
					}
				}
				
				//create user dashboard
				if(array_intersect($postModelUserGroups['groupaccess_id'],array(7,8,9,10)))
				{
					$modelDashboardUser = DashboardUser::find()->where(array('user_id'=>$modelUser->id))->one();
					if($modelDashboardUser==NULL)
					{
						$modelDashboardUser = new DashboardUser();
						$modelDashboardUser->user_id = $modelUser->id;
						$modelDashboardUser->save();
						if(count($modelDashboardUser->errors)!=0)
						throw new ErrorException("Create dashboard user failed.");
					}
				}
							
				//save user bank
				if(isset($_POST['UserBank']))
				{
					$postUserBank = $_POST['UserBank'];
					
					$modelUserBank = new UserBank();
					$modelUserBank->user_id = $modelUser->id;
					$modelUserBank->bank_id = $postUserBank['bank_id'];
					$modelUserBank->save();
					if(count($modelUserBank->errors)!=0)
					throw new ErrorException("Create user bank failed.");
				}
				
				//save user developer
				if(isset($_POST['UserDeveloper']))
				{
					$postUserDeveloper = $_POST['UserDeveloper'];
					
					$modelUserDeveloper = new UserDeveloper();
					$modelUserDeveloper->user_id = $modelUser->id;
					$modelUserDeveloper->developer_id = $postUserDeveloper['developer_id'];
					$modelUserDeveloper->save();
					if(count($modelUserDeveloper->errors)!=0)
					throw new ErrorException("Create user developer failed.");
				}
								
				//save user fintech
				if(isset($_POST['UserFintech']))
				{
					$postUserFintech = $_POST['UserFintech'];
					
					$modelUserFintech = new UserFintech();
					$modelUserFintech->user_id = $modelUser->id;
					$modelUserFintech->fintech_id = $postUserFintech['fintech_id'];
					$modelUserFintech->save();
					if(count($modelUserFintech->errors)!=0)
					throw new ErrorException("Create user fintech failed.");
				}
				
				//save project agent
				if(isset($_POST['ProjectAgents']))
				{
					$modelProjectAgents->load(Yii::$app->request->post());
					$postProjectAgents = Yii::$app->request->post('ProjectAgents');
					$projectIDs = Json::decode($postProjectAgents['project_id']);
					ProjectAgents::deleteAll(array('agent_id' => $modelUser->id));
					foreach($projectIDs as $project_id)
					{
						$modelProjectAgents = new ProjectAgents();
						$modelProjectAgents->project_id = $project_id;
						$modelProjectAgents->agent_id = $modelUser->id;
						$modelProjectAgents->save();
						if(count($modelProjectAgents->errors)!=0)
						{
							throw new ErrorException("Create project agent failed.");
							break;
						}
					}
				}
				
				//if()
				
				//save assistant upline
				if(isset($_POST['AssistantUpline']))
				{
					$postAssistantUpline = $_POST['AssistantUpline'];
					
					$modelAssistantUpline = new AssistantUpline();
					$modelAssistantUpline->assistant_id = $modelUser->id;
					$modelAssistantUpline->upline_id = $postAssistantUpline['upline_id'];
					$modelAssistantUpline->save();
					if(count($modelAssistantUpline->errors)!=0)
					throw new ErrorException("Create assistant upline failed.");
				}
				
				if(isset($_POST['UserAssociateBrokerDetails']['company_name']) and isset($_POST['UserAssociateBrokerDetails']['brand_name']) and isset($_POST['UserAssociateBrokerDetails']['akta_perusahaan']) and isset($_POST['UserAssociateBrokerDetails']['nib']) and isset($_POST['UserAssociateBrokerDetails']['sk_menkeh']) and isset($_POST['UserAssociateBrokerDetails']['npwp']) and isset($_POST['UserAssociateBrokerDetails']['ktp_direktur']) and isset($_POST['UserAssociateBrokerDetails']['bank_account']))
				{
					$modelUserAssociateBrokerDetails->load(Yii::$app->request->post());
					//save akta_perusahaan
					if($_FILES['UserAssociateBrokerDetails']['error']['akta_perusahaan']!=4)
					{					
						//directory path
						$directory_path = 'contents/asscociate-broker-details/'.$modelUser->id.'/';
						if(($path = Yii::$app->AccessMod->createDirectory($directory_path)))
						{
							//get the instance of uploaded akta_perusahaan
							$modelUserAssociateBrokerDetails->akta_perusahaan = UploadedFile::getInstance($modelUserAssociateBrokerDetails,'akta_perusahaan');	
													
							//validate image size
							if($modelUserAssociateBrokerDetails->akta_perusahaan->size > 10000000)
							throw new ErrorException("Image ".$modelUserAssociateBrokerDetails->getAttributeLabel('akta_perusahaan')." size cannot larger than 10MB");
												
							$file_name = session_id().'akta_perusahaan'.str_replace(' ','_',$modelUserAssociateBrokerDetails->akta_perusahaan->name);
							$modelUserAssociateBrokerDetails->akta_perusahaan->saveAs($directory_path.$file_name,false);
							if(!$modelUserAssociateBrokerDetails->akta_perusahaan->saveAs($directory_path.$file_name,false))
							throw new ErrorException("Upload image failed.");
		
							//save path to db column
							$modelUserAssociateBrokerDetails->akta_perusahaan = ((isset($_SERVER['HTTPS'])) ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'].'/cmp/'.$directory_path.$file_name;
						}
						else
						throw new ErrorException($path->errorMessage);
					}
	
					//save nib
					if($_FILES['UserAssociateBrokerDetails']['error']['nib']!=4)
					{					
						//directory path
						$directory_path = 'contents/asscociate-broker-details/'.$modelUser->id.'/';
						if(($path = Yii::$app->AccessMod->createDirectory($directory_path)))
						{
							//get the instance of uploaded nib
							$modelUserAssociateBrokerDetails->nib = UploadedFile::getInstance($modelUserAssociateBrokerDetails,'nib');	
													
							//validate image size
							if($modelUserAssociateBrokerDetails->nib->size > 10000000)
							throw new ErrorException("Image ".$modelUserAssociateBrokerDetails->getAttributeLabel('nib')." size cannot larger than 10MB");
												
							$file_name = session_id().'nib'.str_replace(' ','_',$modelUserAssociateBrokerDetails->nib->name);
							$modelUserAssociateBrokerDetails->nib->saveAs($directory_path.$file_name,false);
							if(!$modelUserAssociateBrokerDetails->nib->saveAs($directory_path.$file_name,false))
							throw new ErrorException("Upload image failed.");
		
							//save path to db column
							$modelUserAssociateBrokerDetails->nib = ((isset($_SERVER['HTTPS'])) ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'].'/cmp/'.$directory_path.$file_name;
						}
						else
						throw new ErrorException($path->errorMessage);
					}
	
					//save sk_menkeh
					if($_FILES['UserAssociateBrokerDetails']['error']['sk_menkeh']!=4)
					{					
						//directory path
						$directory_path = 'contents/asscociate-broker-details/'.$modelUser->id.'/';
						if(($path = Yii::$app->AccessMod->createDirectory($directory_path)))
						{
							//get the instance of uploaded sk_menkeh
							$modelUserAssociateBrokerDetails->sk_menkeh = UploadedFile::getInstance($modelUserAssociateBrokerDetails,'sk_menkeh');	
													
							//validate image size
							if($modelUserAssociateBrokerDetails->sk_menkeh->size > 10000000)
							throw new ErrorException("Image ".$modelUserAssociateBrokerDetails->getAttributeLabel('sk_menkeh')." size cannot larger than 10MB");
												
							$file_name = session_id().'sk_menkeh'.str_replace(' ','_',$modelUserAssociateBrokerDetails->sk_menkeh->name);
							$modelUserAssociateBrokerDetails->sk_menkeh->saveAs($directory_path.$file_name,false);
							if(!$modelUserAssociateBrokerDetails->sk_menkeh->saveAs($directory_path.$file_name,false))
							throw new ErrorException("Upload image failed.");
		
							//save path to db column
							$modelUserAssociateBrokerDetails->sk_menkeh = ((isset($_SERVER['HTTPS'])) ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'].'/cmp/'.$directory_path.$file_name;
						}
						else
						throw new ErrorException($path->errorMessage);
					}
					
					//save npwp
					if($_FILES['UserAssociateBrokerDetails']['error']['npwp']!=4)
					{					
						//directory path
						$directory_path = 'contents/asscociate-broker-details/'.$modelUser->id.'/';
						if(($path = Yii::$app->AccessMod->createDirectory($directory_path)))
						{
							//get the instance of uploaded npwp
							$modelUserAssociateBrokerDetails->npwp = UploadedFile::getInstance($modelUserAssociateBrokerDetails,'npwp');	
													
							//validate image size
							if($modelUserAssociateBrokerDetails->npwp->size > 10000000)
							throw new ErrorException("Image ".$modelUserAssociateBrokerDetails->getAttributeLabel('npwp')." size cannot larger than 10MB");
												
							$file_name = session_id().'npwp'.str_replace(' ','_',$modelUserAssociateBrokerDetails->npwp->name);
							$modelUserAssociateBrokerDetails->npwp->saveAs($directory_path.$file_name,false);
							if(!$modelUserAssociateBrokerDetails->npwp->saveAs($directory_path.$file_name,false))
							throw new ErrorException("Upload image failed.");
		
							//save path to db column
							$modelUserAssociateBrokerDetails->npwp = ((isset($_SERVER['HTTPS'])) ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'].'/cmp/'.$directory_path.$file_name;
						}
						else
						throw new ErrorException($path->errorMessage);
					}
	
					//save ktp_direktur
					if($_FILES['UserAssociateBrokerDetails']['error']['ktp_direktur']!=4)
					{					
						//directory path
						$directory_path = 'contents/asscociate-broker-details/'.$modelUser->id.'/';
						if(($path = Yii::$app->AccessMod->createDirectory($directory_path)))
						{
							//get the instance of uploaded ktp_direktur
							$modelUserAssociateBrokerDetails->ktp_direktur = UploadedFile::getInstance($modelUserAssociateBrokerDetails,'ktp_direktur');	
													
							//validate image size
							if($modelUserAssociateBrokerDetails->ktp_direktur->size > 10000000)
							throw new ErrorException("Image ".$modelUserAssociateBrokerDetails->getAttributeLabel('ktp_direktur')." size cannot larger than 10MB");
												
							$file_name = session_id().'ktp_direktur'.str_replace(' ','_',$modelUserAssociateBrokerDetails->ktp_direktur->name);
							$modelUserAssociateBrokerDetails->ktp_direktur->saveAs($directory_path.$file_name,false);
							if(!$modelUserAssociateBrokerDetails->ktp_direktur->saveAs($directory_path.$file_name,false))
							throw new ErrorException("Upload image failed.");
		
							//save path to db column
							$modelUserAssociateBrokerDetails->ktp_direktur = ((isset($_SERVER['HTTPS'])) ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'].'/cmp/'.$directory_path.$file_name;
						}
						else
						throw new ErrorException($path->errorMessage);
					}
	
					//save bank_account
					if($_FILES['UserAssociateBrokerDetails']['error']['bank_account']!=4)
					{					
						//directory path
						$directory_path = 'contents/asscociate-broker-details/'.$modelUser->id.'/';
						if(($path = Yii::$app->AccessMod->createDirectory($directory_path)))
						{
							//get the instance of uploaded bank_account
							$modelUserAssociateBrokerDetails->bank_account = UploadedFile::getInstance($modelUserAssociateBrokerDetails,'bank_account');	
													
							//validate image size
							if($modelUserAssociateBrokerDetails->bank_account->size > 10000000)
							throw new ErrorException("Image ".$modelUserAssociateBrokerDetails->getAttributeLabel('bank_account')." size cannot larger than 10MB");
												
							$file_name = session_id().'bank_account'.str_replace(' ','_',$modelUserAssociateBrokerDetails->bank_account->name);
							$modelUserAssociateBrokerDetails->bank_account->saveAs($directory_path.$file_name,false);
							if(!$modelUserAssociateBrokerDetails->bank_account->saveAs($directory_path.$file_name,false))
							throw new ErrorException("Upload image failed.");
		
							//save path to db column
							$modelUserAssociateBrokerDetails->bank_account = ((isset($_SERVER['HTTPS'])) ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'].'/cmp/'.$directory_path.$file_name;
						}
						else
						throw new ErrorException($path->errorMessage);
					}
	
					$modelUserAssociateBrokerDetails->user_id = $modelUser->id;
					$modelUserAssociateBrokerDetails->company_name = trim($modelUserAssociateBrokerDetails->company_name);
					$modelUserAssociateBrokerDetails->brand_name = trim($modelUserAssociateBrokerDetails->brand_name);
					$modelUserAssociateBrokerDetails->credits = 0;
					$modelUserAssociateBrokerDetails->createdby = $_SESSION['user']['id'];
					$modelUserAssociateBrokerDetails->createdat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
					
					$modelUserAssociateBrokerDetails->save();
					if(count($modelUserAssociateBrokerDetails->errors)!=0)
					throw new ErrorException("Create user associate broker failed.");
				}
							
				$transaction->commit();
			}
			catch (ErrorException $e) 
			{
				$transaction->rollBack();
				$error = $e->getMessage();
				Yii::$app->session->set('errorMessage', $error);
				$modelUser->profile_description = html_entity_decode($modelUser->profile_description);
				$modelUser->password = '';
				$modelUser->password_repeat = '';
			}
									
			if(!strlen($error))
			return $this->redirect(['view', 'id' => $modelUser->id]);
		}

		return $this->render('create', [
			'modelUser' => $modelUser,
			'modelUserGroups' => $modelUserGroups,
			'modelUserPosition' => $modelUserPosition,
			'groupAccess' => $groupAccess,
			'avatar' => $avatar,
			'countryList' => $countryList,
			'positionList' => $positionList,
			'countryCodeList' => $countryCodeList,
			'bankList' => $bankList,
			'modelUserBank' => $modelUserBank,
			'developerList' => $developerList,
			'modelUserDeveloper' => $modelUserDeveloper,
			'fintechList' => $fintechList,
			'modelUserFintech' => $modelUserFintech,
			'modelAssistantUpline' => $modelAssistantUpline,
			'uplineList' => $uplineList,
			'projectObj' => $projectObj,
			'modelProjectAgents' => $modelProjectAgents,
			'modelUserAssociateBrokerDetails' => $modelUserAssociateBrokerDetails,
		]);
    }

    public function actionUpdate($id)
    {
		if($id==1 and $_SESSION['user']['id']!=1)
		throw new \yii\web\HttpException(401, 'Unauthorized: Can\'t update Superadmin.');
		
		//initialize
        $modelUser = $this->findModel($id);
		$modelUser->profile_description = html_entity_decode($modelUser->profile_description);
		
		$modelUser->password='';
        $modelUserGroups = new UserGroups();
        $modelUserPosition = new UserPosition();
        $modelLookupCountry = new LookupCountry();
        $modelUserBank = new UserBank();
        $modelUserDeveloper = new UserDeveloper();
        $modelUserFintech = new UserFintech();
        $modelProjects = new Projects();
        $modelProjectAgents = new ProjectAgents();
		
        $modelUserAssociateBrokerDetails = UserAssociateBrokerDetails::find()->where(array('user_id'=>$modelUser->id))->one();;
        if($modelUserAssociateBrokerDetails==NULL)
		$modelUserAssociateBrokerDetails = new UserAssociateBrokerDetails();

		//get selected groups
        $getUserGroups = UserGroups::find()->where(['user_id'=>$id])->all();
		$selectedUserGroup = array();
		foreach($getUserGroups as $getUserGroup)
		{
			$selectedUserGroup[] = $getUserGroup->groupaccess_id;
		}
		$modelUserGroups->groupaccess_id = $selectedUserGroup;
				
		//get group access list
        if($_SESSION['user']['id']==1)
		$groupAccessObjs = GroupAccess::find()->where(array('id'=>array(1,2,3,4,5,6,7,8,9,10),'status'=>1))->all();
		elseif($_SESSION['user']['groups']!=NULL and in_array(1,$_SESSION['user']['groups']))
		$groupAccessObjs = GroupAccess::find()->where(array('id'=>array(2,3,4,5,6,7,8,9,10),'status'=>1))->all();
		elseif($_SESSION['user']['groups']!=NULL and in_array(2,$_SESSION['user']['groups']))
		$groupAccessObjs = GroupAccess::find()->where(array('id'=>array(7,8,9,10),'status'=>1))->all();
		elseif($_SESSION['user']['groups']!=NULL and in_array(7,$_SESSION['user']['groups']))
		$groupAccessObjs = GroupAccess::find()->where(array('id'=>array(9),'status'=>1))->all();
		elseif($_SESSION['user']['groups']!=NULL and in_array(8,$_SESSION['user']['groups']))
		$groupAccessObjs = GroupAccess::find()->where(array('id'=>array(10),'status'=>1))->all();
		$groupAccess = [];
		foreach($groupAccessObjs as $groupAccessObj)
		{
			$groupAccess[$groupAccessObj->id] = $groupAccessObj->group_access_name;
		}
		
		//get avatar list
        $avatarObjs = LookupAvatars::find()->where(array('deleted'=>0))->all();
		$avatar = array();
		foreach($avatarObjs as $avatarObj)
		{
			if($avatarObj->id!=1)
			$avatar[$avatarObj->id] = Html::img($avatarObj->image,['width'=>'100']);
		}
		//$avatar[$avatarObjs[0]->id] = '<span>Other</span>'.Html::img($avatarObjs[0]->image,['width'=>'100']);
		$avatar[$avatarObjs[0]->id] = '<span>Other</span>';
		
		//get country list
        $countryList = Yii::$app->AccessMod->getLookupData('lookup_country');
		
		//get selected position
        $getUserPosition = UserPosition::find()->where(['user_id'=>$id])->one();
		if($getUserPosition!=NULL)
		$modelUserPosition->position_id = $getUserPosition->position_id;
		
		//get position list
        $positionObjs = LookupPositions::find()->where(array('deleted'=>0,'id'=>array(1,2,3,4,5,6,7,8,9)))->all();
		$positionList = array();
		foreach($positionObjs as $positionObj)
		{
			$positionList[$positionObj->id]['id'] = $positionObj->id;
			$positionList[$positionObj->id]['name'] = $positionObj->name;
		}
								
		//get country code list
		$countryCodeList = array();
		$countryRecord = Yii::$app->AccessMod->readExcel('contents/others/countries.xls');
		$countryCodeList[0]['name'] = 'Indonesia (+62)';
		$countryCodeList[0]['value'] = '62';
		$countryCodeList[1]['name'] = '------------------------------------------------';
		$countryCodeList[1]['value'] = '';
		
		if(count($countryRecord)!=0)
		{
			$i=2;
			foreach($countryRecord as $key => $country)
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
		
		//get bank list
		$bankList = Banks::find()->where(array('status'=>1,'deletedby'=>NULL,'deletedat'=>NULL))->asArray()->all();
		//get user bank
		$modelUserBank = UserBank::find()->where(array('user_id'=>$modelUser->id))->one();
        if($modelUserBank==NULL)
		$modelUserBank = new UserBank();
		
		//get developer list
		$developerList = Developers::find()->where(array('status'=>1,'deletedby'=>NULL,'deletedat'=>NULL))->asArray()->all();
		//get user developer
		$modelUserDeveloper = UserDeveloper::find()->where(array('user_id'=>$modelUser->id))->one();
        if($modelUserDeveloper==NULL)
        $modelUserDeveloper= new UserDeveloper();
				
		//get fintech list
		$fintechList = Fintechs::find()->where(array('status'=>1,'deletedby'=>NULL,'deletedat'=>NULL))->asArray()->all();
		//get user fintech
		$modelUserFintech = UserFintech::find()->where(array('user_id'=>$modelUser->id))->one();
        if($modelUserFintech ==NULL)
        $modelUserFintech = new UserFintech();
		
		//get project list
		$projectList = Projects::find()->where(array('status'=>1,'deletedby'=>NULL,'deletedat'=>NULL))->asArray()->all();
		$projectObj = array();
		if(count($projectList)!=0)
		{
			foreach($projectList as $project)
			{
				$projectObj[] = (object)$project;
			}
		}
		//get project agent
		$projectAgents = ProjectAgents::find()->where(array('agent_id'=>$modelUser->id))->asArray()->all();
		if($projectAgents!=NULL)
		$modelProjectAgents->project_id = json_encode(array_column($projectAgents,'project_id'));
		
		//get upline list
		$uplineArray = Yii::$app->AccessMod->getAgentList();
		$uplineList = array();
		if(count($uplineArray)!=0)
		{
			$i=0;
			foreach($uplineArray as $upline)
			{
				$uplineList[$i]['id'] = $upline['id'];
				$uplineList[$i]['name'] = $upline['name'].' ('.$upline['group_access_name'].')';
				$i++;
			}
		}
		//get assistant upline
		$modelAssistantUpline = AssistantUpline::find()->where(array('assistant_id'=>$modelUser->id))->one();
        if($modelAssistantUpline ==NULL)
        $modelAssistantUpline = new AssistantUpline();
				
		//for log audit
		$modules = Modules::find()->where(array('controller' => $_SESSION['user']['controller']))->one();
		$olddataUsers = Users::find()->where(array('id' => $modelUser->id))->asArray()->one();
		$olddataUserGroups = UserGroups::find()->where(array('user_id' => $modelUser->id))->asArray()->one();
		$olddata['user'] = json_encode($olddataUsers);
		$olddata['group'] = json_encode($olddataUserGroups);

        if(count($_POST)!=0)
		{
			$error = '';
			$connection = Yii::$app->db;
			$transaction = $connection->beginTransaction();
			try 
			{
				//save user
				$modelUser->load(Yii::$app->request->post());				

				//validate username
				$checkUserByUsername = $modelUser->CheckActiveUserByUsername($modelUser->username);
				if($checkUserByUsername)
				{
					if($checkUserByUsername->id != $modelUser->id)
					throw new ErrorException("Username '".$modelUser->username."' has already been taken.");
				}
				//validate email
				$checkUserByEmail = $modelUser->CheckActiveUserByEmail($modelUser->email);
				if($checkUserByEmail)
				{
					if($checkUserByEmail->id != $modelUser->id)
					throw new ErrorException("Email '".$modelUser->email."' has already been taken.");
				}
				
				//validate sqm id
				if(strlen($modelUser->sqm_id))
				{
					$tmpUser = Users::find()->where(array('sqm_id'=>$modelUser->sqm_id,'status'=>1,'deletedby'=>NULL,'deletedat'=>NULL))->one();
					if($tmpUser!=NULL)
					{
						if($tmpUser->id != $modelUser->id)
						throw new ErrorException("SQM ID '".$modelUser->sqm_id."' has already been taken.");
					}
					
					if(preg_match('/^[a-zA-Z0-9-]+$/i', $modelUser->sqm_id)==0)
					throw new ErrorException("SQM ID '".$modelUser->sqm_id."' is invalid. Alphanumeric and hyphen only.");
				}
				
				$modelUser->username = trim($modelUser->username);
				$modelUser->sqm_id = trim($modelUser->sqm_id);
				$modelUser->email = trim($modelUser->email);
				$modelUser->firstname = trim($modelUser->firstname);
				$modelUser->lastname = trim($modelUser->lastname);
				$modelUser->name = trim($modelUser->firstname.' '.$modelUser->lastname);
				
				if(strlen($_POST['Users']['password']))
				{
					$modelUser->password = trim($modelUser->password);
					$modelUser->password = md5($modelUser->password.$modelUser->password_salt);
					$modelUser->password_repeat = $modelUser->password;
				}
				elseif(strlen($_POST['Users']['generate_password']))
				{
					$modelUser->password = md5($_POST['Users']['generate_password'].$modelUser->password_salt);
					$modelUser->password_repeat = $modelUser->password;
				}
				else
				unset($modelUser->password);

				$modelUser->profile_description = htmlentities($modelUser->profile_description);

				$modelUser->updatedby = $_SESSION['user']['id']; 
				$modelUser->updatedat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
				$modelUser->save();

				if(count($modelUser->errors)!=0)
				throw new ErrorException("Failed to update user.");

				//save avatar
				if(!empty($_FILES['Users']))
				{
					if($_FILES['Users']['error']['photo']!=4)
					{					
						//directory path
						$directory_path = 'contents/users/'.$modelUser->id.'/';
						if(($path = Yii::$app->AccessMod->createDirectory($directory_path)))
						{
							//get the instance of uploaded photo
							$modelUser->photo = UploadedFile::getInstance($modelUser,'photo');	
													
							//validate image size
							if($modelUser->photo->size > 10000000)
							throw new ErrorException("Photo size cannot larger than 10MB");
												
							$file_name = session_id().str_replace(' ','_',$modelUser->photo->name);
							$modelUser->photo->saveAs($directory_path.$file_name,false);
							if(!$modelUser->photo->saveAs($directory_path.$file_name,false))
							throw new ErrorException("Upload photo failed.");
		
							//save path to db column
							$modelUser->avatar = ((isset($_SERVER['HTTPS'])) ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'].'/cmp/'.$directory_path.$file_name;
							$modelUser->save();
							if(count($modelUser->errors)!=0)
							throw new ErrorException("Save photo failed.");
						}
						else
						throw new ErrorException($path->errorMessage);
					}
				}

				//delete and save group
				$deleteUserGroups = UserGroups::deleteAll(['user_id' => $modelUser->id]);
				
				$postModelUserGroups = Yii::$app->request->post('UserGroups');
				
				if(!is_array($postModelUserGroups['groupaccess_id']))
				$postModelUserGroups['groupaccess_id'] = array($postModelUserGroups['groupaccess_id']);
				
				$modelUserGroups->groupaccess_id = array($postModelUserGroups['groupaccess_id']);
				
				foreach($postModelUserGroups['groupaccess_id'] as $groupaccess_id)
				{
					$modelUserGroups = new UserGroups();
					$modelUserGroups->user_id = $modelUser->id;
					$modelUserGroups->groupaccess_id = $groupaccess_id;
					$modelUserGroups->save();

					if(count($modelUserGroups->errors)!=0)
					{
						throw new ErrorException("Failed to update user group.");
						break;
					}
				}
									
				//create user dashboard
				if(array_intersect($postModelUserGroups['groupaccess_id'],array(7,8,9,10)))
				{
					$modelDashboardUser = DashboardUser::find()->where(array('user_id'=>$modelUser->id))->one();
					if($modelDashboardUser==NULL)
					{
						$modelDashboardUser = new DashboardUser();
						$modelDashboardUser->user_id = $modelUser->id;
						$modelDashboardUser->save();
						if(count($modelDashboardUser->errors)!=0)
						throw new ErrorException("Create dashboard user failed.");
					}
				}
				
				//save user bank
				if(isset($_POST['UserBank']))
				{
					$postUserBank = $_POST['UserBank'];
					
					$modelUserBank = UserBank::find()->where(array('user_id'=>$modelUser->id))->one();
					$modelUserBank->bank_id = $postUserBank['bank_id'];
					$modelUserBank->save();
					if(count($modelUserBank->errors)!=0)
					throw new ErrorException("Update user bank failed.");
				}
				
				//save user developer
				if(isset($_POST['UserDeveloper']))
				{
					$postUserDeveloper = $_POST['UserDeveloper'];
					
					$modelUserDeveloper = UserDeveloper::find()->where(array('user_id'=>$modelUser->id))->one();
					$modelUserDeveloper->developer_id = $postUserDeveloper['developer_id'];
					$modelUserDeveloper->save();
					if(count($modelUserDeveloper->errors)!=0)
					throw new ErrorException("Update user developer failed.");
				}
												
				//save user fintech
				if(isset($_POST['UserFintech']))
				{
					$postUserFintech = $_POST['UserFintech'];
					
					$modelUserFintech = UserFintech::find()->where(array('user_id'=>$modelUser->id))->one();
					$modelUserFintech->fintech_id = $postUserFintech['fintech_id'];
					$modelUserFintech->save();
					if(count($modelUserFintech->errors)!=0)
					throw new ErrorException("Update user fintech failed.");
				}
				
				//save project agent
				if(isset($_POST['ProjectAgents']))
				{
					$modelProjectAgents->load(Yii::$app->request->post());
					$postProjectAgents = Yii::$app->request->post('ProjectAgents');
					$projectIDs = Json::decode($postProjectAgents['project_id']);
					ProjectAgents::deleteAll(array('agent_id' => $modelUser->id));
					foreach($projectIDs as $project_id)
					{
						$modelProjectAgents = new ProjectAgents();
						$modelProjectAgents->project_id = $project_id;
						$modelProjectAgents->agent_id = $modelUser->id;
						$modelProjectAgents->save();
						if(count($modelProjectAgents->errors)!=0)
						{
							throw new ErrorException("Create project agent failed.");
							break;
						}
					}
				}
												
				//save assistant upline
				if(isset($_POST['AssistantUpline']))
				{
					$postAssistantUpline = $_POST['AssistantUpline'];
					
					$modelAssistantUpline = AssistantUpline::find()->where(array('assistant_id'=>$modelUser->id))->one();
					$modelAssistantUpline->upline_id = $postAssistantUpline['upline_id'];
					$modelAssistantUpline->save();
					if(count($modelAssistantUpline->errors)!=0)
					throw new ErrorException("Update assistant upline failed.");
				}
				
				if(isset($_POST['UserAssociateBrokerDetails']['company_name']) and isset($_POST['UserAssociateBrokerDetails']['brand_name']) and isset($_POST['UserAssociateBrokerDetails']['akta_perusahaan']) and isset($_POST['UserAssociateBrokerDetails']['nib']) and isset($_POST['UserAssociateBrokerDetails']['sk_menkeh']) and isset($_POST['UserAssociateBrokerDetails']['npwp']) and isset($_POST['UserAssociateBrokerDetails']['ktp_direktur']) and isset($_POST['UserAssociateBrokerDetails']['bank_account']))
				{					
					$modelUserAssociateBrokerDetails = UserAssociateBrokerDetails::find()->where(array('user_id'=>$id))->one();
					
					//save akta_perusahaan
					if($_FILES['UserAssociateBrokerDetails']['error']['akta_perusahaan']!=4)
					{					
						//directory path
						$directory_path = 'contents/asscociate-broker-details/'.$modelUser->id.'/';
						if(($path = Yii::$app->AccessMod->createDirectory($directory_path)))
						{
							//get the instance of uploaded akta_perusahaan
							$modelUserAssociateBrokerDetails->akta_perusahaan = UploadedFile::getInstance($modelUserAssociateBrokerDetails,'akta_perusahaan');	
													
							//validate image size
							if($modelUserAssociateBrokerDetails->akta_perusahaan->size > 10000000)
							throw new ErrorException("Image ".$modelUserAssociateBrokerDetails->getAttributeLabel('akta_perusahaan')." size cannot larger than 10MB");
												
							$file_name = session_id().'akta_perusahaan'.str_replace(' ','_',$modelUserAssociateBrokerDetails->akta_perusahaan->name);
							$modelUserAssociateBrokerDetails->akta_perusahaan->saveAs($directory_path.$file_name,false);
							if(!$modelUserAssociateBrokerDetails->akta_perusahaan->saveAs($directory_path.$file_name,false))
							throw new ErrorException("Upload image failed.");
		
							//save path to db column
							$modelUserAssociateBrokerDetails->akta_perusahaan = ((isset($_SERVER['HTTPS'])) ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'].'/cmp/'.$directory_path.$file_name;
						}
						else
						throw new ErrorException($path->errorMessage);
					}
	
					//save nib
					if($_FILES['UserAssociateBrokerDetails']['error']['nib']!=4)
					{					
						//directory path
						$directory_path = 'contents/asscociate-broker-details/'.$modelUser->id.'/';
						if(($path = Yii::$app->AccessMod->createDirectory($directory_path)))
						{
							//get the instance of uploaded nib
							$modelUserAssociateBrokerDetails->nib = UploadedFile::getInstance($modelUserAssociateBrokerDetails,'nib');	
													
							//validate image size
							if($modelUserAssociateBrokerDetails->nib->size > 10000000)
							throw new ErrorException("Image ".$modelUserAssociateBrokerDetails->getAttributeLabel('nib')." size cannot larger than 10MB");
												
							$file_name = session_id().'nib'.str_replace(' ','_',$modelUserAssociateBrokerDetails->nib->name);
							$modelUserAssociateBrokerDetails->nib->saveAs($directory_path.$file_name,false);
							if(!$modelUserAssociateBrokerDetails->nib->saveAs($directory_path.$file_name,false))
							throw new ErrorException("Upload image failed.");
		
							//save path to db column
							$modelUserAssociateBrokerDetails->nib = ((isset($_SERVER['HTTPS'])) ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'].'/cmp/'.$directory_path.$file_name;
						}
						else
						throw new ErrorException($path->errorMessage);
					}
	
					//save sk_menkeh
					if($_FILES['UserAssociateBrokerDetails']['error']['sk_menkeh']!=4)
					{					
						//directory path
						$directory_path = 'contents/asscociate-broker-details/'.$modelUser->id.'/';
						if(($path = Yii::$app->AccessMod->createDirectory($directory_path)))
						{
							//get the instance of uploaded sk_menkeh
							$modelUserAssociateBrokerDetails->sk_menkeh = UploadedFile::getInstance($modelUserAssociateBrokerDetails,'sk_menkeh');	
													
							//validate image size
							if($modelUserAssociateBrokerDetails->sk_menkeh->size > 10000000)
							throw new ErrorException("Image ".$modelUserAssociateBrokerDetails->getAttributeLabel('sk_menkeh')." size cannot larger than 10MB");
												
							$file_name = session_id().'sk_menkeh'.str_replace(' ','_',$modelUserAssociateBrokerDetails->sk_menkeh->name);
							$modelUserAssociateBrokerDetails->sk_menkeh->saveAs($directory_path.$file_name,false);
							if(!$modelUserAssociateBrokerDetails->sk_menkeh->saveAs($directory_path.$file_name,false))
							throw new ErrorException("Upload image failed.");
		
							//save path to db column
							$modelUserAssociateBrokerDetails->sk_menkeh = ((isset($_SERVER['HTTPS'])) ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'].'/cmp/'.$directory_path.$file_name;
						}
						else
						throw new ErrorException($path->errorMessage);
					}
					
					//save npwp
					if($_FILES['UserAssociateBrokerDetails']['error']['npwp']!=4)
					{					
						//directory path
						$directory_path = 'contents/asscociate-broker-details/'.$modelUser->id.'/';
						if(($path = Yii::$app->AccessMod->createDirectory($directory_path)))
						{
							//get the instance of uploaded npwp
							$modelUserAssociateBrokerDetails->npwp = UploadedFile::getInstance($modelUserAssociateBrokerDetails,'npwp');	
													
							//validate image size
							if($modelUserAssociateBrokerDetails->npwp->size > 10000000)
							throw new ErrorException("Image ".$modelUserAssociateBrokerDetails->getAttributeLabel('npwp')." size cannot larger than 10MB");
												
							$file_name = session_id().'npwp'.str_replace(' ','_',$modelUserAssociateBrokerDetails->npwp->name);
							$modelUserAssociateBrokerDetails->npwp->saveAs($directory_path.$file_name,false);
							if(!$modelUserAssociateBrokerDetails->npwp->saveAs($directory_path.$file_name,false))
							throw new ErrorException("Upload image failed.");
		
							//save path to db column
							$modelUserAssociateBrokerDetails->npwp = ((isset($_SERVER['HTTPS'])) ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'].'/cmp/'.$directory_path.$file_name;
						}
						else
						throw new ErrorException($path->errorMessage);
					}
	
					//save ktp_direktur
					if($_FILES['UserAssociateBrokerDetails']['error']['ktp_direktur']!=4)
					{					
						//directory path
						$directory_path = 'contents/asscociate-broker-details/'.$modelUser->id.'/';
						if(($path = Yii::$app->AccessMod->createDirectory($directory_path)))
						{
							//get the instance of uploaded ktp_direktur
							$modelUserAssociateBrokerDetails->ktp_direktur = UploadedFile::getInstance($modelUserAssociateBrokerDetails,'ktp_direktur');	
													
							//validate image size
							if($modelUserAssociateBrokerDetails->ktp_direktur->size > 10000000)
							throw new ErrorException("Image ".$modelUserAssociateBrokerDetails->getAttributeLabel('ktp_direktur')." size cannot larger than 10MB");
												
							$file_name = session_id().'ktp_direktur'.str_replace(' ','_',$modelUserAssociateBrokerDetails->ktp_direktur->name);
							$modelUserAssociateBrokerDetails->ktp_direktur->saveAs($directory_path.$file_name,false);
							if(!$modelUserAssociateBrokerDetails->ktp_direktur->saveAs($directory_path.$file_name,false))
							throw new ErrorException("Upload image failed.");
		
							//save path to db column
							$modelUserAssociateBrokerDetails->ktp_direktur = ((isset($_SERVER['HTTPS'])) ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'].'/cmp/'.$directory_path.$file_name;
						}
						else
						throw new ErrorException($path->errorMessage);
					}
	
					//save bank_account
					if($_FILES['UserAssociateBrokerDetails']['error']['bank_account']!=4)
					{					
						//directory path
						$directory_path = 'contents/asscociate-broker-details/'.$modelUser->id.'/';
						if(($path = Yii::$app->AccessMod->createDirectory($directory_path)))
						{
							//get the instance of uploaded bank_account
							$modelUserAssociateBrokerDetails->bank_account = UploadedFile::getInstance($modelUserAssociateBrokerDetails,'bank_account');	
													
							//validate image size
							if($modelUserAssociateBrokerDetails->bank_account->size > 10000000)
							throw new ErrorException("Image ".$modelUserAssociateBrokerDetails->getAttributeLabel('bank_account')." size cannot larger than 10MB");
												
							$file_name = session_id().'bank_account'.str_replace(' ','_',$modelUserAssociateBrokerDetails->bank_account->name);
							$modelUserAssociateBrokerDetails->bank_account->saveAs($directory_path.$file_name,false);
							if(!$modelUserAssociateBrokerDetails->bank_account->saveAs($directory_path.$file_name,false))
							throw new ErrorException("Upload image failed.");
		
							//save path to db column
							$modelUserAssociateBrokerDetails->bank_account = ((isset($_SERVER['HTTPS'])) ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'].'/cmp/'.$directory_path.$file_name;
						}
						else
						throw new ErrorException($path->errorMessage);
					}
					
					
					$modelUserAssociateBrokerDetails->company_name = trim($_POST['UserAssociateBrokerDetails']['company_name']);
					$modelUserAssociateBrokerDetails->brand_name = trim($_POST['UserAssociateBrokerDetails']['brand_name']);
					$modelUserAssociateBrokerDetails->updatedby = $_SESSION['user']['id'];
					$modelUserAssociateBrokerDetails->updatedat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
					
					
					$modelUserAssociateBrokerDetails->save();
					if(count($modelUserAssociateBrokerDetails->errors)!=0)
					throw new ErrorException("Create user associate broker failed.");
				}
												
				if(isset($_POST['send_user_notification']) and (strlen($_POST['Users']['password']) or strlen($_POST['Users']['generate_password'])))
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
						
						if(strlen($_POST['Users']['password']))
						$password = $_POST['Users']['password'];
						elseif(strlen($_POST['Users']['generate_password']))
						$password = $_POST['Users']['generate_password'];
						else
						$password = '';
						
						$message = Yii::$app->AccessMod->multipleReplace($message,array('site_url'=>$_SESSION['settings']['SITE_URL'],'name'=>$modelUser->name,'password'=>$password,'year'=>Yii::$app->AccessRule->dateFormat(time(), 'Y')));
						
						$sendEmail = Yii::$app->AccessMod->sendEmail($from, $to, $subject, $message);
						
						if(!$sendEmail)
						throw new ErrorException(Yii::$app->AccessMod->errorMessage);
					}
				}
							
				$transaction->commit();
			}
			catch (ErrorException $e) 
			{
				$transaction->rollBack();
				$error = $e->getMessage();
				Yii::$app->session->set('errorMessage', $error);
				$modelUser->profile_description = html_entity_decode($modelUser->profile_description);
			}
			
			
			//log audit create process
			if(!strlen($error))
			{
				$newdataUsers = Users::find()->where(array('id' => $modelUser->id))->asArray()->one();
				$newdataUserGroups = UserGroups::find()->where(array('user_id' => $modelUser->id))->asArray()->one();
				$newdata['user'] = json_encode($newdataUsers);
				$newdata['group'] = json_encode($newdataUserGroups);
				
				$modelLogAudit = new LogAudit();
				$modelLogAudit->module_id = $modules->id;
				$modelLogAudit->record_id = $modelUser->id;
				$modelLogAudit->action = $_SESSION['user']['action'];
				$modelLogAudit->newdata = json_encode($newdata);
				$modelLogAudit->olddata = json_encode($olddata);
				$modelLogAudit->user_id = $_SESSION['user']['id'];
				$modelLogAudit->createdat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
				$modelLogAudit->save();
			}
					
			if(!strlen($error))
			return $this->redirect(['view', 'id' => $modelUser->id]);
		}

		return $this->render('update', [
			'modelUser' => $modelUser,
			'modelUserGroups' => $modelUserGroups,
			'modelUserPosition' => $modelUserPosition,
			'groupAccess' => $groupAccess,
			'avatar' => $avatar,
			'countryList' => $countryList,
			'positionList' => $positionList,
			'countryCodeList' => $countryCodeList,
			'bankList' => $bankList,
			'modelUserBank' => $modelUserBank,
			'developerList' => $developerList,
			'modelUserDeveloper' => $modelUserDeveloper,
			'fintechList' => $fintechList,
			'modelUserFintech' => $modelUserFintech,
			'modelAssistantUpline' => $modelAssistantUpline,
			'uplineList' => $uplineList,
			'projectObj' => $projectObj,
			'modelProjectAgents' => $modelProjectAgents,
			'modelUserAssociateBrokerDetails' => $modelUserAssociateBrokerDetails,
		]);
    }

    public function actionToggleStatus($id)
    {
		$model = $this->findModel($id);
		
		$modules = Modules::find()->where(array('controller' => $_SESSION['user']['controller']))->one();
		$olddata = Users::find()->where(array('id' => $model->id))->asArray()->one();
		
		$error = '';	
		$connection = \Yii::$app->db;
		$transaction = $connection->beginTransaction();
		try 
		{
			unset($model->password);
			
			if($model->status == 0)
			$model->status = 1;
			else
			$model->status = 0;
		
			$model->updatedby = $_SESSION['user']['id'];
			$model->updatedat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
	
			$model->save();
			
			if(count($model->errors)!=0)
			throw new ErrorException("Failed to toogle user status");

			$transaction->commit();
		}
		catch (ErrorException $e) 
		{
			$transaction->rollBack();
			$error = $e->getMessage();
		}
		
		if(!strlen($error))
		{
			$newdata = Users::find()->where(array('id' => $id))->asArray()->one();
			//log audit create process
			$modelLogAudit = new LogAudit();
			$modelLogAudit->module_id = $modules->id;
			$modelLogAudit->record_id = $model->id;
			$modelLogAudit->action = $_SESSION['user']['action'];
			$modelLogAudit->newdata = json_encode($newdata);
			$modelLogAudit->olddata = json_encode($olddata);
			$modelLogAudit->user_id = $_SESSION['user']['id'];
			$modelLogAudit->createdat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
			$modelLogAudit->save();
		}
				
        return $this->redirect(['index']);
    }

    public function actionExportExcel()
	{
		$error = '';
		$datacolumns = array();
		require_once(Yii::getAlias("@vendor/PHPExcel/Classes/PHPExcel.php"));
		$objPHPExcel = new \PHPExcel();
				
		$username = '';
		$name = '';
		$groupAccess = '';
		$lookupPosition = '';
		$status = '';
		$createdatrange = '';
		$directorID = '';
		$managerID = '';
		if(isset($_REQUEST['UsersSearch']))
		{			
			if(strlen($_REQUEST['UsersSearch']['username']))
			$username = $_REQUEST['UsersSearch']['username'];
			
			if(strlen($_REQUEST['UsersSearch']['name']))
			$name = $_REQUEST['UsersSearch']['name'];
			
			if(strlen($_REQUEST['UsersSearch']['groupAccess']))
			$groupAccess = $_REQUEST['UsersSearch']['groupAccess'];
			
			if(strlen($_REQUEST['UsersSearch']['lookupPosition']))
			$lookupPosition = $_REQUEST['UsersSearch']['lookupPosition'];
			
			if(strlen($_REQUEST['UsersSearch']['status']))
			$status = $_REQUEST['UsersSearch']['status'];
			
			if(strlen($_REQUEST['UsersSearch']['createdatrange']))
			$createdatrange = $_REQUEST['UsersSearch']['createdatrange'];
		}
			
		$modelUser = new Users();
		$data = $modelUser->getUsersData($username,$name,$groupAccess,$lookupPosition,$status,$createdatrange,$directorID,$managerID);
				
		$i=0;
		foreach($data as $value)
		{
			$usersData[$i]['system_group'] = $value['system_group'];
			$usersData[$i]['position'] = $value['position'];
			$usersData[$i]['uuid'] = $value['uuid'];
			$usersData[$i]['username'] = $value['username'];
			$usersData[$i]['email'] = $value['email'];
			$usersData[$i]['name'] = $value['name'];
			$usersData[$i]['contact_number'] = $value['contact_number'];
			$usersData[$i]['dob'] = $value['dob'];
			$usersData[$i]['address_1'] = $value['address_1'];
			$usersData[$i]['address_2'] = $value['address_2'];
			$usersData[$i]['address_3'] = $value['address_3'];
			$usersData[$i]['city'] = $value['city'];
			$usersData[$i]['postcode'] = $value['postcode'];
			$usersData[$i]['state'] = $value['state'];
			$usersData[$i]['country'] = $value['country'];
			$usersData[$i]['status'] = $value['status']==1?'Active':'Inactive';
			$usersData[$i]['createdat'] = $value['createdat'];
			$i++;
		}
				
		$datacolumns[]['name'] = 'system_group';
		$datacolumns[]['name'] = 'position';
		$datacolumns[]['name'] = 'uuid';
		$datacolumns[]['name'] = 'username';
		$datacolumns[]['name'] = 'email';
		$datacolumns[]['name'] = 'name';
		$datacolumns[]['name'] = 'contact_number';
		$datacolumns[]['name'] = 'dob';
		$datacolumns[]['name'] = 'address_1';
		$datacolumns[]['name'] = 'address_2';
		$datacolumns[]['name'] = 'address_3';
		$datacolumns[]['name'] = 'city';
		$datacolumns[]['name'] = 'postcode';
		$datacolumns[]['name'] = 'state';
		$datacolumns[]['name'] = 'country';
		$datacolumns[]['name'] = 'status';
		$datacolumns[]['name'] = 'createdat';
				
		$columnexcel = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q');
		$newcolumn = array();
		
		$objPHPExcel->getProperties()->setCreator("Forefront")
						 ->setLastModifiedBy("Forefront")
						 ->setTitle("Office 2007 XLSX Test Document")
						 ->setSubject("Office 2007 XLSX Test Document")
						 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
						 ->setKeywords("office 2007 openxml php")
						 ->setCategory("Export File");

		//set column name (first row)
		$i = 0;
		foreach($columnexcel as $value)
		{
			$objPHPExcel->getActiveSheet()->setCellValue($value.'1', str_replace('_',' ',ucwords($datacolumns[$i]['name'])));
			$newcolumn[] = $value;
			$i++;
		}
		
		if($usersData)
		{					
			$k = 0;
			foreach($usersData as $value)
			{
				foreach($datacolumns as $columns)
				{
					$datausers[$k][$columns['name']] = $value[$columns['name']];	
				}
				$k++;	
			}
		
			$i = 2;
			foreach($datausers as $user)
			{
				$k = 0;
				foreach($newcolumn as $new)
				{
					$objPHPExcel->getActiveSheet()->setCellValue($new.$i, $user[$datacolumns[$k]['name']]);
					$k++;
				}
				$i++;
			}
		}

		foreach($newcolumn as $col)
		{
			$objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
		}
		
		$objPHPExcel->getActiveSheet()->setTitle('User');
		
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition:attachment;filename="Users-'.date('YmdHis').'.xls"');
		header('Cache-Control: max-age=0');
		
		$objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
				
		return $this->redirect('index');
	}

    public function actionDelete($id)
    {
		if($id==1)
		throw new \yii\web\HttpException(401, 'Unauthorized: Can\'t delete Superadmin.');

		$model = $this->findModel($id);
		
		$modules = Modules::find()->where(array('controller' => $_SESSION['user']['controller']))->one();
		$olddata = Users::find()->where(array('id' => $model->id))->asArray()->one();

		$error = '';	
		$connection = \Yii::$app->db;
		$transaction = $connection->beginTransaction();
		try 
		{
			/***** users soft delete process ******/			
			unset($model->password);
			$model->status = 0;
			$model->deletedby = $_SESSION['user']['id'];
			$model->deletedat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
			$model->save();
			
			if(count($model->errors)!=0)
			throw new ErrorException("Failed to delete user");
						
			$transaction->commit();
		}
		catch (ErrorException $e) 
		{
			$transaction->rollBack();
			$error = $e->getMessage();
		}
		
		if(!strlen($error))
		{
			$newdata = Users::find()->where(array('id' => $model->id))->asArray()->one();
			//log audit create process
			$modelLogAudit = new LogAudit();
			$modelLogAudit->module_id = $modules->id;
			$modelLogAudit->record_id = $model->id;
			$modelLogAudit->action = $_SESSION['user']['action'];
			$modelLogAudit->newdata = json_encode($newdata);
			$modelLogAudit->olddata = json_encode($olddata);
			$modelLogAudit->user_id = $_SESSION['user']['id'];
			$modelLogAudit->createdat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
			$modelLogAudit->save();
		}
				
        return $this->redirect(['index']);
    }
		
	public function actionProfile()
    {
		if(!isset($_SESSION['user']['id']))
		return $this->redirect(['login/']);

		if(!strlen($_SESSION['user']['id']))
		throw new \yii\web\HttpException(401, 'Unauthorized: No Access to User Profile.');
		
		$id = $_SESSION['user']['id'];
        $modelUser = $this->findModel($id);
		$modelUser->profile_description = html_entity_decode($modelUser->profile_description);		
		$modelUser->password='';
		
		$modelUser->country_code = substr($modelUser->contact_number,0,2);
		$modelUser->contact_number = substr($modelUser->contact_number,2);
		
		//get avatar list
        $avatarObjs = LookupAvatars::find()->where(array('deleted'=>0))->all();
		$avatar = array();
		foreach($avatarObjs as $avatarObj)
		{
			if($avatarObj->id!=1)
			$avatar[$avatarObj->id] = Html::img($avatarObj->image,['width'=>'100']);
		}
		//$avatar[$avatarObjs[0]->id] = '<span>Other</span>'.Html::img($avatarObjs[0]->image,['width'=>'100']);
		$avatar[$avatarObjs[0]->id] = '<span>Other</span>';
		
		//get country list
        $countryList = Yii::$app->AccessMod->getLookupData('lookup_country');
		
		$modules = Modules::find()->where(array('controller' => $_SESSION['user']['controller']))->one();
		$olddata = Users::find()->where(array('id' => $modelUser->id))->asArray()->one();
		
		//get country code list
		$countryCodeList = array();
		$countryRecord = Yii::$app->AccessMod->readExcel('contents/others/countries.xls');
		$countryCodeList[0]['name'] = 'Indonesia (+62)';
		$countryCodeList[0]['value'] = '62';
		$countryCodeList[1]['name'] = '------------------------------------------------';
		$countryCodeList[1]['value'] = '';
		if(count($countryRecord)!=0)
		{
			$i=2;
			foreach($countryRecord as $key => $country)
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
				
        if(count($_POST)!=0)
		{			
			$error = '';
			$connection = Yii::$app->db;
			$transaction = $connection->beginTransaction();
			try 
			{
				//save user
				$modelUser->load(Yii::$app->request->post());
				
				//validate username
				$checkUserByUsername = $modelUser->CheckActiveUserByUsername($modelUser->username);
				if($checkUserByUsername)
				{
					if($checkUserByUsername->id != $modelUser->id)
					throw new ErrorException("Username '".$modelUser->username."' has already been taken.");
				}
				//validate email
				$checkUserByEmail = $modelUser->CheckActiveUserByEmail($modelUser->email);
				if($checkUserByEmail)
				{
					if($checkUserByEmail->id != $modelUser->id)
					throw new ErrorException("Email '".$modelUser->email."' has already been taken.");
				}
				
				//validate sqm id
				if(strlen($modelUser->sqm_id))
				{
					$tmpUser = Users::find()->where(array('sqm_id'=>$modelUser->sqm_id,'status'=>1,'deletedby'=>NULL,'deletedat'=>NULL))->one();
					if($tmpUser!=NULL)
					{
						if($tmpUser->id != $modelUser->id)
						throw new ErrorException("SQM ID '".$modelUser->sqm_id."' has already been taken.");
					}
					
					if(preg_match('/^[a-zA-Z0-9-]+$/i', $modelUser->sqm_id)==0)
					throw new ErrorException("SQM ID '".$modelUser->sqm_id."' is invalid. Alphanumeric and hyphen only.");
				}
				
				$modelUser->username = trim($modelUser->username);
				$modelUser->sqm_id = trim($modelUser->sqm_id);
				$modelUser->email = trim($modelUser->email);
				$modelUser->firstname = trim($modelUser->firstname);
				$modelUser->lastname = trim($modelUser->lastname);
				$modelUser->name = trim($modelUser->firstname.' '.$modelUser->lastname);
				
				if(strlen($_POST['Users']['password']))
				{
					$modelUser->password = trim($modelUser->password);
					$modelUser->password = md5($modelUser->password.$modelUser->password_salt);
					$modelUser->password_repeat = $modelUser->password;
				}
				else
				unset($modelUser->password);
				
				$modelUser->profile_description = htmlentities($modelUser->profile_description);	
							
				$modelUser->updatedby = $_SESSION['user']['id']; 
				$modelUser->updatedat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
				$modelUser->save();
				
				if(count($modelUser->errors)!=0)
				throw new ErrorException("Failed to update user.");
				
				//save avatar
				if(!empty($_FILES['Users']))
				{					
					if($_FILES['Users']['error']['photo']!=4)
					{					
						//directory path
						$directory_path = 'contents/users/'.$modelUser->id.'/';
						if(($path = Yii::$app->AccessMod->createDirectory($directory_path)))
						{
							//get the instance of uploaded photo
							$modelUser->photo = UploadedFile::getInstance($modelUser,'photo');	
													
							//validate image size
							if($modelUser->photo->size > 10000000)
							throw new ErrorException("Photo size cannot larger than 10MB");
												
							$file_name = session_id().str_replace(' ','_',$modelUser->photo->name);
							$modelUser->photo->saveAs($directory_path.$file_name,false);
							if(!$modelUser->photo->saveAs($directory_path.$file_name,false))
							throw new ErrorException("Upload photo failed.");
		
							//save path to db column
							$modelUser->avatar = ((isset($_SERVER['HTTPS'])) ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'].'/cmp/'.$directory_path.$file_name;
							$modelUser->save();
							if(count($modelUser->errors)!=0)
							throw new ErrorException("Save photo failed.");
						}
						else
						throw new ErrorException($path->errorMessage);
					}
				}
				
				$transaction->commit();
			}
			catch (ErrorException $e) 
			{
				$transaction->rollBack();
				$error = $e->getMessage();
				Yii::$app->session->set('errorMessage', $error);
				$modelUser->profile_description = html_entity_decode($modelUser->profile_description);
			}
		
			if(!strlen($error))
			{
				$newdata = Users::find()->where(array('id' => $modelUser->id))->asArray()->one();
				//log audit create process
				$modelLogAudit = new LogAudit();
				$modelLogAudit->module_id = $modules->id;
				$modelLogAudit->record_id = $modelUser->id;
				$modelLogAudit->action = $_SESSION['user']['action'];
				$modelLogAudit->newdata = json_encode($newdata);
				$modelLogAudit->olddata = json_encode($olddata);
				$modelLogAudit->user_id = $_SESSION['user']['id'];
				$modelLogAudit->createdat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
				$modelLogAudit->save();
			}
				
			if(!strlen($error))
			return $this->redirect(['profile']);
		}

		return $this->render('profile', [
			'modelUser' => $modelUser,
			'avatar' => $avatar,
			'countryList' => $countryList,
			'countryCodeList' => $countryCodeList,
		]);
    }


    protected function findModel($id)
    {
        if (($model = Users::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
