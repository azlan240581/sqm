<?php

namespace app\controllers;

use Yii;
use app\models\Users;
use app\models\UserAssociateDetails;
use app\models\UserAssociateDetailsSearch;

use app\models\LookupCountry;
use app\models\LookupDomicile;
use app\models\LookupOccupation;
use app\models\LookupIndustryBackground;
use app\models\LookupAssociateApprovalStatus;
use app\models\LookupAssociateProductivityStatus;

use app\models\LogAssociateApproval;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\base\ErrorException;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;
use yii\data\ArrayDataProvider;

/**
 * AssociatesController implements the CRUD actions for UserAssociateDetails model.
 */
class AssociatesController extends Controller
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
		//Bulk action
		if(isset($_POST['action']))
		{
			$bulk_action = $_POST['action'];
			
			switch($bulk_action)
			{
				case 'change-agent':
									
					if(empty($_POST['agent_id']))
					{
						Yii::$app->session->set('errorMessage', 'Please select new associate agent.');
						return $this->redirect(['index']);
					}
					else
					{
						if(!empty($_POST['selection']))
						{
							$result = Yii::$app->MemberMod->changeMemberAgent($_POST['agent_id'],$_POST['selection']);
							if(!$result)
							Yii::$app->session->set('errorMessage', 'Change associate agent failed.');
							else
							Yii::$app->session->set('successMessage', 'Successful change associate agent.');
								
							return $this->redirect(['index']);
						}
						else
						{
							Yii::$app->session->set('errorMessage', 'Please select associate(s).');
							return $this->redirect(['index']);
						}
					}
					
					
				break;
				case 'delete-member':
					if(!empty($_POST['selection']))
					{
						$result = Yii::$app->MemberMod->deleteMemberAccount($_POST['selection']);
						if(!$result)
						Yii::$app->session->set('errorMessage', 'Delete Associate failed.');
						else
						Yii::$app->session->set('successMessage', 'Successful delete associate.');
							
						return $this->redirect(['index']);
					}
					else
					{
						Yii::$app->session->set('errorMessage', 'Please select associate(s).');
						return $this->redirect(['index']);
					}
				break;
				default:
					return $this->redirect(['index']);
				break;
			}
		}
		
		if($_SESSION['user']['groups']!=NULL and array_intersect(array(7,8,9,10),$_SESSION['user']['groups']))
        $searchModel = new UserAssociateDetailsSearch(['agent_id'=>$_SESSION['user']['id']]);
		else
        $searchModel = new UserAssociateDetailsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		
		//get sqm account manager list
		$agentList = Yii::$app->AccessMod->getAgentList(array(7));
		
		//get associate productivity status
		$associateProductivityStatusList = LookupAssociateProductivityStatus::find()->where(array('deleted'=>0))->asArray()->all();
		
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'associateProductivityStatusList' => $associateProductivityStatusList,
            'agentList' => $agentList,
        ]);
    }

    public function actionView($id)
    {
		$modelUserAssociateDetails = $this->findModel($id);
		$modelUsers = $this->findModelUsers($modelUserAssociateDetails->user_id);
		
        return $this->render('view', [
            'modelUsers' => $modelUsers,
            'modelUserAssociateDetails' => $modelUserAssociateDetails,
        ]);
    }

    public function actionInvite()
    {
		$error = '';
        $model = new UserAssociateDetails();
		
		//get sqm account manager list
		$agentList = Yii::$app->AccessMod->getAgentList(array(7));
		
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
			$_SESSION['invite_associate']['upline'] = $_POST['Associate']['upline'];
			$_SESSION['invite_associate']['firstname'] = $_POST['Associate']['firstname'];
			$_SESSION['invite_associate']['lastname'] = $_POST['Associate']['lastname'];
			$_SESSION['invite_associate']['email'] = $_POST['Associate']['email'];
			$_SESSION['invite_associate']['country_code'] = $_POST['Associate']['country_code'];
			$_SESSION['invite_associate']['contact_no'] = $_POST['Associate']['contact_no'];
			
			$result = Yii::$app->MemberMod->memberInvitation($_SESSION['invite_associate'],$_SESSION['invite_associate']['upline']);
			if(!$result)
			Yii::$app->session->set('errorMessage', Yii::$app->MemberMod->errorMessage);
			else
			{
				unset($_SESSION['invite_associate']);
				Yii::$app->session->set('successMessage', 'Invitation successful!');
			}
        }
		
		return $this->render('invite-associate', [
			'model' => $model,
			'error' => $error,
			'agentList' => $agentList,
			'countryCodeList' => $countryCodeList,
		]);
    }

    public function actionUpdate($id)
    {
		$error = '';
		$inputs = array();
		$modelUserAssociateDetails = $this->findModel($id);
		$modelUsers = $this->findModelUsers($modelUserAssociateDetails->user_id);
		
		//get country list
        $countryList = Yii::$app->AccessMod->getLookupData('lookup_country');
		
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
		
		//get domicile list
        $domicileList = LookupDomicile::find()->where(array('deleted'=>0))->asArray()->all();
		
		//get occupaction list
        $occupationList = LookupOccupation::find()->where(array('deleted'=>0))->asArray()->all();
		
		//get domicile list
        $industryBackgroundList = LookupIndustryBackground::find()->where(array('deleted'=>0))->asArray()->all();
		
        if(count($_POST)!=0)
		{
			$modelUsers->load(Yii::$app->request->post());
			$modelUserAssociateDetails->load(Yii::$app->request->post());
								
			if(!strlen($error))
			{
				//save nricpass
				$nricpass = '';
				if($_FILES['UserAssociateDetails']['error']['file']!=4)
				{
					//directory path
					$directory_path = 'contents/associate/'.$id.'/';
					if(($path = Yii::$app->AccessMod->createDirectory($directory_path)))
					{
						//get the instance of uploaded file
						$modelUserAssociateDetails->file = UploadedFile::getInstance($modelUserAssociateDetails,'file');						
						$file_name = session_id().'_nricpass.'.$modelUserAssociateDetails->file->extension;
						$modelUserAssociateDetails->file->saveAs($directory_path.$file_name,false);
						if(!$modelUserAssociateDetails->file->saveAs($directory_path.$file_name,false))
						$error = "Failed uploading identity document image";
						else
						$nricpass = $_SESSION['settings']['SITE_URL'].'/'.$directory_path.$file_name;
					}
					else
					$error = Yii::$app->AccessMod->errorMessage;
				}
			}
			
			if(!strlen($error))
			{
				//save tax license
				$tax_license = '';
				if($_FILES['UserAssociateDetails']['error']['file2']!=4)
				{
					//directory path
					$directory_path = 'contents/associate/'.$id.'/';
					if(($path = Yii::$app->AccessMod->createDirectory($directory_path)))
					{
						//get the instance of uploaded file
						$modelUserAssociateDetails->file2 = UploadedFile::getInstance($modelUserAssociateDetails,'file2');						
						$file_name = session_id().'_tax_license.'.$modelUserAssociateDetails->file2->extension;
						$modelUserAssociateDetails->file2->saveAs($directory_path.$file_name,false);
						if(!$modelUserAssociateDetails->file2->saveAs($directory_path.$file_name,false))
						$error = "Failed uploading tax license image";
						else
						$tax_license = $_SESSION['settings']['SITE_URL'].'/'.$directory_path.$file_name;
					}
					else
					$error = Yii::$app->AccessMod->errorMessage;
				}
			}
			
			if(!strlen($error))
			{
				//save bank account
				$bank_account = '';
				if($_FILES['UserAssociateDetails']['error']['file3']!=4)
				{
					//directory path
					$directory_path = 'contents/associate/'.$id.'/';
					if(($path = Yii::$app->AccessMod->createDirectory($directory_path)))
					{
						//get the instance of uploaded file
						$modelUserAssociateDetails->file3 = UploadedFile::getInstance($modelUserAssociateDetails,'file3');						
						$file_name = session_id().'_bank_account.'.$modelUserAssociateDetails->file3->extension;
						$modelUserAssociateDetails->file3->saveAs($directory_path.$file_name,false);
						if(!$modelUserAssociateDetails->file3->saveAs($directory_path.$file_name,false))
						$error = "Failed uploading bank account image";
						else
						$bank_account = $_SESSION['settings']['SITE_URL'].'/'.$directory_path.$file_name;
					}
					else
					$error = Yii::$app->AccessMod->errorMessage;
				}
			}
			
			if(!strlen($error))
			{
				//save bank account
				$associate_hold_id = '';
				if($_FILES['UserAssociateDetails']['error']['file4']!=4)
				{
					//directory path
					$directory_path = 'contents/associate/'.$id.'/';
					if(($path = Yii::$app->AccessMod->createDirectory($directory_path)))
					{
						//get the instance of uploaded file
						$modelUserAssociateDetails->file4 = UploadedFile::getInstance($modelUserAssociateDetails,'file4');						
						$file_name = session_id().'_associate_hold_id.'.$modelUserAssociateDetails->file4->extension;
						$modelUserAssociateDetails->file4->saveAs($directory_path.$file_name,false);
						if(!$modelUserAssociateDetails->file4->saveAs($directory_path.$file_name,false))
						$error = "Failed uploading associate hold id image";
						else
						$associate_hold_id = $_SESSION['settings']['SITE_URL'].'/'.$directory_path.$file_name;
					}
					else
					$error = Yii::$app->AccessMod->errorMessage;
				}
			}
			
			if(!strlen($error))
			{
				$member_id = $modelUsers->id;
				$user_id = $_SESSION['user']['id'];
				$inputs['action'] = 'update';
				
				$inputs['sqm_id'] = $modelUsers->id;
				$inputs['email'] = $modelUsers->email;
				$inputs['firstname'] = $modelUsers->firstname;
				$inputs['lastname'] = $modelUsers->lastname;
				$inputs['country_code'] = $modelUsers->country_code;
				$inputs['contact_number'] = $modelUsers->contact_number;
				$inputs['dob'] = $modelUsers->dob;
				$inputs['gender'] = $modelUsers->gender;
				$inputs['address_1'] = $modelUsers->address_1;
				$inputs['address_2'] = $modelUsers->address_2;
				$inputs['address_3'] = $modelUsers->address_3;
				$inputs['city'] = $modelUsers->city;
				$inputs['postcode'] = $modelUsers->postcode;
				$inputs['state'] = $modelUsers->state;
				$inputs['country'] = $modelUsers->country;
				
				$inputs['id_number'] = $modelUserAssociateDetails->id_number;
				$inputs['tax_license_number'] = $modelUserAssociateDetails->tax_license_number;
				$inputs['bank_id'] = $modelUserAssociateDetails->bank_id;
				$inputs['account_name'] = $modelUserAssociateDetails->account_name;
				$inputs['account_number'] = $modelUserAssociateDetails->account_number;
				$inputs['domicile'] = $modelUserAssociateDetails->domicile;
				$inputs['occupation'] = $modelUserAssociateDetails->occupation;
				$inputs['industry_background'] = $modelUserAssociateDetails->industry_background;
				$inputs['nricpass'] = $nricpass;
				$inputs['tax_license'] = $tax_license;
				$inputs['bank_account'] = $bank_account;
				$inputs['associate_hold_id'] = $associate_hold_id;
				
				$result = Yii::$app->MemberMod->memberProfile($inputs,$member_id,$user_id);
				if(!$result)
				$error = Yii::$app->MemberMod->errorMessage;
			}
			
			if(!strlen($error))
            return $this->redirect(['view', 'id' => $id]);
			else
			{
				Yii::$app->session->set('errorMessage', Yii::$app->MemberMod->errorMessage);
			}
        }
		
		return $this->render('update', [
            'modelUsers' => $modelUsers,
            'modelUserAssociateDetails' => $modelUserAssociateDetails,
            'countryList' => $countryList,
            'countryCodeList' => $countryCodeList,
            'domicileList' => $domicileList,
            'occupationList' => $occupationList,
            'industryBackgroundList' => $industryBackgroundList,
		]);
    }

    public function actionPendingApproval()
    {
        $searchModel = new UserAssociateDetailsSearch(['pending_approval'=>2]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('pending-approval', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

	public function actionSetApproval($id)
	{
		//initialize
		$modelUserAssociateDetails = $this->findModel($id);
		$modelUsers = $this->findModelUsers($modelUserAssociateDetails->user_id);
		$modelLogAssociateApproval = new LogAssociateApproval();
		$inputs = array();
		$error = '';
		
		$lookupAssociateApprovalStatusList = LookupAssociateApprovalStatus::find()->where(array('id'=>array(3,4)))->asArray()->all();
		
		if(count($_POST)!=0)
		{
			$modelLogAssociateApproval->load(Yii::$app->request->post());	
						
			$inputs['user_id'] = $modelUsers->id;
			$inputs['status'] = $modelLogAssociateApproval->status;
			$inputs['remarks'] = $modelLogAssociateApproval->remarks;
			$inputs['createdby'] = $_SESSION['user']['id'];

			$setApprovalStatus = Yii::$app->MemberMod->setApprovalStatus($inputs);
			if(!$setApprovalStatus)
			Yii::$app->session->set('errorMessage', Yii::$app->MemberMod->errorMessage);
			else
			return $this->redirect(['view', 'id' => $modelUserAssociateDetails->id]);
		}

		if(isset($_REQUEST['ajaxView']))
		{
			return $this->renderAjax('set-approval', [
				'modelUserAssociateDetails' => $modelUserAssociateDetails,
				'modelUsers' => $modelUsers,
				'modelLogAssociateApproval' => $modelLogAssociateApproval,
				'lookupAssociateApprovalStatusList' => $lookupAssociateApprovalStatusList,
			]);
		}
		else
		{
			return $this->render('set-approval', [
				'modelUserAssociateDetails' => $modelUserAssociateDetails,
				'modelUsers' => $modelUsers,
				'modelLogAssociateApproval' => $modelLogAssociateApproval,
				'lookupAssociateApprovalStatusList' => $lookupAssociateApprovalStatusList,
			]);
		}
	}

	public function actionChangeAssociateAgent($id)
	{
		
	}

    public function actionDelete($id)
    {
        //$this->findModel($id)->delete();
		/*$model = $this->findModel($id);
		$modelUser = Users::find()->where(array('id'=>$model->user_id))->one();
		unset($modelUser->password);
		$modelUser->status = 0;
		$modelUser->deletedby = $_SESSION['user']['id'];
		$modelUser->deletedat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
		$modelUser->save();*/
		
		$result = Yii::$app->MemberMod->deleteMemberAccount(array($id));
		if(!$result)
		Yii::$app->session->set('errorMessage', 'Delete Associate failed.');
		else
		Yii::$app->session->set('successMessage', 'Successful delete associate.');
			
        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = UserAssociateDetails::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	
	protected function findModelUsers($id)
    {
        if (($model = Users::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
