<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Prospects;

/**
 * ProspectsSearch represents the model behind the search form about `app\models\Prospects`.
 */
class ProspectsSearch extends Prospects
{
	public $agent_name, $member_name, $interested_projects, $createdatrange;
	
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'agent_id', 'member_id', 'prospect_purpose_of_buying', 'how_prospect_know_us', 'prospect_marital_status', 'prospect_occupation', 'status', 'createdby', 'updatedby', 'deletedby'], 'integer'],
            [['agent_name', 'member_name', 'createdatrange', 'interested_projects', 'prospect_name', 'prospect_email', 'prospect_contact_number', 'prospect_age', 'prospect_identity_document', 'tax_license', 'remarks', 'createdat', 'updatedat', 'deletedat'], 'safe'],
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
        $query = Prospects::find();

        // add conditions that should always apply here
		$query->andWhere(['prospects.deletedby' => NULL, 'prospects.deletedat' => NULL]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'sort' => ['defaultOrder' => ['createdat'=>SORT_DESC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'prospects.id' => $this->id,
            'prospects.agent_id' => $this->agent_id,
            'prospects.member_id' => $this->member_id,
            'prospects.prospect_purpose_of_buying' => $this->prospect_purpose_of_buying,
            'prospects.how_prospect_know_us' => $this->how_prospect_know_us,
            'prospects.prospect_marital_status' => $this->prospect_marital_status,
            'prospects.prospect_occupation' => $this->prospect_occupation,
            'prospects.status' => $this->status,
            'prospects.createdby' => $this->createdby,
            'prospects.createdat' => $this->createdat,
            'prospects.updatedby' => $this->updatedby,
            'prospects.updatedat' => $this->updatedat,
            'prospects.deletedby' => $this->deletedby,
            'prospects.deletedat' => $this->deletedat,
            'prospect_interested_projects.project_id' => $this->interested_projects,
        ]);

        $query->andFilterWhere(['like', 'prospect_name', $this->prospect_name])
            ->andFilterWhere(['like', 'agent_name.name', $this->agent_name])
            ->andFilterWhere(['like', 'member_name.name', $this->member_name])
            ->andFilterWhere(['like', 'prospect_email', $this->prospect_email])
            ->andFilterWhere(['like', 'prospect_contact_number', $this->prospect_contact_number])
            ->andFilterWhere(['like', 'prospect_age', $this->prospect_age])
            ->andFilterWhere(['like', 'prospect_identity_document', $this->prospect_identity_document])
            ->andFilterWhere(['like', 'tax_license', $this->tax_license])
            ->andFilterWhere(['like', 'remarks', $this->remarks]);

		if(!empty($this->createdatrange) && strpos($this->createdatrange, '-') !== false)
		{
			list($start_date, $end_date) = explode(' - ', $this->createdatrange);
			$query->andFilterWhere(['between', 'prospects.createdat', $start_date, $end_date]);
		}

		//join with project interest
		$query->joinWith(['interestedProjects']);

		//join with agent
		$query->joinWith(['agent']);
		$dataProvider->sort->attributes['agent_name'] = [
			'asc' => ['agent_name.name' => SORT_ASC],
			'desc' => ['agent_name.name' => SORT_DESC],
		];

		//join with member
		$query->joinWith(['member']);
		$dataProvider->sort->attributes['member_name'] = [
			'asc' => ['member_name.name' => SORT_ASC],
			'desc' => ['member_name.name' => SORT_DESC],
		];
				
        return $dataProvider;
    }
}
