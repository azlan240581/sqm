<?php

namespace app\controllers;

use Yii;
use app\models\LogMessages;
use app\models\LogMessagesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * LogMessagesController implements the CRUD actions for LogMessages model.
 */
class LogMessagesController extends Controller
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
        $searchModel = new LogMessagesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

		$priorityList = array(array('name'=>'High','value'=>'3'),array('name'=>'Medium','value'=>'2'),array('name'=>'Low','value'=>'1'));

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'priorityList' => $priorityList,
        ]);
    }

    protected function findModel($id)
    {
        if (($model = LogMessages::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
