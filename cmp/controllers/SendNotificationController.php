<?php

namespace app\controllers;

use Yii;
use app\models\UserMessages;
use app\models\UserMessagesSearch;
use app\models\Users;
use app\models\LogUserMessages;
use app\models\UserDevices;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\base\ErrorException;

class SendNotificationController extends Controller
{
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
		//initialize
		$error = '';
		$modelUserMessages = new UserMessages();
		$modelLogUserMessages = new LogUserMessages();
		$modelUserDevices = new UserDevices();
		$modelUsers = new Users();

		//get member list
		$memberList = array();
		$memberListBox = array();
		$memberArray = Yii::$app->AccessMod->getMemberList();		
		if(count($memberArray)!=0)
		{
			foreach($memberArray as $key=>$value)
			{
				$memberList[$key]['id'] = $value['id'];
				$memberList[$key]['name'] = $value['name'].' ('.$value['agent_name'].')';
			}
		}
		if(count($memberList)!=0)
		{
			foreach($memberList as $member)
			{
				$memberListBox[] = (object)$member;
			}
		}
		
        if(count($_POST)!=0)
		{
			$error = '';	
			$connection = \Yii::$app->db;
			$transaction = $connection->beginTransaction();
			try 
			{
				$modelUserMessages->load(Yii::$app->request->post());
	
				$membersID = Json::decode($modelUserMessages->user_id);
				if(count($membersID)==0)
				throw new ErrorException("Please select member");
	
				$subject = $modelUserMessages->subject;
				$message = $modelUserMessages->message;
				$long_message = $modelUserMessages->long_message;

				if(preg_match('/[^a-zA-Z\d ]/', $subject)==1)
				throw new ErrorException("Invalid subject. Please remove all apecial characters.");
								
				if(preg_match('/[^a-zA-Z\d ]/', $message)==1)
				throw new ErrorException("Invalid message. Please remove all apecial characters.");
				
				foreach($membersID as $member_id)
				{
					//create user message
					$modelUserMessages = new UserMessages();
					$modelUserMessages->user_id = $member_id;
					$modelUserMessages->subject = $subject;
					$modelUserMessages->message = $message;
					$modelUserMessages->long_message = htmlentities($long_message);
					$modelUserMessages->priority = 1;
					$modelUserMessages->mark_as_read = 0;
					$modelUserMessages->createdby = $_SESSION['user']['id'];
					$modelUserMessages->createdat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
					$modelUserMessages->save();
					
					if(count($modelUserMessages->errors)!=0)
					{
						throw new ErrorException("Send notification failed.");
						break;
					}
				}
				
				//get member device token
				$memberDevicesList = array();
				foreach($membersID as $member_id)
				{
					$memberDevices = $modelUserDevices->getUserDevices($member_id);
					if($memberDevices)
					{
						foreach($memberDevices as $device)
						{
							if(strlen($device['device_token']))
							$memberDevicesList[] = $device['device_token'];
						}
					}
				}
				
				if(count($memberDevicesList)!=0)
				{
					//send push notifications
					$sendNotification = Yii::$app->AccessMod->sendPushNotification($subject, $message, $memberDevicesList);
					if(!$sendNotification)
					throw new ErrorException(Yii::$app->AccessMod->errorMessage);
				}
				
				//log message create process
				$recipientList = array();
				foreach($membersID as $member_id)
				{
					$recipientList[] = Yii::$app->AccessMod->getName($member_id);		
				}
				$recipients = implode(', ', $recipientList);
				$modelLogUserMessages = new LogUserMessages();
				$modelLogUserMessages->subject = $subject;
				$modelLogUserMessages->message = $message;
				$modelLogUserMessages->long_message = htmlentities($long_message);
				$modelLogUserMessages->recepients_list = $recipients;
				$modelLogUserMessages->priority = 1;
				$modelLogUserMessages->createdby = $_SESSION['user']['id'];
				$modelLogUserMessages->createdat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
				$modelLogUserMessages->save();
				if(count($modelLogUserMessages->errors)!=0)
				throw new ErrorException("Create log user messages failed.");
								
				$transaction->commit();
			}
			catch (ErrorException $e) 
			{
				$transaction->rollBack();
				$error = $e->getMessage();
				Yii::$app->session->set('errorMessage', $error);
			}
			
			if(!strlen($error))
            return $this->redirect(['view', 'id' => $modelLogUserMessages->id]);
        }
		
		return $this->render('create', [
			'modelUserMessages' => $modelUserMessages,
			'memberListBox' => $memberListBox,
		]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'modelLogUserMessages' => $this->findModelLogUserMessages($id),
        ]);
    }

    protected function findModel($id)
    {
        if (($model = UserMessages::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	
	protected function findModelLogUserMessages($id)
    {
        if (($modelLogMessages = LogUserMessages::findOne($id)) !== null) {
            return $modelLogMessages;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
