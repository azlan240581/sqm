<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "activities".
 *
 * @property integer $id
 * @property string $activity_code
 * @property string $activity_name
 * @property string $activity_description
 * @property string $points_value
 * @property integer $status
 * @property integer $createdby
 * @property string $createdat
 * @property integer $updatedby
 * @property string $updatedat
 * @property integer $deletedby
 * @property string $deletedat
 */
class Activities extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'activities';
    }

    public function rules()
    {
        return [
            [['activity_code', 'activity_name', 'createdby', 'createdat'], 'required'],
            [['activity_description'], 'string'],
            [['points_value'], 'number', 'min' => 0],
            [['createdby', 'updatedby', 'deletedby'], 'integer'],
            [['createdat', 'updatedat', 'deletedat'], 'safe'],
            [['activity_code', 'activity_name'], 'string', 'max' => 255],
            [['status'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'activity_code' => 'Activity Code',
            'activity_name' => 'Activity Name',
            'activity_description' => 'Activity Description',
            'points_value' => 'Points Value',
            'status' => 'Status',
            'createdby' => 'Createdby',
            'createdat' => 'Createdat',
            'updatedby' => 'Updatedby',
            'updatedat' => 'Updatedat',
            'deletedby' => 'Deletedby',
            'deletedat' => 'Deletedat',
        ];
    }
	
	public function getActivityInfo($uniqueid)
	{
		$activity = Activities::find()->where(['or',['id' => $uniqueid],['activity_code' => $uniqueid]])->asArray()->one();
		
		if($activity == null)
        return null;
		
		return $activity;
	}	
}
