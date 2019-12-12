<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "log_user_messages".
 *
 * @property integer $id
 * @property string $subject
 * @property string $message
 * @property string $long_message
 * @property string $recepients_list
 * @property integer $priority
 * @property integer $createdby
 * @property string $createdat
 */
class LogUserMessages extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'log_user_messages';
    }

    public function rules()
    {
        return [
            [['subject', 'message', 'recepients_list', 'createdby', 'createdat'], 'required'],
            [['message', 'long_message', 'recepients_list'], 'string'],
            [['createdby'], 'integer'],
            [['createdat'], 'safe'],
            [['subject'], 'string', 'max' => 500],
            [['priority'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'subject' => 'Subject',
            'message' => 'Message',
            'long_message' => 'Long Message',
            'recepients_list' => 'Recepients List',
            'priority' => 'Priority',
            'createdby' => 'Createdby',
            'createdat' => 'Createdat',
        ];
    }
}
