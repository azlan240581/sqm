<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_eligible_commissions".
 *
 * @property integer $id
 * @property integer $user_commission_id
 * @property integer $prospect_booking_id
 * @property integer $user_id
 * @property string $commission_eligible_amount
 * @property integer $status
 * @property integer $createdby
 * @property string $createdat
 * @property integer $updatedby
 * @property string $updatedat
 * @property integer $deletedby
 * @property string $deletedat
 */
class UserEligibleCommissions extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'user_eligible_commissions';
    }

    public function rules()
    {
        return [
            [['user_commission_id', 'prospect_booking_id', 'user_id', 'commission_eligible_amount', 'createdby', 'createdat'], 'required'],
            [['user_commission_id', 'prospect_booking_id', 'user_id', 'createdby', 'updatedby', 'deletedby'], 'integer'],
            [['commission_eligible_amount'], 'number'],
            [['createdat', 'updatedat', 'deletedat'], 'safe'],
            [['status'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_commission_id' => 'User Commission ID',
            'prospect_booking_id' => 'Prospect Booking ID',
            'user_id' => 'User ID',
            'commission_eligible_amount' => 'Commission Eligible Amount',
            'status' => 'Status',
            'createdby' => 'Createdby',
            'createdat' => 'Createdat',
            'updatedby' => 'Updatedby',
            'updatedat' => 'Updatedat',
            'deletedby' => 'Deletedby',
            'deletedat' => 'Deletedat',
        ];
    }
	
	public function getTotalUserEligibleCommissionsPaid($user_commission_id,$user_id)
	{
		$sql = "SELECT IFNULL(SUM(uec.commission_eligible_amount), 0) as total_eligible_commission_paid ";
		$sql .= "FROM user_eligible_commissions uec  ";
		$sql .= "WHERE 0=0 ";
		$sql .= "AND uec.status = 1 ";

		if(!empty($user_commission_id))
		$sql .= "AND uec.user_commission_id='".$user_commission_id."' ";
		if(!empty($user_id))
		$sql .= "AND uec.user_id='".$user_id."' ";

		$connection = Yii::$app->getDb();
		$query = $connection->createCommand($sql);
		$logCommissions = $query->queryOne();
				
		if(count($logCommissions)==0)
		{
			$this->errorMessage = 'Records not found.';
			return false;
		}
		else
		return $logCommissions['total_eligible_commission_paid'];
	}
	
	
}
