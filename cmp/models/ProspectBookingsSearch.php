<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ProspectBookings;

/**
 * ProspectBookingsSearch represents the model behind the search form about `app\models\ProspectBookings`.
 */
class ProspectBookingsSearch extends ProspectBookings
{
    /**
     * @inheritdoc
     */
	public $prospect_name, $agent_name, $dedicated_agent_name, $createdatrange, $eoicreatedatrange, $bookcreatedatrange;
	 
    public function rules()
    {
        return [
            [['id', 'prospect_id', 'agent_id', 'member_id', 'dedicated_agent_id', 'referrer_member_id', 'developer_id', 'project_id', 'product_id', 'product_unit_type', 'payment_method_eoi', 'payment_method', 'createdby', 'updatedby', 'deletedby'], 'integer'],
            [['ref_no', 'prospect_name', 'dedicated_agent_name', 'agent_name', 'createdatrange', 'eoicreatedatrange', 'bookcreatedatrange', 'product_unit', 'express_downpayment', 'eoi_ref_no', 'booking_ref_no', 'cancel_ref_no', 'proof_of_payment_eoi', 'proof_of_payment', 'sp_file', 'ppjb_file', 'cancellation_attachment', 'remarks', 'status', 'createdat', 'updatedat', 'deletedat'], 'safe'],
            [['building_size_sm', 'land_size_sm', 'product_unit_price', 'product_unit_vat_price', 'booking_eoi_amount', 'booking_amount'], 'number'],
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
        $query = ProspectBookings::find();

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
            'prospect_bookings.id' => $this->id,
            'prospect_bookings.prospect_id' => $this->prospect_id,
            'prospect_bookings.agent_id' => $this->agent_id,
            'prospect_bookings.member_id' => $this->member_id,
            'prospect_bookings.dedicated_agent_id' => $this->dedicated_agent_id,
            'prospect_bookings.referrer_member_id' => $this->referrer_member_id,
            'prospect_bookings.developer_id' => $this->developer_id,
            'prospect_bookings.project_id' => $this->project_id,
            'prospect_bookings.product_id' => $this->product_id,
            'prospect_bookings.product_unit_type' => $this->product_unit_type,
            'prospect_bookings.building_size_sm' => $this->building_size_sm,
            'prospect_bookings.land_size_sm' => $this->land_size_sm,
            'prospect_bookings.product_unit_price' => $this->product_unit_price,
            'prospect_bookings.product_unit_vat_price' => $this->product_unit_vat_price,
            'prospect_bookings.payment_method_eoi' => $this->payment_method_eoi,
            'prospect_bookings.booking_eoi_amount' => $this->booking_eoi_amount,
            'prospect_bookings.payment_method' => $this->payment_method,
            'prospect_bookings.booking_amount' => $this->booking_amount,
            'prospect_bookings.createdby' => $this->createdby,
            'prospect_bookings.createdat' => $this->createdat,
            'prospect_bookings.updatedby' => $this->updatedby,
            'prospect_bookings.updatedat' => $this->updatedat,
            'prospect_bookings.deletedby' => $this->deletedby,
            'prospect_bookings.deletedat' => $this->deletedat,
            'prospect_bookings.status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'prospect_bookings.ref_no', $this->ref_no])
			->andFilterWhere(['like', 'prospect_bookings.product_unit', $this->product_unit])
            ->andFilterWhere(['like', 'prospect_bookings.express_downpayment', $this->express_downpayment])
            ->andFilterWhere(['like', 'prospect_bookings.proof_of_payment_eoi', $this->proof_of_payment_eoi])
            ->andFilterWhere(['like', 'prospect_bookings.eoi_ref_no', $this->eoi_ref_no])
            ->andFilterWhere(['like', 'prospect_bookings.booking_ref_no', $this->booking_ref_no])
            ->andFilterWhere(['like', 'prospect_bookings.cancel_ref_no', $this->cancel_ref_no])
            ->andFilterWhere(['like', 'prospect_bookings.proof_of_payment', $this->proof_of_payment])
            ->andFilterWhere(['like', 'prospect_bookings.sp_file', $this->sp_file])
            ->andFilterWhere(['like', 'prospect_bookings.ppjb_file', $this->ppjb_file])
            ->andFilterWhere(['like', 'prospect_bookings.cancellation_attachment', $this->cancellation_attachment])
            ->andFilterWhere(['like', 'prospect_bookings.remarks', $this->remarks])
            ->andFilterWhere(['like', 'dedicated_agent_name.name', $this->dedicated_agent_name])
            ->andFilterWhere(['like', 'agent_name.name', $this->agent_name])
            ->andFilterWhere(['like', 'prospects.prospect_name', $this->prospect_name]);

		//join with project interest
		$query->joinWith(['project']);
		
		$query->joinWith(['prospect']);
		$dataProvider->sort->attributes['prospect_name'] = [
			'asc' => ['prospects.prospect_name' => SORT_ASC],
			'desc' => ['prospects.prospect_name' => SORT_DESC],
		];

		//join with agent
		$query->joinWith(['agent']);
		$dataProvider->sort->attributes['agent_name'] = [
			'asc' => ['agent_name.name' => SORT_ASC],
			'desc' => ['agent_name.name' => SORT_DESC],
		];

		$query->joinWith(['dedicatedAgent']);
		$dataProvider->sort->attributes['dedicated_agent_name'] = [
			'asc' => ['dedicated_agent_name.name' => SORT_ASC],
			'desc' => ['dedicated_agent_name.name' => SORT_DESC],
		];

		//join with member
		$query->joinWith(['member']);
		$dataProvider->sort->attributes['member_name'] = [
			'asc' => ['member_name.name' => SORT_ASC],
			'desc' => ['member_name.name' => SORT_DESC],
		];

		//join with member
		$query->joinWith(['referrerMember']);
		$dataProvider->sort->attributes['referrer_member_name'] = [
			'asc' => ['referrer_member_name.name' => SORT_ASC],
			'desc' => ['referrer_member_name.name' => SORT_DESC],
		];

		if(!empty($this->createdatrange) && strpos($this->createdatrange, '-') !== false)
		{
			list($start_date, $end_date) = explode(' - ', $this->createdatrange);
			$query->andFilterWhere(['between', 'prospect_bookings.createdat', $start_date, $end_date]);
		}

		if(!empty($this->eoicreatedatrange) && strpos($this->eoicreatedatrange, '-') !== false)
		{
			list($start_date, $end_date) = explode(' - ', $this->eoicreatedatrange);
			$query->andFilterWhere(['between', 'prospect_bookings.booking_date_eoi', $start_date, $end_date]);
		}

		if(!empty($this->bookcreatedatrange) && strpos($this->bookcreatedatrange, '-') !== false)
		{
			list($start_date, $end_date) = explode(' - ', $this->bookcreatedatrange);
			$query->andFilterWhere(['between', 'prospect_bookings.booking_date', $start_date, $end_date]);
		}

        return $dataProvider;
    }
}
