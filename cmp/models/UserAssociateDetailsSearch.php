<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\UserAssociateDetails;

/**
 * UserAssociateDetailsSearch represents the model behind the search form about `app\models\UserAssociateDetails`.
 */
class UserAssociateDetailsSearch extends UserAssociateDetails
{
	public $pending_approval, $agent, $associateFirstName, $associateLastName, $associateEmail, $associateContactNo, $associateCreatedAt, $associateLastLoginAt, $createdatrange, $lastloginatrange;
	
    public function rules()
    {
        return [
            [['id', 'user_id', 'referrer_id', 'agent_id', 'assistant_id', 'approval_status', 'productivity_status', 'bank_id'], 'integer'],
            [['assistant_approval', 'agent_approval', 'admin_approval', 'id_number', 'tax_license_number', 'account_name', 'account_number', 'domicile', 'occupation', 'industry_background', 'nricpass', 'tax_license', 'bank_account', 'udf1', 'udf2', 'udf3', 'udf4', 'udf5'], 'safe'],
            [['agent', 'associateFirstName', 'associateLastName', 'associateEmail', 'associateContactNo', 'associateCreatedAt', 'associateLastLoginAt', 'createdatrange', 'lastloginatrange'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = UserAssociateDetails::find();

        // add conditions that should always apply here
		$query->andWhere(['associateFirstName.deletedby' => NULL, 'associateFirstName.deletedat' => NULL]);
			
		$query->joinWith(['agent', 'associateFirstName', 'associateLastName', 'associateEmail', 'associateContactNo', 'associateCreatedAt', 'associateLastLoginAt']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'sort'=> ['defaultOrder' => ['associateCreatedAt'=>SORT_DESC]]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

		$dataProvider->sort->attributes['agent'] = [
			'asc' => ['agent.name' => SORT_ASC],
			'desc' => ['agent.name' => SORT_DESC],
		];
		$dataProvider->sort->attributes['associateFirstName'] = [
			'asc' => ['associateFirstName.firstname' => SORT_ASC],
			'desc' => ['associateFirstName.firstname' => SORT_DESC],
		];
		$dataProvider->sort->attributes['associateLastName'] = [
			'asc' => ['associateLastName.lastname' => SORT_ASC],
			'desc' => ['associateLastName.lastname' => SORT_DESC],
		];
		$dataProvider->sort->attributes['associateEmail'] = [
			'asc' => ['associateEmail.email' => SORT_ASC],
			'desc' => ['associateEmail.email' => SORT_DESC],
		];
		$dataProvider->sort->attributes['associateContactNo'] = [
			'asc' => ['associateContactNo.contact_number' => SORT_ASC],
			'desc' => ['associateContactNo.contact_number' => SORT_DESC],
		];
		$dataProvider->sort->attributes['associateCreatedAt'] = [
			'asc' => ['associateCreatedAt.createdat' => SORT_ASC],
			'desc' => ['associateCreatedAt.createdat' => SORT_DESC],
		];
		$dataProvider->sort->attributes['associateLastLoginAt'] = [
			'asc' => ['associateLastLoginAt.lastloginat' => SORT_ASC],
			'desc' => ['associateLastLoginAt.lastloginat' => SORT_DESC],
		];

		if(strlen($this->pending_approval))
		$query->andWhere(['user_associate_details.approval_status'=>$this->pending_approval]);

        // grid filtering conditions
        $query->andFilterWhere([
            'user_associate_details.id' => $this->id,
            'user_associate_details.user_id' => $this->user_id,
            'user_associate_details.referrer_id' => $this->referrer_id,
            'user_associate_details.agent_id' => $this->agent_id,
            'user_associate_details.assistant_id' => $this->assistant_id,
            'user_associate_details.approval_status' => $this->approval_status,
            'user_associate_details.productivity_status' => $this->productivity_status,
            'user_associate_details.bank_id' => $this->bank_id,
        ]);

        $query->andFilterWhere(['like', 'user_associate_details.assistant_approval', $this->assistant_approval])
            ->andFilterWhere(['like', 'user_associate_details.agent_approval', $this->agent_approval])
            ->andFilterWhere(['like', 'user_associate_details.admin_approval', $this->admin_approval])
            ->andFilterWhere(['like', 'user_associate_details.id_number', $this->id_number])
            ->andFilterWhere(['like', 'user_associate_details.tax_license_number', $this->tax_license_number])
            ->andFilterWhere(['like', 'user_associate_details.account_name', $this->account_name])
            ->andFilterWhere(['like', 'user_associate_details.account_number', $this->account_number])
            ->andFilterWhere(['like', 'user_associate_details.domicile', $this->domicile])
            ->andFilterWhere(['like', 'user_associate_details.occupation', $this->occupation])
            ->andFilterWhere(['like', 'user_associate_details.industry_background', $this->industry_background])
            ->andFilterWhere(['like', 'user_associate_details.nricpass', $this->nricpass])
            ->andFilterWhere(['like', 'user_associate_details.tax_license', $this->tax_license])
            ->andFilterWhere(['like', 'user_associate_details.bank_account', $this->bank_account])
            ->andFilterWhere(['like', 'user_associate_details.udf1', $this->udf1])
            ->andFilterWhere(['like', 'user_associate_details.udf2', $this->udf2])
            ->andFilterWhere(['like', 'user_associate_details.udf3', $this->udf3])
            ->andFilterWhere(['like', 'user_associate_details.udf4', $this->udf4])
            ->andFilterWhere(['like', 'user_associate_details.udf5', $this->udf5])
            ->andFilterWhere(['like', 'LOWER(agent.name)', strtolower($this->agent)])
            ->andFilterWhere(['like', 'LOWER(associateFirstName.firstname)', strtolower($this->associateFirstName)])
            ->andFilterWhere(['like', 'LOWER(associateLastName.lastname)', strtolower($this->associateLastName)])
            ->andFilterWhere(['like', 'LOWER(associateEmail.email)', strtolower($this->associateEmail)])
            ->andFilterWhere(['like', 'LOWER(associateContactNo.contact_number)', strtolower($this->associateContactNo)]);

		if(!empty($this->createdatrange) && strpos($this->createdatrange, '-') !== false)
		{
			list($start_date, $end_date) = explode(' - ', $this->createdatrange);
			$query->andFilterWhere(['between', 'associateCreatedAt.createdat', $start_date, $end_date]);
		}

		if(!empty($this->lastloginatrange) && strpos($this->lastloginatrange, '-') !== false)
		{
			list($start_date, $end_date) = explode(' - ', $this->lastloginatrange);
			$query->andFilterWhere(['between', 'associateLastLoginAt.lastloginat', $start_date, $end_date]);
		}

        return $dataProvider;
    }
}
