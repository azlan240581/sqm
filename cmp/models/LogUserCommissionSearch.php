<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\LogUserCommission;

/**
 * LogUserCommissionSearch represents the model behind the search form about `app\models\LogUserCommission`.
 */
class LogUserCommissionSearch extends LogUserCommission
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'commission_group_tier_id', 'prospect_id', 'prospect_booking_id', 'user_commission_id', 'user_eligible_commission_id', 'user_id', 'status', 'createdby'], 'integer'],
            [['commission_amount'], 'number'],
            [['remarks', 'createdat'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = LogUserCommission::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'commission_group_tier_id' => $this->commission_group_tier_id,
            'prospect_id' => $this->prospect_id,
            'prospect_booking_id' => $this->prospect_booking_id,
            'user_commission_id' => $this->user_commission_id,
            'user_eligible_commission_id' => $this->user_eligible_commission_id,
            'user_id' => $this->user_id,
            'commission_amount' => $this->commission_amount,
            'status' => $this->status,
            'createdby' => $this->createdby,
            'createdat' => $this->createdat,
        ]);

        $query->andFilterWhere(['like', 'remarks', $this->remarks]);

        return $dataProvider;
    }
}
