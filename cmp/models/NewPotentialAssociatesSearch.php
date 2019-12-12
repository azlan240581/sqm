<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\NewPotentialAssociates;

/**
 * NewPotentialAssociatesSearch represents the model behind the search form about `app\models\NewPotentialAssociates`.
 */
class NewPotentialAssociatesSearch extends NewPotentialAssociates
{
	public $user;
	
    public function rules()
    {
        return [
            [['id', 'inviter_id'], 'integer'],
            [['name', 'email', 'contactno', 'registered', 'user'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = NewPotentialAssociates::find();

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

		$query->joinWith(['user']);
		$dataProvider->sort->attributes['user'] = [
			'asc' => ['users.name' => SORT_ASC],
			'desc' => ['users.name' => SORT_DESC],
		];

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'inviter_id' => $this->inviter_id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'contactno', $this->contactno])
            ->andFilterWhere(['like', 'registered', $this->registered])
            ->andFilterWhere(['like', 'users.name', $this->user]);

        return $dataProvider;
    }
}
