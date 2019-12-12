<?php

namespace app\controllers;

use Yii;
use app\models\Prospects;
use app\models\ProspectsSearch;
use app\models\ProspectBookings;
use app\models\ProspectBookingBuyers;
use app\models\ProspectBookingsSearch;
use app\models\LookupProspectStatus;
use app\models\LogProspectHistory;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * ProspectsController implements the CRUD actions for Prospects model.
 */
class ProspectsController extends Controller
{
    /**
     * @inheritdoc
     */
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

    /**
     * Lists all Prospects models.
     * @return mixed
     */
    public function actionIndex()
    {
		$project_ids = Yii::$app->AccessMod->getAgentProjectID($_SESSION['user']['id']);
        $searchModel = new ProspectsSearch(['interested_projects' => $project_ids]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		$modelLogProspectHistory = new LogProspectHistory();

		//get status array
		$statusArray = LookupProspectStatus::find()->where(array('deleted'=>0))->asArray()->all();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
			'modelLogProspectHistory' => $modelLogProspectHistory,
			'statusArray' => $statusArray,
        ]);
    }

    public function actionIndexAdmin()
    {
        $searchModel = new ProspectsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		$modelLogProspectHistory = new LogProspectHistory();

		//get status array
		$statusArray = LookupProspectStatus::find()->where(array('deleted'=>0))->asArray()->all();

        return $this->render('index-admin', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
			'modelLogProspectHistory' => $modelLogProspectHistory,
			'statusArray' => $statusArray,
        ]);
    }

    public function actionMyAssociateProspects()
    {
        $searchModel = new ProspectsSearch(['agent_id'=>$_SESSION['user']['id']]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		$modelLogProspectHistory = new LogProspectHistory();

		//get status array
		$statusArray = LookupProspectStatus::find()->where(array('deleted'=>0))->asArray()->all();

        return $this->render('my-associate-prospects', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
			'modelLogProspectHistory' => $modelLogProspectHistory,
			'statusArray' => $statusArray,
        ]);
    }

    public function actionPendingEoiApproval()
    {
        $searchModel = new ProspectBookingsSearch(['status'=>1]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index-eoi-approval', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionPendingBookingApproval()
    {
        $searchModel = new ProspectBookingsSearch(['status'=>4]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index-booking-approval', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionPendingContractSignedApproval()
    {
        $searchModel = new ProspectBookingsSearch(['status'=>7]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index-contract-signed-approval', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionPendingCancellationApproval()
    {
        $searchModel = new ProspectBookingsSearch(['status'=>10]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index-cancellation-approval', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Prospects model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
		$bookingTransactions = Yii::$app->ProspectMod->getProspectBookings($id);
		$logProspectHistory = Yii::$app->ProspectMod->getProspectHistories($id);
								
		if(isset($_REQUEST['ajaxView']))
		{
			return $this->renderAjax('view', [
	            'model' => $this->findModel($id),
	            'logProspectHistory' => $logProspectHistory,
			]);
		}
        return $this->render('view', [
            'model' => $this->findModel($id),
            'bookingTransactions' => $bookingTransactions,
            'logProspectHistory' => $logProspectHistory,
        ]);
    }

    public function actionViewAdmin($id)
    {
		$bookingTransactions = Yii::$app->ProspectMod->getProspectBookings($id);
		$logProspectHistory = Yii::$app->ProspectMod->getProspectHistories($id);

        return $this->render('view-admin', [
            'model' => $this->findModel($id),
            'bookingTransactions' => $bookingTransactions,
            'logProspectHistory' => $logProspectHistory,
        ]);
    }

    public function actionViewMyAssociateProspects($id)
    {
		$logProspectHistory = Yii::$app->ProspectMod->getProspectHistories($id);

        return $this->render('view-my-associate-prospects', [
            'model' => $this->findModel($id),
            'logProspectHistory' => $logProspectHistory,
        ]);
    }

    public function actionViewEoi()
    {
        $model = $this->findModel($_REQUEST['id']);
        $modelPB = ProspectBookings::findOne($_REQUEST['prospect_booking_id']);
		$modelPBB = ProspectBookingBuyers::find()->where(['prospect_booking_id'=>$modelPB->id])->all();
		
        return $this->renderAjax('view-eoi', [
            'model' => $model,
            'modelPB' => $modelPB,
            'modelPBB' => $modelPBB,
        ]);
    }

    public function actionViewEoiApproval()
    {
        $model = $this->findModel($_REQUEST['id']);
        $modelPB = ProspectBookings::findOne($_REQUEST['prospect_booking_id']);
		$modelPBB = ProspectBookingBuyers::find()->where(['prospect_booking_id'=>$modelPB->id])->all();
		
		if(count($_POST) != 0)
		{
			$inputs = $_POST['ProspectBookings'];
			
			$prospectMod = Yii::$app->ProspectMod;
			if(!($eoiApproval = $prospectMod->approvalProspectEOI($inputs['prospect_booking_id'],$_SESSION['user']['id'],$inputs['action'],$inputs['remarks'])))
			Yii::$app->session->set('errorMessage', $prospectMod->errorMessage);
			else
			Yii::$app->session->set('successMessage', 'Prospect booking EOI has been '.($inputs['action']==1?'Approved':'Rejected').'. Message has been sent to person in charge');
			
            return $this->redirect(['pending-eoi-approval', 'id' => $_REQUEST['id']]);
			
		}
		else
		{
			return $this->renderAjax('view-eoi-approval', [
				'model' => $model,
				'modelPB' => $modelPB,
	            'modelPBB' => $modelPBB,
			]);
		}
    }

    public function actionViewBooking()
    {
        $model = $this->findModel($_REQUEST['id']);
        $modelPB = ProspectBookings::findOne($_REQUEST['prospect_booking_id']);
		$modelPBB = ProspectBookingBuyers::find()->where(['prospect_booking_id'=>$modelPB->id])->all();
		
        return $this->renderAjax('view-booking', [
            'model' => $model,
            'modelPB' => $modelPB,
            'modelPBB' => $modelPBB,
        ]);
    }

    public function actionViewBookingApproval()
    {
        $model = $this->findModel($_REQUEST['id']);
        $modelPB = ProspectBookings::findOne($_REQUEST['prospect_booking_id']);
		$modelPBB = ProspectBookingBuyers::find()->where(['prospect_booking_id'=>$modelPB->id])->all();
		
		if(count($_POST) != 0)
		{
			$inputs = $_POST['ProspectBookings'];
			
			$prospectMod = Yii::$app->ProspectMod;
			if(!($bookingApproval = $prospectMod->approvalProspectBooking($inputs['prospect_booking_id'],$_SESSION['user']['id'],$inputs['action'],$inputs['remarks'])))
			Yii::$app->session->set('errorMessage', $prospectMod->errorMessage);
			else
			Yii::$app->session->set('successMessage', 'Prospect booking has been '.($inputs['action']==1?'Approved':'Rejected').'. Message has been sent to person in charge');
			
            return $this->redirect(['pending-booking-approval', 'id' => $_REQUEST['id']]);
			
		}
		else
		{
			return $this->renderAjax('view-booking-approval', [
				'model' => $model,
				'modelPB' => $modelPB,
				'modelPBB' => $modelPBB,
			]);
		}
    }

    public function actionViewContractSigned()
    {
        $model = $this->findModel($_REQUEST['id']);
        $modelPB = ProspectBookings::findOne($_REQUEST['prospect_booking_id']);
		
        return $this->renderAjax('view-contract-signed', [
            'model' => $model,
            'modelPB' => $modelPB,
        ]);
    }

    public function actionViewFullBooking()
    {
        $model = $this->findModel($_REQUEST['id']);
        $modelPB = ProspectBookings::findOne($_REQUEST['prospect_booking_id']);
		
        return $this->renderAjax('view-full-booking', [
            'model' => $model,
            'modelPB' => $modelPB,
        ]);
    }

    public function actionViewContractSignedApproval()
    {
        $model = $this->findModel($_REQUEST['id']);
        $modelPB = ProspectBookings::findOne($_REQUEST['prospect_booking_id']);
		
		if(count($_POST) != 0)
		{
			$inputs = $_POST['ProspectBookings'];
			
			$prospectMod = Yii::$app->ProspectMod;
			if(!($bookingApproval = $prospectMod->approvalProspectContractSigned($inputs['prospect_booking_id'],$_SESSION['user']['id'],$inputs['action'],$inputs['remarks'])))
			Yii::$app->session->set('errorMessage', $prospectMod->errorMessage);
			else
			Yii::$app->session->set('successMessage', 'Prospect booking has been '.($inputs['action']==1?'Approved':'Rejected').'. Message has been sent to person in charge');
			
            return $this->redirect(['pending-contract-signed-approval', 'id' => $_REQUEST['id']]);
			
		}
		else
		{
			return $this->renderAjax('view-contract-signed-approval', [
				'model' => $model,
				'modelPB' => $modelPB,
			]);
		}
    }

    public function actionViewCancellationApproval()
    {
        $model = $this->findModel($_REQUEST['id']);
        $modelPB = ProspectBookings::findOne($_REQUEST['prospect_booking_id']);
		
		if(count($_POST) != 0)
		{
			$inputs = $_POST['ProspectBookings'];
			
			$prospectMod = Yii::$app->ProspectMod;
			if(!($bookingApproval = $prospectMod->approvalCancelBooking($inputs['prospect_booking_id'],$_SESSION['user']['id'],$inputs['action'],$inputs['remarks'])))
			Yii::$app->session->set('errorMessage', $prospectMod->errorMessage);
			else
			Yii::$app->session->set('successMessage', 'Prospect booking has been '.($inputs['action']==1?'Approved':'Rejected').'. Message has been sent to person in charge');
			
            return $this->redirect(['pending-cancellation-approval', 'id' => $_REQUEST['id']]);
			
		}
		else
		{
			return $this->renderAjax('view-cancellation-approval', [
				'model' => $model,
				'modelPB' => $modelPB,
			]);
		}
    }

    /**
     * Creates a new Prospects model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Prospects();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionCreateFollowUp($id)
    {
        $model = $this->findModel($id);
        $modelPH = new LogProspectHistory();

        if (count($_POST)!=0) 
		{
			$inputs = array_merge($_POST['Prospects'],$_POST['LogProspectHistory']);
			
			if($_FILES['Prospects']['error']['prospect_identity_document']==0)
			{
				//create folder
				Yii::$app->AccessMod->createDirectory('contents/prospects/'.$id.'/');
				
				//get the instance of uploaded file
				$filePath = 'contents/prospects/'.$id.'/id'.date('ymdHis').'-';
				$model->prospect_identity_document = UploadedFile::getInstance($model,'prospect_identity_document');
				$model->prospect_identity_document->saveAs($filePath.$model->prospect_identity_document->name);
				
				//save path to db column
				$inputs['prospect_identity_document'] = '/cmp/'.$filePath.$model->prospect_identity_document->name;
			}

			if($_FILES['Prospects']['error']['tax_license']==0)
			{
				//create folder
				Yii::$app->AccessMod->createDirectory('contents/prospects/'.$id.'/');
				
				//get the instance of uploaded file
				$filePath = 'contents/prospects/'.$id.'/tl'.date('ymdHis').'-';
				$model->tax_license = UploadedFile::getInstance($model,'tax_license');
				$model->tax_license->saveAs($filePath.$model->tax_license->name);
				
				//save path to db column
				$inputs['tax_license'] = '/cmp/'.$filePath.$model->tax_license->name;
			}
			
			$prospectMod = Yii::$app->ProspectMod;
			if(!($followup = $prospectMod->createProspectHistoryFollowUp($inputs['project_id'],(int)$id,$_SESSION['user']['id'],$inputs)))
			Yii::$app->session->set('errorMessage', $prospectMod->errorMessage);
			else
			Yii::$app->session->set('successMessage', 'Prospect follow up has been recorded.');
			
            return $this->redirect(['view', 'id' => $id]);
        } 
		else 
		{
            return $this->renderAjax('create-follow-up', [
                'model' => $model,
				'modelPH' => $modelPH,
            ]);
        }
    }

    public function actionCreateAppointmentScheduled($id)
    {
        $modelPH = new LogProspectHistory();

        if (count($_POST)!=0) 
		{
			$inputs = $_POST['LogProspectHistory'];
			
			$prospectMod = Yii::$app->ProspectMod;
			if(!($appoinment = $prospectMod->createProspectHistoryAppointmentSchedule($inputs['project_id'],(int)$id,$_SESSION['user']['id'],$inputs)))
			Yii::$app->session->set('errorMessage', $prospectMod->errorMessage);
			else
			Yii::$app->session->set('successMessage', 'Prospect appointment scheduled has been recorded.');
			
            return $this->redirect(['view', 'id' => $id]);
        } 
		else 
		{
            return $this->renderAjax('create-appointment-scheduled', [
                'modelPH' => $modelPH,
				'prospect_id' => $id,
            ]);
        }
    }

    public function actionCreateLevelInterest($id)
    {
        $modelPH = new LogProspectHistory();

        if (count($_POST)!=0) 
		{
			$inputs = $_POST['LogProspectHistory'];

			/*if($_FILES['LogProspectHistory']['error']['udf1']==0)
			{
				//create folder
				Yii::$app->AccessMod->createDirectory('contents/prospects/'.$id.'/');
				
				//get the instance of uploaded file
				$filePath = 'contents/prospects/'.$id.'/udf1'.date('ymdHis').'-';
				$modelPH->udf1 = UploadedFile::getInstance($modelPH,'udf1');
				$modelPH->udf1->saveAs($filePath.$modelPH->udf1->name);
				
				//save path to db column
				$inputs['udf1'] = '/cmp/'.$filePath.$modelPH->udf1->name;
			}*/
			
			$prospectMod = Yii::$app->ProspectMod;
			if(!($level = $prospectMod->createProspectHistoryLevelInterest($inputs['project_id'],(int)$id,$_SESSION['user']['id'],$inputs)))
			Yii::$app->session->set('errorMessage', $prospectMod->errorMessage);
			else
			Yii::$app->session->set('successMessage', 'Prospect level of interest has been recorded.');
						
            return $this->redirect(['view', 'id' => $id]);
        } 
		else 
		{
            return $this->renderAjax('create-level-interest', [
                'modelPH' => $modelPH,
				'prospect_id' => $id,
            ]);
        }
    }

    public function actionCreateEoi($id)
    {
        $model = $this->findModel($id);
        $modelPB = new ProspectBookings();
		$modelPBB[] = new ProspectBookingBuyers();
		
		if(!empty($_GET['project_id']))
		{
			echo json_encode(Yii::$app->GeneralMod->getProjectProductsByProjectID(array($_GET['project_id'])));
			exit();
		}


        if (count($_POST)!=0) 
		{
			$inputs = array_merge($_POST['ProspectBookings'],$_POST['ProspectBookingBuyers']);
			
			if(!empty($inputs['buyer_firstname'][0]) and !empty($inputs['buyer_lastname'][0]))
			{
				$i=0;
				foreach($inputs['buyer_firstname'] as $buyers)
				{
					$inputs['buyers'][$i]['buyer_firstname'] = $inputs['buyer_firstname'][$i];
					$inputs['buyers'][$i]['buyer_lastname'] = $inputs['buyer_lastname'][$i];
					$i++;
				}
			}
			
			if($_FILES['ProspectBookings']['error']['proof_of_payment_eoi']==0)
			{
				//create folder
				Yii::$app->AccessMod->createDirectory('contents/prospects/'.$id.'/');
				
				//get the instance of uploaded file
				$filePath = 'contents/prospects/'.$id.'/bookeoi'.date('ymdHis').'-';
				$modelPB->proof_of_payment_eoi = UploadedFile::getInstance($modelPB,'proof_of_payment_eoi');
				$modelPB->proof_of_payment_eoi->saveAs($filePath.$modelPB->proof_of_payment_eoi->name);
				
				//save path to db column
				$inputs['proof_of_payment_eoi'] = '/cmp/'.$filePath.$modelPB->proof_of_payment_eoi->name;
			}

			if($_FILES['Prospects']['error']['prospect_identity_document']==0)
			{
				//create folder
				Yii::$app->AccessMod->createDirectory('contents/prospects/'.$id.'/');
				
				//get the instance of uploaded file
				$filePath = 'contents/prospects/'.$id.'/id'.date('ymdHis').'-';
				$model->prospect_identity_document = UploadedFile::getInstance($model,'prospect_identity_document');
				$model->prospect_identity_document->saveAs($filePath.$model->prospect_identity_document->name);
				
				//save path to db column
				$inputs['prospect_identity_document'] = '/cmp/'.$filePath.$model->prospect_identity_document->name;
			}

			if($_FILES['Prospects']['error']['tax_license']==0)
			{
				//create folder
				Yii::$app->AccessMod->createDirectory('contents/prospects/'.$id.'/');
				
				//get the instance of uploaded file
				$filePath = 'contents/prospects/'.$id.'/tl'.date('ymdHis').'-';
				$model->tax_license = UploadedFile::getInstance($model,'tax_license');
				$model->tax_license->saveAs($filePath.$model->tax_license->name);
				
				//save path to db column
				$inputs['tax_license'] = '/cmp/'.$filePath.$model->tax_license->name;
			}

			$prospectMod = Yii::$app->ProspectMod;
			if(!($eoi = $prospectMod->createProspectEOI($inputs['project_id'],(int)$id,$_SESSION['user']['id'],$inputs)))
			Yii::$app->session->set('errorMessage', $prospectMod->errorMessage);
			else
			Yii::$app->session->set('successMessage', 'Prospect booking(EOI) has been recorded.');
			
		
            return $this->redirect(['view', 'id' => $id]);
        } 
		else 
		{
            return $this->renderAjax('create-eoi', [
                'model' => $model,
                'modelPB' => $modelPB,
                'modelPBB' => $modelPBB,
            ]);
        }
    }

    public function actionEditEoi()
    {
        $model = $this->findModel($_REQUEST['id']);
        $modelPB = ProspectBookings::findOne($_REQUEST['prospect_booking_id']);
		$modelPBB = ProspectBookingBuyers::find()->where(['prospect_booking_id'=>$modelPB->id])->all();
		
		if(!empty($_GET['project_id']))
		{
			echo json_encode(Yii::$app->GeneralMod->getProjectProductsByProjectID(array($_GET['project_id'])));
			exit();
		}

        if (count($_POST)!=0) 
		{
			$inputs = array_merge($_POST['Prospects'],$_POST['ProspectBookings'],$_POST['ProspectBookingBuyers']);
			$inputs['prospect_id'] = $_REQUEST['id'];
			$inputs['prospect_booking_id'] = $_REQUEST['prospect_booking_id'];

			if(!empty($inputs['buyer_firstname'][0]) and !empty($inputs['buyer_lastname'][0]))
			{
				$i=0;
				foreach($inputs['buyer_firstname'] as $buyers)
				{
					$inputs['buyers'][$i]['buyer_firstname'] = $inputs['buyer_firstname'][$i];
					$inputs['buyers'][$i]['buyer_lastname'] = $inputs['buyer_lastname'][$i];
					$i++;
				}
			}

			if($_FILES['ProspectBookings']['error']['proof_of_payment_eoi']==0)
			{
				//create folder
				Yii::$app->AccessMod->createDirectory('contents/prospects/'.$inputs['prospect_id'].'/');
				
				//get the instance of uploaded file
				$filePath = 'contents/prospects/'.$inputs['prospect_id'].'/bookeoi'.date('ymdHis').'-';
				$modelPB->proof_of_payment_eoi = UploadedFile::getInstance($modelPB,'proof_of_payment_eoi');
				$modelPB->proof_of_payment_eoi->saveAs($filePath.$modelPB->proof_of_payment_eoi->name);
				
				//save path to db column
				$inputs['proof_of_payment_eoi'] = '/cmp/'.$filePath.$modelPB->proof_of_payment_eoi->name;
			}

			if($_FILES['Prospects']['error']['prospect_identity_document']==0)
			{
				//create folder
				Yii::$app->AccessMod->createDirectory('contents/prospects/'.$inputs['prospect_id'].'/');
				
				//get the instance of uploaded file
				$filePath = 'contents/prospects/'.$inputs['prospect_id'].'/id'.date('ymdHis').'-';
				$model->prospect_identity_document = UploadedFile::getInstance($model,'prospect_identity_document');
				$model->prospect_identity_document->saveAs($filePath.$model->prospect_identity_document->name);
				
				//save path to db column
				$inputs['prospect_identity_document'] = '/cmp/'.$filePath.$model->prospect_identity_document->name;
			}

			if($_FILES['Prospects']['error']['tax_license']==0)
			{
				//create folder
				Yii::$app->AccessMod->createDirectory('contents/prospects/'.$inputs['prospect_id'].'/');
				
				//get the instance of uploaded file
				$filePath = 'contents/prospects/'.$inputs['prospect_id'].'/tl'.date('ymdHis').'-';
				$model->tax_license = UploadedFile::getInstance($model,'tax_license');
				$model->tax_license->saveAs($filePath.$model->tax_license->name);
				
				//save path to db column
				$inputs['tax_license'] = '/cmp/'.$filePath.$model->tax_license->name;
			}
			
			$prospectMod = Yii::$app->ProspectMod;
			if(!($eoi = $prospectMod->updateProspectEOI($inputs['project_id'],$_REQUEST['id'],$_REQUEST['prospect_booking_id'],$_SESSION['user']['id'],$inputs)))
			Yii::$app->session->set('errorMessage', $prospectMod->errorMessage);
			else
			Yii::$app->session->set('successMessage', 'Prospect booking(EOI) has been updated.');
			
            return $this->redirect(['view', 'id' => $_REQUEST['id']]);
        } 
		else 
		{
            return $this->renderAjax('update-eoi', [
                'model' => $model,
                'modelPB' => $modelPB,
		 		'modelPBB' => $modelPBB,
           ]);
        }
    }

    public function actionCreateBooking($id)
    {
		if(!empty($_GET['project_id']))
		{
			echo json_encode(Yii::$app->GeneralMod->getProjectProductsByProjectID(array($_GET['project_id'])));
			exit();
		}

		if(!empty($_GET['product_id']))
		{
			echo json_encode(Yii::$app->GeneralMod->getUnitTypesByProductID(array($_GET['product_id'])));
			exit();
		}

        $model = $this->findModel($id);
        $modelPB = new ProspectBookings();
		$modelPBB[] = new ProspectBookingBuyers();

        if (count($_POST)!=0) 
		{
			$inputs = array_merge($_POST['ProspectBookings'],$_POST['ProspectBookingBuyers']);
			$inputs['prospect_id'] = $_REQUEST['id'];

			if(!empty($inputs['buyer_firstname'][0]) and !empty($inputs['buyer_lastname'][0]))
			{
				$i=0;
				foreach($inputs['buyer_firstname'] as $buyers)
				{
					$inputs['buyers'][$i]['buyer_firstname'] = $inputs['buyer_firstname'][$i];
					$inputs['buyers'][$i]['buyer_lastname'] = $inputs['buyer_lastname'][$i];
					$i++;
				}
			}

			if($_FILES['ProspectBookings']['error']['proof_of_payment']==0)
			{
				//create folder
				Yii::$app->AccessMod->createDirectory('contents/prospects/'.$id.'/');
				
				//get the instance of uploaded file
				$filePath = 'contents/prospects/'.$id.'/book'.date('ymdHis').'-';
				$modelPB->proof_of_payment = UploadedFile::getInstance($modelPB,'proof_of_payment');
				$modelPB->proof_of_payment->saveAs($filePath.$modelPB->proof_of_payment->name);
				
				//save path to db column
				$inputs['proof_of_payment'] = '/cmp/'.$filePath.$modelPB->proof_of_payment->name;
			}

			if($_FILES['ProspectBookings']['error']['sp_file']==0)
			{
				//create folder
				Yii::$app->AccessMod->createDirectory('contents/prospects/'.$id.'/');
				
				//get the instance of uploaded file
				$filePath = 'contents/prospects/'.$id.'/sp'.date('ymdHis').'-';
				$modelPB->sp_file = UploadedFile::getInstance($modelPB,'sp_file');
				$modelPB->sp_file->saveAs($filePath.$modelPB->sp_file->name);
				
				//save path to db column
				$inputs['sp_file'] = '/cmp/'.$filePath.$modelPB->sp_file->name;
			}

			if($_FILES['Prospects']['error']['prospect_identity_document']==0)
			{
				//create folder
				Yii::$app->AccessMod->createDirectory('contents/prospects/'.$id.'/');
				
				//get the instance of uploaded file
				$filePath = 'contents/prospects/'.$id.'/id'.date('ymdHis').'-';
				$model->prospect_identity_document = UploadedFile::getInstance($model,'prospect_identity_document');
				$model->prospect_identity_document->saveAs($filePath.$model->prospect_identity_document->name);
				
				//save path to db column
				$inputs['prospect_identity_document'] = '/cmp/'.$filePath.$model->prospect_identity_document->name;
			}

			if($_FILES['Prospects']['error']['tax_license']==0)
			{
				//create folder
				Yii::$app->AccessMod->createDirectory('contents/prospects/'.$id.'/');
				
				//get the instance of uploaded file
				$filePath = 'contents/prospects/'.$id.'/tl'.date('ymdHis').'-';
				$model->tax_license = UploadedFile::getInstance($model,'tax_license');
				$model->tax_license->saveAs($filePath.$model->tax_license->name);
				
				//save path to db column
				$inputs['tax_license'] = '/cmp/'.$filePath.$model->tax_license->name;
			}
			
			$prospectMod = Yii::$app->ProspectMod;
			if(!($eoi = $prospectMod->createProspectBooking($inputs['project_id'],(int)$id,$_SESSION['user']['id'],$inputs)))
			Yii::$app->session->set('errorMessage', $prospectMod->errorMessage);
			else
			Yii::$app->session->set('successMessage', 'Prospect booking has been recorded.');
			
            return $this->redirect(['view', 'id' => $_REQUEST['id']]);
        } 
        else 
		{
            return $this->renderAjax('create-booking', [
                'model' => $model,
                'modelPB' => $modelPB,
		 		'modelPBB' => $modelPBB,
            ]);
        }
    }

    public function actionEoiBooking()
    {
		if(!empty($_GET['project_id']))
		{
			echo json_encode(Yii::$app->GeneralMod->getProjectProductsByProjectID(array($_GET['project_id'])));
			exit();
		}

		if(!empty($_GET['product_id']))
		{
			echo json_encode(Yii::$app->GeneralMod->getUnitTypesByProductID(array($_GET['product_id'])));
			exit();
		}

        $model = $this->findModel($_REQUEST['id']);
        $modelPB = ProspectBookings::findOne($_REQUEST['prospect_booking_id']);
		$modelPBB = ProspectBookingBuyers::find()->where(['prospect_booking_id'=>$modelPB->id])->all();

        if (count($_POST)!=0) 
		{
			
			$inputs = array_merge($_POST['Prospects'],$_POST['ProspectBookings'],$_POST['ProspectBookingBuyers']);
			$inputs['prospect_id'] = $_REQUEST['id'];
			$inputs['prospect_booking_id'] = $_REQUEST['prospect_booking_id'];

			if(!empty($inputs['buyer_firstname'][0]) and !empty($inputs['buyer_lastname'][0]))
			{
				$i=0;
				foreach($inputs['buyer_firstname'] as $buyers)
				{
					$inputs['buyers'][$i]['buyer_firstname'] = $inputs['buyer_firstname'][$i];
					$inputs['buyers'][$i]['buyer_lastname'] = $inputs['buyer_lastname'][$i];
					$i++;
				}
			}


			if($_FILES['ProspectBookings']['error']['proof_of_payment']==0)
			{
				//create folder
				Yii::$app->AccessMod->createDirectory('contents/prospects/'.$inputs['prospect_id'].'/');
				
				//get the instance of uploaded file
				$filePath = 'contents/prospects/'.$inputs['prospect_id'].'/book'.date('ymdHis').'-';
				$modelPB->proof_of_payment = UploadedFile::getInstance($modelPB,'proof_of_payment');
				$modelPB->proof_of_payment->saveAs($filePath.$modelPB->proof_of_payment->name);
				
				//save path to db column
				$inputs['proof_of_payment'] = '/cmp/'.$filePath.$modelPB->proof_of_payment->name;
			}

			if($_FILES['ProspectBookings']['error']['sp_file']==0)
			{
				//create folder
				Yii::$app->AccessMod->createDirectory('contents/prospects/'.$inputs['prospect_id'].'/');
				
				//get the instance of uploaded file
				$filePath = 'contents/prospects/'.$inputs['prospect_id'].'/sp'.date('ymdHis').'-';
				$modelPB->sp_file = UploadedFile::getInstance($modelPB,'sp_file');
				$modelPB->sp_file->saveAs($filePath.$modelPB->sp_file->name);
				
				//save path to db column
				$inputs['sp_file'] = '/cmp/'.$filePath.$modelPB->sp_file->name;
			}

			if($_FILES['Prospects']['error']['prospect_identity_document']==0)
			{
				//create folder
				Yii::$app->AccessMod->createDirectory('contents/prospects/'.$inputs['prospect_id'].'/');
				
				//get the instance of uploaded file
				$filePath = 'contents/prospects/'.$inputs['prospect_id'].'/id'.date('ymdHis').'-';
				$model->prospect_identity_document = UploadedFile::getInstance($model,'prospect_identity_document');
				$model->prospect_identity_document->saveAs($filePath.$model->prospect_identity_document->name);
				
				//save path to db column
				$inputs['prospect_identity_document'] = '/cmp/'.$filePath.$model->prospect_identity_document->name;
			}

			if($_FILES['Prospects']['error']['tax_license']==0)
			{
				//create folder
				Yii::$app->AccessMod->createDirectory('contents/prospects/'.$inputs['prospect_id'].'/');
				
				//get the instance of uploaded file
				$filePath = 'contents/prospects/'.$inputs['prospect_id'].'/tl'.date('ymdHis').'-';
				$model->tax_license = UploadedFile::getInstance($model,'tax_license');
				$model->tax_license->saveAs($filePath.$model->tax_license->name);
				
				//save path to db column
				$inputs['tax_license'] = '/cmp/'.$filePath.$model->tax_license->name;
			}
			
			$prospectMod = Yii::$app->ProspectMod;
			if(!($eoi = $prospectMod->prospectEOIBooking($inputs['project_id'],(int)$inputs['prospect_id'],$inputs['prospect_booking_id'],$_SESSION['user']['id'],$inputs)))
			Yii::$app->session->set('errorMessage', $prospectMod->errorMessage);
			else
			Yii::$app->session->set('successMessage', 'Prospect booking has been recorded.');
			
            return $this->redirect(['view', 'id' => $_REQUEST['id']]);
        } 
        else 
		{
            return $this->renderAjax('eoi-booking', [
                'model' => $model,
                'modelPB' => $modelPB,
		 		'modelPBB' => $modelPBB,
            ]);
        }
    }

    public function actionEditBooking()
    {
		if(!empty($_GET['project_id']))
		{
			echo json_encode(Yii::$app->GeneralMod->getProjectProductsByProjectID(array($_GET['project_id'])));
			exit();
		}

		if(!empty($_GET['product_id']))
		{
			echo json_encode(Yii::$app->GeneralMod->getUnitTypesByProductID(array($_GET['product_id'])));
			exit();
		}

        $model = $this->findModel($_REQUEST['id']);
        $modelPB = ProspectBookings::findOne($_REQUEST['prospect_booking_id']);
		$modelPBB = ProspectBookingBuyers::find()->where(['prospect_booking_id'=>$modelPB->id])->all();
		
        if (count($_POST)!=0) 
		{
			$inputs = array_merge($_POST['Prospects'],$_POST['ProspectBookings'],$_POST['ProspectBookingBuyers']);
			$inputs['prospect_id'] = $_REQUEST['id'];
			$inputs['prospect_booking_id'] = $_REQUEST['prospect_booking_id'];

			if(!empty($inputs['buyer_firstname'][0]) and !empty($inputs['buyer_lastname'][0]))
			{
				$i=0;
				foreach($inputs['buyer_firstname'] as $buyers)
				{
					$inputs['buyers'][$i]['buyer_firstname'] = $inputs['buyer_firstname'][$i];
					$inputs['buyers'][$i]['buyer_lastname'] = $inputs['buyer_lastname'][$i];
					$i++;
				}
			}

			if($_FILES['ProspectBookings']['error']['proof_of_payment']==0)
			{
				//create folder
				Yii::$app->AccessMod->createDirectory('contents/prospects/'.$inputs['prospect_id'].'/');
				
				//get the instance of uploaded file
				$filePath = 'contents/prospects/'.$inputs['prospect_id'].'/bookeoi'.date('ymdHis').'-';
				$modelPB->proof_of_payment = UploadedFile::getInstance($modelPB,'proof_of_payment');
				$modelPB->proof_of_payment->saveAs($filePath.$modelPB->proof_of_payment->name);
				
				//save path to db column
				$inputs['proof_of_payment'] = '/cmp/'.$filePath.$modelPB->proof_of_payment->name;
			}

			if($_FILES['ProspectBookings']['error']['sp_file']==0)
			{
				//create folder
				Yii::$app->AccessMod->createDirectory('contents/prospects/'.$inputs['prospect_id'].'/');
				
				//get the instance of uploaded file
				$filePath = 'contents/prospects/'.$inputs['prospect_id'].'/sp'.date('ymdHis').'-';
				$modelPB->sp_file = UploadedFile::getInstance($modelPB,'sp_file');
				$modelPB->sp_file->saveAs($filePath.$modelPB->sp_file->name);
				
				//save path to db column
				$inputs['sp_file'] = '/cmp/'.$filePath.$modelPB->sp_file->name;
			}

			if($_FILES['Prospects']['error']['prospect_identity_document']==0)
			{
				//create folder
				Yii::$app->AccessMod->createDirectory('contents/prospects/'.$inputs['prospect_id'].'/');
				
				//get the instance of uploaded file
				$filePath = 'contents/prospects/'.$inputs['prospect_id'].'/id'.date('ymdHis').'-';
				$model->prospect_identity_document = UploadedFile::getInstance($model,'prospect_identity_document');
				$model->prospect_identity_document->saveAs($filePath.$model->prospect_identity_document->name);
				
				//save path to db column
				$inputs['prospect_identity_document'] = '/cmp/'.$filePath.$model->prospect_identity_document->name;
			}

			if($_FILES['Prospects']['error']['tax_license']==0)
			{
				//create folder
				Yii::$app->AccessMod->createDirectory('contents/prospects/'.$inputs['prospect_id'].'/');
				
				//get the instance of uploaded file
				$filePath = 'contents/prospects/'.$inputs['prospect_id'].'/tl'.date('ymdHis').'-';
				$model->tax_license = UploadedFile::getInstance($model,'tax_license');
				$model->tax_license->saveAs($filePath.$model->tax_license->name);
				
				//save path to db column
				$inputs['tax_license'] = '/cmp/'.$filePath.$model->tax_license->name;
			}
			
			$prospectMod = Yii::$app->ProspectMod;
			if(!($eoi = $prospectMod->updateProspectBooking($inputs['project_id'],$_REQUEST['id'],$_REQUEST['prospect_booking_id'],$_SESSION['user']['id'],$inputs)))
			Yii::$app->session->set('errorMessage', $prospectMod->errorMessage);
			else
			Yii::$app->session->set('successMessage', 'Prospect booking has been updated.');
			
            return $this->redirect(['view', 'id' => $_REQUEST['id']]);
        } 
		else 
		{
            return $this->renderAjax('update-booking', [
                'model' => $model,
                'modelPB' => $modelPB,
		 		'modelPBB' => $modelPBB,
            ]);
        }
    }

    public function actionEditFullBooking()
    {
		if(!empty($_GET['project_id']))
		{
			echo json_encode(Yii::$app->GeneralMod->getProjectProductsByProjectID(array($_GET['project_id'])));
			exit();
		}

		if(!empty($_GET['product_id']))
		{
			echo json_encode(Yii::$app->GeneralMod->getUnitTypesByProductID(array($_GET['product_id'])));
			exit();
		}

        $model = $this->findModel($_REQUEST['id']);
        $modelPB = ProspectBookings::findOne($_REQUEST['prospect_booking_id']);
		$modelPBB = ProspectBookingBuyers::find()->where(['prospect_booking_id'=>$modelPB->id])->all();
		
        if (count($_POST)!=0) 
		{
			$inputs = array_merge($_POST['Prospects'],$_POST['ProspectBookings'],$_POST['ProspectBookingBuyers']);
			$inputs['prospect_id'] = $_REQUEST['id'];
			$inputs['prospect_booking_id'] = $_REQUEST['prospect_booking_id'];

			if(!empty($inputs['buyer_firstname'][0]) and !empty($inputs['buyer_lastname'][0]))
			{
				$i=0;
				foreach($inputs['buyer_firstname'] as $buyers)
				{
					$inputs['buyers'][$i]['buyer_firstname'] = $inputs['buyer_firstname'][$i];
					$inputs['buyers'][$i]['buyer_lastname'] = $inputs['buyer_lastname'][$i];
					$i++;
				}
			}

			if($_FILES['ProspectBookings']['error']['proof_of_payment_eoi']==0)
			{
				//create folder
				Yii::$app->AccessMod->createDirectory('contents/prospects/'.$id.'/');
				
				//get the instance of uploaded file
				$filePath = 'contents/prospects/'.$id.'/bookeoi'.date('ymdHis').'-';
				$modelPB->proof_of_payment_eoi = UploadedFile::getInstance($modelPB,'proof_of_payment_eoi');
				$modelPB->proof_of_payment_eoi->saveAs($filePath.$modelPB->proof_of_payment_eoi->name);
				
				//save path to db column
				$inputs['proof_of_payment_eoi'] = '/cmp/'.$filePath.$modelPB->proof_of_payment_eoi->name;
			}

			if($_FILES['ProspectBookings']['error']['proof_of_payment']==0)
			{
				//create folder
				Yii::$app->AccessMod->createDirectory('contents/prospects/'.$inputs['prospect_id'].'/');
				
				//get the instance of uploaded file
				$filePath = 'contents/prospects/'.$inputs['prospect_id'].'/bookeoi'.date('ymdHis').'-';
				$modelPB->proof_of_payment = UploadedFile::getInstance($modelPB,'proof_of_payment');
				$modelPB->proof_of_payment->saveAs($filePath.$modelPB->proof_of_payment->name);
				
				//save path to db column
				$inputs['proof_of_payment'] = '/cmp/'.$filePath.$modelPB->proof_of_payment->name;
			}

			if($_FILES['ProspectBookings']['error']['sp_file']==0)
			{
				//create folder
				Yii::$app->AccessMod->createDirectory('contents/prospects/'.$inputs['prospect_id'].'/');
				
				//get the instance of uploaded file
				$filePath = 'contents/prospects/'.$inputs['prospect_id'].'/sp'.date('ymdHis').'-';
				$modelPB->sp_file = UploadedFile::getInstance($modelPB,'sp_file');
				$modelPB->sp_file->saveAs($filePath.$modelPB->sp_file->name);
				
				//save path to db column
				$inputs['sp_file'] = '/cmp/'.$filePath.$modelPB->sp_file->name;
			}

			if($_FILES['ProspectBookings']['error']['ppjb_file']==0)
			{
				//create folder
				Yii::$app->AccessMod->createDirectory('contents/prospects/'.$inputs['prospect_id'].'/');
				
				//get the instance of uploaded file
				$filePath = 'contents/prospects/'.$inputs['prospect_id'].'/ppjb'.date('ymdHis').'-';
				$modelPB->ppjb_file = UploadedFile::getInstance($modelPB,'ppjb_file');
				$modelPB->ppjb_file->saveAs($filePath.$modelPB->ppjb_file->name);
				
				//save path to db column
				$inputs['ppjb_file'] = '/cmp/'.$filePath.$modelPB->ppjb_file->name;
			}

			if($_FILES['Prospects']['error']['prospect_identity_document']==0)
			{
				//create folder
				Yii::$app->AccessMod->createDirectory('contents/prospects/'.$inputs['prospect_id'].'/');
				
				//get the instance of uploaded file
				$filePath = 'contents/prospects/'.$inputs['prospect_id'].'/id'.date('ymdHis').'-';
				$model->prospect_identity_document = UploadedFile::getInstance($model,'prospect_identity_document');
				$model->prospect_identity_document->saveAs($filePath.$model->prospect_identity_document->name);
				
				//save path to db column
				$inputs['prospect_identity_document'] = '/cmp/'.$filePath.$model->prospect_identity_document->name;
			}

			if($_FILES['Prospects']['error']['tax_license']==0)
			{
				//create folder
				Yii::$app->AccessMod->createDirectory('contents/prospects/'.$inputs['prospect_id'].'/');
				
				//get the instance of uploaded file
				$filePath = 'contents/prospects/'.$inputs['prospect_id'].'/tl'.date('ymdHis').'-';
				$model->tax_license = UploadedFile::getInstance($model,'tax_license');
				$model->tax_license->saveAs($filePath.$model->tax_license->name);
				
				//save path to db column
				$inputs['tax_license'] = '/cmp/'.$filePath.$model->tax_license->name;
			}
			
			$prospectMod = Yii::$app->ProspectMod;
			if(!($eoi = $prospectMod->updateProspectFullBooking($inputs['project_id'],$_REQUEST['id'],$_REQUEST['prospect_booking_id'],$_SESSION['user']['id'],$inputs)))
			Yii::$app->session->set('errorMessage', $prospectMod->errorMessage);
			else
			Yii::$app->session->set('successMessage', 'Prospect booking has been updated.');
			
            return $this->redirect(['view-admin', 'id' => $_REQUEST['id']]);
        } 
		else 
		{
            return $this->renderAjax('update-full-booking', [
                'model' => $model,
                'modelPB' => $modelPB,
		 		'modelPBB' => $modelPBB,
            ]);
        }
    }

    public function actionUpdateContractSigned()
	{
        $model = $this->findModel($_REQUEST['id']);
        $modelPB = ProspectBookings::findOne($_REQUEST['prospect_booking_id']);
		$modelPBB = ProspectBookingBuyers::find()->where(['prospect_booking_id'=>$modelPB->id])->all();
		
        if (count($_POST)!=0) 
		{
			$inputs = $_POST['ProspectBookings'];
			$inputs['prospect_id'] = $_REQUEST['id'];
			$inputs['prospect_booking_id'] = $_REQUEST['prospect_booking_id'];

			if($_FILES['ProspectBookings']['error']['ppjb_file']==0)
			{
				//create folder
				Yii::$app->AccessMod->createDirectory('contents/prospects/'.$inputs['prospect_id'].'/');
				
				//get the instance of uploaded file
				$filePath = 'contents/prospects/'.$inputs['prospect_id'].'/ppjb'.date('ymdHis').'-';
				$modelPB->ppjb_file = UploadedFile::getInstance($modelPB,'ppjb_file');
				$modelPB->ppjb_file->saveAs($filePath.$modelPB->ppjb_file->name);
				
				//save path to db column
				$inputs['ppjb_file'] = '/cmp/'.$filePath.$modelPB->ppjb_file->name;
			}

			$prospectMod = Yii::$app->ProspectMod;
			if(!($eoi = $prospectMod->prospectContractSigned((int)$inputs['prospect_id'],$inputs['prospect_booking_id'],$_SESSION['user']['id'],$inputs)))
			Yii::$app->session->set('errorMessage', $prospectMod->errorMessage);
			else
			Yii::$app->session->set('successMessage', 'Prospect Contract Signed has been recorded.');
			
            return $this->redirect(['view', 'id' => $_REQUEST['id']]);
        } 
        else 
		{
            return $this->renderAjax('update-contract-signed', [
                'model' => $model,
                'modelPB' => $modelPB,
		 		'modelPBB' => $modelPBB,
            ]);
        }
	}


    public function actionEditContractSigned()
    {
        $model = $this->findModel($_REQUEST['id']);
        $modelPB = ProspectBookings::findOne($_REQUEST['prospect_booking_id']);
		$modelPBB = ProspectBookingBuyers::find()->where(['prospect_booking_id'=>$modelPB->id])->all();
		
		if(!empty($_GET['project_id']))
		{
			echo json_encode(Yii::$app->GeneralMod->getProjectProductsByProjectID(array($_GET['project_id'])));
			exit();
		}

        if (count($_POST)!=0) 
		{
			$inputs = $_POST['ProspectBookings'];
			$inputs['prospect_id'] = $_REQUEST['id'];
			$inputs['prospect_booking_id'] = $_REQUEST['prospect_booking_id'];

			if($_FILES['ProspectBookings']['error']['ppjb_file']==0)
			{
				//create folder
				Yii::$app->AccessMod->createDirectory('contents/prospects/'.$inputs['prospect_id'].'/');
				
				//get the instance of uploaded file
				$filePath = 'contents/prospects/'.$inputs['prospect_id'].'/ppjb'.date('ymdHis').'-';
				$modelPB->ppjb_file = UploadedFile::getInstance($modelPB,'ppjb_file');
				$modelPB->ppjb_file->saveAs($filePath.$modelPB->ppjb_file->name);
				
				//save path to db column
				$inputs['ppjb_file'] = '/cmp/'.$filePath.$modelPB->ppjb_file->name;
			}

			$prospectMod = Yii::$app->ProspectMod;
			if(!($eoi = $prospectMod->updateProspectContractSigned((int)$inputs['prospect_id'],$inputs['prospect_booking_id'],$_SESSION['user']['id'],$inputs)))
			Yii::$app->session->set('errorMessage', $prospectMod->errorMessage);
			else
			Yii::$app->session->set('successMessage', 'Prospect Contract Signed has been recorded.');
			
            return $this->redirect(['view', 'id' => $_REQUEST['id']]);
        } 
		else 
		{
            return $this->renderAjax('update-contract-signed', [
                'model' => $model,
                'modelPB' => $modelPB,
		 		'modelPBB' => $modelPBB,
            ]);
        }
    }

    public function actionShareProspect($id)
    {
        $model = $this->findModel($id);
        $modelPB = new ProspectBookings();

        if(count($_POST)!=0) 
		{
			$projects = json_decode($_POST['ProspectBookings']['project_id']);
			
			$prospectMod = Yii::$app->ProspectMod;
			if(!($share = $prospectMod->shareProspect($id,$_SESSION['user']['id'],$projects)))
			Yii::$app->session->set('errorMessage', $prospectMod->errorMessage);
			else
			Yii::$app->session->set('successMessage', 'Prospect project interest has been changed.');

			$action = empty($_REQUEST['action'])?'view':$_REQUEST['action'];
            return $this->redirect([$action, 'id' => $model->id]);
        } else {
            return $this->renderAjax('share-prospect', [
                'model' => $model,
                'modelPB' => $modelPB,
            ]);
        }
    }

    public function actionCancelBooking($id)
    {
        $model = $this->findModel($id);
        $modelPB = ProspectBookings::findOne($_REQUEST['prospect_booking_id']);
		$modelPBB = ProspectBookingBuyers::find()->where(['prospect_booking_id'=>$modelPB->id])->all();

        if(count($_POST)!=0) 
		{
			$inputs = $_POST['ProspectBookings'];
			$inputs['prospect_id'] = $modelPB->prospect_id;
			
			if($_FILES['ProspectBookings']['error']['cancellation_attachment']==0)
			{
				//create folder
				Yii::$app->AccessMod->createDirectory('contents/prospects/'.$inputs['prospect_id'].'/');
				
				//get the instance of uploaded file
				$filePath = 'contents/prospects/'.$inputs['prospect_id'].'/ca'.date('ymdHis').'-';
				$modelPB->cancellation_attachment = UploadedFile::getInstance($modelPB,'cancellation_attachment');
				$modelPB->cancellation_attachment->saveAs($filePath.$modelPB->cancellation_attachment->name);
				
				//save path to db column
				$inputs['cancellation_attachment'] = '/cmp/'.$filePath.$modelPB->cancellation_attachment->name;
			}
			
			$prospectMod = Yii::$app->ProspectMod;
			if(!($share = $prospectMod->cancelBooking($modelPB->prospect_id,$modelPB->id,$_SESSION['user']['id'],$inputs)))
			Yii::$app->session->set('errorMessage', $prospectMod->errorMessage);
			else
			Yii::$app->session->set('successMessage', 'Prospect booking has been cancelled.');

			$action = empty($_REQUEST['action'])?'view':$_REQUEST['action'];
            return $this->redirect([$action, 'id' => $model->id]);
        } else {
            return $this->renderAjax('cancel-booking', [
                'model' => $model,
                'modelPB' => $modelPB,
                'modelPBB' => $modelPBB,
            ]);
        }
    }

    public function actionCancelBookingFull($id)
    {
        $model = $this->findModel($id);
        $modelPB = ProspectBookings::findOne($_REQUEST['prospect_booking_id']);
		$modelPBB = ProspectBookingBuyers::find()->where(['prospect_booking_id'=>$modelPB->id])->all();

        if(count($_POST)!=0) 
		{
			$inputs = $_POST['ProspectBookings'];
			$inputs['prospect_id'] = $modelPB->prospect_id;
			
			if($_FILES['ProspectBookings']['error']['cancellation_attachment']==0)
			{
				//create folder
				Yii::$app->AccessMod->createDirectory('contents/prospects/'.$inputs['prospect_id'].'/');
				
				//get the instance of uploaded file
				$filePath = 'contents/prospects/'.$inputs['prospect_id'].'/ca'.date('ymdHis').'-';
				$modelPB->cancellation_attachment = UploadedFile::getInstance($modelPB,'cancellation_attachment');
				$modelPB->cancellation_attachment->saveAs($filePath.$modelPB->cancellation_attachment->name);
				
				//save path to db column
				$inputs['cancellation_attachment'] = '/cmp/'.$filePath.$modelPB->cancellation_attachment->name;
			}
			
			$prospectMod = Yii::$app->ProspectMod;
			if(!($share = $prospectMod->cancelBookingFull($modelPB->prospect_id,$modelPB->id,$_SESSION['user']['id'],$inputs)))
			Yii::$app->session->set('errorMessage', $prospectMod->errorMessage);
			else
			Yii::$app->session->set('successMessage', 'Prospect booking has been cancelled.');

			$action = empty($_REQUEST['action'])?'view-admin':$_REQUEST['action'];
            return $this->redirect([$action, 'id' => $model->id]);
        } else {
            return $this->renderAjax('cancel-booking-full', [
                'model' => $model,
                'modelPB' => $modelPB,
                'modelPBB' => $modelPBB,
            ]);
        }
    }

    /**
     * Deletes an existing Prospects model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
		$model->deletedby = $_SESSION['user']['id'];
		$model->deletedat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
		$model->save();
		
		return $this->redirect(['/prospects']);
    }

    public function actionFileIdentityDocumentDelete()
    {
		$alert = 'Success';

		$model = $this->findModel($_REQUEST['key']);
		$model->prospect_identity_document = null;
		$model->save();

		if(count($model->errors)!=0)
		$alert = 'Failed';

		echo json_encode($alert);
    }

    public function actionFileTaxLicenseDelete()
    {
		$alert = 'Success';

		$model = $this->findModel($_REQUEST['key']);
		$model->tax_license = null;
		$model->save();

		if(count($model->errors)!=0)
		$alert = 'Failed';

		echo json_encode($alert);
    }

    public function actionFileUdf1Delete()
    {
		$alert = 'Success';

		$model = LogProspectHistory::findOne($_REQUEST['key']);
		$model->udf1 = null;
		$model->save();

		if(count($model->errors)!=0)
		$alert = 'Failed';

		echo json_encode($alert);
    }

    public function actionFileEoiDelete()
    {
		$alert = 'Success';

		$model = ProspectBookings::findOne($_REQUEST['key']);
		$model->proof_of_payment_eoi = null;
		$model->save();

		if(count($model->errors)!=0)
		$alert = 'Failed';

		echo json_encode($alert);
    }

    public function actionFileBookingDelete()
    {
		$alert = 'Success';

		$model = ProspectBookings::findOne($_REQUEST['key']);
		$model->proof_of_payment = null;
		$model->save();

		if(count($model->errors)!=0)
		$alert = 'Failed';

		echo json_encode($alert);
    }

    public function actionFileSpDelete()
    {
		$alert = 'Success';

		$model = ProspectBookings::findOne($_REQUEST['key']);
		$model->sp_file = null;
		$model->save();

		if(count($model->errors)!=0)
		$alert = 'Failed';

		echo json_encode($alert);
    }

    public function actionFilePpjbDelete()
    {
		$alert = 'Success';

		$model = ProspectBookings::findOne($_REQUEST['key']);
		$model->ppjb_file = null;
		$model->save();

		if(count($model->errors)!=0)
		$alert = 'Failed';

		echo json_encode($alert);
    }

	public function actionDropInterest($id)
	{
        $model = $this->findModel($id);
        $modelPH = new LogProspectHistory();

        if (count($_POST)!=0) 
		{
			$inputs = array_merge($_POST['LogProspectHistory']);
			
			$prospectMod = Yii::$app->ProspectMod;
			if(!($eoi = $prospectMod->prospectDropInterest($inputs['project_id'],$model->id,$_SESSION['user']['id'],$inputs)))
			Yii::$app->session->set('errorMessage', $prospectMod->errorMessage);
			else
			Yii::$app->session->set('successMessage', 'Prospect drop interest has been recorded.');
			
            return $this->redirect(['view', 'id' => $_REQUEST['id']]);
        } 
        else 
		{
            return $this->renderAjax('drop-interest', [
                'model' => $model,
                'modelPH' => $modelPH,
            ]);
        }
	}

    /**
     * Finds the Prospects model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Prospects the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Prospects::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
