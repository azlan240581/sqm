<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "log_associate_registration_approval".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $status
 * @property string $remarks
 * @property integer $createdby
 * @property string $createdat
 */
class LogAssociateRegistrationApproval extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log_associate_registration_approval';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'status', 'remarks', 'createdby', 'createdat'], 'required'],
            [['user_id', 'createdby'], 'integer'],
            [['remarks'], 'string'],
            [['createdat'], 'safe'],
            [['status'], 'string', 'max' => 1],
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
            'status' => 'Status',
            'remarks' => 'Remarks',
            'createdby' => 'Createdby',
            'createdat' => 'Createdat',
        ];
    }
}
