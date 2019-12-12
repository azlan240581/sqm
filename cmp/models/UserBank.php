<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_bank".
 *
 * @property integer $id
 * @property integer $bank_id
 * @property integer $user_id
 */
class UserBank extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_bank';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['bank_id', 'user_id'], 'required'],
            [['bank_id', 'user_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'bank_id' => 'Bank ID',
            'user_id' => 'User ID',
        ];
    }
}
