<?php

namespace app\controllers;

use Yii;
use app\models\LoanApplications;
use app\models\LoanApplicationsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\base\ErrorException;
use yii\filters\VerbFilter;
use yii\helpers\Html;

/**
 * LoanApplicationsController implements the CRUD actions for LoanApplications model.
 */
class LoanApplicationsController extends Controller
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
        $searchModel = new LoanApplicationsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
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
        $model = new LoanApplications();

        if(count($_POST)!=0)
		{
			$model->load(Yii::$app->request->post());
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
			$model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        }

		return $this->render('update', [
			'model' => $model,
		]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = LoanApplications::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
