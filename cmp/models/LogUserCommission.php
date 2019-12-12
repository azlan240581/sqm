<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "log_user_commission".
 *
 * @property integer $id
 * @property integer $commission_group_tier_id
 * @property integer $prospect_id
 * @property integer $prospect_booking_id
 * @property integer $user_commission_id
 * @property integer $user_eligible_commission_id
 * @property integer $user_id
 * @property string $commission_amount
 * @property integer $status
 * @property string $remarks
 * @property integer $createdby
 * @property string $createdat
 */
class LogUserCommission extends \yii\db\ActiveRecord
{
	public $errorMessage;
	
    public static function tableName()
    {
        return 'log_user_commission';
    }

    public function rules()
    {
        return [
            [['commission_group_tier_id', 'prospect_id', 'prospect_booking_id', 'user_commission_id', 'user_eligible_commission_id', 'user_id', 'status', 'createdby'], 'integer'],
            [['user_id', 'commission_amount', 'status', 'createdby', 'createdat'], 'required'],
            [['commission_amount'], 'number', 'min'=>0],
            [['remarks'], 'string'],
            [['createdat'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'commission_group_tier_id' => 'Commission Group Tier ID',
            'prospect_id' => 'Prospect ID',
            'prospect_booking_id' => 'Prospect Booking ID',
            'user_commission_id' => 'User Commission ID',
            'user_eligible_commission_id' => 'User Eligible Commission ID',
            'user_id' => 'User ID',
            'commission_amount' => 'Commission Amount',
            'status' => 'Status',
            'remarks' => 'Remarks',
            'createdby' => 'Createdby',
            'createdat' => 'Createdat',
        ];
    }
		
	public function getLogUserCommissions($user_id,$prospect_booking_id='',$status='')
	{
		$sql = "SELECT luc.*, p.prospect_name, d.company_name as developer_name, pr.project_name, pp.product_name, pb.product_unit, u.name as createdbyName ";
		$sql .= "FROM log_user_commission luc  ";
		$sql .= "LEFT JOIN prospects p ON p.id = luc.prospect_id ";
		$sql .= "LEFT JOIN prospect_bookings pb ON pb.id = luc.prospect_booking_id ";
		$sql .= "LEFT JOIN projects pr ON pr.id = pb.project_id ";
		$sql .= "LEFT JOIN project_products pp ON pp.id=pb.product_id ";
		$sql .= "LEFT JOIN developers d ON d.id=pr.developer_id ";
		$sql .= "LEFT JOIN users u ON u.id=luc.createdby ";
		$sql .= "WHERE 0=0 ";
		if(!empty($user_id))
		$sql .= "AND luc.user_id='".$user_id."' ";
		if(!empty($prospect_booking_id))
		$sql .= "AND luc.prospect_booking_id='".$prospect_booking_id."' ";
		if(!empty($status))
		$sql .= "AND luc.status='".$status."' ";
		$sql .= "ORDER BY luc.createdat ASC ";

		$connection = Yii::$app->getDb();
		$query = $connection->createCommand($sql);
		$logCommissions = $query->queryAll();
					
		if(count($logCommissions)==0)
		{
			$this->errorMessage = 'Records not found.';
			return false;
		}
		else
		return $logCommissions;
	}
		
	public function getTotalEligibleCommissionGiven($user_id,$prospect_booking_id)
	{
		$sql = "SELECT IFNULL(SUM(luc.commission_amount), 0) as total_commission_paid ";
		$sql .= "FROM log_user_commission luc  ";
		$sql .= "WHERE 0=0 ";
		$sql .= "AND luc.status = 2 ";
		//$sql .= "AND luc.commission_group_tier_id IS NULL ";
		//$sql .= "AND luc.user_commission_id IS NULL ";

		if(!empty($user_id))
		$sql .= "AND luc.user_id='".$user_id."' ";
		if(!empty($prospect_booking_id))
		$sql .= "AND luc.prospect_booking_id='".$prospect_booking_id."' ";

		$connection = Yii::$app->getDb();
		$query = $connection->createCommand($sql);
		$logCommissions = $query->queryOne();
				
		if(count($logCommissions)==0)
		{
			$this->errorMessage = 'Records not found.';
			return false;
		}
		else
		return $logCommissions['total_commission_paid'];
	}
	
	public function getTotalCommissionPaid($user_id,$prospect_booking_id)
	{
		$sql = "SELECT IFNULL(SUM(luc.commission_amount), 0) as total_commission_paid ";
		$sql .= "FROM log_user_commission luc  ";
		$sql .= "WHERE 0=0 ";
		$sql .= "AND luc.status = 4 ";
		//$sql .= "AND luc.commission_group_tier_id IS NULL ";
		//$sql .= "AND luc.user_commission_id IS NULL ";

		if(!empty($user_id))
		$sql .= "AND luc.user_id='".$user_id."' ";
		if(!empty($prospect_booking_id))
		$sql .= "AND luc.prospect_booking_id='".$prospect_booking_id."' ";

		$connection = Yii::$app->getDb();
		$query = $connection->createCommand($sql);
		$logCommissions = $query->queryOne();
				
		if(count($logCommissions)==0)
		{
			$this->errorMessage = 'Records not found.';
			return false;
		}
		else
		return $logCommissions['total_commission_paid'];
	}
	
	
}
