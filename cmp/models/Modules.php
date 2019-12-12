<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "modules".
 *
 * @property integer $id
 * @property string $name
 * @property string $controller
 * @property string $icon
 * @property integer $parentid
 * @property string $class
 * @property integer $sort
 * @property integer $status
 * @property string $updatedat
 *
 * @property LogAudit[] $logAudits
 * @property ModuleGroups[] $moduleGroups
 * @property UserModules[] $userModules
 */
class Modules extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'modules';
    }

    public function rules()
    {
        return [
            [['name', 'controller'], 'required'],
            [['parentid', 'sort', 'status'], 'integer'],
            [['updatedat'], 'safe'],
            [['name', 'controller', 'icon', 'class'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'controller' => 'Controller',
            'icon' => 'Icon',
            'parentid' => 'Parentid',
            'class' => 'Class',
            'sort' => 'Sort',
            'status' => 'Status',
            'updatedat' => 'Updatedat',
        ];
    }
			
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLogAudits()
    {
        return $this->hasMany(LogAudit::className(), ['module_id' => 'id']);
    }

    public function getModuleGroups()
    {
        return $this->hasMany(ModuleGroups::className(), ['module_id' => 'id']);
    }

    public function getUserModules()
    {
        return $this->hasMany(UserModules::className(), ['module_id' => 'id']);
    }
	
	//***************************************//
	
    //for group access assign permission process
    public function getModulesDataList()
	{
		$sql = "SELECT id,name,controller,parentid FROM `modules` WHERE controller IS NOT NULL AND status = 1 ORDER BY sort ASC";
		$module = Yii::$app->db->createCommand($sql)->queryAll();
		
		return $module;
	}
}
