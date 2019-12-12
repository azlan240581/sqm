<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "log_messages".
 *
 * @property integer $id
 * @property string $subject
 * @property string $message
 * @property string $recepients_list
 * @property string $priority
 * @property integer $createdby
 * @property string $createdat
 */
class LogMessages extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'log_messages';
    }

    public function rules()
    {
        return [
            [['subject', 'message', 'recepients_list', 'createdby', 'createdat'], 'required'],
            [['message', 'recepients_list'], 'string'],
            [['priority', 'createdby'], 'integer'],
            [['createdat'], 'safe'],
            [['subject'], 'string', 'max' => 500],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'subject' => 'Subject',
            'message' => 'Message',
            'recepients_list' => 'Recepients List',
            'priority' => 'Priority',
            'createdby' => 'Createdby',
            'createdat' => 'Createdat',
        ];
    }
	
	public function getCreatedByUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'createdby']);
    }
	
}
