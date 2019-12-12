<?php

namespace app\controllers;

use Yii;
use app\models\Banners;
use app\models\BannersSearch;
use app\models\LookupBannerCategories;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\base\ErrorException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\helpers\Html;

/**
 * BannersController implements the CRUD actions for Banners model.
 */
class BannersController extends Controller
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
        $searchModel = new BannersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

		//get lookup banner category list
		$lookupBannerCategoryList = LookupBannerCategories::find()->where(array('deleted'=>0))->asArray()->all();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'lookupBannerCategoryList' => $lookupBannerCategoryList,
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
        $model = new Banners();
		
		//get lookup banner category list
		$lookupBannerCategoryList = LookupBannerCategories::find()->where(array('deleted'=>0))->asArray()->all();
		
		if(isset($_GET['banner_title']))
		{
			$x = 0;
			while($x <= 1000)
			{
				$permalink = trim(strtolower($_GET['banner_title']));
				$permalink = trim(preg_replace("/[^A-Za-z0-9\-\']/", ' ', $permalink));
				$permalink = trim(preg_replace("/\s+/", ' ', $permalink));
				$model->permalink = str_replace(' ','-',$permalink);
				if(!empty($_GET['id']))
				$model->id = $_GET['id'];
				if($x!=0)
				$model->permalink = $model->permalink.'-'.$x;
				if($model->checkUnique('permalink'))
				{
					echo json_encode($model->permalink);
					exit();
				}
				$x++;
			}
		}
		
		if(isset($_GET['permalink']))
		{
			$model->permalink = $_GET['permalink'];
			if(!empty($_GET['id']))
			$model->id = $_GET['id'];
			echo json_encode($model->checkUnique('permalink'));
			exit();
		}
		
        if(count($_POST)!=0)
		{
			$error = '';
			$connection = \Yii::$app->db;
			$transaction = $connection->beginTransaction();
			try 
			{				
				$model->load(Yii::$app->request->post());
				$model->banner_description = htmlentities($model->banner_description);
				$model->published_date_start = date('Y-m-d 00:00:00', strtotime(Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s')));
				
				/*
				if(strlen($model->published_date_start))
				$model->published_date_start = date('Y-m-d 00:00:00', strtotime($model->published_date_start));
				if(!strlen($model->published_date_end))
				$model->published_date_end = NULL;
				if(strlen($model->published_date_end))
				$model->published_date_end = date('Y-m-d 23:59:59', strtotime($model->published_date_end));
				*/
				
				//validate youtube video id
				if(strlen($model->banner_video))
				{
					if(preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $model->banner_video, $youtubeID)==1)
					{
						if(in_array('HTTP/1.0 200 OK',get_headers('https://youtu.be/'.$youtubeID[0])))
						$model->media_value = $youtubeID[0];
					}
					else
					{
						if(in_array('HTTP/1.0 200 OK',get_headers('https://youtu.be/'.$model->banner_video)))
						$model->banner_video = $model->banner_video;
					}
				}


				$model->createdby = $_SESSION['user']['id'];
				$model->createdat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
				$model->save();
				if(count($model->errors)!=0)
				throw new ErrorException("Create banner failed.");
				
				//directory path
				$directory_path = 'contents/banner/'.$model->id;
				//create directory based on id
				Yii::$app->AccessMod->createDirectory($directory_path);
				
				//save banner image
				if($_FILES['Banners']['error']['file']!=4)
				{					
					//directory path
					$directory_path = 'contents/banner/'.$model->id.'/';
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
						$model->banner_img = ((isset($_SERVER['HTTPS'])) ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'].'/cmp/'.$directory_path.$file_name;
						$model->save();
						if(count($model->errors)!=0)
						throw new ErrorException("Save banner image failed.");
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
				$model->banner_description = html_entity_decode($model->banner_description);
			}
								
			if(!strlen($error))
			return $this->redirect(['view', 'id' => $model->id]);
        }
		
		return $this->render('create', [
			'model' => $model,
			'lookupBannerCategoryList' => $lookupBannerCategoryList,
		]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->banner_description = html_entity_decode($model->banner_description);
		
		//get lookup banner category list
		$lookupBannerCategoryList = LookupBannerCategories::find()->where(array('deleted'=>0))->asArray()->all();
		
		if(isset($_GET['banner_title']))
		{
			$x = 0;
			while($x <= 1000)
			{
				$permalink = trim(strtolower($_GET['banner_title']));
				$permalink = trim(preg_replace("/[^A-Za-z0-9\-\']/", ' ', $permalink));
				$permalink = trim(preg_replace("/\s+/", ' ', $permalink));
				$model->permalink = str_replace(' ','-',$permalink);
				if(!empty($_GET['id']))
				$model->id = $_GET['id'];
				if($x!=0)
				$model->permalink = $model->permalink.'-'.$x;
				if($model->checkUnique('permalink'))
				{
					echo json_encode($model->permalink);
					exit();
				}
				$x++;
			}
		}
		
		if(isset($_GET['permalink']))
		{
			$model->permalink = $_GET['permalink'];
			if(!empty($_GET['id']))
			$model->id = $_GET['id'];
			echo json_encode($model->checkUnique('permalink'));
			exit();
		}
		
        if(count($_POST)!=0)
		{
			$error = '';
			$connection = \Yii::$app->db;
			$transaction = $connection->beginTransaction();
			try 
			{				
				$model->load(Yii::$app->request->post());
				$model->banner_description = htmlentities($model->banner_description);
				$model->published_date_start = date('Y-m-d 00:00:00', strtotime($model->published_date_start));
				
				/*
				if(strlen($model->published_date_start))
				$model->published_date_start = date('Y-m-d 00:00:00', strtotime($model->published_date_start));
				if(!strlen($model->published_date_end))
				$model->published_date_end = NULL;
				if(strlen($model->published_date_end))
				$model->published_date_end = date('Y-m-d 23:59:59', strtotime($model->published_date_end));
				*/
				
				//save banner image
				if($_FILES['Banners']['error']['file']!=4)
				{					
					//directory path
					$directory_path = 'contents/banner/'.$model->id.'/';
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
						$model->banner_img = ((isset($_SERVER['HTTPS'])) ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'].'/cmp/'.$directory_path.$file_name;
					}
					else
					throw new ErrorException($path->errorMessage);
				}

				//validate youtube video id
				if(strlen($model->banner_video))
				{
					if(preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $model->banner_video, $youtubeID)==1)
					{
						if(in_array('HTTP/1.0 200 OK',get_headers('https://youtu.be/'.$youtubeID[0])))
						$model->media_value = $youtubeID[0];
					}
					else
					{
						if(in_array('HTTP/1.0 200 OK',get_headers('https://youtu.be/'.$model->banner_video)))
						$model->banner_video = $model->banner_video;
					}
				}

				$model->updatedby = $_SESSION['user']['id'];
				$model->updatedat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
				$model->save();
				if(count($model->errors)!=0)
				throw new ErrorException("Create banner failed.");
				
				$transaction->commit();
			}
			catch (ErrorException $e) 
			{
				$transaction->rollBack();
				$error = $e->getMessage();
				Yii::$app->session->set('errorMessage', $error);
				$model->banner_description = html_entity_decode($model->banner_description);
			}
								
			if(!strlen($error))
			return $this->redirect(['view', 'id' => $model->id]);
        }
		
		return $this->render('update', [
			'model' => $model,
			'lookupBannerCategoryList' => $lookupBannerCategoryList,
		]);
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
		$model->deletedby = $_SESSION['user']['id'];
		$model->deletedat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
		$model->save();
        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Banners::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
