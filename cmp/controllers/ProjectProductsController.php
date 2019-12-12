<?php

namespace app\controllers;

use Yii;
use app\models\ProjectProducts;
use app\models\ProjectProductsSearch;

use app\models\ProjectProductUnitTypes;
use app\models\ProjectProductUnitTypesSearch;

use app\models\Projects;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\base\ErrorException;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;
use yii\data\ArrayDataProvider;

/**
 * ProjectProductsController implements the CRUD actions for ProjectProducts model.
 */
class ProjectProductsController extends Controller
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
        $searchModel = new ProjectProductsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

		//get project list
		$projectList = array();
		$projectArray = Projects::find()->where(array('status'=>1,'deletedat'=>NULL,'deletedat'=>NULL))->asArray()->all();
		if(count($projectArray)!=0)
		{
			foreach($projectArray as $key=>$project)
			{
				$projectList[$key]['value'] = $project['project_name'];
				$projectList[$key]['name'] = $project['project_name'].' ('.Yii::$app->GeneralMod->getDeveloperName($project['developer_id']).')';
			}
		}

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'projectList' => $projectList,
        ]);
    }

    public function actionView($id)
    {
		$model = $this->findModel($id);
        $searchModelProjectProductUnitTypesSearch = new ProjectProductUnitTypesSearch(['project_id'=>$model->project_id,'project_product_id'=>$model->id]);
        $dataProviderProjectProductUnitTypesSearch = $searchModelProjectProductUnitTypesSearch->search(Yii::$app->request->queryParams);
		
        return $this->render('view', [
            'model' => $model,
            'searchModelProjectProductUnitTypesSearch' => $searchModelProjectProductUnitTypesSearch,
            'dataProviderProjectProductUnitTypesSearch' => $dataProviderProjectProductUnitTypesSearch,
        ]);
    }

    public function actionCreate()
    {
        $model = new ProjectProducts();
		$modelProjectProductUnitTypes = new ProjectProductUnitTypes();
		
		//get project list
		$projectList = array();
		$projectArray = Projects::find()->where(array('status'=>1,'deletedat'=>NULL,'deletedat'=>NULL))->asArray()->all();
		if(count($projectArray)!=0)
		{
			foreach($projectArray as $key=>$project)
			{
				$projectList[$key]['id'] = $project['id'];
				$projectList[$key]['name'] = $project['project_name'].' ('.Yii::$app->GeneralMod->getDeveloperName($project['developer_id']).')';
			}
		}
		
        if(count($_POST)!=0)
		{
			$error = '';
			$connection = Yii::$app->db;
			$transaction = $connection->beginTransaction();
			try 
			{
				$model->load(Yii::$app->request->post());
				$model->createdby = $_SESSION['user']['id'];
				$model->createdat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
				$model->save();
				if(count($model->errors)!=0)
				throw new ErrorException("Create project product failed.");
				
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
			'modelProjectProductUnitTypes' => $modelProjectProductUnitTypes,
			'projectList' => $projectList,
		]);
    }

	public function actionCreateUnitType($id)
	{
		$modelProjectProducts = $this->findModel($id);
		$modelProjectProductUnitTypes = new ProjectProductUnitTypes();
		
        if(count($_POST)!=0)
		{
			$error = '';
			$connection = Yii::$app->db;
			$transaction = $connection->beginTransaction();
			try 
			{
				$modelProjectProductUnitTypes->load(Yii::$app->request->post());
				$modelProjectProductUnitTypes->project_id = $modelProjectProducts->project_id;
				$modelProjectProductUnitTypes->project_product_id = $modelProjectProducts->id;
				$modelProjectProductUnitTypes->createdby = $_SESSION['user']['id'];
				$modelProjectProductUnitTypes->createdat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
				$modelProjectProductUnitTypes->save();
				if(count($modelProjectProductUnitTypes->errors)!=0)
				throw new ErrorException("Create product unit type failed.");
				
				$transaction->commit();
			}
			catch (ErrorException $e) 
			{
				$transaction->rollBack();
				$error = $e->getMessage();
				Yii::$app->session->set('errorMessage', $error);
			}
									
			if(!strlen($error))
            return $this->redirect(['view', 'id' => $modelProjectProducts->id]);
        }
		
		return $this->render('create-unit-type', [
			'modelProjectProducts' => $modelProjectProducts,
			'modelProjectProductUnitTypes' => $modelProjectProductUnitTypes,
		]);
	}

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
		$modelProjectProductUnitTypes = new ProjectProductUnitTypes();
		
		//get project list
		$projectList = array();
		$projectArray = Projects::find()->where(array('status'=>1,'deletedat'=>NULL,'deletedat'=>NULL))->asArray()->all();
		if(count($projectArray)!=0)
		{
			foreach($projectArray as $key=>$project)
			{
				$projectList[$key]['id'] = $project['id'];
				$projectList[$key]['name'] = $project['project_name'].' ('.Yii::$app->GeneralMod->getDeveloperName($project['developer_id']).')';
			}
		}

        if(count($_POST)!=0)
		{
			$error = '';
			$connection = Yii::$app->db;
			$transaction = $connection->beginTransaction();
			try 
			{
				$model->load(Yii::$app->request->post());
				$model->updatedby = $_SESSION['user']['id'];
				$model->updatedat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
				$model->save();
				if(count($model->errors)!=0)
				throw new ErrorException("Update project product failed.");
				
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
			'modelProjectProductUnitTypes' => $modelProjectProductUnitTypes,
			'projectList' => $projectList,
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

    public function actionDeleteUnitType($id)
    {
        $model = $this->findModelProjectProductUnitTypes($id);
		$model->deletedby = $_SESSION['user']['id'];
		$model->deletedat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
		$model->save();
		
            return $this->redirect(['view', 'id' => $model->project_product_id]);
    }

    protected function findModel($id)
    {
        if (($model = ProjectProducts::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findModelProjectProductUnitTypes($id)
    {
        if (($model = ProjectProductUnitTypes::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
