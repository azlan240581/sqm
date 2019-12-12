<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\CommissionGroupTiers;

/**
 * CommissionSearch represents the model behind the search form about `app\models\Commission`.
 */
class CommissionGroupTiersSearch extends CommissionGroupTiers
{
	public $lookupProductType, $lookupCommissionGroup, $lookupCommissionTier, $lookupCommissionType;
	
    public function rules()
    {
        return [
            [['id', 'product_type_id', 'commission_group_id', 'commission_tier_id', 'commission_type', 'expiration_period', 'createdby', 'updatedby', 'deletedby'], 'integer'],
            [['minimum_transaction_value', 'maximum_transaction_value', 'commission_value'], 'number'],
            [['lookupProductType', 'lookupCommissionGroup', 'lookupCommissionTier', 'lookupCommissionType', 'createdat', 'updatedat', 'deletedat'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = CommissionGroupTiers::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'pagination' => false,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
		
		$query->joinWith(['lookupProductType']);
		$dataProvider->sort->attributes['lookupProductType'] = [
			'asc' => ['lookup_product_type.name' => SORT_ASC],
			'desc' => ['lookup_product_type.name' => SORT_DESC],
		];
		
		$query->joinWith(['lookupCommissionGroup']);
		$dataProvider->sort->attributes['lookupCommissionGroup'] = [
			'asc' => ['lookup_commission_group.name' => SORT_ASC],
			'desc' => ['lookup_commission_group.name' => SORT_DESC],
		];
		
		$query->joinWith(['lookupCommissionTier']);
		$dataProvider->sort->attributes['lookupCommissionTier'] = [
			'asc' => ['lookup_commission_tier.name' => SORT_ASC],
			'desc' => ['lookup_commission_tier.name' => SORT_DESC],
		];
		
		$query->joinWith(['lookupCommissionType']);
		$dataProvider->sort->attributes['lookupCommissionType'] = [
			'asc' => ['lookup_commission_type.name' => SORT_ASC],
			'desc' => ['lookup_commission_type.name' => SORT_DESC],
		];
		
        // grid filtering conditions
        $query->andFilterWhere([
            'commission_group_tiers.id' => $this->id,
            'commission_group_tiers.product_type_id' => $this->product_type_id,
            'commission_group_tiers.commission_group_id' => $this->commission_group_id,
            'commission_group_tiers.commission_tier_id' => $this->commission_tier_id,
            'commission_group_tiers.minimum_transaction_value' => $this->minimum_transaction_value,
            'commission_group_tiers.maximum_transaction_value' => $this->maximum_transaction_value,
            'commission_group_tiers.commission_type' => $this->commission_type,
            'commission_group_tiers.commission_value' => $this->commission_value,
            'commission_group_tiers.expiration_period' => $this->expiration_period,
            'commission_group_tiers.createdby' => $this->createdby,
            'commission_group_tiers.createdat' => $this->createdat,
            'commission_group_tiers.updatedby' => $this->updatedby,
            'commission_group_tiers.updatedat' => $this->updatedat,
            'commission_group_tiers.deletedby' => $this->deletedby,
            'commission_group_tiers.deletedat' => $this->deletedat,
        ]);

        $query->andFilterWhere(['like', 'LOWER(lookup_product_type.name)', strtolower($this->lookupProductType)])
			->andFilterWhere(['like', 'LOWER(lookup_commission_group.name)', strtolower($this->lookupCommissionGroup)])
			->andFilterWhere(['like', 'LOWER(lookup_commission_tier.name)', strtolower($this->lookupCommissionTier)])
			->andFilterWhere(['like', 'LOWER(lookup_commission_type.name)', strtolower($this->lookupCommissionType)]);

        return $dataProvider;
    }
}
