<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "log_user_points".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $points_value
 * @property integer $status
 * @property string $remarks
 * @property integer $createdby
 * @property string $createdat
 */
class LogUserPoints extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'log_user_points';
    }

    public function rules()
    {
        return [
            [['user_id', 'points_value', 'status', 'createdby', 'createdat'], 'required'],
            [['user_id', 'createdby'], 'integer'],
            [['points_value'], 'number', 'min'=>0],
            [['remarks'], 'string'],
            [['createdat'], 'safe'],
            [['status'], 'integer'],
        ];
    }

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
	
	public function getLogUserPoints($user_id, $limit='')
	{
		$sql = "SELECT lup.points_value, lup.remarks, lpa.name as action ";
		$sql .= "FROM log_user_points lup, lookup_points_actions lpa ";
		$sql .= "WHERE 0=0 ";
		$sql .= "AND lup.status = lpa.id ";
		$sql .= "AND lup.user_id = '".$user_id."' ";
		$sql .= "ORDER BY lup.createdat DESC ";
		if(strlen($limit))
		$sql .= "LIMIT ".$limit." ";
		
		$connection = Yii::$app->getDb();
		$query = $connection->createCommand($sql);
		$result = $query->queryAll();
				
		if($result==false)
		return array();
		else
		return $result;
	}
	
}
