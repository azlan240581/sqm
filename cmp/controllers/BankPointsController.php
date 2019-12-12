<?php

namespace app\controllers;

use Yii;
use app\models\BankPoints;
use app\models\BankPointsSearch;
use app\models\LogBankPoints;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BankPointsController implements the CRUD actions for BankPoints model.
 */
class BankPointsController extends Controller
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
        return $this->render('index', [
            'model' => $this->findModel(1),
        ]);
    }

    public function actionTopup()
    {
		//initialize
		$error = '';
        $model = new BankPoints();
        $modelLogBankPoints = new LogBankPoints();

        if(count($_POST)!=0)
		{
			$modelLogBankPoints->load(Yii::$app->request->post());
			if($modelLogBankPoints->points_value<=0)
			$error = 'Invalid points value';
			
			if(!strlen($error))
			{
				$points_value = $modelLogBankPoints->points_value;
				$remarks = $modelLogBankPoints->remarks;
				$user_id = $_SESSION['user']['id'];
				
				$result = Yii::$app->PointsMod->topupBankPoints($points_value,$remarks,$user_id);
				if(!$result)
				$error = Yii::$app->PointsMod->errorMessage;
			}
			
			if(!strlen($error))
            return $this->redirect(['index']);
			else
			{
				$modelLogBankPoints->addError('points_value',$error);
				return $this->render('topup', [
					'model' => $model,
					'modelLogBankPoints' => $modelLogBankPoints,
				]);
			}
        } 
		
		if(isset($_REQUEST['ajaxView']))
		{
			return $this->renderAjax('topup', [
				'model' => $model,
				'modelLogBankPoints' => $modelLogBankPoints,
			]);
		}
		else
		{
			return $this->render('topup', [
				'model' => $model,
				'modelLogBankPoints' => $modelLogBankPoints,
			]);
		}
    }

    protected function findModel($id)
    {
        if (($model = BankPoints::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
