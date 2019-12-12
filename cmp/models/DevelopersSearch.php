<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Developers;

/**
 * DevelopersSearch represents the model behind the search form about `app\models\Developers`.
 */
class DevelopersSearch extends Developers
{
	public $createdatrange;
	
    public function rules()
    {
        return [
            [['id', 'createdby', 'deletedby'], 'integer'],
            [['company_name', 'company_registration_no', 'contact_person_name', 'contact_person_email', 'contact_person_contactno', 'status', 'createdat', 'updatedby', 'updatedat', 'deletedat'], 'safe'],
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
        $query = Developers::find();

        // add conditions that should always apply here
		$query->andWhere(['developers.deletedby' => NULL, 'developers.deletedat' => NULL]);

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
            'developers.id' => $this->id,
            'developers.createdby' => $this->createdby,
            'developers.createdat' => $this->createdat,
            'developers.updatedby' => $this->updatedby,
            'developers.updatedat' => $this->updatedat,
            'developers.deletedby' => $this->deletedby,
            'developers.deletedat' => $this->deletedat,
        ]);

        $query->andFilterWhere(['like', 'developers.company_name', $this->company_name])
            ->andFilterWhere(['like', 'developers.company_registration_no', $this->company_registration_no])
            ->andFilterWhere(['like', 'developers.contact_person_name', $this->contact_person_name])
            ->andFilterWhere(['like', 'developers.contact_person_email', $this->contact_person_email])
            ->andFilterWhere(['like', 'developers.contact_person_contactno', $this->contact_person_contactno])
            ->andFilterWhere(['like', 'developers.status', $this->status]);

		if(!empty($this->createdatrange) && strpos($this->createdatrange, '-') !== false)
		{
			list($start_date, $end_date) = explode(' - ', $this->createdatrange);
			$query->andFilterWhere(['between', 'developers.createdat', $start_date, $end_date]);
		}

        return $dataProvider;
    }
}
