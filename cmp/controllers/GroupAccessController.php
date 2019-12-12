<?php

namespace app\controllers;

use Yii;
use app\models\GroupAccess;
use app\models\GroupAccessSearch;
use app\models\Modules;
use app\models\ModuleGroups;
use app\models\LogAudit;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\base\ErrorException;

/**
 * GroupAccessController implements the CRUD actions for GroupAccess model.
 */
class GroupAccessController extends Controller
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
        $searchModel = new GroupAccessSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
		$model = $this->findModel($id);
		
		if(isset($_REQUEST['ajaxView']))
		{
			return $this->renderAjax('view', [
				'model' => $model,
			]);
		}
		else
		{
			return $this->render('view', [
				'model' => $model,
			]);
		}
    }

    public function actionCreate()
    {
        $model = new GroupAccess();

        if (count($_POST)!=0)
		{
			/***** group_access create process ******/
			$model->load(Yii::$app->request->post());
							
			$model->save();
				
            return $this->redirect(['view', 'id' => $model->id]);
        }
		
		return $this->render('create', [
			'model' => $model,
		]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
		
		$modules = Modules::find()->where(array('controller' => $_SESSION['user']['controller']))->one();
		$olddata = GroupAccess::find()->where(array('id' => $model->id))->asArray()->one();
		
        if (count($_POST)!=0)
		{
			$error = '';	
			$connection = \Yii::$app->db;
			$transaction = $connection->beginTransaction();
			try 
			{
				/***** user_points update process ******/
				$model->load(Yii::$app->request->post());
				$model->updatedat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');			
				$model->save();
				
				if(count($model->errors)!=0)
				throw new ErrorException("Failed to update group access");
								
				$transaction->commit();
			}
			catch (ErrorException $e) 
			{
				$transaction->rollBack();
				$error = $e->getMessage();
				$model->addError('status',$error);
			}
			
			if(!strlen($error))
			{
				$newdata = GroupAccess::find()->where(array('id' => $model->id))->asArray()->one();
				
				//log audit create process
				$modelLogAudit = new LogAudit();
				$modelLogAudit->module_id = $modules->id;
				$modelLogAudit->record_id = $model->id;
				$modelLogAudit->action = $_SESSION['user']['action'];
				$modelLogAudit->newdata = json_encode($newdata);
				$modelLogAudit->olddata = json_encode($olddata);
				$modelLogAudit->user_id = $_SESSION['user']['id'];
				$modelLogAudit->createdat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
				
				$modelLogAudit->save();
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
		
		$modules = Modules::find()->where(array('controller' => $_SESSION['user']['controller']))->one();
		$olddata = GroupAccess::find()->where(array('id' => $model->id))->asArray()->one();
		
		$error = '';	
		$connection = \Yii::$app->db;
		$transaction = $connection->beginTransaction();
		try 
		{
			/***** user_points delete process ******/
			$model->status = 0;
			$model->save();
			
			if(count($model->errors)!=0)
			throw new ErrorException("Failed to delete group access");
							
			$transaction->commit();
		}
		catch (ErrorException $e) 
		{
			$transaction->rollBack();
			$error = $e->getMessage();
		}
		
		if(!strlen($error))
		{
			$newdata = GroupAccess::find()->where(array('id' => $model->id))->asArray()->one();
			
			//log audit create process
			$modelLogAudit = new LogAudit();
			$modelLogAudit->module_id = $modules->id;
			$modelLogAudit->record_id = $model->id;
			$modelLogAudit->action = $_SESSION['user']['action'];
			$modelLogAudit->newdata = json_encode($newdata);
			$modelLogAudit->olddata = json_encode($olddata);
			$modelLogAudit->user_id = $_SESSION['user']['id'];
			$modelLogAudit->createdat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
			
			$modelLogAudit->save();
		}
		
        return $this->redirect(['index']);
	}
	
	
	//assign module action
	public function actionAssignPermission($id)
    {
        $model = $this->findModel($id);
        $modelModules = new Modules();
        $modelModuleGroups = new ModuleGroups();
		
		$modules = Modules::find()->where(array('controller' => $_SESSION['user']['controller']))->one();
		$olddataGroupAccess = GroupAccess::find()->where(array('id' => $model->id))->asArray()->one();
		$olddataModuleGroups = ModuleGroups::find()->where(array('groupaccess_id' => $model->id))->asArray()->all();
		$olddata['group_access'] = json_encode($olddataGroupAccess);
		$olddata['module_groups'] = json_encode($olddataModuleGroups);
		
		//get module list from model Modules
		$module = $modelModules->getModulesDataList();
		//get module group data from model ModuleGroups
		$module_groups = $modelModuleGroups->getModuleGroupsData($model->id);
		
        if (count($_POST)!=0)
		{
			$error = '';	
			$connection = \Yii::$app->db;
			$transaction = $connection->beginTransaction();
			try 
			{
				/***** module_groups delete process ******/
				$modelModuleGroups = ModuleGroups::find()->where('groupaccess_id = '.$model->id)->all();
				if(count($modelModuleGroups)!=0)
				{
					foreach($modelModuleGroups as $modelModuleGroup)
					{
						$modelModuleGroup->delete();
					
						if(count($modelModuleGroup->errors)!=0)
						{
							throw new ErrorException("Failed to delete module groups");
							break;
						}
					}
				}
					
				/***** module_groups assign modules process ******/
				$postModuleGroups = Yii::$app->request->post('module');
					
				foreach($postModuleGroups as $moduleID => $action)
				{
					$modelModuleGroups = new ModuleGroups();
					
					$modelModuleGroups->groupaccess_id = $model->id;
					$modelModuleGroups->module_id = $moduleID;
					$modelModuleGroups->permission = serialize($action);
					
					$modelModuleGroups->save();
					
					if(count($modelModuleGroups->errors)!=0)
					{
						throw new ErrorException("Failed to assign module groups");
						break;
					}
				}
								
				$transaction->commit();
			}
			catch (ErrorException $e) 
			{
				$transaction->rollBack();
				$error = $e->getMessage();
			}
			
			if(!strlen($error))
			{
				$newdataGroupAccess = GroupAccess::find()->where(array('id' => $model->id))->asArray()->one();
				$newdataModuleGroups = ModuleGroups::find()->where(array('groupaccess_id' => $model->id))->asArray()->all();
				$newdata['group_access'] = json_encode($newdataGroupAccess);
				$newdata['module_groups'] = json_encode($newdataModuleGroups);
				
				//log audit create process
				$modelLogAudit = new LogAudit();
				$modelLogAudit->module_id = $modules->id;
				$modelLogAudit->record_id = $model->id;
				$modelLogAudit->action = $_SESSION['user']['action'];
				$modelLogAudit->newdata = json_encode($newdata);
				$modelLogAudit->olddata = json_encode($olddata);
				$modelLogAudit->user_id = $_SESSION['user']['id'];
				$modelLogAudit->createdat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
				
				$modelLogAudit->save();
			}
			
			return $this->redirect(['index']);
		}
		
		return $this->renderAjax('assign-permission', [
			'model' => $model,
			'module' => $module,
			'module_groups' => $module_groups,
		]);
    }
	
    protected function findModel($id)
    {
        if (($model = GroupAccess::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
