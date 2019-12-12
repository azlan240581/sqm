<?php

namespace app\controllers;

use Yii;

class LogoutController extends \yii\web\Controller
{
	public $defaultAction = 'logout';

    public function actionLogout()
    {
		Yii::$app->user->logout();
		
        //return $this->goHome();
        return $this->redirect(['/dashboard/']);
   }

}
