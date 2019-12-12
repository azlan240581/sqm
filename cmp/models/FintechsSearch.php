<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Fintechs;

/**
 * FintechSearch represents the model behind the search form about `app\models\Fintech`.
 */
class FintechsSearch extends Fintechs
{
	public $createdatrange;
	
    public function rules()
    {
        return [
            [['id', 'createdby', 'updatedby', 'deletedby'], 'integer'],
            [['company_name', 'company_registration_no', 'company_description', 'contact_person_name', 'contact_person_email', 'contact_person_contactno', 'status', 'createdat', 'updatedat', 'deletedat'], 'safe'],
            [['createdatrange'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Fintechs::find();

        // add conditions that should always apply here
		$query->andWhere(['fintechs.deletedby' => NULL, 'fintechs.deletedat' => NULL]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'sort' => [
					  'defaultOrder' => ['createdat' => SORT_DESC,]
					  ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'fintechs.id' => $this->id,
            'fintechs.createdby' => $this->createdby,
            'fintechs.createdat' => $this->createdat,
            'fintechs.updatedby' => $this->updatedby,
            'fintechs.updatedat' => $this->updatedat,
            'fintechs.deletedby' => $this->deletedby,
            'fintechs.deletedat' => $this->deletedat,
        ]);

        $query->andFilterWhere(['like', 'fintechs.company_name', $this->company_name])
            ->andFilterWhere(['like', 'fintechs.company_registration_no', $this->company_registration_no])
            ->andFilterWhere(['like', 'fintechs.company_description', $this->company_description])
            ->andFilterWhere(['like', 'fintechs.contact_person_name', $this->contact_person_name])
            ->andFilterWhere(['like', 'fintechs.contact_person_email', $this->contact_person_email])
            ->andFilterWhere(['like', 'fintechs.contact_person_contactno', $this->contact_person_contactno])
            ->andFilterWhere(['like', 'fintechs.status', $this->status]);

		if(!empty($this->createdatrange) && strpos($this->createdatrange, '-') !== false)
		{
			list($start_date, $end_date) = explode(' - ', $this->createdatrange);
			$query->andFilterWhere(['between', 'fintechs.createdat', $start_date, $end_date]);
		}

        return $dataProvider;
    }
}
