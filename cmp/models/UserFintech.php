<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_fintech".
 *
 * @property integer $id
 * @property integer $fintech_id
 * @property integer $user_id
 */
class UserFintech extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_fintech';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fintech_id', 'user_id'], 'required'],
            [['fintech_id', 'user_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fintech_id' => 'Fintech ID',
            'user_id' => 'User ID',
        ];
    }
}
