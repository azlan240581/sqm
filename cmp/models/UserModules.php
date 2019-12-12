<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_modules".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $module_id
 * @property string $permission
 *
 * @property Modules $module
 * @property Users $user
 */
class UserModules extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_modules';
    }

    public function rules()
    {
        return [
            [['user_id', 'module_id', 'permission'], 'required'],
            [['user_id', 'module_id'], 'integer'],
            [['permission'], 'string', 'max' => 255],
            [['module_id'], 'exist', 'skipOnError' => true, 'targetClass' => Modules::className(), 'targetAttribute' => ['module_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'module_id' => 'Module ID',
            'permission' => 'Permission',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModule()
    {
        return $this->hasOne(Modules::className(), ['id' => 'module_id']);
    }

    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }
}
