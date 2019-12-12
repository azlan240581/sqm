<?php

namespace app\controllers;

use Yii;
use app\models\Activities;
use app\models\ActivitiesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ActivitiesController implements the CRUD actions for Activities model.
 */
class ActivitiesController extends Controller
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
        $searchModel = new ActivitiesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		
		//status list
		$statusList = array(array('name'=>'Active','value'=>'1'),array('name'=>'Inactive','value'=>'0'));
		
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'statusList' => $statusList,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $model = new Activities();
		$model->status = 1;
		
        if(count($_POST)!=0)
		{
			$model->load(Yii::$app->request->post());
			$model->activity_code = str_replace(' ','_',strtoupper($model->activity_code));
			$model->createdby = $_SESSION['user']['id'];
			$model->createdat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
			$model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        }
		
		return $this->render('create', [
			'model' => $model,
		]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if(count($_POST)!=0)
		{
			$model->load(Yii::$app->request->post());
			$model->activity_code = str_replace(' ','_',strtoupper($model->activity_code));
			$model->updatedby = $_SESSION['user']['id'];
			$model->updatedat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
			$model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        }
		
		return $this->render('update', [
			'model' => $model,
		]);
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
		$model->status = 0;
		$model->deletedby = $_SESSION['user']['id'];
		$model->deletedat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
		$model->save();
        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Activities::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
