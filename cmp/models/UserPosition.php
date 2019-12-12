<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_position".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $position_id
 */
class UserPosition extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_position';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'position_id'], 'required'],
            [['user_id', 'position_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'position_id' => 'Position ID',
        ];
    }
}
