<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Banks;

/**
 * BanksSearch represents the model behind the search form about `app\models\Banks`.
 */
class BanksSearch extends Banks
{
	public $createdatrange;
	
    public function rules()
    {
        return [
            [['id', 'createdby', 'updatedby', 'deletedby'], 'integer'],
            [['bank_name', 'company_name', 'company_registration_no', 'company_description', 'contact_person_name', 'contact_person_email', 'contact_person_contactno', 'status', 'createdat', 'updatedat', 'deletedat', 'createdatrange'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Banks::find();

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
            'banks.id' => $this->id,
            'banks.createdby' => $this->createdby,
            'banks.createdat' => $this->createdat,
            'banks.updatedby' => $this->updatedby,
            'banks.updatedat' => $this->updatedat,
            'banks.deletedby' => $this->deletedby,
            'banks.deletedat' => $this->deletedat,
        ]);

        $query->andFilterWhere(['like', 'banks.bank_name', $this->bank_name])
            ->andFilterWhere(['like', 'banks.company_name', $this->company_name])
            ->andFilterWhere(['like', 'banks.company_registration_no', $this->company_registration_no])
            ->andFilterWhere(['like', 'banks.company_description', $this->company_description])
            ->andFilterWhere(['like', 'banks.contact_person_name', $this->contact_person_name])
            ->andFilterWhere(['like', 'banks.contact_person_email', $this->contact_person_email])
            ->andFilterWhere(['like', 'banks.contact_person_contactno', $this->contact_person_contactno])
            ->andFilterWhere(['like', 'banks.status', $this->status]);

		if(!empty($this->createdatrange) && strpos($this->createdatrange, '-') !== false)
		{
			list($start_date, $end_date) = explode(' - ', $this->createdatrange);
			$query->andFilterWhere(['between', 'banks.createdat', $start_date, $end_date]);
		}

        return $dataProvider;
    }
}
