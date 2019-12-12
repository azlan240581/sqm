<?php

namespace app\controllers;

use Yii;
use app\models\Rewards;
use app\models\RewardsSearch;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\base\ErrorException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\helpers\Html;

/**
 * RewardsController implements the CRUD actions for Rewards model.
 */
class RewardsController extends Controller
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
        $searchModel = new RewardsSearch();
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
        $model = new Rewards();
		$model->scenario = 'create';
		$model->status = 1;

        if(count($_POST)!=0)
		{
			$error = '';
			$connection = \Yii::$app->db;
			$transaction = $connection->beginTransaction();
			try 
			{							
				$model->load(Yii::$app->request->post());
				$model->description = htmlentities($model->description);
								
				if(strlen($model->published_date_start))
				$model->published_date_start = date('Y-m-d 00:00:00', strtotime($model->published_date_start));
				if(!strlen($model->published_date_end))
				$model->published_date_end = NULL;
				if(strlen($model->published_date_end))
				$model->published_date_end = date('Y-m-d 23:59:59', strtotime($model->published_date_end));

				$model->images = 'test';
				$model->file = 'test';
				$model->createdby = $_SESSION['user']['id'];
				$model->createdat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
				$model->save();
				
				if(count($model->errors)!=0)
				throw new ErrorException("Create reward failed.");
				
				//directory path
				$directory_path = 'contents/rewards/'.$model->id;
				//create directory based on id
				Yii::$app->AccessMod->createDirectory($directory_path);
				//save banner image
				if($_FILES['Rewards']['error']['file']!=4)
				{					
					//directory path
					$directory_path = 'contents/rewards/'.$model->id.'/';
					if(($path = Yii::$app->AccessMod->createDirectory($directory_path)))
					{
						//get the instance of uploaded file
						$model->file = UploadedFile::getInstance($model,'file');	
												
						//validate image size
						if($model->file->size > 10000000)
						throw new ErrorException("Image size cannot larger than 10MB");
											
						$file_name = session_id().str_replace(' ','_',$model->file->name);
						$model->file->saveAs($directory_path.$file_name,false);
						if(!$model->file->saveAs($directory_path.$file_name,false))
						throw new ErrorException("Upload image failed.");
	
						//save path to db column
						$model->images = ((isset($_SERVER['HTTPS'])) ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'].'/cmp/'.$directory_path.$file_name;
						$model->save();
						if(count($model->errors)!=0)
						throw new ErrorException("Save reward image failed.");
					}
					else
					throw new ErrorException($path->errorMessage);
				}
				
				$transaction->commit();
			}
			catch (ErrorException $e) 
			{
				$transaction->rollBack();
				$error = $e->getMessage();
				Yii::$app->session->set('errorMessage', $error);
				$model->description = html_entity_decode($model->description);
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
		$model->description = html_entity_decode($model->description);
				
        if(count($_POST)!=0)
		{
			$error = '';
			$connection = \Yii::$app->db;
			$transaction = $connection->beginTransaction();
			try 
			{				
				$model->load(Yii::$app->request->post());
				$model->description = htmlentities($model->description);
				
				if(strlen($model->published_date_start))
				$model->published_date_start = date('Y-m-d 00:00:00', strtotime($model->published_date_start));
				if(!strlen($model->published_date_end))
				$model->published_date_end = NULL;
				if(strlen($model->published_date_end))
				$model->published_date_end = date('Y-m-d 23:59:59', strtotime($model->published_date_end));

				//save banner image
				if($_FILES['Rewards']['error']['file']!=4)
				{					
					//directory path
					$directory_path = 'contents/rewards/'.$model->id.'/';
					if(($path = Yii::$app->AccessMod->createDirectory($directory_path)))
					{
						//get the instance of uploaded file
						$model->file = UploadedFile::getInstance($model,'file');	
												
						//validate image size
						if($model->file->size > 10000000)
						throw new ErrorException("Image size cannot larger than 10MB");
											
						$file_name = session_id().str_replace(' ','_',$model->file->name);
						$model->file->saveAs($directory_path.$file_name,false);
						if(!$model->file->saveAs($directory_path.$file_name,false))
						throw new ErrorException("Upload image failed.");
	
						//save path to db column
						$model->images = ((isset($_SERVER['HTTPS'])) ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'].'/cmp/'.$directory_path.$file_name;
					}
					else
					throw new ErrorException($path->errorMessage);
				}

				$model->updatedby = $_SESSION['user']['id'];
				$model->updatedat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
				$model->save();
				if(count($model->errors)!=0)
				throw new ErrorException("Update reward failed.");
				
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
        $model = $this->findModel($id);
		$model->status = 0;
		$model->deletedby = $_SESSION['user']['id'];
		$model->deletedat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
		$model->save();
        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Rewards::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
