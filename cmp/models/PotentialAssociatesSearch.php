<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PotentialAssociates;

/**
 * PotentialAssociatesSearch represents the model behind the search form about `app\models\PotentialAssociates`.
 */
class PotentialAssociatesSearch extends PotentialAssociates
{
	public $user, $registeratrange, $createdatrange;
	
    public function rules()
    {
        return [
            [['id', 'inviter_id', 'user_id'], 'integer'],
            [['name', 'email', 'contactno', 'status', 'register_at', 'createdat'], 'safe'],
            [['user', 'registeratrange', 'createdatrange'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = PotentialAssociates::find();

        // add conditions that should always apply here
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

		$query->joinWith(['user']);
		$dataProvider->sort->attributes['user'] = [
			'asc' => ['users.name' => SORT_ASC],
			'desc' => ['users.name' => SORT_DESC],
		];

        // grid filtering conditions
        $query->andFilterWhere([
            'potential_associates.id' => $this->id,
            'potential_associates.inviter_id' => $this->inviter_id,
            'potential_associates.register_at' => $this->register_at,
            'potential_associates.user_id' => $this->user_id,
        ]);

        $query->andFilterWhere(['like', 'potential_associates.name', $this->name])
            ->andFilterWhere(['like', 'potential_associates.email', $this->email])
            ->andFilterWhere(['like', 'potential_associates.contactno', $this->contactno])
            ->andFilterWhere(['like', 'potential_associates.status', $this->status])
            ->andFilterWhere(['like', 'users.name', $this->user]);

		if(!empty($this->registeratrange) && strpos($this->registeratrange, '-') !== false)
		{
			list($start_date, $end_date) = explode(' - ', $this->registeratrange);
			$query->andFilterWhere(['between', 'potential_associates.register_at', $start_date, $end_date]);
		}
		        
		if(!empty($this->createdatrange) && strpos($this->createdatrange, '-') !== false)
		{
			list($start_date, $end_date) = explode(' - ', $this->createdatrange);
			$query->andFilterWhere(['between', 'potential_associates.createdat', $start_date, $end_date]);
		}
		        
        return $dataProvider;
    }
}
