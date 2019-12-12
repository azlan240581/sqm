<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\SettingsCategories;
use app\models\SettingsRules;
use app\models\SettingsRulesValue;
use app\models\Modules;
use app\models\LogAudit;


class SettingsController extends \yii\web\Controller
{
	public function init()
	{
		$this->defaultAction = Yii::$app->AccessRule->get_default_action_by_controller($this->id);
	}
	
    public function actionIndex()
    {
		$data = SettingsCategories::find()->all();
						
        if (count($_POST)!=0)
		{
			$connection = \Yii::$app->db;
			$transaction = $connection->beginTransaction();
			try 
			{				
				$postrules = $_POST['rule'];
				$settingsrules = SettingsRules::find()->all();
				
				foreach($settingsrules as $rule)
				{
					if(!isset($postrules[$rule->settings_rules_key]))
					$postrules[$rule->settings_rules_key]='';
	
					$modelSettingsRulesValue = SettingsRulesValue::find()->where(['settings_rules_id' => $rule->id])->one();
					if($modelSettingsRulesValue != NULL)
					{
						$modelSettingsRulesValue->settings_rules_id = $rule->id;
						$modelSettingsRulesValue->value = ((is_array($postrules[$rule->settings_rules_key])) ? implode(',',$postrules[$rule->settings_rules_key]) : $postrules[$rule->settings_rules_key]);
						$modelSettingsRulesValue->updatedat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
						$modelSettingsRulesValue->save();
					}
					else
					{
						$modelSettingsRulesValue = new SettingsRulesValue();
						$modelSettingsRulesValue->settings_rules_id = $rule->id;
						$modelSettingsRulesValue->value = ((is_array($postrules[$rule->settings_rules_key])) ? implode(',',$postrules[$rule->settings_rules_key]) : $postrules[$rule->settings_rules_key]);
						$modelSettingsRulesValue->updatedat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
						$modelSettingsRulesValue->save();
					}
				}
				
				$transaction->commit();
			}
			catch (\Exception $e) 
			{
				$transaction->rollBack();
				throw $e;
			}
		}
		
        return $this->render('index',[
			'data'=>$data, 
		]);
    }

}
