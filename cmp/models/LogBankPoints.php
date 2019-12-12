<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "log_bank_points".
 *
 * @property integer $id
 * @property string $points_value
 * @property string $remarks
 * @property integer $createdby
 * @property string $createdat
 */
class LogBankPoints extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'log_bank_points';
    }

    public function rules()
    {
        return [
            [['points_value', 'createdby', 'createdat'], 'required'],
            [['points_value'], 'number'],
            [['remarks'], 'string'],
            [['createdby'], 'integer'],
            [['createdat'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'points_value' => 'Points Value',
            'remarks' => 'Remarks',
            'createdby' => 'Createdby',
            'createdat' => 'Createdat',
        ];
    }
	
	public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'createdby']);
    }
}
