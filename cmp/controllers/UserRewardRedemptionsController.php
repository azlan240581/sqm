<?php

namespace app\controllers;

use Yii;
use app\models\UserRewardRedemptions;
use app\models\UserRewardRedemptionsSearch;
use app\models\Rewards;
use app\models\LookupRedemptionStatus;
use app\models\LogUserRewardRedemptions;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserRewardRedemptionsController implements the CRUD actions for UserRewardRedemptions model.
 */
class UserRewardRedemptionsController extends Controller
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
        $searchModel = new UserRewardRedemptionsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		
		$lookupRedemptionStatusList = LookupRedemptionStatus::find()->where(array('deleted'=>0))->asArray()->all();
		
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'lookupRedemptionStatusList' => $lookupRedemptionStatusList,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionApprove($id)
    {
        $model = $this->findModel($id);
        $modelLogUserRewardRedemptions = new LogUserRewardRedemptions;

        if(count($_POST)!=0)
		{
			$error = '';
			$connection = Yii::$app->db;
			$transaction = $connection->beginTransaction();
			try 
			{
				//update user reward redemption
				$model->load(Yii::$app->request->post());
				$model->status = 3;
				$model->updatedby = $_SESSION['user']['id'];
				$model->updatedat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
				$model->save();
				if(count($model->errors)!=0)
				throw new ErrorException("Approve user reward redemption failed.");
				
				//create log user redemptions
				$modelLogUserRewardRedemptions->load(Yii::$app->request->post());
				$modelLogUserRewardRedemptions->user_id = $model->user_id;
				$modelLogUserRewardRedemptions->reward_id = $model->reward_id;
				$modelLogUserRewardRedemptions->associate_reward_redemption_id = $model->id;
				$modelLogUserRewardRedemptions->points_value = $model->points_value;
				$modelLogUserRewardRedemptions->status = $model->status;
				$modelLogUserRewardRedemptions->createdby = $_SESSION['user']['id'];
				$modelLogUserRewardRedemptions->createdat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
				$modelLogUserRewardRedemptions->save();
				if(count($modelLogUserRewardRedemptions->errors)!=0)
				throw new ErrorException("Create log user reward redemption failed.");
				
				$transaction->commit();
			}
			catch (ErrorException $e) 
			{
				$transaction->rollBack();
				$error = $e->getMessage();
				Yii::$app->session->set('errorMessage', $error);
			}
									
            return $this->redirect(['view', 'id' => $model->id]);
        }
		
		return $this->renderAjax('approve', [
			'model' => $model,
			'modelLogUserRewardRedemptions' => $modelLogUserRewardRedemptions,
		]);
    }

    public function actionCancel($id)
    {
        $model = $this->findModel($id);
        $modelLogUserRewardRedemptions = new LogUserRewardRedemptions;

        if(count($_POST)!=0)
		{
			$error = '';
			$connection = Yii::$app->db;
			$transaction = $connection->beginTransaction();
			try 
			{
				//update user reward redemption
				$model->load(Yii::$app->request->post());
				$model->status = 2;
				$model->updatedby = $_SESSION['user']['id'];
				$model->updatedat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
				$model->save();
				if(count($model->errors)!=0)
				throw new ErrorException("Cancel user reward redemption failed.");
				
				//create log user redemptions
				$modelLogUserRewardRedemptions->load(Yii::$app->request->post());
				$modelLogUserRewardRedemptions->user_id = $model->user_id;
				$modelLogUserRewardRedemptions->reward_id = $model->reward_id;
				$modelLogUserRewardRedemptions->associate_reward_redemption_id = $model->id;
				$modelLogUserRewardRedemptions->points_value = $model->points_value;
				$modelLogUserRewardRedemptions->status = $model->status;
				$modelLogUserRewardRedemptions->createdby = $_SESSION['user']['id'];
				$modelLogUserRewardRedemptions->createdat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
				$modelLogUserRewardRedemptions->save();
				if(count($modelLogUserRewardRedemptions->errors)!=0)
				throw new ErrorException("Create log user reward redemption failed.");
				
				$transaction->commit();
			}
			catch (ErrorException $e) 
			{
				$transaction->rollBack();
				$error = $e->getMessage();
				Yii::$app->session->set('errorMessage', $error);
			}
									
            return $this->redirect(['view', 'id' => $model->id]);
        }
		
		return $this->renderAjax('cancel', [
			'model' => $model,
			'modelLogUserRewardRedemptions' => $modelLogUserRewardRedemptions,
		]);
    }

    protected function findModel($id)
    {
        if (($model = UserRewardRedemptions::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
