<?php

namespace app\controllers;

use Yii;
use app\models\Collaterals;
use app\models\CollateralsSearch;

use app\models\Projects;
use app\models\ProjectAgents;

use app\models\CollateralsMedias;
use app\models\CollateralsMediasSearch;
use app\models\LookupCollateralMediaTypes;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\base\ErrorException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\helpers\Html;

/**
 * CollateralsController implements the CRUD actions for Collaterals model.
 */
class CollateralsController extends Controller
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
        {
			//get project agents
			$projectAgents = ProjectAgents::find()->where(array('agent_id'=>$_SESSION['user']['id']))->asArray()->all();
			if(count($projectAgents)==0)
			throw new \yii\web\HttpException(401, 'Unauthorized: You are not assign to any project. Please Contact administrator.');		
			else
			{
				$searchModel = new CollateralsSearch();
				$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
				//get project list
				$projectList = Projects::find()
									->where(array('id'=>array_column($projectAgents,'project_id'),'status'=>1,'deletedby'=>NULL,'deletedat'=>NULL,))
									->orderBy(array('project_name' => SORT_ASC,))
									->asArray()
									->all();
			}
		}
		else
		{
			$searchModel = new CollateralsSearch();
			$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
			//get project list
			$projectList = Projects::find()
								->where(array('status'=>1,'deletedby'=>NULL,'deletedat'=>NULL,))
								->orderBy(array('project_name' => SORT_ASC,))
								->asArray()
								->all();
		}

		//get collateral media types
		$collateralMediaTypeList = LookupCollateralMediaTypes::find()->where(array('deleted'=>0))->asArray()->all();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'projectList' => $projectList,
            'collateralMediaTypeList' => $collateralMediaTypeList,
        ]);
    }

    public function actionView($id)
    {
		$model = $this->findModel($id);
		$modelCollateralsMedias = CollateralsMedias::find()->where(array('collateral_id'=>$model->id))->one();;
				
        return $this->render('view', [
            'model' => $model,
            'modelCollateralsMedias' => $modelCollateralsMedias,
        ]);
    }

    public function actionCreate()
    {
        $model = new Collaterals();
        $model->status = 1;
        $model->scenario = 'create';
        $modelCollateralsMedias = new CollateralsMedias();
		
		//get collateral media types
		$collateralMediaTypeList = LookupCollateralMediaTypes::find()->where(array('deleted'=>0))->asArray()->all();
		
		if($_SESSION['user']['groups']!=NULL and array_intersect(array(7,8,9,10),$_SESSION['user']['groups']))
        {
			//get project agents
			$projectAgents = ProjectAgents::find()->where(array('agent_id'=>$_SESSION['user']['id']))->asArray()->all();
			if(count($projectAgents)==0)
			throw new \yii\web\HttpException(401, 'Unauthorized: You are not assign to any project. Please Contact administrator.');		
			else
			{
				//get leveloper list
				$projectList = Projects::find()
									->where(array('id'=>array_column($projectAgents,'project_id'),'status'=>1,'deletedby'=>NULL,'deletedat'=>NULL,))
									->orderBy(array('project_name' => SORT_ASC,))
									->asArray()
									->all();
			}
		}
		else
		{
			//get leveloper list
			$projectList = Projects::find()
								->where(array('status'=>1,'deletedby'=>NULL,'deletedat'=>NULL,))
								->orderBy(array('project_name' => SORT_ASC,))
								->asArray()
								->all();
		}
		
		if(isset($_GET['title']))
		{
			$x = 0;
			while($x <= 1000)
			{
				$permalink = trim(strtolower($_GET['title']));
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
			$connection = Yii::$app->db;
			$transaction = $connection->beginTransaction();
			try 
			{
				//save collaterals		
				$model->load(Yii::$app->request->post());
				$model->description = htmlentities($model->description);
				$model->published_date_start = date('Y-m-d 00:00:00', strtotime(Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s')));
				
				/*
				if(strlen($model->published_date_start))
				$model->published_date_start = date('Y-m-d 00:00:00', strtotime($model->published_date_start));
				if(!strlen($model->published_date_end))
				$model->published_date_end = NULL;
				if(strlen($model->published_date_end))
				$model->published_date_end = date('Y-m-d 23:59:59', strtotime($model->published_date_end));
				*/
				
				$model->thumb_image = 'test';
				$model->file = 'test';
				
				$model->createdby = $_SESSION['user']['id'];
				$model->createdat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
				$model->save();
				if(count($model->errors)!=0)
				throw new ErrorException("Create collaterals failed.");
				
				//directory path
				$directory_path = 'contents/collateral-media/'.$model->id.'/';
				//create directory based on id
				Yii::$app->AccessMod->createDirectory($directory_path);
				
				//save whats new image
				if($_FILES['Collaterals']['error']['file']!=4)
				{					
					//directory path
					$directory_path = 'contents/collateral-media/'.$model->id.'/';
					if(($path = Yii::$app->AccessMod->createDirectory($directory_path)))
					{
						//get the instance of uploaded file
						$model->file = UploadedFile::getInstance($model,'file');	
						
						$imageDimension = getimagesize($model->file->tempName);							
						$imageWidth = $imageDimension[0];
						$imageHeight = $imageDimension[1];
						if($imageWidth > $_SESSION['settings']['COLLATERAL_MEDIA_THUMB_IMAGE_WIDTH'] || $imageHeight > $_SESSION['settings']['COLLATERAL_MEDIA_THUMB_IMAGE_HEIGHT'])
						throw new ErrorException("Thumb image width cannot more than ".$_SESSION['settings']['COLLATERAL_MEDIA_THUMB_IMAGE_WIDTH']."px and height cannot more than ".$_SESSION['settings']['COLLATERAL_MEDIA_THUMB_IMAGE_HEIGHT']."px");
						
						//validate image size
						if($model->file->size > 10000000)
						throw new ErrorException("Thumb image size cannot larger than 10MB");
											
						$file_name = session_id().str_replace(' ','_',$model->file->name);
						$model->file->saveAs($directory_path.$file_name,false);
						if(!$model->file->saveAs($directory_path.$file_name,false))
						throw new ErrorException("Failed uploading thumb image.");
	
						//save path to db column
						$model->thumb_image = ((isset($_SERVER['HTTPS'])) ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'].'/cmp/'.$directory_path.$file_name;
						$model->save();
						if(count($model->errors)!=0)
						throw new ErrorException("Upload collateral thumb image failed.");
					}
					else
					throw new ErrorException($path->errorMessage);
				}
				
				//save collateral medias
				$modelCollateralsMedias->load(Yii::$app->request->post());
				$modelCollateralsMedias->collateral_id = $model->id;
				$modelCollateralsMedias->thumb_image = $model->thumb_image;
				$modelCollateralsMedias->media_title = $model->title;
				$modelCollateralsMedias->sort = 0;
				$modelCollateralsMedias->createdby = $_SESSION['user']['id'];
				$modelCollateralsMedias->createdat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
				$modelCollateralsMedias->save();
				if(count($modelCollateralsMedias->errors)!=0)
				throw new ErrorException("Create collateral media failed.");
				
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
			'modelCollateralsMedias' => $modelCollateralsMedias,
			'projectList' => $projectList,
			'collateralMediaTypeList' => $collateralMediaTypeList,
		]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
		$model->description=html_entity_decode($model->description);
		$modelCollateralsMedias = CollateralsMedias::find()->where(array('collateral_id'=>$model->id))->one();;
		
		//get leveloper list
		$projectList = Projects::find()
							->where(array('status'=>1,'deletedby'=>NULL,'deletedat'=>NULL,))
							->orderBy(array('project_name' => SORT_ASC,))
							->asArray()
							->all();
		
		//get collateral media types
		$collateralMediaTypeList = LookupCollateralMediaTypes::find()->where(array('deleted'=>0))->asArray()->all();
							
		if(isset($_GET['title']))
		{
			$x = 0;
			while($x <= 1000)
			{
				$permalink = trim(strtolower($_GET['title']));
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
			$connection = Yii::$app->db;
			$transaction = $connection->beginTransaction();
			try 
			{				
				$model->load(Yii::$app->request->post());
				$model->description = htmlentities($model->description);
				$model->published_date_start = date('Y-m-d 00:00:00', strtotime($model->published_date_start));
				
				/*
				if(strlen($model->published_date_start))
				$model->published_date_start = date('Y-m-d 00:00:00', strtotime($model->published_date_start));
				if(!strlen($model->published_date_end))
				$model->published_date_end = NULL;
				if(strlen($model->published_date_end))
				$model->published_date_end = date('Y-m-d 23:59:59', strtotime($model->published_date_end));
				*/
				
				$model->updatedby = $_SESSION['user']['id'];
				$model->updatedat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
				$model->save();
				if(count($model->errors)!=0)
				throw new ErrorException("Update collaterals failed.");
				
				//save whats new image
				if($_FILES['Collaterals']['error']['file']!=4)
				{					
					//directory path
					$directory_path = 'contents/collateral-media/'.$model->id.'/';
					if(($path = Yii::$app->AccessMod->createDirectory($directory_path)))
					{
						//get the instance of uploaded file
						$model->file = UploadedFile::getInstance($model,'file');	
						
						$imageDimension = getimagesize($model->file->tempName);							
						$imageWidth = $imageDimension[0];
						$imageHeight = $imageDimension[1];
						if($imageWidth > $_SESSION['settings']['COLLATERAL_MEDIA_THUMB_IMAGE_WIDTH'] || $imageHeight > $_SESSION['settings']['COLLATERAL_MEDIA_THUMB_IMAGE_HEIGHT'])
						throw new ErrorException("Thumb image width cannot more than ".$_SESSION['settings']['COLLATERAL_MEDIA_THUMB_IMAGE_WIDTH']."px and height cannot more than ".$_SESSION['settings']['COLLATERAL_MEDIA_THUMB_IMAGE_HEIGHT']."px");
						
						//validate image size
						if($model->file->size > 10000000)
						throw new ErrorException("Thumb image size cannot larger than 10MB");
											
						$file_name = session_id().str_replace(' ','_',$model->file->name);
						$model->file->saveAs($directory_path.$file_name,false);
						if(!$model->file->saveAs($directory_path.$file_name,false))
						throw new ErrorException("Failed uploading thumb image.");
	
						//save path to db column
						$model->thumb_image = ((isset($_SERVER['HTTPS'])) ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'].'/cmp/'.$directory_path.$file_name;
						$model->save();
						if(count($model->errors)!=0)
						throw new ErrorException("Upload collateral thumb image failed.");
					}
					else
					throw new ErrorException($path->errorMessage);
				}
				
				//save collateral medias
				$modelCollateralsMedias->load(Yii::$app->request->post());
				$modelCollateralsMedias->thumb_image = $model->thumb_image;
				$modelCollateralsMedias->media_title = $model->title;
				$modelCollateralsMedias->save();
				if(count($modelCollateralsMedias->errors)!=0)
				throw new ErrorException("Update collateral media failed.");
				
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
		
		return $this->render('update', [
			'model' => $model,
			'modelCollateralsMedias' => $modelCollateralsMedias,
			'projectList' => $projectList,
			'collateralMediaTypeList' => $collateralMediaTypeList,
		]);
    }
	
	public function actionViewMedia($id)
	{
		$modelCollateralsMedias = $this->findModelCollateralsMedias($id);
		$modelCollaterals = $this->findModel($modelCollateralsMedias->collateral_id);
		
		return $this->render('view-media', [
			'modelCollaterals' => $modelCollaterals,
			'modelCollateralsMedias' => $modelCollateralsMedias,
		]);
	}
	
	public function actionCreateMedia($id)
	{
		$modelCollaterals = $this->findModel($id);
		$modelCollateralsMedias = new CollateralsMedias();
		$modelCollateralsMedias->collateral_id = $id;
		$modelCollateralsMedias->published = 1;
		$modelCollateralsMedias->scenario = 'create';
		
		//get collateral media types
		$collateralMediaTypeList = LookupCollateralMediaTypes::find()->where(array('deleted'=>0))->asArray()->all();
		
		if(count($_POST)!=0)
		{
			$error = '';
			$connection = \Yii::$app->db;
			$transaction = $connection->beginTransaction();
			try 
			{				
				$modelCollateralsMedias->load(Yii::$app->request->post());
								
				//save whats new image
				if($_FILES['CollateralsMedias']['error']['file']!=4)
				{					
					//directory path
					$directory_path = 'contents/collateral-media/'.$modelCollaterals->id.'/';
					if(($path = Yii::$app->AccessMod->createDirectory($directory_path)))
					{
						//get the instance of uploaded file
						$modelCollateralsMedias->file = UploadedFile::getInstance($modelCollateralsMedias,'file');	
						
						$imageDimension = getimagesize($modelCollateralsMedias->file->tempName);							
						$imageWidth = $imageDimension[0];
						$imageHeight = $imageDimension[1];
						if($imageWidth > $_SESSION['settings']['COLLATERAL_MEDIA_THUMB_IMAGE_WIDTH'] || $imageHeight > $_SESSION['settings']['COLLATERAL_MEDIA_THUMB_IMAGE_HEIGHT'])
						throw new ErrorException("Thumb image width cannot more than ".$_SESSION['settings']['COLLATERAL_MEDIA_THUMB_IMAGE_WIDTH']."px and height cannot more than ".$_SESSION['settings']['COLLATERAL_MEDIA_THUMB_IMAGE_HEIGHT']."px");
						
						//validate image size
						if($modelCollateralsMedias->file->size > 10000000)
						throw new ErrorException("Thumb image size cannot larger than 10MB");
											
						$file_name = session_id().str_replace(' ','_',$modelCollateralsMedias->file->name);
						$modelCollateralsMedias->file->saveAs($directory_path.$file_name,false);
						if(!$modelCollateralsMedias->file->saveAs($directory_path.$file_name,false))
						throw new ErrorException("Failed uploading thumb image.");
	
						//save path to db column
						$modelCollateralsMedias->thumb_image = ((isset($_SERVER['HTTPS'])) ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'].'/cmp/'.$directory_path.$file_name;
					}
					else
					throw new ErrorException($path->errorMessage);
				}
				
				if($modelCollateralsMedias->collateral_media_type_id==4)
				{
					//validate embedded video id
					if(strlen($modelCollateralsMedias->media_value))
					{
						if(preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $modelCollateralsMedias->media_value, $youtubeID)==1)
						{
							if(in_array('HTTP/1.0 200 OK',get_headers('https://youtu.be/'.$youtubeID[0])))
							$modelCollateralsMedias->media_value = $youtubeID[0];
						}
						else
						{
							if(in_array('HTTP/1.0 200 OK',get_headers('https://youtu.be/'.$modelCollateralsMedias->media_value)))
							$modelCollateralsMedias->media_value = $modelCollateralsMedias->media_value;
						}
					}
				}
				else
				{
					$modelCollateralsMedias->media_value = $modelCollateralsMedias->media_value;
				}
				
				$modelCollateralsMedias->file = 'test';
				$modelCollateralsMedias->image = 'test';
				$modelCollateralsMedias->brochure = 'test';
				$modelCollateralsMedias->youtube = 'test';
				
				$modelCollateralsMedias->createdby = $_SESSION['user']['id'];
				$modelCollateralsMedias->createdat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
				$modelCollateralsMedias->save();
				
				if(count($modelCollateralsMedias->errors)!=0)
				throw new ErrorException("Create collateral media failed.");
				
				$transaction->commit();
			}
			catch (ErrorException $e) 
			{
				$transaction->rollBack();
				$error = $e->getMessage();
			}
								
			if(!strlen($error))
			return $this->redirect(['view', 'id' => $modelCollaterals->id]);
			else
			Yii::$app->session->set('errorMessage', $error);
		}
		
		return $this->render('create-media', [
			'modelCollaterals' => $modelCollaterals,
			'modelCollateralsMedias' => $modelCollateralsMedias,
			'collateralMediaTypeList' => $collateralMediaTypeList,
		]);
	}
	
	public function actionUpdateMedia($id)
	{
		$modelCollateralsMedias = $this->findModelCollateralsMedias($id);
		$modelCollaterals = $this->findModel($modelCollateralsMedias->collateral_id);
		
		//get collateral media type list
		$collateralMediaTypeList = LookupCollateralMediaTypes::find()->where(array('deleted'=>0))->asArray()->all();
		
		if(count($_POST)!=0)
		{
			$modelCollateralsMedias->load(Yii::$app->request->post());
			
			$error = '';
			$connection = \Yii::$app->db;
			$transaction = $connection->beginTransaction();
			try 
			{				
				$modelCollateralsMedias->load(Yii::$app->request->post());
								
				//save whats new image
				if($_FILES['CollateralsMedias']['error']['file']!=4)
				{					
					//directory path
					$directory_path = 'contents/collateral-media/'.$modelCollaterals->id.'/';
					if(($path = Yii::$app->AccessMod->createDirectory($directory_path)))
					{
						//get the instance of uploaded file
						$modelCollateralsMedias->file = UploadedFile::getInstance($modelCollateralsMedias,'file');	
						
						$imageDimension = getimagesize($modelCollateralsMedias->file->tempName);							
						$imageWidth = $imageDimension[0];
						$imageHeight = $imageDimension[1];
						if($imageWidth > $_SESSION['settings']['COLLATERAL_MEDIA_THUMB_IMAGE_WIDTH'] || $imageHeight > $_SESSION['settings']['COLLATERAL_MEDIA_THUMB_IMAGE_HEIGHT'])
						throw new ErrorException("Thumb image width cannot more than ".$_SESSION['settings']['COLLATERAL_MEDIA_THUMB_IMAGE_WIDTH']."px and height cannot more than ".$_SESSION['settings']['COLLATERAL_MEDIA_THUMB_IMAGE_HEIGHT']."px");
						
						//validate image size
						if($modelCollateralsMedias->file->size > 10000000)
						throw new ErrorException("Thumb image size cannot larger than 10MB");
											
						$file_name = session_id().str_replace(' ','_',$modelCollateralsMedias->file->name);
						$modelCollateralsMedias->file->saveAs($directory_path.$file_name,false);
						if(!$modelCollateralsMedias->file->saveAs($directory_path.$file_name,false))
						throw new ErrorException("Failed uploading thumb image.");
	
						//save path to db column
						$modelCollateralsMedias->thumb_image = ((isset($_SERVER['HTTPS'])) ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'].'/cmp/'.$directory_path.$file_name;
					}
					else
					throw new ErrorException($path->errorMessage);
				}

				if($modelCollateralsMedias->collateral_media_type_id==4)
				{
					//validate embedded video id
					if(strlen($modelCollateralsMedias->media_value))
					{
						if(preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $modelCollateralsMedias->media_value, $youtubeID)==1)
						{
							if(in_array('HTTP/1.0 200 OK',get_headers('https://youtu.be/'.$youtubeID[0])))
							$modelCollateralsMedias->media_value = $youtubeID[0];
						}
						else
						{
							if(in_array('HTTP/1.0 200 OK',get_headers('https://youtu.be/'.$modelCollateralsMedias->media_value)))
							$modelCollateralsMedias->media_value = $modelCollateralsMedias->media_value;
						}
					}
				}
				else
				{
					$modelCollateralsMedias->media_value = $modelCollateralsMedias->media_value;
				}
				
				$modelCollateralsMedias->file = 'test';
				$modelCollateralsMedias->image = 'test';
				$modelCollateralsMedias->brochure = 'test';
				$modelCollateralsMedias->youtube = 'test';
				
				$modelCollateralsMedias->createdby = $_SESSION['user']['id'];
				$modelCollateralsMedias->createdat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
				$modelCollateralsMedias->save();
				
				if(count($modelCollateralsMedias->errors)!=0)
				throw new ErrorException("Update collateral media failed.");
				
				$transaction->commit();
			}
			catch (ErrorException $e) 
			{
				$transaction->rollBack();
				$error = $e->getMessage();
			}
								
			if(!strlen($error))
			return $this->redirect(['view', 'id' => $modelCollaterals->id]);
			else
			Yii::$app->session->set('errorMessage', $error);
		}
		
		return $this->render('update-media', [
			'modelCollaterals' => $modelCollaterals,
			'modelCollateralsMedias' => $modelCollateralsMedias,
			'collateralMediaTypeList' => $collateralMediaTypeList,
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
	
	public function actionDeleteMedia($id)
    {
        $model = $this->findModelCollateralsMedias($id);
		$model->published = 0;
		$model->deletedby = $_SESSION['user']['id'];
		$model->deletedat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
		$model->save();

		return $this->redirect(['view', 'id' => $model->collateral_id]);
    }

    protected function findModel($id)
    {
        if (($model = Collaterals::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	
    protected function findModelCollateralsMedias($id)
    {
        if (($model = CollateralsMedias::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
