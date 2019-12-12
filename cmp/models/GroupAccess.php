<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "group_access".
 *
 * @property integer $id
 * @property string $group_access_name
 * @property integer $sort
 * @property string $updatedat
 * @property integer $status
 *
 * @property ModuleGroups[] $moduleGroups
 * @property UserGroups[] $userGroups
 */
class GroupAccess extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'group_access';
    }

    public function rules()
    {
        return [
            [['group_access_name'], 'required'],
            [['sort', 'status'], 'integer'],
            [['updatedat'], 'safe'],
            [['group_access_name'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'group_access_name' => 'Group Access Name',
            'sort' => 'Sort',
            'updatedat' => 'Updatedat',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModuleGroups()
    {
        return $this->hasMany(ModuleGroups::className(), ['groupaccess_id' => 'id']);
    }

    public function getUserGroups()
    {
        return $this->hasMany(UserGroups::className(), ['groupaccess_id' => 'id']);
    }
}
