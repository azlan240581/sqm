<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\LogBankPoints;

/**
 * LogBankPointsSearch represents the model behind the search form about `app\models\LogBankPoints`.
 */
class LogBankPointsSearch extends LogBankPoints
{
	public $user,$createdatrange;
	
    public function rules()
    {
        return [
            [['id', 'createdby'], 'integer'],
            [['points_value'], 'number'],
            [['remarks', 'createdat', 'user', 'createdatrange'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = LogBankPoints::find();

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
            'log_bank_points.id' => $this->id,
            'log_bank_points.points_value' => $this->points_value,
            'log_bank_points.createdby' => $this->createdby,
            'log_bank_points.createdat' => $this->createdat,
        ]);

        $query->andFilterWhere(['like', 'LOWER(log_bank_points.remarks)', strtolower($this->remarks)])
			->andFilterWhere(['like', 'LOWER(users.name)', strtolower($this->user)]);

		if(!empty($this->createdatrange) && strpos($this->createdatrange, '-') !== false)
		{
			list($start_date, $end_date) = explode(' - ', $this->createdatrange);
			$query->andFilterWhere(['between', 'log_bank_points.createdat', $start_date, $end_date]);
		}

        return $dataProvider;
    }
}
