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

use app\models\SettingsRules;
use app\models\SettingsRulesValue;

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
class AssignVirtualAssociateController extends Controller
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
		if($_SESSION['user']['groups']!=NULL and array_intersect(array(7,8,9,10),$_SESSION['user']['groups']))
        $searchModel = new UserAssociateDetailsSearch(['agent_id'=>$_SESSION['user']['id']]);
		else
        $searchModel = new UserAssociateDetailsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		
		//get associate productivity status
		$associateProductivityStatusList = LookupAssociateProductivityStatus::find()->where(array('deleted'=>0))->asArray()->all();
		
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'associateProductivityStatusList' => $associateProductivityStatusList,
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

    public function actionAssignVirtualAssociate($id)
    {
		$modelUserAssociateDetails = $this->findModel($id);
		$modelUsers = $this->findModelUsers($modelUserAssociateDetails->user_id);
		
		$error = '';
		$connection = \Yii::$app->db;
		$transaction = $connection->beginTransaction();
		try 
		{
			$modelSettingsRules = SettingsRules::find()->where(array('settings_rules_key'=>'AUTO_ASSIGN_PROSPECT_TO_MEMBER'))->one();
			if($modelSettingsRules==NULL)
			throw new ErrorException("Invalid settings rules key failed.");
			
			$modelSettingsRulesValue = SettingsRulesValue::find()->where(array('settings_rules_id'=>$modelSettingsRules->id))->one();
			$modelSettingsRulesValue->value = $modelUsers->uuid;
			$modelSettingsRulesValue->save();
			if(count($modelSettingsRulesValue->errors)!=0)
			throw new ErrorException("Assign virtual associate failed.");
			
			$transaction->commit();
		}
		catch (ErrorException $e) 
		{
			$transaction->rollBack();
			$error = $e->getMessage();
			Yii::$app->session->set('errorMessage', $error);
		}
		
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
