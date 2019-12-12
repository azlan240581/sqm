<?php

namespace app\controllers;

use Yii;
use app\models\UserPoints;
use app\models\UserPointsSearch;
use app\models\LogUserPoints;
use app\models\LogAssociateActivities;
use app\models\LookupPointsActions;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserPointsController implements the CRUD actions for UserPoints model.
 */
class UserPointsController extends Controller
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
		$searchModel = new UserPointsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $model = $this->findModel($id);
		
		$logAssociateActivities =  LogAssociateActivities::find()->where(array('associate_id'=>$model->user_id))->orderBy(array('createdat'=>SORT_DESC))->limit(5)->asArray()->all();
		$logUserPoints =  LogUserPoints::find()->where(array('user_id'=>$model->user_id))->orderBy(array('createdat'=>SORT_DESC))->limit(5)->asArray()->all();
		if(count($logUserPoints)!=0)
		{
			foreach($logUserPoints as $key => $logPoints)
			{
				$pointsAction = LookupPointsActions::findOne($logPoints['status']);
				$logUserPoints[$key]['status'] = $pointsAction->name;
			}
		}
		
        return $this->render('view', [
            'model' => $model,
            'logAssociateActivities' => $logAssociateActivities,
            'logUserPoints' => $logUserPoints,
        ]);
    }

    public function actionTogglePoints($id)
    {
		//initialize
		$inputs = array();
        $model = $this->findModel($id);
        $modelLogUserPoints = new LogUserPoints();

        if(count($_POST)!=0)
		{
			$modelLogUserPoints->load(Yii::$app->request->post());
			
			$member_id = $model->user_id;
			$points_action = $modelLogUserPoints->status;
			$points_value = $modelLogUserPoints->points_value;
			$remarks = $modelLogUserPoints->remarks;
			$user_id = $_SESSION['user']['id'];
						
			$result = Yii::$app->PointsMod->memberPoints($member_id,$points_action,$points_value,$remarks,$user_id);
			if(!$result)
			Yii::$app->session->set('errorMessage', Yii::$app->PointsMod->errorMessage);
			else
			return $this->redirect(['view', 'id' => $model->id]);
        }
		
		return $this->render('toggle-points', [
			'model' => $model,
			'modelLogUserPoints' => $modelLogUserPoints,
		]);
    }

    protected function findModel($id)
    {
        if (($model = UserPoints::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
