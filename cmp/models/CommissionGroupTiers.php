<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "commission".
 *
 * @property integer $id
 * @property integer $commission_group_id
 * @property integer $commission_tier_id
 * @property string $minimum_transaction_value
 * @property string $maximum_transaction_value
 * @property integer $commission_type
 * @property string $commission_value
 * @property integer $expiration_period
 * @property integer $createdby
 * @property string $createdat
 * @property integer $updatedby
 * @property string $updatedat
 * @property integer $deletedby
 * @property string $deletedat
 */
class CommissionGroupTiers extends \yii\db\ActiveRecord
{
	public $errorMessage;
	
    public static function tableName()
    {
        return 'commission_group_tiers';
    }

    public function rules()
    {
        return [
            [['product_type_id', 'commission_group_id', 'commission_tier_id', 'minimum_transaction_value', 'commission_type', 'commission_value', 'expiration_period', 'createdby', 'createdat'], 'required'],
            [['product_type_id', 'commission_group_id', 'commission_tier_id', 'commission_type', 'expiration_period', 'createdby', 'updatedby', 'deletedby'], 'integer'],
            [['minimum_transaction_value', 'maximum_transaction_value', 'commission_value'], 'number', 'min'=>0],
            [['createdat', 'updatedat', 'deletedat'], 'safe'],
            [['expiration_period'], 'integer', 'min'=>0],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_type_id' => 'Product Type ID',
            'commission_group_id' => 'Commission Group ID',
            'commission_tier_id' => 'Commission Tier ID',
            'minimum_transaction_value' => 'Minimum Transaction Value',
            'maximum_transaction_value' => 'Maximum Transaction Value',
            'commission_type' => 'Commission Type',
            'commission_value' => 'Commission Value',
            'expiration_period' => 'Expiration Period (Month)',
            'createdby' => 'Createdby',
            'createdat' => 'Createdat',
            'updatedby' => 'Updatedby',
            'updatedat' => 'Updatedat',
            'deletedby' => 'Deletedby',
            'deletedat' => 'Deletedat',
        ];
    }
	
    public function getLookupProductType()
    {
        return $this->hasOne(LookupProductType::className(), ['id' => 'product_type_id']);
    }
	
    public function getLookupCommissionGroup()
    {
        return $this->hasOne(LookupCommissionGroup::className(), ['id' => 'commission_group_id']);
    }
	
    public function getLookupCommissionTier()
    {
        return $this->hasOne(LookupCommissionTier::className(), ['id' => 'commission_tier_id']);
    }
	
    public function getLookupCommissionType()
    {
        return $this->hasOne(LookupCommissionType::className(), ['id' => 'commission_type']);
    }
	
	
	public function getCommissionGroupTierByTotalTransactionValue($product_type_id,$commission_group_id,$commission_tier_id,$total_transaction_value)
	{
		$sql = "SELECT cgt.id, cgt.product_type_id, cgt.commission_group_id, cgt.commission_tier_id, cgt.minimum_transaction_value, cgt.maximum_transaction_value, cgt.commission_type as commission_type_id, cgt.commission_value, ";
		$sql .= "(SELECT lpt.name FROM lookup_product_type lpt WHERE lpt.id=cgt.product_type_id) as product_type_name, ";
		$sql .= "(SELECT lcg.name FROM lookup_commission_group lcg WHERE lcg.id=cgt.commission_group_id) as commission_group_name, ";
		$sql .= "(SELECT lct.name FROM lookup_commission_tier lct WHERE lct.id=cgt.commission_tier_id) as commission_tier_name, ";
		$sql .= "(SELECT lcty.name FROM lookup_commission_type lcty WHERE lcty.id=cgt.commission_type) as commission_type_name ";
		$sql .= "FROM commission_group_tiers cgt ";
		$sql .= "WHERE 0=0 ";
		
		if(!empty($product_type_id))
		$sql .= "AND cgt.product_type_id=".$product_type_id." ";
		if(!empty($commission_group_id))
		$sql .= "AND cgt.commission_group_id=".$commission_group_id." ";
		if(!empty($commission_tier_id))
		$sql .= "AND cgt.commission_tier_id=".$commission_tier_id." ";
		if(!empty($total_transaction_value))
		{
			$sql .= "AND cgt.minimum_transaction_value <= ".$total_transaction_value." ";
			$sql .= "AND (cgt.maximum_transaction_value >= ".$total_transaction_value." OR cgt.maximum_transaction_value = 0) ";
		}
		
		$sql .= "AND cgt.deletedby IS NULL ";
		$sql .= "AND cgt.deletedat IS NULL ";
		$sql .= "ORDER BY cgt.commission_tier_id DESC ";
		
		$connection = Yii::$app->getDb();
		$query = $connection->createCommand($sql);
		$result = $query->queryOne();
		
		return $result;
	}
	
	
}
