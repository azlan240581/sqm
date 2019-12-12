<?php

namespace app\controllers;

use Yii;
use app\models\NewsFeeds;
use app\models\NewsFeedsSearch;

use app\models\NewsFeedMedias;
use app\models\NewsFeedMediasSearch;

use app\models\Projects;
use app\models\ProjectAgents;
use app\models\Collaterals;
use app\models\PropertyProducts;

use app\models\LookupNewsFeedCategories;
use app\models\LookupNewsFeedStatus;
use app\models\LookupMediaTypes;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\base\ErrorException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\helpers\Html;
use yii\helpers\Json;

/**
 * NewsFeedsController implements the CRUD actions for NewsFeeds model.
 */
class NewsFeedsController extends Controller
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
				$searchModel = new NewsFeedsSearch();
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
			$searchModel = new NewsFeedsSearch();
			$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
			//get project list
			$projectList = Projects::find()
								->where(array('status'=>1,'deletedby'=>NULL,'deletedat'=>NULL,))
								->orderBy(array('project_name' => SORT_ASC,))
								->asArray()
								->all();
		}
		
		//get lookup news feed categories
		$lookupNewsFeedCategoryList = LookupNewsFeedCategories::find()->where(array('deleted'=>0))->asArray()->all();

		//get lookup news feed status
		$lookupNewsFeedStatusList = LookupNewsFeedStatus::find()->where(array('deleted'=>0))->asArray()->all();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'projectList' => $projectList,
            'lookupNewsFeedCategoryList' => $lookupNewsFeedCategoryList,
            'lookupNewsFeedStatusList' => $lookupNewsFeedStatusList,
        ]);
    }

    public function actionView($id)
    {
        $model = $this->findModel($id);
        $searchModelNewsFeedMedias = new NewsFeedMediasSearch(['news_feed_id'=>$model->id]);
        $dataProviderNewsFeedMedias = $searchModelNewsFeedMedias->search(Yii::$app->request->queryParams);

		//get lookup media type list
		$lookupMediaTypeList = LookupMediaTypes::find()->where(array('deleted'=>0))->asArray()->all();

        return $this->render('view', [
            'model' => $model,
            'searchModelNewsFeedMedias' => $searchModelNewsFeedMedias,
            'dataProviderNewsFeedMedias' => $dataProviderNewsFeedMedias,
            'lookupMediaTypeList' => $lookupMediaTypeList,
        ]);
    }

    public function actionCreate()
    {
        $model = new NewsFeeds();
		$model->scenario = 'create';
		
        $modelNewsFeedMedias = new NewsFeedMedias();
		$modelNewsFeedMedias->scenario = 'create';
		$modelNewsFeedMedias->published = 1;
		
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

		//get property product list
		$propertyProductList = array();
		if(isset($_REQUEST['get_property_product_list']))
		{
			$propertyProductArray = PropertyProducts::find()
									->where(array('project_id'=>$_REQUEST['get_property_product_list'],'status'=>3,'deletedby'=>NULL,'deletedat'=>NULL,))
									->orderBy(array('title' => SORT_ASC,))
									->asArray()
									->all();
			
			if(count($propertyProductArray)!=0)
			{
				foreach($propertyProductArray as $key=>$value)
				{
					$propertyProductList[$key]['id'] = $value['id'];
					$propertyProductList[$key]['name'] = $value['title'];
				}
			}
			echo json_encode($propertyProductList);
			exit();
		}

		//get collateral list
		$collateralObj = array();
		$collateralList = array();
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
				
		//get lookup news feed categories
		$lookupNewsFeedCategoryList = LookupNewsFeedCategories::find()->where(array('deleted'=>0))->asArray()->all();
		
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
				
				if($model->category_id==2)
				{
					if(strlen($model->promotion_date_range))
					{
						list($promoStartDate, $promoEndDate) = explode(' - ', $model->promotion_date_range);
						$model->promotion_start_date = $promoStartDate;
						$model->promotion_end_date = $promoEndDate;
					}
					$model->promotion_terms_conditions = htmlentities($model->promotion_terms_conditions);
				}
				if($model->category_id==3)
				{
					if(strlen($model->event_at))
					$model->event_at = date('Y-m-d h:i:00', strtotime($model->event_at));
				}
				
				if($_SESSION['user']['id']==1 or in_array(Yii::$app->AccessMod->getUserGroupID($_SESSION['user']['id']),array(1,2,3,7,8)))
				$model->status = 3;
				else
				$model->status = 1;
				
				$model->createdby = $_SESSION['user']['id'];
				$model->createdat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
				$model->save();
				if(count($model->errors)!=0)
				throw new ErrorException("Create news feed failed.");
				
				//directory path
				$directory_path = 'contents/news-feed/'.$model->id.'/';
				//create directory based on id
				Yii::$app->AccessMod->createDirectory($directory_path);
												
				//save whats new image
				if($_FILES['NewsFeeds']['error']['file']!=4)
				{					
					//directory path
					$directory_path = 'contents/news-feed/'.$model->id.'/';
					if(($path = Yii::$app->AccessMod->createDirectory($directory_path)))
					{
						//get the instance of uploaded file
						$model->file = UploadedFile::getInstance($model,'file');	
												
						$imageDimension = getimagesize($model->file->tempName);							
						$imageWidth = $imageDimension[0];
						$imageHeight = $imageDimension[1];
						if($imageWidth > $_SESSION['settings']['NEWS_FEED_MEDIA_THUMB_IMAGE_WIDTH'] || $imageHeight > $_SESSION['settings']['NEWS_FEED_MEDIA_THUMB_IMAGE_HEIGHT'])
						throw new ErrorException("Thumb image width cannot more than ".$_SESSION['settings']['NEWS_FEED_MEDIA_THUMB_IMAGE_WIDTH']."px and height cannot more than ".$_SESSION['settings']['NEWS_FEED_MEDIA_THUMB_IMAGE_HEIGHT']."px");
						
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
						throw new ErrorException("Upload news feed thumb image failed.");
					}
					else
					throw new ErrorException($path->errorMessage);
				}
				
				$modelNewsFeedMedias->load(Yii::$app->request->post());
								
				//save whats new image
				if($_FILES['NewsFeedMedias']['error']['file']!=4)
				{					
					//directory path
					$directory_path = 'contents/news-feed/'.$model->id.'/';
					if(($path = Yii::$app->AccessMod->createDirectory($directory_path)))
					{
						//get the instance of uploaded file
						$modelNewsFeedMedias->file = UploadedFile::getInstance($modelNewsFeedMedias,'file');	
						
						$imageDimension = getimagesize($modelNewsFeedMedias->file->tempName);							
						$imageWidth = $imageDimension[0];
						$imageHeight = $imageDimension[1];
						if($imageWidth > $_SESSION['settings']['NEWS_FEED_MEDIA_THUMB_IMAGE_WIDTH'] || $imageHeight > $_SESSION['settings']['NEWS_FEED_MEDIA_THUMB_IMAGE_HEIGHT'])
						throw new ErrorException("Thumb image width cannot more than ".$_SESSION['settings']['NEWS_FEED_MEDIA_THUMB_IMAGE_WIDTH']."px and height cannot more than ".$_SESSION['settings']['NEWS_FEED_MEDIA_THUMB_IMAGE_HEIGHT']."px");
						
						//validate image size
						if($modelNewsFeedMedias->file->size > 10000000)
						throw new ErrorException("Thumb image size cannot larger than 10MB");
											
						$file_name = session_id().str_replace(' ','_',$modelNewsFeedMedias->file->name);
						$modelNewsFeedMedias->file->saveAs($directory_path.$file_name,false);
						if(!$modelNewsFeedMedias->file->saveAs($directory_path.$file_name,false))
						throw new ErrorException("Failed uploading thumb image.");
	
						//save path to db column
						$modelNewsFeedMedias->thumb_image = ((isset($_SERVER['HTTPS'])) ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'].'/cmp/'.$directory_path.$file_name;
					}
					else
					throw new ErrorException($path->errorMessage);
				}

				if($_FILES['NewsFeedMedias']['error']['image']!=4)
				{					
					//directory path
					$directory_path = 'contents/news-feed/'.$model->id.'/';
					if(($path = Yii::$app->AccessMod->createDirectory($directory_path)))
					{
						//get the instance of uploaded file
						$modelNewsFeedMedias->image = UploadedFile::getInstance($modelNewsFeedMedias,'image');	
													
						//validate image size
						if($modelNewsFeedMedias->image->size > 10000000)
						throw new ErrorException("Image size cannot larger than 10MB");
											
						$file_name = session_id().str_replace(' ','_',$modelNewsFeedMedias->image->name);
						$modelNewsFeedMedias->image->saveAs($directory_path.$file_name,false);
						if(!$modelNewsFeedMedias->image->saveAs($directory_path.$file_name,false))
						throw new ErrorException("Failed uploading image.");
	
						//save path to db column
						$modelNewsFeedMedias->media_value = ((isset($_SERVER['HTTPS'])) ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'].'/cmp/'.$directory_path.$file_name;
					}
					else
					throw new ErrorException($path->errorMessage);
				}
				$modelNewsFeedMedias->file = 'test';
				$modelNewsFeedMedias->image = 'test';
				$modelNewsFeedMedias->youtube = 'test';
				
				$modelNewsFeedMedias->media_type_id = 1;
				$modelNewsFeedMedias->news_feed_id = $model->id;
				$modelNewsFeedMedias->createdby = $_SESSION['user']['id'];
				$modelNewsFeedMedias->createdat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
				$modelNewsFeedMedias->save();
				
				if(count($modelNewsFeedMedias->errors)!=0)
				throw new ErrorException("Create news feed media failed.");
				
				$transaction->commit();
			}
			catch (ErrorException $e) 
			{
				$transaction->rollBack();
				$error = $e->getMessage();
				Yii::$app->session->set('errorMessage', $error);
				$model->collaterals_id = json_encode(unserialize($model->collaterals_id));
				$model->description = html_entity_decode($model->description);
				$model->promotion_terms_conditions = html_entity_decode($model->promotion_terms_conditions);
			}
			
			if(!strlen($error))
            return $this->redirect(['view', 'id' => $model->id]);
        } 
		
		return $this->render('create', [
			'model' => $model,
			'modelNewsFeedMedias' => $modelNewsFeedMedias,
			'projectList' => $projectList,
			'collateralObj' => $collateralObj,
			'propertyProductList' => $propertyProductList,
			'lookupNewsFeedCategoryList' => $lookupNewsFeedCategoryList,
		]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->description = html_entity_decode($model->description);
        $model->promotion_terms_conditions = html_entity_decode($model->promotion_terms_conditions);
		$model->collaterals_id = json_encode(unserialize($model->collaterals_id));
        if(strlen($model->promotion_start_date) and $model->promotion_end_date)
		$model->promotion_date_range = $model->promotion_start_date.' - '.$model->promotion_end_date;
				
		$modelCollaterals = new Collaterals();
		
		//get project list
		$projectList = Projects::find()
							->where(array('status'=>1,'deletedby'=>NULL,'deletedat'=>NULL,))
							->orderBy(array('project_name' => SORT_ASC,))
							->asArray()
							->all();
		
		//get collateral list
		$collateralList = array();
		$collateralObj = array();
		$collateralArray = $modelCollaterals->getCollateralList($model->project_id,'','');
		if($collateralArray!=NULL)
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
		
		//get property product list
		$propertyProductList = array();
		$propertyProductArray = PropertyProducts::find()
							->where(array('project_id'=>$model->project_id,'status'=>3,'deletedby'=>NULL,'deletedat'=>NULL,))
							->orderBy(array('title' => SORT_ASC,))
							->asArray()
							->all();
		if(count($propertyProductArray)!=0)
		{
			foreach($propertyProductArray as $key=>$value)
			{
				$propertyProductList[$key]['id'] = $value['id'];
				$propertyProductList[$key]['name'] = $value['title'];
			}
		}
				
		//get lookup news feed category list
		$lookupNewsFeedCategoryList = LookupNewsFeedCategories::find()->where(array('deleted'=>0))->asArray()->all();

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
				
				if($model->category_id==2)
				{
					if(strlen($model->promotion_date_range))
					{
						list($promoStartDate, $promoEndDate) = explode(' - ', $model->promotion_date_range);
						$model->promotion_start_date = $promoStartDate;
						$model->promotion_end_date = $promoEndDate;
					}
					$model->promotion_terms_conditions = htmlentities($model->promotion_terms_conditions);
				}
				if($model->category_id==3)
				{
				
				}
				
				$model->updatedby = $_SESSION['user']['id'];
				$model->updatedat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
				$model->save();
				if(count($model->errors)!=0)
				throw new ErrorException("Update news feed failed.");
						
				//save whats new image
				if($_FILES['NewsFeeds']['error']['file']!=4)
				{					
					//directory path
					$directory_path = 'contents/news-feed/'.$model->id.'/';
					if(($path = Yii::$app->AccessMod->createDirectory($directory_path)))
					{
						//get the instance of uploaded file
						$model->file = UploadedFile::getInstance($model,'file');	
						
						$imageDimension = getimagesize($model->file->tempName);							
						$imageWidth = $imageDimension[0];
						$imageHeight = $imageDimension[1];
						if($imageWidth > $_SESSION['settings']['NEWS_FEED_MEDIA_THUMB_IMAGE_WIDTH'] || $imageHeight > $_SESSION['settings']['NEWS_FEED_MEDIA_THUMB_IMAGE_HEIGHT'])
						throw new ErrorException("Thumb image width cannot more than ".$_SESSION['settings']['NEWS_FEED_MEDIA_THUMB_IMAGE_WIDTH']."px and height cannot more than ".$_SESSION['settings']['NEWS_FEED_MEDIA_THUMB_IMAGE_HEIGHT']."px");
						
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
						throw new ErrorException("Upload news feed thumb image failed.");
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
			'collateralObj' => $collateralObj,
			'propertyProductList' => $propertyProductList,
			'lookupNewsFeedCategoryList' => $lookupNewsFeedCategoryList,
		]);
    }

	public function actionViewMedia($id)
	{
        $model = $this->findModelNewsFeedMedias($id);
        $modelNewsFeeds = $this->findModel($model->news_feed_id);
	
        return $this->render('view-media', [
            'model' => $model,
            'modelNewsFeeds' => $modelNewsFeeds,
        ]);
	}

	public function actionCreateMedia($id)
	{
        $modelNewsFeeds = $this->findModel($id);
        $modelNewsFeedMedias = new NewsFeedMedias();
		$modelNewsFeedMedias->scenario = 'create';
		$modelNewsFeedMedias->published = 1;
		
		//get lookup media type
		$lookupMediaTypeList = LookupMediaTypes::find()->where(array('deleted'=>0))->asArray()->all();
		
		if(count($_POST)!=0)
		{
			$error = '';
			$connection = \Yii::$app->db;
			$transaction = $connection->beginTransaction();
			try 
			{				
				$modelNewsFeedMedias->load(Yii::$app->request->post());
								
				//save whats new image
				if($_FILES['NewsFeedMedias']['error']['file']!=4)
				{					
					//directory path
					$directory_path = 'contents/news-feed/'.$modelNewsFeeds->id.'/';
					if(($path = Yii::$app->AccessMod->createDirectory($directory_path)))
					{
						//get the instance of uploaded file
						$modelNewsFeedMedias->file = UploadedFile::getInstance($modelNewsFeedMedias,'file');	
						
						$imageDimension = getimagesize($modelNewsFeedMedias->file->tempName);							
						$imageWidth = $imageDimension[0];
						$imageHeight = $imageDimension[1];
						if($imageWidth > $_SESSION['settings']['NEWS_FEED_MEDIA_THUMB_IMAGE_WIDTH'] || $imageHeight > $_SESSION['settings']['NEWS_FEED_MEDIA_THUMB_IMAGE_HEIGHT'])
						throw new ErrorException("Thumb image width cannot more than ".$_SESSION['settings']['NEWS_FEED_MEDIA_THUMB_IMAGE_WIDTH']."px and height cannot more than ".$_SESSION['settings']['NEWS_FEED_MEDIA_THUMB_IMAGE_HEIGHT']."px");
						
						//validate image size
						if($modelNewsFeedMedias->file->size > 10000000)
						throw new ErrorException("Thumb image size cannot larger than 10MB");
											
						$file_name = session_id().str_replace(' ','_',$modelNewsFeedMedias->file->name);
						$modelNewsFeedMedias->file->saveAs($directory_path.$file_name,false);
						if(!$modelNewsFeedMedias->file->saveAs($directory_path.$file_name,false))
						throw new ErrorException("Failed uploading thumb image.");
	
						//save path to db column
						$modelNewsFeedMedias->thumb_image = ((isset($_SERVER['HTTPS'])) ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'].'/cmp/'.$directory_path.$file_name;
					}
					else
					throw new ErrorException($path->errorMessage);
				}

				if($modelNewsFeedMedias->media_type_id==1)//image
				{
					if($_FILES['NewsFeedMedias']['error']['image']!=4)
					{					
						//directory path
						$directory_path = 'contents/news-feed/'.$modelNewsFeeds->id.'/';
						if(($path = Yii::$app->AccessMod->createDirectory($directory_path)))
						{
							//get the instance of uploaded file
							$modelNewsFeedMedias->image = UploadedFile::getInstance($modelNewsFeedMedias,'image');	
														
							//validate image size
							if($modelNewsFeedMedias->image->size > 10000000)
							throw new ErrorException("Image size cannot larger than 10MB");
												
							$file_name = session_id().str_replace(' ','_',$modelNewsFeedMedias->image->name);
							$modelNewsFeedMedias->image->saveAs($directory_path.$file_name,false);
							if(!$modelNewsFeedMedias->image->saveAs($directory_path.$file_name,false))
							throw new ErrorException("Failed uploading image.");
		
							//save path to db column
							$modelNewsFeedMedias->media_value = ((isset($_SERVER['HTTPS'])) ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'].'/cmp/'.$directory_path.$file_name;
						}
						else
						throw new ErrorException($path->errorMessage);
					}
				}
				elseif($modelNewsFeedMedias->media_type_id==2)//youtube
				{
					//validate embedded video id
					if(strlen($modelNewsFeedMedias->youtube))
					{
						if(preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $modelNewsFeedMedias->youtube, $youtubeID)==1)
						{
							if(in_array('HTTP/1.0 200 OK',get_headers('https://youtu.be/'.$youtubeID[0])))
							$modelNewsFeedMedias->media_value = $youtubeID[0];
						}
						else
						{
							if(in_array('HTTP/1.0 200 OK',get_headers('https://youtu.be/'.$modelNewsFeedMedias->youtube)))
							$modelNewsFeedMedias->media_value = $modelNewsFeedMedias->youtube;
						}
					}
				}
				$modelNewsFeedMedias->file = 'test';
				$modelNewsFeedMedias->image = 'test';
				$modelNewsFeedMedias->youtube = 'test';
				
				$modelNewsFeedMedias->news_feed_id = $modelNewsFeeds->id;
				$modelNewsFeedMedias->createdby = $_SESSION['user']['id'];
				$modelNewsFeedMedias->createdat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
				$modelNewsFeedMedias->save();
				
				if(count($modelNewsFeedMedias->errors)!=0)
				throw new ErrorException("Create news feed media failed.");
				
				$transaction->commit();
			}
			catch (ErrorException $e) 
			{
				$transaction->rollBack();
				$error = $e->getMessage();
				Yii::$app->session->set('errorMessage', $error);
			}
								
			if(!strlen($error))
			return $this->redirect(['view', 'id' => $modelNewsFeeds->id]);
		}
			
		return $this->render('create-media', [
			'modelNewsFeeds' => $modelNewsFeeds,
			'modelNewsFeedMedias' => $modelNewsFeedMedias,
			'lookupMediaTypeList' => $lookupMediaTypeList,
		]);
	}
	
	public function actionUpdateMedia($id)
	{
        $modelNewsFeedMedias = $this->findModelNewsFeedMedias($id);
        $modelNewsFeeds = $this->findModel($modelNewsFeedMedias->news_feed_id);
		
		//get lookup media type
		$lookupMediaTypeList = LookupMediaTypes::find()->where(array('deleted'=>0))->asArray()->all();
		
		if(count($_POST)!=0)
		{
			$error = '';
			$connection = \Yii::$app->db;
			$transaction = $connection->beginTransaction();
			try 
			{				
				$modelNewsFeedMedias->load(Yii::$app->request->post());
								
				//save whats new image
				if($_FILES['NewsFeedMedias']['error']['file']!=4)
				{					
					//directory path
					$directory_path = 'contents/news-feed/'.$modelNewsFeeds->id.'/';
					if(($path = Yii::$app->AccessMod->createDirectory($directory_path)))
					{
						//get the instance of uploaded file
						$modelNewsFeedMedias->file = UploadedFile::getInstance($modelNewsFeedMedias,'file');	
						
						$imageDimension = getimagesize($modelNewsFeedMedias->file->tempName);							
						$imageWidth = $imageDimension[0];
						$imageHeight = $imageDimension[1];
						if($imageWidth > $_SESSION['settings']['NEWS_FEED_MEDIA_THUMB_IMAGE_WIDTH'] || $imageHeight > $_SESSION['settings']['NEWS_FEED_MEDIA_THUMB_IMAGE_HEIGHT'])
						throw new ErrorException("Thumb image width cannot more than ".$_SESSION['settings']['NEWS_FEED_MEDIA_THUMB_IMAGE_WIDTH']."px and height cannot more than ".$_SESSION['settings']['NEWS_FEED_MEDIA_THUMB_IMAGE_HEIGHT']."px");
						
						//validate image size
						if($modelNewsFeedMedias->file->size > 10000000)
						throw new ErrorException("Thumb image size cannot larger than 10MB");
											
						$file_name = session_id().str_replace(' ','_',$modelNewsFeedMedias->file->name);
						$modelNewsFeedMedias->file->saveAs($directory_path.$file_name,false);
						if(!$modelNewsFeedMedias->file->saveAs($directory_path.$file_name,false))
						throw new ErrorException("Failed uploading thumb image.");
	
						//save path to db column
						$modelNewsFeedMedias->thumb_image = ((isset($_SERVER['HTTPS'])) ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'].'/cmp/'.$directory_path.$file_name;
					}
					else
					throw new ErrorException($path->errorMessage);
				}

				if($_POST['NewsFeedMedias']['media_type_id']==1)//image
				{
					if($_FILES['NewsFeedMedias']['error']['image']!=4)
					{					
						//directory path
						$directory_path = 'contents/news-feed/'.$modelNewsFeeds->id.'/';
						if(($path = Yii::$app->AccessMod->createDirectory($directory_path)))
						{
							//get the instance of uploaded file
							$modelNewsFeedMedias->image = UploadedFile::getInstance($modelNewsFeedMedias,'image');	
														
							//validate image size
							if($modelNewsFeedMedias->image->size > 10000000)
							throw new ErrorException("Image size cannot larger than 10MB");
												
							$file_name = session_id().str_replace(' ','_',$modelNewsFeedMedias->image->name);
							$modelNewsFeedMedias->image->saveAs($directory_path.$file_name,false);
							if(!$modelNewsFeedMedias->image->saveAs($directory_path.$file_name,false))
							throw new ErrorException("Failed uploading image.");
		
							//save path to db column
							$modelNewsFeedMedias->media_value = ((isset($_SERVER['HTTPS'])) ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'].'/cmp/'.$directory_path.$file_name;
						}
						else
						throw new ErrorException($path->errorMessage);
					}
				}
				/*if($modelNewsFeedMedias->media_type_id==2)//youtube
				{
					//validate embedded video id
					if(strlen($modelNewsFeedMedias->youtube))
					{
						if(preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $modelNewsFeedMedias->youtube, $youtubeID)==1)
						{
							if(in_array('HTTP/1.0 200 OK',get_headers('https://youtu.be/'.$youtubeID[0])))
							$modelNewsFeedMedias->media_value = $youtubeID[0];
						}
						else
						{
							if(in_array('HTTP/1.0 200 OK',get_headers('https://youtu.be/'.$modelNewsFeedMedias->youtube)))
							$modelNewsFeedMedias->media_value = $modelNewsFeedMedias->youtube;
						}
					}
				}*/
				if($_POST['NewsFeedMedias']['media_type_id']==2)//youtube
				{
					//validate embedded video id
					if(strlen($_POST['NewsFeedMedias']['youtube']))
					{
						if(preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $_POST['NewsFeedMedias']['youtube'], $youtubeID)==1)
						{
							if(in_array('HTTP/1.0 200 OK',get_headers('https://youtu.be/'.$youtubeID[0])))
							$modelPropertyProductMedias->media_value = $youtubeID[0];
						}
						else
						{
							if(in_array('HTTP/1.0 200 OK',get_headers('https://youtu.be/'.$_POST['NewsFeedMedias']['youtube'])))
							$modelPropertyProductMedias->media_value = $_POST['NewsFeedMedias']['youtube'];
						}
					}
				}
				
				$modelNewsFeedMedias->file = 'test';
				$modelNewsFeedMedias->image = 'test';
				$modelNewsFeedMedias->youtube = 'test';
				
				$modelNewsFeedMedias->createdby = $_SESSION['user']['id'];
				$modelNewsFeedMedias->createdat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
				$modelNewsFeedMedias->save();
				
				if(count($modelNewsFeedMedias->errors)!=0)
				throw new ErrorException("Update news feed media failed.");
				
				$transaction->commit();
			}
			catch (ErrorException $e) 
			{
				$transaction->rollBack();
				$error = $e->getMessage();
				Yii::$app->session->set('errorMessage', $error);
			}
								
			if(!strlen($error))
			return $this->redirect(['view', 'id' => $modelNewsFeeds->id]);
		}		
		
		return $this->render('update-media', [
			'modelNewsFeeds' => $modelNewsFeeds,
			'modelNewsFeedMedias' => $modelNewsFeedMedias,
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
        $modelNewsFeedMedias = $this->findModelNewsFeedMedias($id);
		$modelNewsFeedMedias->deletedby = $_SESSION['user']['id'];
		$modelNewsFeedMedias->deletedat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
		$modelNewsFeedMedias->save();

		return $this->redirect(['view', 'id' => $modelNewsFeedMedias->news_feed_id]);
    }

    protected function findModel($id)
    {
        if (($model = NewsFeeds::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findModelNewsFeedMedias($id)
    {
        if (($model = NewsFeedMedias::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
