<?php

namespace app\controllers;

use Yii;
use app\models\NewPotentialAssociates;
use app\models\NewPotentialAssociatesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * NewPotentialAssociatesController implements the CRUD actions for NewPotentialAssociates model.
 */
class NewPotentialAssociatesController extends Controller
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
        $searchModel = new NewPotentialAssociatesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

		$registeredList = array(array('name'=>'Yes','value'=>'1'),array('name'=>'No','value'=>'0'));

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'registeredList' => $registeredList,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    protected function findModel($id)
    {
        if (($model = NewPotentialAssociates::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
