<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "log_audit".
 *
 * @property integer $id
 * @property integer $module_id
 * @property integer $record_id
 * @property string $action
 * @property string $newdata
 * @property string $olddata
 * @property integer $user_id
 * @property string $createdat
 *
 * @property Modules $module
 */
class LogAudit extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log_audit';
    }

    public function rules()
    {
        return [
            [['module_id', 'record_id', 'action', 'newdata', 'olddata', 'user_id', 'createdat'], 'required'],
            [['module_id', 'record_id', 'user_id'], 'integer'],
            [['action', 'newdata', 'olddata'], 'string'],
            [['createdat'], 'safe'],
            [['module_id'], 'exist', 'skipOnError' => true, 'targetClass' => Modules::className(), 'targetAttribute' => ['module_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'module_id' => 'Module ID',
            'record_id' => 'Record ID',
            'action' => 'Action',
            'newdata' => 'Newdata',
            'olddata' => 'Olddata',
            'user_id' => 'User ID',
            'createdat' => 'Createdat',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModule()
    {
        return $this->hasOne(Modules::className(), ['id' => 'module_id']);
    }
}
