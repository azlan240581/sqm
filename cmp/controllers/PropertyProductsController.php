<?php

namespace app\controllers;

use Yii;
use app\models\PropertyProducts;
use app\models\PropertyProductsSearch;

use app\models\PropertyProductMedias;
use app\models\PropertyProductMediasSearch;

use app\models\Projects;
use app\models\ProjectProducts;
use app\models\ProjectAgents;
use app\models\Collaterals;

use app\models\LookupPropertyProductTypes;
use app\models\LookupProductStatus;
use app\models\LookupMediaTypes;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\base\ErrorException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\helpers\Html;
use yii\helpers\Json;

/**
 * PropertyProductsController implements the CRUD actions for PropertyProducts model.
 */
class PropertyProductsController extends Controller
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
				$searchModel = new PropertyProductsSearch();
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
			$searchModel = new PropertyProductsSearch();
			$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
			//get project list
			$projectList = Projects::find()
								->where(array('status'=>1,'deletedby'=>NULL,'deletedat'=>NULL,))
								->orderBy(array('project_name' => SORT_ASC,))
								->asArray()
								->all();
		}
		
		//get propery product type
		$lookupPropertyProductTypeList = LookupPropertyProductTypes::find()->where(array('deleted'=>0))->asArray()->all();
		
		//get propery product type
		$lookupProductStatusList = LookupProductStatus::find()->where(array('deleted'=>0))->asArray()->all();
		
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'projectList' => $projectList,
            'lookupPropertyProductTypeList' => $lookupPropertyProductTypeList,
            'lookupProductStatusList' => $lookupProductStatusList,
        ]);
    }

    public function actionView($id)
    {
		$model = $this->findModel($id);
        $searchModelPropertyProductMedias = new PropertyProductMediasSearch(['product_id'=>$model->id]);
        $dataProviderPropertyProductMedias = $searchModelPropertyProductMedias->search(Yii::$app->request->queryParams);
		
		//get lookup media type list
		$lookupMediaTypeList = LookupMediaTypes::find()->where(array('deleted'=>0))->asArray()->all();
		
        return $this->render('view', [
            'model' => $model,
            'searchModelPropertyProductMedias' => $searchModelPropertyProductMedias,
            'dataProviderPropertyProductMedias' => $dataProviderPropertyProductMedias,
            'lookupMediaTypeList' => $lookupMediaTypeList,
        ]);
    }

    public function actionCreate()
    {
        $model = new PropertyProducts();
		$model->scenario = 'create';
		
		$modelPropertyProductMedias = new PropertyProductMedias();
		$modelPropertyProductMedias->scenario = 'create';
		$modelPropertyProductMedias->published = 1;
		
        $modelProjectProducts = new ProjectProducts();
        $modelCollaterals = new Collaterals();
		
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
		
		//get project product list
		$projectProductList = array();
		if(isset($_REQUEST['get_project_product_list']))
		{
			$projectProductArray = $modelProjectProducts->getProjectProductList($_REQUEST['get_project_product_list'],'','');
			if(count($projectProductArray)!=0)
			{
				foreach($projectProductArray as $key=>$value)
				{
					$projectProductList[$key]['id'] = $value['id'];
					$projectProductList[$key]['name'] = $value['product_name'];
				}
			}
			echo json_encode($projectProductList);
			exit();
		}
		
		//get collateral list
		$collateralObj = array();
		if(isset($_REQUEST['get_collateral_list']))
		{
			$collateralArray = $modelCollaterals->getCollateralList($_REQUEST['get_collateral_list'],'','');
			if(count($collateralArray)!=0)
			{
				foreach($collateralArray as $key=>$value)
				{
					$collateralList[$key]['id'] = $value['id'];
					$collateralList[$key]['name'] = $value['title'];
				}
			}
			echo json_encode($collateralList);
			exit();
		}
		
		//get propery product type
		$propertyProductTypeList = LookupPropertyProductTypes::find()->where(array('deleted'=>0))->asArray()->all();
		
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
			$connection = \Yii::$app->db;
			$transaction = $connection->beginTransaction();
			try 
			{
				$model->load(Yii::$app->request->post());
				
				if(empty($model->project_product_id))
				throw new ErrorException("Please select project product failed.");
								
				$model->property_type_id = 1;
				$model->description = htmlentities($model->description);
				$model->collaterals_id = serialize(Json::decode($model->collaterals_id));
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

				if($_SESSION['user']['id']==1 or in_array(Yii::$app->AccessMod->getUserGroupID($_SESSION['user']['id']),array(1,2,3,7,8)))
				$model->status = 3;
				else
				$model->status = 1;
				
				$model->createdby = $_SESSION['user']['id'];
				$model->createdat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
				$model->save();
				
				if(count($model->errors)!=0)
				throw new ErrorException("Create property product failed.");
				
				//directory path
				$directory_path = 'contents/property-product/'.$model->id.'/';
				//create directory based on id
				Yii::$app->AccessMod->createDirectory($directory_path);
				
				//save whats new image
				if($_FILES['PropertyProducts']['error']['file']!=4)
				{					
					//directory path
					$directory_path = 'contents/property-product/'.$model->id.'/';
					if(($path = Yii::$app->AccessMod->createDirectory($directory_path)))
					{
						//get the instance of uploaded file
						$model->file = UploadedFile::getInstance($model,'file');	
												
						$imageDimension = getimagesize($model->file->tempName);							
						$imageWidth = $imageDimension[0];
						$imageHeight = $imageDimension[1];
						if($imageWidth > $_SESSION['settings']['PRODUCT_MEDIA_THUMB_IMAGE_WIDTH'] || $imageHeight > $_SESSION['settings']['PRODUCTS_MEDIA_THUMB_IMAGE_HEIGHT'])
						throw new ErrorException("Thumb image width cannot more than ".$_SESSION['settings']['PRODUCT_MEDIA_THUMB_IMAGE_WIDTH']."px and height cannot more than ".$_SESSION['settings']['PRODUCTS_MEDIA_THUMB_IMAGE_HEIGHT']."px");
						
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
						throw new ErrorException("Upload property product thumb image failed.");
					}
					else
					throw new ErrorException($path->errorMessage);
				}
				
				$modelPropertyProductMedias->load(Yii::$app->request->post());
								
				//save whats new image
				if($_FILES['PropertyProductMedias']['error']['file']!=4)
				{					
					//directory path
					$directory_path = 'contents/property-product/'.$model->id.'/';
					if(($path = Yii::$app->AccessMod->createDirectory($directory_path)))
					{
						//get the instance of uploaded file
						$modelPropertyProductMedias->file = UploadedFile::getInstance($modelPropertyProductMedias,'file');	
						
						$imageDimension = getimagesize($modelPropertyProductMedias->file->tempName);							
						$imageWidth = $imageDimension[0];
						$imageHeight = $imageDimension[1];
						if($imageWidth > $_SESSION['settings']['PRODUCT_MEDIA_THUMB_IMAGE_WIDTH'] || $imageHeight > $_SESSION['settings']['PRODUCTS_MEDIA_THUMB_IMAGE_HEIGHT'])
						throw new ErrorException("Thumb image width cannot more than ".$_SESSION['settings']['PRODUCT_MEDIA_THUMB_IMAGE_WIDTH']."px and height cannot more than ".$_SESSION['settings']['PRODUCTS_MEDIA_THUMB_IMAGE_HEIGHT']."px");
						
						//validate image size
						if($modelPropertyProductMedias->file->size > 10000000)
						throw new ErrorException("Thumb image size cannot larger than 10MB");
											
						$file_name = session_id().str_replace(' ','_',$modelPropertyProductMedias->file->name);
						$modelPropertyProductMedias->file->saveAs($directory_path.$file_name,false);
						if(!$modelPropertyProductMedias->file->saveAs($directory_path.$file_name,false))
						throw new ErrorException("Failed uploading thumb image.");
	
						//save path to db column
						$modelPropertyProductMedias->thumb_image = ((isset($_SERVER['HTTPS'])) ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'].'/cmp/'.$directory_path.$file_name;
					}
					else
					throw new ErrorException($path->errorMessage);
				}

				if($_FILES['PropertyProductMedias']['error']['image']!=4)
				{					
					//directory path
					$directory_path = 'contents/property-product/'.$model->id.'/';
					if(($path = Yii::$app->AccessMod->createDirectory($directory_path)))
					{
						//get the instance of uploaded file
						$modelPropertyProductMedias->image = UploadedFile::getInstance($modelPropertyProductMedias,'image');	
													
						//validate image size
						if($modelPropertyProductMedias->image->size > 10000000)
						throw new ErrorException("Image size cannot larger than 10MB");
											
						$file_name = session_id().str_replace(' ','_',$modelPropertyProductMedias->image->name);
						$modelPropertyProductMedias->image->saveAs($directory_path.$file_name,false);
						if(!$modelPropertyProductMedias->image->saveAs($directory_path.$file_name,false))
						throw new ErrorException("Failed uploading image.");
	
						//save path to db column
						$modelPropertyProductMedias->media_value = ((isset($_SERVER['HTTPS'])) ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'].'/cmp/'.$directory_path.$file_name;
					}
					else
					throw new ErrorException($path->errorMessage);
				}
				
				$modelPropertyProductMedias->file = 'test';
				$modelPropertyProductMedias->image = 'test';
				$modelPropertyProductMedias->youtube = 'test';
				
				$modelPropertyProductMedias->media_type_id = 1;
				$modelPropertyProductMedias->product_id = $model->id;
				$modelPropertyProductMedias->createdby = $_SESSION['user']['id'];
				$modelPropertyProductMedias->createdat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
				$modelPropertyProductMedias->save();
				
				if(count($modelPropertyProductMedias->errors)!=0)
				throw new ErrorException("Create property product media failed.");
				
				$transaction->commit();
			}
			catch (ErrorException $e) 
			{
				$transaction->rollBack();
				$error = $e->getMessage();
				Yii::$app->session->set('errorMessage', $error);
				$model->collaterals_id = json_encode(unserialize($model->collaterals_id));
				$model->description = html_entity_decode($model->description);
			}
			
			if(!strlen($error))
            return $this->redirect(['view', 'id' => $model->id]);
        }
		
		return $this->render('create', [
			'model' => $model,
			'modelPropertyProductMedias' => $modelPropertyProductMedias,
			'projectList' => $projectList,
			'projectProductList' => $projectProductList,
			'collateralObj' => $collateralObj,
			'propertyProductTypeList' => $propertyProductTypeList,
		]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->description = html_entity_decode($model->description);
        $modelProjectProducts = new ProjectProducts();
        $modelCollaterals = new Collaterals();
		
		//get project list
		$projectList = Projects::find()
							->where(array('status'=>1,'deletedby'=>NULL,'deletedat'=>NULL,))
							->orderBy(array('project_name' => SORT_ASC,))
							->asArray()
							->all();
		
		//get project product list
		$projectProductList = array();
		$projectProductArray = $modelProjectProducts->getProjectProductList($model->project_id);
		if(count($projectProductArray)!=0)
		{
			foreach($projectProductArray as $key=>$value)
			{
				$projectProductList[$key]['id'] = $value['id'];
				$projectProductList[$key]['name'] = $value['product_name'];
			}
		}
		
		//get collateral list
		$model->collaterals_id = json_encode(unserialize($model->collaterals_id));
		$collateralList = array();
		$collateralObj = array();
		$collateralArray = $modelCollaterals->getCollateralList($model->project_id,'','');		
		if($collateralArray!=NULL)
		{
			if(count($collateralArray)!=0)
			{
				foreach($collateralArray as $key=>$value)
				{
					$collateralList[$key]['id'] = $value['id'];
					$collateralList[$key]['name'] = $value['title'];
				}
			}
			if(count($collateralList)!=0)
			{
				foreach($collateralList as $collateral)
				{
					$collateralObj[] = (object)$collateral;
				}
			}
		}
			
				
		//get propery product type
		$propertyProductTypeList = LookupPropertyProductTypes::find()->where(array('deleted'=>0))->asArray()->all();

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
			$connection = \Yii::$app->db;
			$transaction = $connection->beginTransaction();
			try 
			{
				$model->load(Yii::$app->request->post());
				$model->description = htmlentities($model->description);
				$model->collaterals_id = serialize(Json::decode($model->collaterals_id));
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
				throw new ErrorException("Update property product failed.");
				
				//save whats new image
				if($_FILES['PropertyProducts']['error']['file']!=4)
				{					
					//directory path
					$directory_path = 'contents/property-product/'.$model->id.'/';
					if(($path = Yii::$app->AccessMod->createDirectory($directory_path)))
					{
						//get the instance of uploaded file
						$model->file = UploadedFile::getInstance($model,'file');	
												
						$imageDimension = getimagesize($model->file->tempName);							
						$imageWidth = $imageDimension[0];
						$imageHeight = $imageDimension[1];
						if($imageWidth > $_SESSION['settings']['PRODUCT_MEDIA_THUMB_IMAGE_WIDTH'] || $imageHeight > $_SESSION['settings']['PRODUCTS_MEDIA_THUMB_IMAGE_HEIGHT'])
						throw new ErrorException("Thumb image width cannot more than ".$_SESSION['settings']['PRODUCT_MEDIA_THUMB_IMAGE_WIDTH']."px and height cannot more than ".$_SESSION['settings']['PRODUCTS_MEDIA_THUMB_IMAGE_HEIGHT']."px");
						
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
						throw new ErrorException("Upload property product thumb image failed.");
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
				$model->collaterals_id = json_encode(unserialize($model->collaterals_id));
				$model->description = html_entity_decode($model->description);
			}
			
			if(!strlen($error))
            return $this->redirect(['view', 'id' => $model->id]);
        }
		
		return $this->render('update', [
			'model' => $model,
			'projectList' => $projectList,
			'projectProductList' => $projectProductList,
			'collateralObj' => $collateralObj,
			'propertyProductTypeList' => $propertyProductTypeList,
		]);
    }
	
	public function actionViewMedia($id)
	{
        $model = $this->findModelPropertyProductMedias($id);
        $modelPropertyProducts = $this->findModel($model->product_id);
		
        return $this->render('view-media', [
            'model' => $model,
            'modelPropertyProducts' => $modelPropertyProducts,
        ]);
	}
	
	public function actionCreateMedia($id)
	{
        $modelPropertyProducts = $this->findModel($id);
		$modelPropertyProductMedias = new PropertyProductMedias();
		$modelPropertyProductMedias->scenario = 'create';
		$modelPropertyProductMedias->published = 1;
		
		//get lookup media type
		$lookupMediaTypeList = LookupMediaTypes::find()->where(array('deleted'=>0))->asArray()->all();
		
		if(count($_POST)!=0)
		{
			$error = '';
			$connection = \Yii::$app->db;
			$transaction = $connection->beginTransaction();
			try 
			{				
				$modelPropertyProductMedias->load(Yii::$app->request->post());
								
				//save whats new image
				if($_FILES['PropertyProductMedias']['error']['file']!=4)
				{					
					//directory path
					$directory_path = 'contents/property-product/'.$modelPropertyProducts->id.'/';
					if(($path = Yii::$app->AccessMod->createDirectory($directory_path)))
					{
						//get the instance of uploaded file
						$modelPropertyProductMedias->file = UploadedFile::getInstance($modelPropertyProductMedias,'file');	
						
						$imageDimension = getimagesize($modelPropertyProductMedias->file->tempName);							
						$imageWidth = $imageDimension[0];
						$imageHeight = $imageDimension[1];
						if($imageWidth > $_SESSION['settings']['PRODUCT_MEDIA_THUMB_IMAGE_WIDTH'] || $imageHeight > $_SESSION['settings']['PRODUCTS_MEDIA_THUMB_IMAGE_HEIGHT'])
						throw new ErrorException("Thumb image width cannot more than ".$_SESSION['settings']['PRODUCT_MEDIA_THUMB_IMAGE_WIDTH']."px and height cannot more than ".$_SESSION['settings']['PRODUCTS_MEDIA_THUMB_IMAGE_HEIGHT']."px");
						
						//validate image size
						if($modelPropertyProductMedias->file->size > 10000000)
						throw new ErrorException("Thumb image size cannot larger than 10MB");
											
						$file_name = session_id().str_replace(' ','_',$modelPropertyProductMedias->file->name);
						$modelPropertyProductMedias->file->saveAs($directory_path.$file_name,false);
						if(!$modelPropertyProductMedias->file->saveAs($directory_path.$file_name,false))
						throw new ErrorException("Failed uploading thumb image.");
	
						//save path to db column
						$modelPropertyProductMedias->thumb_image = ((isset($_SERVER['HTTPS'])) ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'].'/cmp/'.$directory_path.$file_name;
					}
					else
					throw new ErrorException($path->errorMessage);
				}

				if($modelPropertyProductMedias->media_type_id==1)//image
				{
					if($_FILES['PropertyProductMedias']['error']['image']!=4)
					{					
						//directory path
						$directory_path = 'contents/property-product/'.$modelPropertyProducts->id.'/';
						if(($path = Yii::$app->AccessMod->createDirectory($directory_path)))
						{
							//get the instance of uploaded file
							$modelPropertyProductMedias->image = UploadedFile::getInstance($modelPropertyProductMedias,'image');	
														
							//validate image size
							if($modelPropertyProductMedias->image->size > 10000000)
							throw new ErrorException("Image size cannot larger than 10MB");
												
							$file_name = session_id().str_replace(' ','_',$modelPropertyProductMedias->image->name);
							$modelPropertyProductMedias->image->saveAs($directory_path.$file_name,false);
							if(!$modelPropertyProductMedias->image->saveAs($directory_path.$file_name,false))
							throw new ErrorException("Failed uploading image.");
		
							//save path to db column
							$modelPropertyProductMedias->media_value = ((isset($_SERVER['HTTPS'])) ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'].'/cmp/'.$directory_path.$file_name;
						}
						else
						throw new ErrorException($path->errorMessage);
					}
				}
				elseif($modelPropertyProductMedias->media_type_id==2)//youtube
				{
					//validate embedded video id
					if(strlen($modelPropertyProductMedias->youtube))
					{
						if(preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $modelPropertyProductMedias->youtube, $youtubeID)==1)
						{
							if(in_array('HTTP/1.0 200 OK',get_headers('https://youtu.be/'.$youtubeID[0])))
							$modelPropertyProductMedias->media_value = $youtubeID[0];
						}
						else
						{
							if(in_array('HTTP/1.0 200 OK',get_headers('https://youtu.be/'.$modelPropertyProductMedias->youtube)))
							$modelPropertyProductMedias->media_value = $modelPropertyProductMedias->youtube;
						}
					}
				}
				$modelPropertyProductMedias->file = 'test';
				$modelPropertyProductMedias->image = 'test';
				$modelPropertyProductMedias->youtube = 'test';
				
				$modelPropertyProductMedias->product_id = $modelPropertyProducts->id;
				$modelPropertyProductMedias->createdby = $_SESSION['user']['id'];
				$modelPropertyProductMedias->createdat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
				$modelPropertyProductMedias->save();
				
				if(count($modelPropertyProductMedias->errors)!=0)
				throw new ErrorException("Create property product media failed.");
				
				$transaction->commit();
			}
			catch (ErrorException $e) 
			{
				$transaction->rollBack();
				$error = $e->getMessage();
				Yii::$app->session->set('errorMessage', $error);
			}
								
			if(!strlen($error))
			return $this->redirect(['view', 'id' => $modelPropertyProducts->id]);
		}
		
		return $this->render('create-media', [
			'modelPropertyProducts' => $modelPropertyProducts,
			'modelPropertyProductMedias' => $modelPropertyProductMedias,
			'lookupMediaTypeList' => $lookupMediaTypeList,
		]);
	}

	public function actionUpdateMedia($id)
	{
        $modelPropertyProductMedias = $this->findModelPropertyProductMedias($id);
        $modelPropertyProducts = $this->findModel($modelPropertyProductMedias->product_id);
		
		//get lookup media type
		$lookupMediaTypeList = LookupMediaTypes::find()->where(array('deleted'=>0))->asArray()->all();
		
		if(count($_POST)!=0)
		{
			$error = '';
			$connection = \Yii::$app->db;
			$transaction = $connection->beginTransaction();
			try 
			{				
				//$modelPropertyProductMedias->load(Yii::$app->request->post());
													
				//save whats new image
				if($_FILES['PropertyProductMedias']['error']['file']!=4)
				{					
					//directory path
					$directory_path = 'contents/property-product/'.$modelPropertyProducts->id.'/';
					if(($path = Yii::$app->AccessMod->createDirectory($directory_path)))
					{
						//get the instance of uploaded file
						$modelPropertyProductMedias->file = UploadedFile::getInstance($modelPropertyProductMedias,'file');	
						
						$imageDimension = getimagesize($modelPropertyProductMedias->file->tempName);							
						$imageWidth = $imageDimension[0];
						$imageHeight = $imageDimension[1];
						if($imageWidth > $_SESSION['settings']['PRODUCT_MEDIA_THUMB_IMAGE_WIDTH'] || $imageHeight > $_SESSION['settings']['PRODUCTS_MEDIA_THUMB_IMAGE_HEIGHT'])
						throw new ErrorException("Thumb image width cannot more than ".$_SESSION['settings']['PRODUCT_MEDIA_THUMB_IMAGE_WIDTH']."px and height cannot more than ".$_SESSION['settings']['PRODUCTS_MEDIA_THUMB_IMAGE_HEIGHT']."px");
						
						//validate image size
						if($modelPropertyProductMedias->file->size > 10000000)
						throw new ErrorException("Thumb image size cannot larger than 10MB");
											
						$file_name = session_id().str_replace(' ','_',$modelPropertyProductMedias->file->name);
						$modelPropertyProductMedias->file->saveAs($directory_path.$file_name,false);
						if(!$modelPropertyProductMedias->file->saveAs($directory_path.$file_name,false))
						throw new ErrorException("Failed uploading thumb image.");
	
						//save path to db column
						$modelPropertyProductMedias->thumb_image = ((isset($_SERVER['HTTPS'])) ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'].'/cmp/'.$directory_path.$file_name;
					}
					else
					throw new ErrorException($path->errorMessage);
				}

				if($_POST['PropertyProductMedias']['media_type_id']==1)//image
				{
					if($_FILES['PropertyProductMedias']['error']['image']!=4)
					{					
						//directory path
						$directory_path = 'contents/property-product/'.$modelPropertyProducts->id.'/';
						if(($path = Yii::$app->AccessMod->createDirectory($directory_path)))
						{
							//get the instance of uploaded file
							$modelPropertyProductMedias->image = UploadedFile::getInstance($modelPropertyProductMedias,'image');	
														
							//validate image size
							if($modelPropertyProductMedias->image->size > 10000000)
							throw new ErrorException("Image size cannot larger than 10MB");
												
							$file_name = session_id().str_replace(' ','_',$modelPropertyProductMedias->image->name);
							$modelPropertyProductMedias->image->saveAs($directory_path.$file_name,false);
							if(!$modelPropertyProductMedias->image->saveAs($directory_path.$file_name,false))
							throw new ErrorException("Failed uploading image.");
		
							//save path to db column
							$modelPropertyProductMedias->media_value = ((isset($_SERVER['HTTPS'])) ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'].'/cmp/'.$directory_path.$file_name;
						}
						else
						throw new ErrorException($path->errorMessage);
					}
				}
				/*if($modelPropertyProductMedias->media_type_id==2)//youtube
				{
					//validate embedded video id
					if(strlen($modelPropertyProductMedias->youtube))
					{
						if(preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $modelPropertyProductMedias->youtube, $youtubeID)==1)
						{
							if(in_array('HTTP/1.0 200 OK',get_headers('https://youtu.be/'.$youtubeID[0])))
							$modelPropertyProductMedias->media_value = $youtubeID[0];
						}
						else
						{
							if(in_array('HTTP/1.0 200 OK',get_headers('https://youtu.be/'.$modelPropertyProductMedias->youtube)))
							$modelPropertyProductMedias->media_value = $modelPropertyProductMedias->youtube;
						}
					}
				}*/
				if($_POST['PropertyProductMedias']['media_type_id']==2)//youtube
				{
					//validate embedded video id
					if(strlen($_POST['PropertyProductMedias']['youtube']))
					{
						if(preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $_POST['PropertyProductMedias']['youtube'], $youtubeID)==1)
						{
							if(in_array('HTTP/1.0 200 OK',get_headers('https://youtu.be/'.$youtubeID[0])))
							$modelPropertyProductMedias->media_value = $youtubeID[0];
						}
						else
						{
							if(in_array('HTTP/1.0 200 OK',get_headers('https://youtu.be/'.$_POST['PropertyProductMedias']['youtube'])))
							$modelPropertyProductMedias->media_value = $_POST['PropertyProductMedias']['youtube'];
						}
					}
				}
				
				$modelPropertyProductMedias->file = 'test';
				$modelPropertyProductMedias->image = 'test';
				$modelPropertyProductMedias->youtube = 'test';
				
				$modelPropertyProductMedias->createdby = $_SESSION['user']['id'];
				$modelPropertyProductMedias->createdat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
				
				$modelPropertyProductMedias->save();
				
				if(count($modelPropertyProductMedias->errors)!=0)
				throw new ErrorException("Update property product media failed.");
				
				$transaction->commit();
			}
			catch (ErrorException $e) 
			{
				$transaction->rollBack();
				$error = $e->getMessage();
				Yii::$app->session->set('errorMessage', $error);
			}
								
			if(!strlen($error))
			return $this->redirect(['view', 'id' => $modelPropertyProducts->id]);
		}
		
		return $this->render('update-media', [
			'modelPropertyProducts' => $modelPropertyProducts,
			'modelPropertyProductMedias' => $modelPropertyProductMedias,
			'lookupMediaTypeList' => $lookupMediaTypeList,
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
	
    public function actionDeleteMedia($id)
    {
        $modelPropertyProductMedias = $this->findModelPropertyProductMedias($id);
		$modelPropertyProductMedias->deletedby = $_SESSION['user']['id'];
		$modelPropertyProductMedias->deletedat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
		$modelPropertyProductMedias->save();

		return $this->redirect(['view', 'id' => $modelPropertyProductMedias->product_id]);
    }

    protected function findModel($id)
    {
        if (($model = PropertyProducts::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	
    protected function findModelPropertyProductMedias($id)
    {
        if (($model = PropertyProductMedias::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
