<?php

namespace app\controllers;

use Yii;
use app\models\UserCommissions;
use app\models\UserCommissionsSearch;
use app\models\LookupUserCommissionStatus;
use app\models\ProspectBookings;
use app\models\UserEligibleCommissions;

use app\models\LogUserCommission;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\base\ErrorException;
use yii\filters\VerbFilter;
use yii\helpers\Html;

/**
 * UserCommissionsController implements the CRUD actions for UserCommissions model.
 */
class AccountManagerCommissionsController extends Controller
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
        $searchModel = new UserCommissionsSearch(['userGroup'=>array(7,8,9,10)]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		
		//get user commission status
		$lookupUserCommissionStatus = LookupUserCommissionStatus::find()->where(array('deleted'=>0))->asArray()->all();
		
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'lookupUserCommissionStatus' => $lookupUserCommissionStatus,
        ]);
    }

    public function actionView($id)
    {
		$model = $this->findModel($id);
		$modelUserEligibleCommissions = new UserEligibleCommissions();
		$modelLogUserCommission = new LogUserCommission();
		
		$logUserCommissions = $modelLogUserCommission->getLogUserCommissions($model->user_id,'',1);
		if($logUserCommissions)
		{
			foreach($logUserCommissions as $key=>$value)
			{
				//check eligible commission
				//$tmpUserEligibleCommissionGiven = $modelLogUserCommission->getTotalEligibleCommissionGiven($value['user_id'],$value['prospect_booking_id']);
				$tmpUserEligibleCommissionGiven = 0;
				$tmpUserEligibleCommissions = UserEligibleCommissions::find()->where(array('user_commission_id'=>$value['user_commission_id'],'prospect_booking_id'=>$value['prospect_booking_id'],'user_id'=>$value['user_id'],'status'=>0,'deletedby'=>NULL,'deletedat'=>NULL))->asArray()->all();
				if(count($tmpUserEligibleCommissions)!=0)
				{
					foreach($tmpUserEligibleCommissions as $tmpUserEligibleCommission)
					{
						$tmpUserEligibleCommissionGiven = $tmpUserEligibleCommissionGiven+$tmpUserEligibleCommission['commission_eligible_amount'];
					}
				}
				
				//check commission paid
				$tmpTotalCommissionPaid = $modelLogUserCommission->getTotalCommissionPaid($value['user_id'],$value['prospect_booking_id']);
							
				$logUserCommissions[$key]['commission_amount'] = $value['commission_amount']-($tmpUserEligibleCommissionGiven+$tmpTotalCommissionPaid);
				$logUserCommissions[$key]['eligible_commission_amount'] = $tmpUserEligibleCommissionGiven;
				$logUserCommissions[$key]['paid_commission_amount'] = $tmpTotalCommissionPaid;
				
				if($tmpUserEligibleCommissionGiven!=0 and $value['commission_amount']!=$tmpTotalCommissionPaid)
				$logUserCommissions[$key]['status'] = 2;
				if($value['commission_amount']==$tmpTotalCommissionPaid)
				$logUserCommissions[$key]['status'] = 4;
				
				//check cancel commission
				$logUserCommissionCancel = LogUserCommission::find()->where(array('prospect_id'=>$value['prospect_id'],'prospect_booking_id'=>$value['prospect_booking_id'],'user_commission_id'=>$value['user_commission_id'],'status'=>3))->asArray()->all();
				if(count($logUserCommissionCancel)!=0)
				$logUserCommissions[$key]['status'] = 3;
			}
		}
		
		//get user eligible commission
		$userEligibleCommissionAmount = 0;
		$userEligibleCommissions = UserEligibleCommissions::find()->where(array('user_commission_id'=>$model->id,'user_id'=>$model->user_id,'status'=>0,'deletedby'=>NULL,'deletedat'=>NULL))->asArray()->all();
		if(count($userEligibleCommissions)!=0)
		{
			foreach($userEligibleCommissions as $userEligibleCommission)
			{
				$userEligibleCommissionAmount = $userEligibleCommissionAmount+$userEligibleCommission['commission_eligible_amount'];
			}
		}
		
		//get total eligible commission paid
		$totalUserEligibleCommissionPaid = $modelUserEligibleCommissions->getTotalUserEligibleCommissionsPaid($model->id,$model->user_id);
		
		/*echo '<pre>';
		//print_r($model->getAttributes());
		print_r($logUserCommissions);
		//print_r($userEligibleCommissionAmount);
		//print_r($totalUserEligibleCommissionPaid);
		echo '</pre>';
		exit();*/
		
        return $this->render('view', [
            'model' => $model,
            'logUserCommissions' => $logUserCommissions,
            'userEligibleCommissionAmount' => $userEligibleCommissionAmount,
            'totalUserEligibleCommissionPaid' => $totalUserEligibleCommissionPaid,
        ]);
    }
	
    public function actionViewCommissionTransaction($id,$prospect_booking_id)
    {
		$model = $this->findModel($id);
		$modelProspectBookings = ProspectBookings::findOne($prospect_booking_id);
		$modelUserEligibleCommissions = new UserEligibleCommissions();
		$modelLogUserCommission = new LogUserCommission();
		
		$logUserCommissions = $modelLogUserCommission->getLogUserCommissions($model->user_id,$modelProspectBookings->id,2);
		if(!$logUserCommissions)
		$logUserCommissions = array();
		else
		{
			foreach($logUserCommissions as $key=>$value)
			{
				if($value['status']==2)
				{
					//check eligible commission payment
					$userEligibleCommission = UserEligibleCommissions::find()->where(array('id'=>$value['user_eligible_commission_id']))->one();
					if($userEligibleCommission->deletedby!=NULL and $userEligibleCommission->deletedat!=NULL)
					{
						$logUserCommissions[$key]['status'] = 3;
						$logCancelElgibible = LogUserCommission::find()->where(array('user_eligible_commission_id'=>$value['user_eligible_commission_id'],'status'=>3))->one();
						if($logCancelElgibible!=NULL)
						{
							$logUserCommissions[$key]['createdbyName'] = Yii::$app->AccessMod->getName($logCancelElgibible->createdby);
							$logUserCommissions[$key]['createdat'] = $logCancelElgibible->createdat;
						}
					}
					elseif($userEligibleCommission->status==1)
					{
						$logUserCommissions[$key]['paid'] = $userEligibleCommission->status;
						$logUserCommissions[$key]['status'] = 4;
						$logClaimedElgibible = LogUserCommission::find()->where(array('user_eligible_commission_id'=>$value['user_eligible_commission_id'],'status'=>4))->one();
						if($logClaimedElgibible!=NULL)
						{
							$logUserCommissions[$key]['createdbyName'] = Yii::$app->AccessMod->getName($logClaimedElgibible->createdby);
							$logUserCommissions[$key]['createdat'] = $logClaimedElgibible->createdat;
						}
					}
					else
					$logUserCommissions[$key]['paid'] = $userEligibleCommission->status;
				}
			}
		}
		
		/*echo '<pre>';
		print_r($logUserCommissions);
		echo '</pre>';
		exit();*/
		
		$estimateCommission = LogUserCommission::find()
									->select('commission_amount')
									->where(array(
										'user_commission_id'=>$model->id,
										'user_id'=>$model->user_id,
										'prospect_booking_id'=>$prospect_booking_id,
										'status'=>1
										)
									)
									->asArray()
									->one();
		
		//get user eligible commission
		$userEligibleCommissionAmount = 0;
		$userEligibleCommissions = UserEligibleCommissions::find()->where(array('user_commission_id'=>$model->id,'prospect_booking_id'=>$modelProspectBookings->id,'user_id'=>$model->user_id,'status'=>0,'deletedby'=>NULL,'deletedat'=>NULL))->asArray()->all();
		if(count($userEligibleCommissions)!=0)
		{
			foreach($userEligibleCommissions as $userEligibleCommission)
			{
				$userEligibleCommissionAmount = $userEligibleCommissionAmount+$userEligibleCommission['commission_eligible_amount'];
			}
		}
		
		//get user eligible commission
		$totalCommissionPaid = $modelLogUserCommission->getTotalCommissionPaid($model->user_id,$prospect_booking_id);
				
		/*echo '<pre>';
		print_r($logUserCommissions);
		print_r($userEligibleCommissionAmount);
		print_r($totalCommissionPaid);
		echo '</pre>';
		exit();*/
		
        return $this->renderAjax('view-commission-transaction', [
            'model' => $model,
            'modelProspectBookings' => $modelProspectBookings,
            'logUserCommissions' => $logUserCommissions,
            'estimateCommission' => $estimateCommission,
            'userEligibleCommissionAmount' => $userEligibleCommissionAmount,
            'totalCommissionPaid' => $totalCommissionPaid,
        ]);
    }

    public function actionEligibleCommission($id,$prospect_booking_id)
    {
		$modelUserCommissions = new UserCommissions();
		$modelLogUserCommission = new LogUserCommission();
		$modelProspectBookings = ProspectBookings::findOne($prospect_booking_id);
		$modelUserEligibleCommissions = new UserEligibleCommissions();
		
		$modelUserCommissions = $this->findModel($id);
		$logUserCommission = LogUserCommission::find()
									->where(array(
										'user_commission_id'=>$modelUserCommissions->id,
										'user_id'=>$modelUserCommissions->user_id,
										'prospect_booking_id'=>$prospect_booking_id,
										'status'=>1,
										)
									)
									->asArray()
									->one();
		
		//get user eligible commission
		$totalEligibleCommissionAmount = 0;
		$eligibleCommissions = UserEligibleCommissions::find()->where(array('user_commission_id'=>$modelUserCommissions->id,'prospect_booking_id'=>$modelProspectBookings->id,'user_id'=>$modelUserCommissions->user_id,'status'=>0,'deletedby'=>NULL,'deletedat'=>NULL))->asArray()->all();
		if(count($eligibleCommissions)!=0)
		{
			foreach($eligibleCommissions as $eligibleCommission)
			{
				$totalEligibleCommissionAmount = $totalEligibleCommissionAmount+$eligibleCommission['commission_eligible_amount'];
			}
		}
		
		$totalCommissionPaid = $modelLogUserCommission->getTotalCommissionPaid($modelUserCommissions->user_id,$prospect_booking_id);
		
		/*echo '<pre>';
		print_r($modelUserCommissions->getAttributes());
		print_r($logUserCommission);
		print_r($totalCommissionPaid);
		echo '</pre>';
		exit();*/
		
		if(count($_POST)!=0)
		{
			/*echo '<pre>';
			print_r($_POST);
			echo '</pre>';
			exit();*/
			
			if(count($_POST)!=0)
			{
				$error = '';
				$connection = Yii::$app->db;
				$transaction = $connection->beginTransaction();
				try 
				{
					$modelLogUserCommission->load(Yii::$app->request->post());

					//update user commissions
					$modelUserCommissions->status = 3;
					$modelUserCommissions->updatedby = $_SESSION['user']['id'];
					$modelUserCommissions->updatedat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
					$modelUserCommissions->save();
					if(count($modelUserCommissions->errors)!=0)
					throw new ErrorException("Update user commission status failed.");
					
					//create user eligible commissions
					$modelUserEligibleCommissions = new UserEligibleCommissions();
					$modelUserEligibleCommissions->user_commission_id = $modelUserCommissions->id;
					$modelUserEligibleCommissions->prospect_booking_id = $modelProspectBookings->id;
					$modelUserEligibleCommissions->user_id = $modelUserCommissions->user_id;
					$modelUserEligibleCommissions->commission_eligible_amount = $modelLogUserCommission->commission_amount;
					$modelUserEligibleCommissions->status = 0;
					$modelUserEligibleCommissions->createdby = $_SESSION['user']['id'];
					$modelUserEligibleCommissions->createdat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
					$modelUserEligibleCommissions->save();
					if(count($modelUserEligibleCommissions->errors)!=0)
					throw new ErrorException("Create user eligible commission failed.");
					
					//create log user commission
					$modelLogUserCommission->load(Yii::$app->request->post());
					$modelLogUserCommission->prospect_id = $modelProspectBookings->prospect_id;
					$modelLogUserCommission->prospect_booking_id = $modelProspectBookings->id;
					$modelLogUserCommission->user_eligible_commission_id = $modelUserEligibleCommissions->id;
					$modelLogUserCommission->user_id = $modelUserCommissions->user_id;
					$modelLogUserCommission->status = 2;
					$modelLogUserCommission->createdby = $_SESSION['user']['id'];
					$modelLogUserCommission->createdat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
					$modelLogUserCommission->save();
					if(count($modelLogUserCommission->errors)!=0)
					throw new ErrorException("Create log user commission failed.");
										
					$transaction->commit();
				}
				catch (ErrorException $e) 
				{
					$transaction->rollBack();
					$error = $e->getMessage();
					Yii::$app->session->set('errorMessage', $error);
				}
										
				return $this->redirect(['view', 'id' => $modelUserCommissions->id]);
			}
			
		}
		
        return $this->renderAjax('eligible-commission', [
            'modelUserEligibleCommissions' => $modelUserEligibleCommissions,
            'modelLogUserCommission' => $modelLogUserCommission,
            'modelProspectBookings' => $modelProspectBookings,
            'modelUserCommissions' => $modelUserCommissions,
            'logUserCommission' => $logUserCommission,
            'totalEligibleCommissionAmount' => $totalEligibleCommissionAmount,
            'totalCommissionPaid' => $totalCommissionPaid,
        ]);
    }

    public function actionPayEligibleCommission($id,$user_eligible_commission_id,$prospect_booking_id)
	{
		$modelUserCommissions = $this->findModel($id);
		$modelUserEligibleCommissions = UserEligibleCommissions::findOne($user_eligible_commission_id);
		$modelProspectBookings = ProspectBookings::findOne($prospect_booking_id);
		$modelLogUserCommission = new LogUserCommission();
		
		/*echo '<pre>';
		print_r($modelUserCommissions->getAttributes());
		print_r($modelUserEligibleCommissions->getAttributes());
		print_r($modelProspectBookings->getAttributes());
		echo '</pre>';
		exit();*/
		
		$error = '';
		$connection = Yii::$app->db;
		$transaction = $connection->beginTransaction();
		try 
		{
			//update user commissions
			$userEligibleCommissions = UserEligibleCommissions::find()->where(array('user_commission_id'=>$modelUserCommissions->id,'user_id'=>$modelUserCommissions->user_id,'status'=>0,'deletedby'=>NULL,'deletedat'=>NULL))->one();
			if($userEligibleCommissions==NULL)
			$modelUserCommissions->status = 1;
			else
			$modelUserCommissions->status = 3;
			$modelUserCommissions->updatedby = $_SESSION['user']['id'];
			$modelUserCommissions->updatedat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
			$modelUserCommissions->save();
			if(count($modelUserCommissions->errors)!=0)
			throw new ErrorException("Update user commission status failed.");
			
			//create user eligible commissions
			$modelUserEligibleCommissions->status = 1;
			$modelUserEligibleCommissions->updatedby = $_SESSION['user']['id'];
			$modelUserEligibleCommissions->updatedat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
			$modelUserEligibleCommissions->save();
			if(count($modelUserEligibleCommissions->errors)!=0)
			throw new ErrorException("Update user eligible commission status failed.");
			
			//create log user commission
			$modelLogUserCommission->load(Yii::$app->request->post());
			$modelLogUserCommission->prospect_id = $modelProspectBookings->prospect_id;
			$modelLogUserCommission->prospect_booking_id = $modelProspectBookings->id;
			$modelLogUserCommission->user_eligible_commission_id = $modelUserEligibleCommissions->id;
			$modelLogUserCommission->user_id = $modelUserCommissions->user_id;
			$modelLogUserCommission->commission_amount = $modelUserEligibleCommissions->commission_eligible_amount;
			$modelLogUserCommission->status = 4;
			$modelLogUserCommission->createdby = $_SESSION['user']['id'];
			$modelLogUserCommission->createdat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
			$modelLogUserCommission->save();
			if(count($modelLogUserCommission->errors)!=0)
			throw new ErrorException("Create log user commission failed.");
			
			//get total eligible commission paid
			$totalUserEligibleCommissionPaid = $modelUserEligibleCommissions->getTotalUserEligibleCommissionsPaid($modelUserCommissions->id,$modelUserCommissions->user_id);
			if($totalUserEligibleCommissionPaid==$modelUserCommissions->total_commission_amount)
			{	
				$modelUserCommissions->status = 4;
				$modelUserCommissions->updatedby = $_SESSION['user']['id'];
				$modelUserCommissions->updatedat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
				$modelUserCommissions->save();
				if(count($modelUserCommissions->errors)!=0)
				throw new ErrorException("Update user commission status failed.");
			}
			
			$transaction->commit();
		}
		catch (ErrorException $e) 
		{
			$transaction->rollBack();
			$error = $e->getMessage();
			Yii::$app->session->set('errorMessage', $error);
		}
								
		return $this->redirect(['view', 'id' => $modelUserCommissions->id]);
		
        /*return $this->renderAjax('pay-commission', [
            'modelUserCommissions' => $modelUserCommissions,
            'modelUserEligibleCommissions' => $modelUserEligibleCommissions,
            'modelProspectBookings' => $modelProspectBookings,
            'modelLogUserCommission' => $modelLogUserCommission,
        ]);*/
	}
	
    public function actionCancelEligibleCommission($id,$user_eligible_commission_id,$prospect_booking_id)
	{
		$modelUserCommissions = $this->findModel($id);
		$modelUserEligibleCommissions = UserEligibleCommissions::findOne($user_eligible_commission_id);
		$modelProspectBookings = ProspectBookings::findOne($prospect_booking_id);
		$modelLogUserCommission = new LogUserCommission();
		
		/*echo '<pre>';
		print_r($modelUserCommissions->getAttributes());
		print_r($modelUserEligibleCommissions->getAttributes());
		print_r($modelProspectBookings->getAttributes());
		echo '</pre>';
		exit();*/
		
		$error = '';
		$connection = Yii::$app->db;
		$transaction = $connection->beginTransaction();
		try 
		{
			//update user commissions
			$userEligibleCommissions = UserEligibleCommissions::find()->where(array('user_commission_id'=>$modelUserCommissions->id,'user_id'=>$modelUserCommissions->user_id,'status'=>0,'deletedby'=>NULL,'deletedat'=>NULL))->one();
			if($userEligibleCommissions==NULL)
			$modelUserCommissions->status = 1;
			else
			$modelUserCommissions->status = 3;
			$modelUserCommissions->updatedby = $_SESSION['user']['id'];
			$modelUserCommissions->updatedat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
			$modelUserCommissions->save();
			if(count($modelUserCommissions->errors)!=0)
			throw new ErrorException("Update user commission status failed.");
			
			//create user eligible commissions
			$modelUserEligibleCommissions->status = 0;
			$modelUserEligibleCommissions->deletedby = $_SESSION['user']['id'];
			$modelUserEligibleCommissions->deletedat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
			$modelUserEligibleCommissions->save();
			if(count($modelUserEligibleCommissions->errors)!=0)
			throw new ErrorException("Cancel user eligible commission failed.");
			
			//create log user commission
			$modelLogUserCommission->load(Yii::$app->request->post());
			$modelLogUserCommission->prospect_id = $modelProspectBookings->prospect_id;
			$modelLogUserCommission->prospect_booking_id = $modelProspectBookings->id;
			$modelLogUserCommission->user_eligible_commission_id = $modelUserEligibleCommissions->id;
			$modelLogUserCommission->user_id = $modelUserCommissions->user_id;
			$modelLogUserCommission->commission_amount = $modelUserEligibleCommissions->commission_eligible_amount;
			$modelLogUserCommission->status = 3;
			$modelLogUserCommission->createdby = $_SESSION['user']['id'];
			$modelLogUserCommission->createdat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
			$modelLogUserCommission->save();
			if(count($modelLogUserCommission->errors)!=0)
			throw new ErrorException("Create cancel log user commission failed.");
			
			//get total eligible commission paid
			/*$totalUserEligibleCommissionPaid = $modelUserEligibleCommissions->getTotalUserEligibleCommissionsPaid($modelUserCommissions->id,$modelUserCommissions->user_id);
			if($totalUserEligibleCommissionPaid==$modelUserCommissions->total_commission_amount)
			{	
				$modelUserCommissions->status = 4;
				$modelUserCommissions->updatedby = $_SESSION['user']['id'];
				$modelUserCommissions->updatedat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
				$modelUserCommissions->save();
				if(count($modelUserCommissions->errors)!=0)
				throw new ErrorException("Update user commission status failed.");
			}*/
			
			$transaction->commit();
		}
		catch (ErrorException $e) 
		{
			$transaction->rollBack();
			$error = $e->getMessage();
			Yii::$app->session->set('errorMessage', $error);
		}
								
		return $this->redirect(['view', 'id' => $modelUserCommissions->id]);
		
        /*return $this->renderAjax('pay-commission', [
            'modelUserCommissions' => $modelUserCommissions,
            'modelUserEligibleCommissions' => $modelUserEligibleCommissions,
            'modelProspectBookings' => $modelProspectBookings,
            'modelLogUserCommission' => $modelLogUserCommission,
        ]);*/
	}

    protected function findModel($id)
    {
        if (($model = UserCommissions::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
