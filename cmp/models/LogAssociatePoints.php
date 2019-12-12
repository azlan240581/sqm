<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "log_associate_points".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $points_value
 * @property integer $status
 * @property string $remarks
 * @property integer $createdby
 * @property string $createdat
 */
class LogAssociatePoints extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log_associate_points';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'points_value', 'status', 'createdby', 'createdat'], 'required'],
            [['user_id', 'createdby'], 'integer'],
            [['points_value'], 'number'],
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
            'points_value' => 'Points Value',
            'status' => 'Status',
            'remarks' => 'Remarks',
            'createdby' => 'Createdby',
            'createdat' => 'Createdat',
        ];
    }
}
