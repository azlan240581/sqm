<?php 
namespace app\components;

use Yii;
use yii\helpers\Html;

use app\models\Users;
use app\models\UserGroups;
use app\models\UserAssociateDetails;
use app\models\UserMessages;
use app\models\LogUserMessages;
use app\models\UserDevices;
use app\models\GroupListsTopics;
use app\models\SystemEmailTemplate;
use app\models\Prospects;
use app\models\GroupAccess;
use app\models\ProjectAgents;

use yii\base\ErrorException;
use yii\helpers\FileHelper;

/* start: qrcode */
use dosamigos\qrcode\formats\MailTo;
use dosamigos\qrcode\QrCode;
/* end: qrcode */

use app\models\LogApi;

class AccessMod extends \yii\base\Component{
	
	private $userID;
	public $errorMessage;

    public function init() {
        parent::init();
    }

	public static function isControllerExists($id)
	{
        $id=ucfirst($id);
        $controllerPath=Yii::$app->controllerPath;
        return file_exists($controllerPath.DIRECTORY_SEPARATOR.$id."Controller.php");
	}

	public static function getSalt()
	{
		$salt = md5(time());
		return $salt;
	}

    public static function getUsername($id)
    {
		$user = new Users;

		if($user == null)
        return false;

		return $user->getUsername($id); 
    }

    public static function getName($id)
    {
		$user = Users::find()->where(array('id'=>$id))->one();

		if($user == null)
        return null;

		return $user->name; 
    }

    public static function getUserGroupID($id)
    {
		$userGroups = UserGroups::find()->where(array('user_id'=>$id))->one();

		if($userGroups == null)
        return null;

		return $userGroups->groupaccess_id; 
    }

    public static function getUserGroupName($id)
    {
		$groupAccess = GroupAccess::find()->where(array('id'=>$id))->one();

		if($groupAccess == null)
        return null;

		return $groupAccess->group_access_name;
    }

	public function getUserNewMessage($userid) 
	{
		$messages = UserMessages::find()->where(array('user_id'=>$userid,'mark_as_read'=>0))->orderBy(['priority'=>SORT_DESC,'createdat'=>SORT_DESC])->asArray()->all();

		if($messages == null)
        return false;

		return $messages; 
	}

	public function get_uuid($str) 
	{
		$str = md5($str);
		$uuid = substr($str,0,8).'-'.substr($str,8,4).'-'.substr($str,12,4).'-'.substr($str,16,4).'-'.substr($str,20,12);
		return strtoupper($uuid);
	}


	public function generate_unique_id($prefix='',$no=0)
	{
		return $prefix.str_pad(date("U"),10,0,STR_PAD_LEFT).str_pad($no,5,0,STR_PAD_LEFT);
	}

	public function generate_simple_unique_id($prefix='',$no=0, $pad=3)
	{
		return $prefix.str_pad($no,$pad,0,STR_PAD_LEFT);
	}

	public function generate_ticket_unique_id($prefix='',$no=0, $pad=5)
	{
		return $prefix.str_pad($no,$pad,0,STR_PAD_LEFT);
	}

	public function getAllControllers()
	{
		$controllersRaw = \yii\helpers\FileHelper::findFiles(Yii::getAlias('@app/controllers'), ['recursive' => true]);
		$controllers = [];
		foreach ($controllersRaw as $controller) {
			$tmp = str_replace('Controller.php','',basename($controller));
			$controllers[] = $this->splitUppercase($tmp);
		}
		return $controllers;
	}


	public function getAllControllerActions($controller)
	{
		$tmp = explode('-',$controller);
		$actions = [];
		
		$controllerPath = '';
		for($i=0;$i<count($tmp);$i++)
		{
			if($i==0)
			$controllerPath .= ucfirst($tmp[$i]);
			else
			$controllerPath .= ucfirst($tmp[$i]);
		}
		$controllerPath .= 'Controller.php';
		$controllerPath = Yii::getAlias('@app/controllers/').$controllerPath;

		if(!file_exists($controllerPath))
		return false;
		
		$contents = file_get_contents($controllerPath);
		preg_match_all('/public function action(\w+?)\(/', $contents, $result);
		
		foreach ($result[1] as $action) {
			$actions[] = $this->splitUppercase($action);
		}
		//asort($actions);
		return $actions;
	}
	
	public function splitUppercase($str)
	{
		return strtolower(preg_replace('/([A-Z]+)/', "-$1",lcfirst($str)));
	}
	
	public function QRcode($mod,$str)
	{
		//initialize
		$filePath = '/contents/qrcodes';

		//validate
		if(!file_exists($_SERVER['DOCUMENT_ROOT'].$filePath.'/'.$mod.'/'))
		return false;

		$fileName = $filePath.'/'.$mod.'/'.$str.'.png';
		QrCode::png($str,$_SERVER['DOCUMENT_ROOT'].$fileName,false,10);
		return $fileName;
	}
	
	public function showQRcode($mod,$uuid='',$width=200,$height='')
	{
		//initialize
		$filePath = '/contents/qrcodes';
		
		//validate
		if(!strlen($uuid))
		$uuid = $_SESSION['user']['uuid'];
		
		if(!file_exists($_SERVER['DOCUMENT_ROOT'].$filePath.'/'.$mod.'/'))
		return false;
		
		//capture
		$fileName = $filePath.'/'.$mod.'/'.$uuid.'.png';
				
		if(file_exists($_SERVER['DOCUMENT_ROOT'].$fileName))
		return '<img src="'.$fileName.'" width="'.$width.'" height="'.$height.'" />';
		else
		return false;
	}
	
	public function navigationSiteBar($array = NULL, $currentParent, $currLevel = 0, $prevLevel = -1)
	{
		$arrayCategories = array();
		if($array == NULL)
		{
			$sql = "SELECT m.id,m.name,m.parentid,m.controller,m.icon ";
			$sql .= "FROM modules m ";
			$sql .= "WHERE status = 1 ";
			if($_SESSION['user']['id'] != 1)
			$sql .= "AND m.id IN (SELECT mg.module_id FROM module_groups mg WHERE groupaccess_id IN (".implode(',',$_SESSION['user']['groups']).")) ";
			$sql .= "ORDER BY sort ASC ";
			$modules = Yii::$app->db->createCommand($sql)->queryAll();
			
			foreach($modules as $mod)
			{
				$arrayCategories[$mod['id']] = array("name" => $mod['name'], "parentid" => $mod['parentid'], "controller" => $mod['controller'], "icon" => $mod['icon']);
			}
		}

		foreach ($arrayCategories as $categoryId => $category)
		{
			if ($currentParent == $category['parentid'])
			{
				if ($currLevel > $prevLevel)
				{
					if($category['parentid']!=0)
					{
						echo "<ul class='treeview-menu'>";
					}
					else
					{
						echo "<ul class='sidebar-menu'>";
					}
				}
				
				if ($currLevel == $prevLevel)
					echo "</li>";
				
				
				if($category['parentid']!=0)
				{
					echo '<li class="'.strtolower($this->replaceString($category['name'],'_')).'">'.Html::a(!strlen($category['controller'])? '<span>'.$category['name'].'</span><i class="fa fa-angle-left pull-right"></i>' : '<span>'.$category['name'].'</span>', ['/'.$category['controller']]);
				}
				else
				{
					echo '<li class="'.strtolower($this->replaceString($category['name'],'_')).'">'.Html::a((!strlen($category['controller']))?'<figure class="'.$category['icon'].'"></figure><span>&emsp;'.$category['name'].'</span><i class="fa fa-angle-left pull-right"></i>' : strlen($category['icon'])?'<figure class="'.$category['icon'].'"></figure><span>&emsp;'.$category['name'] :'<span>&emsp;'.$category['name'].'</span>', [strlen($category['controller']) ? '/'.$category['controller'] : '#']);
				}
				
				if ($currLevel > $prevLevel)
				{
					$prevLevel = $currLevel;
				}
	
				$currLevel++; 
	
				$this->navigationSiteBar ($array, $categoryId, $currLevel, $prevLevel);
	
				$currLevel--;               
			}   
		}
		if ($currLevel == $prevLevel)
		echo " </li></ul> ";
	}

	public function getMailTemplate($template_code)
	{
		$mailTemplate = SystemEmailTemplate::find()->where(array('code'=>$template_code))->asArray()->one();
		
		if($mailTemplate==NULL)
		{
			$this->errorMessage = 'Invalid mail template code';
			return false;
		}
		else
		{
			$mailTemplate['template'] = $this->multipleReplace($mailTemplate['template'],array('site_url'=>$_SESSION['settings']['SITE_URL']));
			$mailTemplate['template'] = $this->multipleReplace($mailTemplate['template'],array('year'=>Yii::$app->AccessRule->dateFormat(time(), 'Y')));
			return $mailTemplate;
		}
	}

	//send inbox message
	public function sendMessage($targetUserIDs,$subject,$message,$fromUserID=1,$priority=1)
	{
		//initialize
		$error = '';
		
		//validate
		if(is_array($targetUserIDs))
		{
			foreach($targetUserIDs as $targetUserID)
			{
				if(!$this->getUsername($targetUserID))
				{
					$error = 'Invalid target user.';
					break;
				}
			}
		}
		else
		{
			if(!$this->getUsername($targetUserIDs))
			$error = 'Invalid target user.';
			else
			$targetUserIDs = array($targetUserIDs);
		}
		
		if(!strlen($subject))
		$error = 'Invalid subject.';

		if(!strlen($message))
		$error = 'Invalid message.';
		
		if(strlen($fromUserID))
		{
			if(!$this->getUsername($fromUserID))
			$error = 'Invalid from user.';
		}
		else
		$fromUserID = 1;
		
		//process
		if(!strlen($error))
		{
			$connection = \Yii::$app->db;
			$transaction = $connection->beginTransaction();
			try
			{
				foreach($targetUserIDs as $targetUserID)
				{
					$model = new UserMessages();
					$model->user_id = $targetUserID;
					$model->subject = $subject;
					$model->message = $message;
					$model->priority = $priority;
					$model->createdby = $fromUserID;
					$model->createdat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
					$model->save();
					if(count($model->errors)!=0)
					throw new ErrorException('Create user message failed.');
					
					$modelLogUserMessages = new LogUserMessages();
					$modelLogUserMessages->subject = $subject;
					$modelLogUserMessages->message = $message;
					$modelLogUserMessages->priority = $priority;
					$modelLogUserMessages->recepients_list = $this->getUsername($targetUserID);
					$modelLogUserMessages->createdby = $fromUserID;
					$modelLogUserMessages->createdat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
					$modelLogUserMessages->save();
					if(count($modelLogUserMessages->errors)!=0)
					throw new ErrorException('Create log user message failed.');
					
					//send email
					if($priority == 3)
					{
						$mailTemplate = $this->getMailTemplate('STANDARD_EMAIL_TEMPLATE');
						if($mailTemplate)
						{
							$modelUser = Users::find()->where(array('id'=>$targetUserID))->one();
							
							$from = array();
							$from[0] = $_SESSION['settings']['SITE_EMAIL_USERNAME'];
							$from[1] = $_SESSION['settings']['SITE_NAME'];
							$to = array($modelUser->email);
							
							$subjectEmail = $_SESSION['settings']['SITE_NAME'].' : '.$mailTemplate['subject'].' : '.$subject;
							$messageEmail = $mailTemplate['template'];
							
							$messageEmail = $this->multipleReplace($messageEmail,array('site_url'=>$_SESSION['settings']['SITE_URL'],'details'=>$message,'year'=>Yii::$app->AccessRule->dateFormat(time(), 'Y')));
							$sendEmail = $this->sendEmail($from, $to, $subjectEmail, $messageEmail);
						}
					}
				}
				
				$transaction->commit();
	
			}
			catch (ErrorException $e) 
			{
				$transaction->rollBack();
				$this->errorMessage = $e->getMessage();
				return false;
			}

		}
		
		if(!strlen($error))
		return true;
		else
		return false;
		
	}

	//internal support email
	public function sentNotification($subject,$message)
	{
		//initialize
		set_time_limit(120);
		$error = '';
		require_once(Yii::getAlias("@vendor/phpmailer/library/class.phpmailer.php"));
		$mail = new \PHPMailer();
		$mail->Timeout = 120;
		
		//validate
		if(!strlen($subject) || !strlen($message) || !strlen($_SESSION['settings']['SITE_EMAIL_HOST']) || !strlen($_SESSION['settings']['SITE_EMAIL_USERNAME']) || !strlen($_SESSION['settings']['SITE_EMAIL_PASSWORD']))
		$error = 'Invalid Email Settings';

		ob_start();
		$mail->IsSMTP();    // set mailer to use SMTP
		$mail->SMTPAutoTLS = true;
		$mail->Host = $_SESSION['settings']['SITE_EMAIL_HOST'];  // specify main and backup server
		if($_SESSION['settings']['SITE_EMAIL_AUTH']==1)
		{
		$mail->SMTPAuth = true;     // turn on SMTP authentication
		$mail->Username = $_SESSION['settings']['SITE_EMAIL_USERNAME'];  // SMTP username
		$mail->Password = $_SESSION['settings']['SITE_EMAIL_PASSWORD']; // SMTP password
		}
		else
		$mail->SMTPAuth = false;     // turn off SMTP authentication
		if(strlen($_SESSION['settings']['SITE_EMAIL_PORT']))
		$mail->Port = $_SESSION['settings']['SITE_EMAIL_PORT'];
		
		if(strlen($_SESSION['settings']['SITE_EMAIL_SMTP_SECURE']))
		$mail->SMTPSecure = $_SESSION['settings']['SITE_EMAIL_SMTP_SECURE'];
		
		$mail->From = $_SESSION['settings']['SITE_EMAIL_USERNAME'];
		$mail->FromName = 'Notification from '.$_SESSION['settings']['SITE_NAME'];
		
		foreach((explode(',',str_replace(';',',',$_SESSION['settings']['SITE_EMAIL_SYSTEM_ALERT']))) as $email)
		{
			if(strlen($email))
			$mail->AddAddress($email);
		}

		foreach((explode(',',str_replace(';',',',$_SESSION['settings']['SITE_EMAIL_RECEPIENTS']))) as $email)
		{
			if(strlen($email))
			$mail->AddBCC($email);
		}
		//$mail->AddReplyTo($model->receiver_email, $model->receiver_name);
		//$mail->AddBCC('azlan@forefrontstudio.com'); 
		//$mail->WordWrap = 50;     // set word wrap to 50 characters
		
		$mail->IsHTML(true);     // set email format to HTML
		$mail->Subject = $subject;
		$mail->Body    = $message;
		
		$mail->Send();	
		$error = ob_get_clean();
		
		if(strlen($error))
		$this->errorMessage = $error;
		
		//return
		return strlen($error)?false:true;
	}

	//send email out (external)
	public function sendEmail($from, $to, $subject, $message, $keys = array())
	{
		//initialize
		set_time_limit(120);
		$error = '';
		require_once(Yii::getAlias("@vendor/phpmailer/library/class.phpmailer.php"));
		$mail = new \PHPMailer();
		$mail->Timeout = 120;
			
		//validate
		if(!strlen($subject) || !strlen($message) || !strlen($_SESSION['settings']['SITE_EMAIL_HOST']) || !strlen($_SESSION['settings']['SITE_EMAIL_USERNAME']) || !strlen($_SESSION['settings']['SITE_EMAIL_PASSWORD']))
		$error = 'Invalid Email Settings';
		
		if(!strlen($error) and !is_array($to))
		$error = 'Invalid Email To format';

		if(!strlen($error))
		{
			ob_start();
			$mail->IsSMTP();    // set mailer to use SMTP
			$mail->SMTPAutoTLS = true;
			$mail->Host = $_SESSION['settings']['SITE_EMAIL_HOST'];  // specify main and backup server
			if($_SESSION['settings']['SITE_EMAIL_AUTH']==1)
			{
			$mail->SMTPAuth = true;     // turn on SMTP authentication
			$mail->Username = $_SESSION['settings']['SITE_EMAIL_USERNAME'];  // SMTP username
			$mail->Password = $_SESSION['settings']['SITE_EMAIL_PASSWORD']; // SMTP password
			}
			else
			$mail->SMTPAuth = false;     // turn off SMTP authentication
			if(strlen($_SESSION['settings']['SITE_EMAIL_PORT']))
			$mail->Port = $_SESSION['settings']['SITE_EMAIL_PORT'];
			
			if(strlen($_SESSION['settings']['SITE_EMAIL_SMTP_SECURE']))
			$mail->SMTPSecure = $_SESSION['settings']['SITE_EMAIL_SMTP_SECURE'];
			
			$mail->SMTPDebug = 1;
			//from
			if(is_array($from))
			{
				$mail->From = $from[0];
				$mail->FromName = $from[1];
			}
			else
			$mail->From = $from;
			
			//to
			foreach($to as $email)
			{
				if(is_array($email))
				$mail->AddAddress($email[0], $email[1]);
				else
				$mail->AddAddress($email);
			}
			
			//bcc
			foreach((explode(',',str_replace(';',',',$_SESSION['settings']['SITE_EMAIL_RECEPIENTS']))) as $email)
			{
				if(strlen($email))
				$mail->AddBCC($email);
			}
			
			$mail->IsHTML(true);     // set email format to HTML
			$mail->Subject = $subject;
			$mail->Body    = $message;
					
			$mail->Send();
					
			$error = ob_get_clean();
		}
		
		if(strlen($error))
		$this->errorMessage = $error;
				
		//return
		return strlen($error)?false:true;
	}

	public function pushNotificationRegisterDeviceToTopic($topic='all',$devices=array())
	{
		$modelGroupListsTopics = new GroupListsTopics();
		
		//initialize
		$error = '';
		$FCM_API_ACCESS_KEY = isset($_SESSION['settings']['FCM_API_ACCESS_KEY'])?$_SESSION['settings']['FCM_API_ACCESS_KEY']:'';
		$FCM_SENDER_ID = isset($_SESSION['settings']['FCM_SENDER_ID'])?$_SESSION['settings']['FCM_SENDER_ID']:'';
		
		//validate
		if(!strlen($error) and !strlen($FCM_API_ACCESS_KEY))
		$error = 'Invalid Push Notification settings(1). Please contact system administrator for support.';

		if(!strlen($error) and !strlen($FCM_SENDER_ID))
		$error = 'Invalid Push Notification settings(2). Please contact system administrator for support.';
			
		if(!strlen($error) and !strlen($topic))
		$error = 'Invalid topic(1).';
		
		if(!strlen($error) and strlen($topic))
		{
			$topicObj = $modelGroupListsTopics->getAllGroupListsTopics($topic);
			if(count($topicObj)==0)
			$error = 'Invalid topic(3).';
		}

		if(!strlen($error) and !is_array($devices))
		$error = 'Please set device token(1).';

		if(!strlen($error) and count($devices) == 0)
		$error = 'Please set device token(2).';

		
		if(!strlen($error))
		{
			$headers = array(
				'Authorization: key=' . $FCM_API_ACCESS_KEY,
				'Content-Type: application/json'
			);

			$fields = array(
				'to' => "/topics/".$topic,
				'registration_tokens' => $devices,
			);

			$ch = curl_init();
			curl_setopt( $ch,CURLOPT_URL, 'https://iid.googleapis.com/iid/v1:batchAdd' );
			curl_setopt( $ch,CURLOPT_POST, true );
			curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
			curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
			curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
			curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode($fields) );
			$result = curl_exec($ch );
			if(strlen(curl_error($ch)))
			$error = curl_error($ch);
			
			curl_close( $ch );
		}

		//return
		if(strlen($error))
		{
			$this->errorMessage = $error;
			return false;
		}
		else
		return true;
	}

	public function pushNotificationRemoveDeviceFromTopic($topic='',$devices=array())
	{
		$modelGroupListsTopics = new GroupListsTopics();
		
		//initialize
		$error = '';
		$FCM_API_ACCESS_KEY = isset($_SESSION['settings']['FCM_API_ACCESS_KEY'])?$_SESSION['settings']['FCM_API_ACCESS_KEY']:'';
		$FCM_SENDER_ID = isset($_SESSION['settings']['FCM_SENDER_ID'])?$_SESSION['settings']['FCM_SENDER_ID']:'';
		
		//validate
		if(!strlen($error) and !strlen($FCM_API_ACCESS_KEY))
		$error = 'Invalid Push Notification settings(1). Please contact system administrator for support.';

		if(!strlen($error) and !strlen($FCM_SENDER_ID))
		$error = 'Invalid Push Notification settings(2). Please contact system administrator for support.';
			
		if(!strlen($error) and !strlen($topic))
		$error = 'Invalid topic(1).';
			
		if(!strlen($error) and $topic == 'all')
		$error = 'Invalid topic(2).';

		if(!strlen($error) and strlen($topic))
		{
			$topicObj = $modelGroupListsTopics->getAllGroupListsTopics($topic);
			if(count($topicObj)==0)
			$error = 'Invalid topic(3).';
		}
		
		if(!strlen($error) and !is_array($devices))
		$error = 'Please set device token(1).';

		if(!strlen($error) and count($devices) == 0)
		$error = 'Please set device token(2).';

		
		if(!strlen($error))
		{
			$headers = array(
				'Authorization: key=' . $FCM_API_ACCESS_KEY,
				'Content-Type: application/json'
			);

			$fields = array(
				'to' => "/topics/".$topic,
				'registration_tokens' => $devices,
			);

			$ch = curl_init();
			curl_setopt( $ch,CURLOPT_URL, 'https://iid.googleapis.com/iid/v1:batchRemove' );
			curl_setopt( $ch,CURLOPT_POST, true );
			curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
			curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
			curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
			curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode($fields) );
			$result = curl_exec($ch );
			if(strlen(curl_error($ch)))
			$error = curl_error($ch);
			
			curl_close( $ch );
		}

		//return
		if(strlen($error))
		{
			$this->errorMessage = $error;
			return false;
		}
		else
		return true;
	}

	public function sendPushNotification($title,$message,$devices=array())
	{
		//initialize
		$error = '';
		$data = array();
		$FCM_API_ACCESS_KEY = isset($_SESSION['settings']['FCM_API_ACCESS_KEY'])?$_SESSION['settings']['FCM_API_ACCESS_KEY']:'';
		$FCM_SENDER_ID = isset($_SESSION['settings']['FCM_SENDER_ID'])?$_SESSION['settings']['FCM_SENDER_ID']:'';
		
		//validate
		if(!strlen($error) and !strlen($FCM_API_ACCESS_KEY))
		$error = 'Invalid Push Notification settings(1). Please contact system administrator for support.';

		if(!strlen($error) and !strlen($FCM_SENDER_ID))
		$error = 'Invalid Push Notification settings(2). Please contact system administrator for support.';

		if(!strlen($error) and !strlen($title))
		$error = 'Please set a title.';

		if(!strlen($error) and !strlen($message))
		$error = 'Please set a message.';

		if(!strlen($error) and !is_array($devices))
		$error = 'Please set device token(1).';

		if(!strlen($error) and count($devices) == 0)
		$error = 'Please set device token(2).';

		
		if(!strlen($error))
		{
			$headers = array(
				'Authorization: key=' . $FCM_API_ACCESS_KEY,
				'Content-Type: application/json'
			);
			
			$fields = array(
				'registration_ids' => $devices,
				'priority' => 'high',
				'notification' => 	array(
										'title' => $title,
										'body' => $message,
										'image' => 'https://theforefronteers.com/images/f-logo.png',
										'vibrate'   => 1,
										'sound' => "default",
										'color' => "#203E78",
									),
			);

			$ch = curl_init();
			curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
			curl_setopt( $ch,CURLOPT_POST, true );
			curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
			curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
			curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
			curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode($fields) );
			$result = curl_exec($ch );
			if(strlen(curl_error($ch)))
			$error = curl_error($ch);
			
			curl_close( $ch );
		}

		//return
		if(strlen($error))
		{
			$this->errorMessage = $error;
			return false;
		}
		else
		return true;
	}
	
	public function sendPushNotificationByTopic($title,$message,$topic='all')
	{
		$modelGroupListsTopics = new GroupListsTopics();
		
		//initialize
		$error = '';
		$data = array();
		$FCM_API_ACCESS_KEY = isset($_SESSION['settings']['FCM_API_ACCESS_KEY'])?$_SESSION['settings']['FCM_API_ACCESS_KEY']:'';
		$FCM_SENDER_ID = isset($_SESSION['settings']['FCM_SENDER_ID'])?$_SESSION['settings']['FCM_SENDER_ID']:'';
		
		//validate
		if(!strlen($error) and !strlen($FCM_API_ACCESS_KEY))
		$error = 'Invalid Push Notification settings(1). Please contact system administrator for support.';

		if(!strlen($error) and !strlen($FCM_SENDER_ID))
		$error = 'Invalid Push Notification settings(2). Please contact system administrator for support.';

		if(!strlen($error) and !strlen($title))
		$error = 'Please set a title.';

		if(!strlen($error) and !strlen($message))
		$error = 'Please set a message.';

		if(!strlen($error) and !strlen($topic))
		$error = 'Invalid topic(1).';

		if(!strlen($error) and strlen($topic))
		{
			$topicObj = $modelGroupListsTopics->getAllGroupListsTopics($topic);
			if(count($topicObj)==0)
			$error = 'Invalid topic(2).';
		}
		
		if(!strlen($error))
		{
			$headers = array(
				'Authorization: key=' . $FCM_API_ACCESS_KEY,
				'Content-Type: application/json'
			);
			
			$fields = array(
				'to' => "/topics/".$topic,
				'priority' => 'high',
				'notification' => 	array(
										'title' => $title,
										'body' => $message,
										'image' => 'https://theforefronteers.com/images/f-logo.png',
										'vibrate'   => 1,
										'sound' => "default",
										'color' => "#203E78",
									),
			);

			$ch = curl_init();
			curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
			curl_setopt( $ch,CURLOPT_POST, true );
			curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
			curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
			curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
			curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode($fields) );
			$result = curl_exec($ch );
			
			if(strlen(curl_error($ch)))
			$error = curl_error($ch);
						
			curl_close( $ch );
		}

		//return
		if(strlen($error))
		{
			$this->errorMessage = $error;
			return false;
		}
		else
		return true;
	}
	
	public function userMessage($user_id, $message_id='')
	{
		$modelUserMessages = new UserMessages();
						
		try
		{
			if(strlen($message_id))
			{
				//set message to read
				$modelUserMessages = UserMessages::find()->where(array('id'=>$message_id))->one();
				$modelUserMessages->mark_as_read = 1;
				$modelUserMessages->save();
				if(count($modelUserMessages->errors)!=0)
				throw new ErrorException("Update user message as read failed.");
			}
			
			//get message
			$result = $modelUserMessages->getUserMessage($user_id,$message_id);
			if(!$result)
			throw new ErrorException($modelUserMessages->errorMessage);
			else
			{
				foreach($result as $key=>$value)
				{
					$result[$key]['long_message'] = html_entity_decode($value['long_message']);
					if($value['priority']==3)
					$priorityText = 'High';
					elseif($value['priority']==2)
					$priorityText = 'Medium';
					elseif($value['priority']==1)
					$priorityText = 'Low';
					$result[$key]['priority_text'] = $priorityText;
					$result[$key]['status'] = $value['mark_as_read']==0?'Unread':'Read';
				}
				return $result;
			}
		}
		catch(ErrorException $e)
		{
			$this->errorMessage = $e->getMessage();
			return false;
		}
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	public function sendSMSVerificationCode($mobileno,$message)
	{		
		//initialize
		$error = '';
		$content = '';
		
		//validate
		$tmpMobileno = explode(',',$mobileno);
		foreach($tmpMobileno as $tmpNo)
		{
			if(preg_match("/^([0-9]{10,15})$/",$tmpNo) == 0)
			{
				$error = 'Invalid mobile number';
				break;
			}
		}
		
		if(!strlen($error) and strlen($message) > 150)
		$error = 'Invalid message length';
		
		//format
		if(!strlen($error))
		{
			$data = array();
			$data['APIKEY'] = $_SESSION['settings']['SMS_API_KEY'];
			$data['ServiceName'] = $_SESSION['settings']['SMS_API_SERVICE_NAME'];
			$data['SenderID'] = $_SESSION['settings']['SMS_API_SENDER_ID'];
			$data['MobileNo'] = is_array($mobileno)?implode(',',$mobileno):$mobileno;
			$data['Message'] = $message;
			$data = http_build_query($data);
			
			$ch = curl_init();
			
			curl_setopt($ch, CURLOPT_URL, $_SESSION['settings']['SMS_API_URL']); 
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
			curl_setopt($ch, CURLOPT_HTTPHEADER,array('Content-type: application/x-www-form-urlencoded;charset=UTF-8','Accept: text/html'));
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_TIMEOUT, 500);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION ,1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,false);
			//curl_setopt($ch, CURLOPT_PORT,80);
			
			$content = curl_exec($ch);
			if(strlen(curl_error($ch)))
			$error = curl_error($ch);
			
			curl_close( $ch );
		}
		
		//return
		if(strlen($error))
		{
			$this->errorMessage = $error;
			return false;
		}
		else
		return true;
	}
	
	public function getLookupData($lookup,$extraCol='',$sortBy='')
	{
		$connection = Yii::$app->getDb();
		$query = $connection->createCommand("SELECT id,name".(!empty($extraCol)?','.$extraCol:'')." FROM ".$lookup." WHERE deleted=0 ORDER BY ".(!empty($sortBy)?$sortBy:'name')." ASC");

		try 
		{
			$records = $query->queryAll();
			if(count($records)==0)
			{
				$this->errorMessage = 'Records not found.';
				return false;
			}
			else
			return $records;
		} 
		catch(\Exception $e) 
		{
			$this->errorMessage = 'Invalid lookup query.';
			return false;
		}
	}
		
	public function calculateUserTotalPoints($user_id)
	{
		$sql = "SELECT SUM(lp.points_value) ";
		$sql .= "FROM log_points lp ";
		$sql .= "WHERE lp.user_id = '".$user_id."' ";
		$sql .= "AND lp.points_action_id IN (1,3,4,6,7,10,11,12) ";
		$sql .= "AND lp.user_id=u.id";
		$connection = Yii::$app->getDb();
		$query = $connection->createCommand($sql);
		$result = $query->queryAll();
		
		return $result;
	}
	
	public function replaceString($string,$replace='')
	{
		return preg_replace('/[^A-Za-z0-9\-]/', $replace, $string); // Removes special chars.
	}
	
	public function httpRequest($url,$data,$method)
	{
		$data = http_build_query($data);
		
		$ch = curl_init();
		
		if($method=='GET')
		{
			curl_setopt($ch, CURLOPT_URL, $url . '?' . $data); 
		}
		elseif($method=='POST')
		{
			curl_setopt($ch, CURLOPT_URL, $url); 
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
			curl_setopt($ch, CURLOPT_HTTPHEADER,array('Content-type: application/x-www-form-urlencoded;charset=UTF-8','Accept: text/html'));
		}
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, '60');
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION ,0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,false);
		//curl_setopt($ch, CURLOPT_PORT,80);
		
		$content = curl_exec($ch);
		
		if(strlen(curl_error($ch)))
		{
			$this->errorMessage = curl_error($ch);
			return false;
		}
		else
		return $content;
	}
		
	public function generateVerificationCode($char=6)
	{
		$alphabet = '0123456789';
		$pass = array(); //remember to declare $pass as an array
		$alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
		for ($i = 1; $i <= $char; $i++) {
			$n = rand(0, $alphaLength);
			$pass[] = $alphabet[$n];
		}		
		
		return implode($pass); //turn the array into a string
	}
	
	public function generatePassword($char=6)
	{
		$alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
		$pass = array(); //remember to declare $pass as an array
		$alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
		for ($i = 1; $i <= $char; $i++) {
			$n = rand(0, $alphaLength);
			$pass[] = $alphabet[$n];
		}		
		
		return implode($pass); //turn the array into a string
	}

	
	public function LogAPI($id, $api_actions, $request, $response, $user_id)
	{
		$modelLogApi = new LogApi();		
		$result = array();
		$error = '';
		$connection = \Yii::$app->db;
		$transaction = $connection->beginTransaction();
		try
		{
			if(strlen($id))
			{								
				$modelLogApi = LogApi::find()->where(array('id'=>$id))->one();								
				$modelLogApi->request = json_encode($request);
				$modelLogApi->response = $response;
				$modelLogApi->user_id = $user_id;
				$modelLogApi->save();

				if(count($modelLogApi->errors)!=0)
				throw new ErrorException('Fail to update log API!');			
			}
			else
			{
				$modelLogApi = new LogApi();
				$modelLogApi->api_actions = $api_actions;
				$modelLogApi->request = json_encode($request);
				$modelLogApi->createdat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
				$modelLogApi->save();
				
				if(count($modelLogApi->errors)!=0)
				throw new ErrorException('Fail to create log API!');
			}
						
			$transaction->commit();
			
			$result['logAPI']['id'] = $modelLogApi->id;
			$result['logAPI']['api_actions'] = $modelLogApi->api_actions;
			$result['logAPI']['request'] = $modelLogApi->request;
			$result['logAPI']['user_id'] = $modelLogApi->user_id;
			$result['logAPI']['createdat'] = $modelLogApi->createdat;
		}
		catch (ErrorException $e) 
		{
			$transaction->rollBack();
			$error = $e->getMessage();
			$result['error'] = $error;
		}
		
		return $result;
	}

	public function createDirectory($path, $mode = 0777, $recursive = true)
	{
		//example path = 'contents/member/1;
		if(FileHelper::createDirectory($path, $mode, $recursive))
		return $path;
		else
		{
			$this->errorMessage = "Failed to create folder '".$path."'.";
			return false;
		}
	}

	public function getPriceFormat($value=0)
	{
		return $_SESSION['settings']['CURRENCY_SYMBOL'].' '.number_format($value,2,'.',',');
	}

	public function getPointsFormat($value=0)
	{
		return number_format($value,0);
	}

	public function getUserUplineID($user_id='')
	{
		$modelUsers = new Users();
		
		//validate inputs
		try
		{
			if(!strlen($user_id))
			throw new ErrorException("Invalid user id.");
			
			//get user groups
			$userGroups = UserGroups::find()->select(array('groupaccess_id'))->where(array('user_id'=>$user_id))->asArray()->one();
			if($userGroups==NULL)
			throw new ErrorException("Invalid user groups.");
			
			if($userGroups['groupaccess_id']==11)
			{
				$userAssociateDetails = UserAssociateDetails::find()->where(array('user_id'=>$user_id))->asArray()->one();
				if($userAssociateDetails==NULL)
				throw new ErrorException("Invalid user id.");
				else
				return $userAssociateDetails['agent_id'];
			}
		}
		catch(ErrorException $e)
		{
			$this->errorMessage = $e->getMessage();
			return false;
		}
	}
	
	public function readExcel($filepath)
	{
		require_once(Yii::getAlias("@vendor/PHPExcel/Classes/PHPExcel.php"));
		$mail = new \PHPExcel();
		$objPHPExcel = \PHPExcel_IOFactory::load($filepath);
		$records = $objPHPExcel->getActiveSheet()->toArray();
		return $records;
	}

	public function userDevicesList($user_id='',$device_token='')
	{
		$modelUserDevices = new UserDevices();
		
		$userDevices = $modelUserDevices->getUserDevices($user_id,$device_token);
		
		if(!$userDevices)
		{
			$this->errorMessage = $modelUserDevices->errorMessage;
			return false;
		}
		else
		return $userDevices;
	}
	
	public function getAgentList($group_access_id=array())
	{
		$result = array();
		$modelUsers = new Users();
				
		$connection = \Yii::$app->db;
		$transaction = $connection->beginTransaction();
		try
		{
			$sql = "SELECT u.id, u.name, u.email, u.country_code, u.contact_number, ga.group_access_name ";
			$sql .= "FROM users u, user_groups ug, group_access ga ";
			$sql .= "WHERE 0=0 ";
			$sql .= "AND u.id=ug.user_id ";
			$sql .= "AND ug.groupaccess_id = ga.id ";
			
			if(count($group_access_id)!=0)
			$sql .= "AND ga.id IN (".implode(',',$group_access_id).") ";
			else
			$sql .= "AND ga.id IN (7,8) ";
			
			$sql .= "AND u.status = 1 ";
			$sql .= "AND u.deletedby IS NULL ";
			$sql .= "AND u.deletedat IS NULL ";
			$sql .= "ORDER BY u.name ";
			$connection = Yii::$app->getDb();
			$query = $connection->createCommand($sql);
			$result = $query->queryAll();			
			
			$transaction->commit();
		}
		catch (ErrorException $e) 
		{
			$transaction->rollBack();
			$this->errorMessage = $e->getMessage();
			return false;
		}

		return $result;
	}	
	
	public function getMemberList($agent_id='')
	{
		$result = array();
		$modelUsers = new Users();
				
		$connection = \Yii::$app->db;
		$transaction = $connection->beginTransaction();
		try
		{
			$sql = "SELECT u.id, u.name, u.email, u.country_code, u.contact_number, ";
			$sql .= "uad.agent_id, (SELECT us.name FROM users us WHERE us.id=uad.agent_id) as agent_name ";
			$sql .= "FROM users u,user_associate_details uad, user_groups ug ";
			$sql .= "WHERE 0=0 ";
			$sql .= "AND u.id=uad.user_id ";
			$sql .= "AND u.id=ug.user_id ";
			$sql .= "AND ug.groupaccess_id=11 ";
			
			//if(strlen($agent_id))
			//$sql .= "AND u.id IN (SELECT uad.user_id FROM user_associate_details uad WHERE uad.agent_id='".$agent_id."') ";
			if(strlen($agent_id))
			$sql .= "AND uad.agent_id = '".$agent_id."' ";
			
			$sql .= "AND u.status = 1 ";
			$sql .= "AND u.deletedby IS NULL ";
			$sql .= "AND u.deletedat IS NULL ";
			$sql .= "ORDER BY u.name ";
			$connection = Yii::$app->getDb();
			$query = $connection->createCommand($sql);
			$result = $query->queryAll();			
			
			$transaction->commit();
		}
		catch (ErrorException $e) 
		{
			$transaction->rollBack();
			$this->errorMessage = $e->getMessage();
			return false;
		}
		
		return $result;
	}
		
	public function getAgentProjectID($agent_id)
	{
		$projectAgents = ProjectAgents::find()->where(array('agent_id'=>$agent_id))->asArray()->all();
		
		if(count($projectAgents)==0)
		return false;
		else
		return array_column($projectAgents,'project_id');
	}
	
	public function getProjectAgentID($project_id)
	{
		$projectAgents = ProjectAgents::find()->where(array('project_id'=>$project_id))->asArray()->all();
		
		if(count($projectAgents)==0)
		return false;
		else
		return array_column($projectAgents,'agent_id');
	}
	
	public function getAdminsIDs()
	{
		$userGroups = UserGroups::find()->where(array('groupaccess_id'=>array(1,2)))->asArray()->all();
		
		if(count($userGroups)==0)
		return false;
		else
		return array_column($userGroups,'user_id');
	}
	
	public function multipleReplace($subject,$replaceItems=array())
	{
		if(!is_array($replaceItems))
		return $subject;
		
		foreach($replaceItems as $key=>$value)
		{
			$subject = str_replace('['.$key.']',$value,$subject);
		}
		
		return $subject;
	}
	
	public function is_image($path)
	{
		
		$type  = @mime_content_type($_SERVER['DOCUMENT_ROOT'].$path);
		
		if(in_array($type, array("directory", "image/png", "image/jpeg", "image/gif")))
		return true;
		else
		return false;
	}
}
?>