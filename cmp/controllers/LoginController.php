<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\UserGroups;
use yii\helpers\Url;

class LoginController extends \yii\web\Controller
{
	public $defaultAction = 'login';
	
    public function actionLogin()
    {
		$this->layout = 'loginlayout';
		
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        $modelUserGroups = new UserGroups();

        if ($model->load(Yii::$app->request->post()) && $model->login()) 
		{
			//set session user
			if(!Yii::$app->user->isGuest)
			{
				$userID = Yii::$app->user->getId();
				
				//get user info
				$_user = Yii::$app->user->identity;
				
				//update log user
				$model->updateLastLogin($userID,'Successful Login');
	
				//session user
				$session = Yii::$app->session;
				//$user['employer'] = $modelUserEmployer->getEmployerByUserID($_user->id);
				$userGroups = $modelUserGroups->getUserGroups($_user->id);
				$user['groups'] = is_array($userGroups)?$userGroups:array();
				$user['id'] = $_user->id;
				$user['uuid'] = $_user->uuid;
				$user['username'] = $_user->username;
				$user['name'] = $_user->name;
				$user['status'] = (($user['id']==1) ? 1 : $_user->status);
				$user['createdat'] = $_user->createdat;
				$user['lastLogin'] = $model->getLastLogin($user['id']);
				$user['countLoginPerDay'] = $model->getCountLoginPerDay($user['id']);
				$session->set('user', $user);			
			}
						
			//redirect user
			if(isset($_SESSION['browse_history']))
			{				
				$url = $_SESSION['browse_history'];
				unset($_SESSION['browse_history']);
				return $this->redirect($url);
			}
			else			
            return $this->goBack();
        }

        return $this->render('index',array('model' => $model));
    }

}
