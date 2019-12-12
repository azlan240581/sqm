<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_developer".
 *
 * @property integer $id
 * @property integer $developer_id
 * @property integer $user_id
 */
class UserDeveloper extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_developer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['developer_id', 'user_id'], 'required'],
            [['developer_id', 'user_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'developer_id' => 'Developer ID',
            'user_id' => 'User ID',
        ];
    }
}
