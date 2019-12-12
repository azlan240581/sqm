<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "module_groups".
 *
 * @property integer $id
 * @property integer $module_id
 * @property integer $groupaccess_id
 * @property string $permission
 *
 * @property GroupAccess $groupaccess
 * @property Modules $module
 */
class ModuleGroups extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'module_groups';
    }

    public function rules()
    {
        return [
            [['module_id', 'groupaccess_id', 'permission'], 'required'],
            [['module_id', 'groupaccess_id'], 'integer'],
            [['permission'], 'string'],
            [['groupaccess_id'], 'exist', 'skipOnError' => true, 'targetClass' => GroupAccess::className(), 'targetAttribute' => ['groupaccess_id' => 'id']],
            [['module_id'], 'exist', 'skipOnError' => true, 'targetClass' => Modules::className(), 'targetAttribute' => ['module_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'module_id' => 'Module ID',
            'groupaccess_id' => 'Groupaccess ID',
            'permission' => 'Permission',
        ];
    }
		
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroupaccess()
    {
        return $this->hasOne(GroupAccess::className(), ['id' => 'groupaccess_id']);
    }

    public function getModule()
    {
        return $this->hasOne(Modules::className(), ['id' => 'module_id']);
    }
	
	//************************************//
	
    //for group access assign permission process
    public function getModuleGroupsData($groupaccessID)
    {
		$sql = "SELECT module_id, permission FROM `module_groups` WHERE groupaccess_id = ".$groupaccessID;
		$module_groups = Yii::$app->db->createCommand($sql)->queryAll();
		
		return $module_groups;
	}
}
