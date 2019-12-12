<?php

namespace app\controllers;

use Yii;
use app\models\Banks;
use app\models\BanksSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\base\ErrorException;
use yii\filters\VerbFilter;
use yii\helpers\Html;

/**
 * BanksController implements the CRUD actions for Banks model.
 */
class BanksController extends Controller
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
        $searchModel = new BanksSearch();
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
        $model = new Banks();

        if(count($_POST)!=0)
		{
			$error = '';
			$connection = Yii::$app->db;
			$transaction = $connection->beginTransaction();
			try 
			{
				//validate bank name
				/*
				$checkUserByUsername = $modelUser->CheckActiveUserByUsername($modelUser->username);
				if($checkUserByUsername)
				throw new ErrorException("Username '".$modelUser->username."' has already been taken.");
				*/
				
				$model->load(Yii::$app->request->post());
				$model->createdby = $_SESSION['user']['id'];
				$model->createdat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
				$model->save();
				if(count($model->errors)!=0)
				throw new ErrorException("Create bank failed.");
				
				$transaction->commit();
			}
			catch (ErrorException $e) 
			{
				$transaction->rollBack();
				$error = $e->getMessage();
				Yii::$app->session->set('errorMessage', $error);
			}
									
			if(!strlen($error))
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
			$error = '';
			$connection = Yii::$app->db;
			$transaction = $connection->beginTransaction();
			try 
			{
				//validate bank name
				/*
				$checkUserByUsername = $modelUser->CheckActiveUserByUsername($modelUser->username);
				if($checkUserByUsername)
				throw new ErrorException("Username '".$modelUser->username."' has already been taken.");
				*/
				
				$model->load(Yii::$app->request->post());
				$model->updatedby = $_SESSION['user']['id'];
				$model->updatedat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
				$model->save();
				if(count($model->errors)!=0)
				throw new ErrorException("Update bank failed.");
				
				$transaction->commit();
			}
			catch (ErrorException $e) 
			{
				$transaction->rollBack();
				$error = $e->getMessage();
				Yii::$app->session->set('errorMessage', $error);
			}
									
			if(!strlen($error))
            return $this->redirect(['view', 'id' => $model->id]);
        } 

		return $this->render('update', [
			'model' => $model,
		]);
    }

    public function actionDelete($id)
    {		
		$error = '';
		$connection = Yii::$app->db;
		$transaction = $connection->beginTransaction();
		try 
		{
			$model = $this->findModel($id);
			$model->status = '0';
			$model->deletedby = $_SESSION['user']['id'];
			$model->deletedat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
			$model->save();
			if(count($model->errors)!=0)
			throw new ErrorException("Delete developer failed.");
			
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
        if (($model = Banks::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
