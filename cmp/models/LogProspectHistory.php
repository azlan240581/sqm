<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "log_prospect_history".
 *
 * @property integer $id
 * @property integer $prospect_id
 * @property integer $prospect_booking_id
 * @property integer $project_id
 * @property integer $history_id
 * @property string $udf1
 * @property string $udf2
 * @property string $udf3
 * @property string $remarks
 * @property integer $createdby
 * @property string $createdat
 */
class LogProspectHistory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log_prospect_history';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['project_id', 'prospect_id', 'history_id', 'createdby', 'createdat'], 'required'],
            [['prospect_id', 'prospect_booking_id', 'project_id', 'history_id', 'level_of_interest', 'site_visit', 'createdby'], 'integer'],
            [['appointment_at', 'createdat'], 'safe'],
            [['appointment_location', 'udf1', 'udf2', 'udf3'], 'string', 'max' => 255],
            [['remarks'], 'string', 'max' => 500],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'project_id' => 'Project ID',
            'prospect_id' => 'Prospect ID',
            'prospect_booking_id' => 'Prospect Booking ID',
            'history_id' => 'History ID',
            'appointment_at' => 'Date / Time',
            'appointment_location' => 'Location',
            'level_of_interest' => 'Level of Interest',
            'site_visit' => 'Site Visit',
            'udf1' => 'Udf1',
            'udf2' => 'Udf2',
            'udf3' => 'Udf3',
            'remarks' => 'Remarks',
            'createdby' => 'Createdby',
            'createdat' => 'Createdat',
        ];
    }

	public function logProspectHistoryByProspectID($prospect_id)
	{
		$history = 	LogProspectHistory::find()
					->select(['log_prospect_history.id','lookup_prospect_history.name','log_prospect_history.remarks','log_prospect_history.createdat'])
					->where(['prospect_id' => $prospect_id])
					->leftJoin('lookup_prospect_history', 'lookup_prospect_history.id=log_prospect_history.history_id')
					->asArray()->all();

		if($history == null)
        return false;
		
		return $history;
	}	

	public function lastLogProspectHistoryByProspectID($prospect_id)
	{
		$history = 	LogProspectHistory::find()
					->select(['log_prospect_history.id','lookup_prospect_history.name','log_prospect_history.remarks','log_prospect_history.createdat'])
					->where(['prospect_id' => $prospect_id])
					->leftJoin('lookup_prospect_history', 'lookup_prospect_history.id=log_prospect_history.history_id')
					->orderBy(['id'=>SORT_DESC])
					->asArray()->one();

		if($history == null)
        return false;
		
		return $history;
	}	
}
