<?php

namespace app\controllers;

use Yii;
use app\models\GroupListsTopics;
use app\models\GroupListsTopicsSearch;
use app\models\Users;
use app\models\UserDevices;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\base\ErrorException;

/**
 * GroupListsTopicsController implements the CRUD actions for GroupListsTopics model.
 */
class GroupListsTopicsController extends Controller
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
        $searchModel = new GroupListsTopicsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

		$statusArray = array(array('name'=>'Active','value'=>1),array('name'=>'Inactive','value'=>0));

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'statusArray' => $statusArray,
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
        $model = new GroupListsTopics();
		$modelUsers = new Users();
		$modelUserDevices = new UserDevices();
		
		
        if(count($_POST)!=0 && isset($_POST['topic']))
		{			
			$error = '';	
			$connection = \Yii::$app->db;
			$transaction = $connection->beginTransaction();
			try 
			{
				$model->load(Yii::$app->request->post());
				$usersID = Json::decode($model->user_id);
				
				if(count($usersID)==0)
				throw new ErrorException("Please select device owners");

				//create topic
				$model->topic_name = trim($model->topic_name);
				$model->status = strlen($model->status)?$model->status:1;
				$model->createdby = $_SESSION['user']['id'];
				$model->createdat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
				$model->save();
			
				if(count($model->errors)!=0)
				throw new ErrorException("Failed to create topic");
				
				//get customer device
				$customerDevices = array();
				foreach($usersID as $user_id)
				{
					$devices = $modelCustomerDevices->getCustomerDevices($user_id);
					if($devices)
					{
						foreach($devices as $device)
						{
							if(strlen($device['device_token']))
							$customerDevices[] = $device['device_token'];
						}
					}
				}
								
				//register device to topic
				$registerDevice = Yii::$app->AccessMod->pushNotificationRegisterDeviceToTopic($model->topic_name, $customerDevices);
								
				if(!$registerDevice)
				throw new ErrorException(Yii::$app->AccessMod->errorMessage);
				
				$transaction->commit();
			}
			catch (ErrorException $e) 
			{
				$transaction->rollBack();
				$error = $e->getMessage();
				$model->addError('topic_name',$error);
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
		if($id==1)
		throw new \yii\web\HttpException(401, 'Unauthorized: Can\'t update topic all.');		
		
        $model = $this->findModel($id);
		$modelUsers = new Users();
		$modelCustomerDevices = new CustomerDevices();
		
		$levelList = LookupCustomerLevel::find()->asArray()->all();
				
		//get customer list
		$userList = $modelUsers->getCustomerList();
		$userListBox = [];
		if($userList != false)
		{
			foreach($userList as $user)
			{
				$userListBox[] = (object)$user;
			}
		}
		
		$selectedLevel = '';
        if(count($_POST)!=0 && isset($_POST['level']))
		{
			$model->load(Yii::$app->request->post());
			$selectedLevel = $_POST['level'];
			$userList = $modelUsers->getCustomerList($selectedLevel);
			$userListBox = [];
			if($userList != false)
			{
				foreach($userList as $user)
				{
					$userListBox[] = (object)$user;
				}
			}
		}
		
		//get old topic user id			
		$oldTopicUserId = Json::decode($model->user_id);
				
        if(count($_POST)!=0 && isset($_POST['topic']))
		{			
			$error = '';	
			$connection = \Yii::$app->db;
			$transaction = $connection->beginTransaction();
			try 
			{			
				$model->load(Yii::$app->request->post());
				$usersID = Json::decode($model->user_id);
				
				if(count($usersID)==0)
				throw new ErrorException("Please select device owners");
				
				$model->topic_name = trim($model->topic_name);
				$model->updatedby = $_SESSION['user']['id'];
				$model->updatedat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
				$model->save();
			
				if(count($model->errors)!=0)
				throw new ErrorException("Failed to create topic");
				
				//get customer device
				$customerDevices = array();
				foreach($usersID as $user_id)
				{
					$devices = $modelCustomerDevices->getCustomerDevices($user_id);
					if($devices)
					{
						foreach($devices as $device)
						{
							if(strlen($device['device_token']))
							$customerDevices[] = $device['device_token'];
						}
					}
				}
				
				//register device to topic
				$registerDeviceToTopic = Yii::$app->AccessMod->pushNotificationRegisterDeviceToTopic($model->topic_name, $customerDevices);
				
				if(!$registerDeviceToTopic)
				throw new ErrorException(Yii::$app->AccessMod->errorMessage);
				
				//remove customer device from topic
				$newTopicUserId = Json::decode($model->user_id);
				$unselectUserID = array_diff($oldTopicUserId, $newTopicUserId);
				if(count($unselectUserID)!=0)
				{
					$customerDevices = array();
					foreach($unselectUserID as $user_id)
					{
						$devices = $modelCustomerDevices->getCustomerDevices($user_id);
						if($devices)
						{
							foreach($devices as $device)
							{
								if(strlen($device['device_token']))
								$customerDevices[] = $device['device_token'];
							}
						}
					}
					
					$removeDeviceFromTopic = Yii::$app->AccessMod->pushNotificationRemoveDeviceFromTopic($model->topic_name, $customerDevices);
					
					if(!$removeDeviceFromTopic)
					throw new ErrorException(Yii::$app->AccessMod->errorMessage);
				}
				
				$transaction->commit();
			}
			catch (ErrorException $e) 
			{
				$transaction->rollBack();
				$error = $e->getMessage();
				$model->addError('topic_name',$error);
			}
			
			if(!strlen($error))
            return $this->redirect(['view', 'id' => $model->id]);
        }
		
		return $this->render('update', [
			'model' => $model,
			'levelList' => $levelList,
			'selectedLevel' => $selectedLevel,
			'userListBox' => $userListBox,
		]);
    }

    public function actionToggleStatus($id)
    {
		if($id==1)
		throw new \yii\web\HttpException(401, 'Unauthorized: Can\'t deactivate topic all.');		
		
        $model = $this->findModel($id);
		if($model->status == 0)
		{
			$model->status = 1;
			$model->deletedby = NULL;
			$model->deletedat = NULL;
		}
		else
		$model->status = 0;
		$model->updatedby = $_SESSION['user']['id'];
		$model->updatedat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
		$model->save();

        return $this->redirect(['index']);
    }

    public function actionDelete($id)
    {
		if($id==1)
		throw new \yii\web\HttpException(401, 'Unauthorized: Can\'t delete topic all.');		
		
        $model = $this->findModel($id);
		$model->status = 0;
		$model->deletedby = $_SESSION['user']['id'];
		$model->deletedat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
		$model->save();

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = GroupListsTopics::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
