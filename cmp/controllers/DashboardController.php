<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\base\ErrorException;

use app\models\UserAssociateDetails;
use app\models\Prospects;


class DashboardController extends \yii\web\Controller
{
	public function init()
	{
		$this->defaultAction = Yii::$app->AccessRule->get_default_action_by_controller($this->id);
	}

    public function actionIndex()
    {
		$totalMemberStatus = Yii::$app->GeneralMod->getTotalMemberStatus();
		$totalProspectStatus = Yii::$app->GeneralMod->getTotalProspectStatus();
		
		/*echo '<pre>';
		print_r($totalMemberStatus);
		print_r($totalProspectStatus);
		echo '</pre>';
		exit();*/
		
        return $this->render('index', [
        	'totalMemberStatus' => $totalMemberStatus,
        	'totalProspectStatus' => $totalProspectStatus,
		]);
    }
	
    public function actionIndexAgent()
    {
		$totalMemberStatus = Yii::$app->GeneralMod->getTotalMemberStatus($_SESSION['user']['id']);
		$totalProspectStatus = Yii::$app->GeneralMod->getTotalProspectStatus($_SESSION['user']['id']);
		
		/*echo '<pre>';
		print_r($totalMemberStatus);
		print_r($totalProspectStatus);
		echo '</pre>';
		exit();*/
		
        return $this->render('index-agent', [
        	'totalMemberStatus' => $totalMemberStatus,
        	'totalProspectStatus' => $totalProspectStatus,
		]);
    }
}
