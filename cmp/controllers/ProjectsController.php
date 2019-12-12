<?php

namespace app\controllers;

use Yii;
use app\models\Projects;
use app\models\ProjectsSearch;

use app\models\Developers;
use app\models\ProjectAgents;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\base\ErrorException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\helpers\Html;
use yii\helpers\Json;

/**
 * ProjectsController implements the CRUD actions for Projects model.
 */
class ProjectsController extends Controller
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
        $searchModel = new ProjectsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		
		//get leveloper list
		$developerList = Developers::find()
							->where(array('status'=>1,'deletedby'=>NULL,'deletedat'=>NULL,))
							->orderBy(array('company_name' => SORT_ASC,))
							->asArray()
							->all();
		$statusList = array(array('name'=>'Active','value'=>'1'),array('name'=>'Inactive','value'=>'0'));
		
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'developerList' => $developerList,
            'statusList' => $statusList,
        ]);
    }

    public function actionView($id)
    {
		$model = $this->findModel($id);
		$modelProjectAgents = ProjectAgents::find()->where(array('project_id'=>$model->id))->asArray()->all();
		
        return $this->render('view', [
            'model' => $model,
            'modelProjectAgents' => $modelProjectAgents,
        ]);
    }

    public function actionCreate()
    {
        $model = new Projects();
        $model->scenario = 'create';
        $model->status = 1;
        $modelProjectAgents = new ProjectAgents();
        $modelDevelopers = new Developers();
		
		//get leveloper list
		$developerList = Developers::find()
							->where(array('status'=>1,'deletedby'=>NULL,'deletedat'=>NULL,))
							->orderBy(array('company_name' => SORT_ASC,))
							->asArray()
							->all();
	
		//get sqm account manager list
		$sqmAccountManagerList = array();
		$agentList = Yii::$app->AccessMod->getAgentList(array(7));
		if(count($agentList)!=0)
		{
			foreach($agentList as $key=>$agent)
			{
				$sqmAccountManagerList[$key]['id'] = $agent['id'];
				$sqmAccountManagerList[$key]['name'] = $agent['name'];
			}
		}
		$sqmAccountManagerObj = array();
		if(count($sqmAccountManagerList)!=0)
		{
			foreach($sqmAccountManagerList as $sqmAccountManager)
			{
				$sqmAccountManagerObj[] = (object)$sqmAccountManager;
			}
		}
		
		if(isset($_GET['project_name']))
		{
			$model->project_name = $_GET['project_name'];
			if(!empty($_GET['id']))
			$model->id = $_GET['id'];
			echo json_encode($model->checkUnique('project_name'));
			exit();
		}
		
        if(count($_POST)!=0)
		{
			$error = '';	
			$connection = \Yii::$app->db;
			$transaction = $connection->beginTransaction();
			try 
			{
				/***** projects create process ******/
				$model->load(Yii::$app->request->post());
				$model->thumb_image = 'test';
				$model->file = 'test';
				$model->createdby = $_SESSION['user']['id'];
				$model->createdat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
				$model->save();
				if(count($model->errors)!=0)
				throw new ErrorException("Create project failed.");
				
				//directory path
				$directory_path = 'contents/projects/'.$model->id.'/';
				//create directory based on id
				Yii::$app->AccessMod->createDirectory($directory_path);
				//save project thumb image
				if($_FILES['Projects']['error']['file']!=4)
				{					
					//directory path
					$directory_path = 'contents/projects/'.$model->id.'/';
					if(($path = Yii::$app->AccessMod->createDirectory($directory_path)))
					{
						//get the instance of uploaded file
						$model->file = UploadedFile::getInstance($model,'file');	
						
						$imageDimension = getimagesize($model->file->tempName);							
						$imageWidth = $imageDimension[0];
						$imageHeight = $imageDimension[1];
						if($imageWidth > 800 || $imageHeight > 600)
						throw new ErrorException("Thumb image width cannot more than 800px and height cannot more than 600px");
						
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
						throw new ErrorException("Upload project thumb image failed.");
					}
					else
					throw new ErrorException($path->errorMessage);
				}				
				
				//project agents create process
				$modelProjectAgents->load(Yii::$app->request->post());
				$postProjectAgents = Yii::$app->request->post('ProjectAgents');
				$agentID = Json::decode($postProjectAgents['agent_id']);
				foreach($agentID as $agent_id)
				{
					$modelProjectAgents = new ProjectAgents();
					$modelProjectAgents->project_id = $model->id;
					$modelProjectAgents->agent_id = $agent_id;
					$modelProjectAgents->save();
					if(count($modelProjectAgents->errors)!=0)
					{
						throw new ErrorException("Create project agent failed.");
						break;
					}
				}
				
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
			'modelProjectAgents' => $modelProjectAgents,
			'developerList' => $developerList,
			'sqmAccountManagerObj' => $sqmAccountManagerObj,
		]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelProjectAgents = new ProjectAgents();

		//get leveloper list
		$developerList = Developers::find()
							->where(array('status'=>1,'deletedby'=>NULL,'deletedat'=>NULL,))
							->orderBy(array('company_name' => SORT_ASC,))
							->asArray()
							->all();
	
		$projectAgents = ProjectAgents::find()->where(array('project_id'=>$model->id))->asArray()->all();
		if($projectAgents!=NULL)
		$modelProjectAgents->agent_id = json_encode(array_column($projectAgents,'agent_id'));
		//get sqm account manager list
		$sqmAccountManagerList = array();
		$agentList = Yii::$app->AccessMod->getAgentList(array(7));
		if(count($agentList)!=0)
		{
			foreach($agentList as $key=>$agent)
			{
				$sqmAccountManagerList[$key]['id'] = $agent['id'];
				$sqmAccountManagerList[$key]['name'] = $agent['name'];
			}
		}
		$sqmAccountManagerObj = array();
		if(count($sqmAccountManagerList)!=0)
		{
			foreach($sqmAccountManagerList as $sqmAccountManager)
			{
				$sqmAccountManagerObj[] = (object)$sqmAccountManager;
			}
		}
		
		if(isset($_GET['project_name']))
		{
			$model->project_name = $_GET['project_name'];
			if(!empty($_GET['id']))
			$model->id = $_GET['id'];
			echo json_encode($model->checkUnique('project_name'));
			exit();
		}
		
        if(count($_POST)!=0)
		{
			$error = '';	
			$connection = \Yii::$app->db;
			$transaction = $connection->beginTransaction();
			try 
			{
				/***** merchants update process ******/
				$model->load(Yii::$app->request->post());
				$model->updatedby = $_SESSION['user']['id'];
				$model->updatedat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
				$model->save();
				if(count($model->errors)!=0)
				throw new ErrorException("Update project failed.");
				
				//save project thumb image
				if($_FILES['Projects']['error']['file']!=4)
				{					
					//directory path
					$directory_path = 'contents/projects/'.$model->id.'/';
					if(($path = Yii::$app->AccessMod->createDirectory($directory_path)))
					{
						//get the instance of uploaded file
						$model->file = UploadedFile::getInstance($model,'file');	
						
						$imageDimension = getimagesize($model->file->tempName);							
						$imageWidth = $imageDimension[0];
						$imageHeight = $imageDimension[1];
						if($imageWidth > 800 || $imageHeight > 600)
						throw new ErrorException("Thumb image width cannot more than 800px and height cannot more than 600px");
						
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
						throw new ErrorException("Upload project thumb image failed.");
					}
					else
					throw new ErrorException($path->errorMessage);
				}				
				
				$modelProjectAgents->load(Yii::$app->request->post());
				ProjectAgents::deleteAll('project_id = '.$model->id);
				$postProjectAgents = Yii::$app->request->post('ProjectAgents');
				$agentID = Json::decode($postProjectAgents['agent_id']);
				foreach($agentID as $agent_id)
				{
					$modelProjectAgents = new ProjectAgents();
					$modelProjectAgents->project_id = $model->id;
					$modelProjectAgents->agent_id = $agent_id;
					$modelProjectAgents->save();
					if(count($modelProjectAgents->errors)!=0)
					{
						throw new ErrorException("Create project agent failed.");
						break;
					}
				}

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
			'modelProjectAgents' => $modelProjectAgents,
			'developerList' => $developerList,
			'sqmAccountManagerObj' => $sqmAccountManagerObj,
		]);
    }

    public function actionDelete($id)
    {
		$model = $this->findModel($id);

		$error = '';
		$connection = Yii::$app->db;
		$transaction = $connection->beginTransaction();
		try 
		{
			$model->status = 0;
			$model->deletedby = $_SESSION['user']['id'];
			$model->deletedat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
			$model->save();
			if(count($model->errors)!=0)
			throw new ErrorException("Delete project failed.");
			
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
        if (($model = Projects::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
