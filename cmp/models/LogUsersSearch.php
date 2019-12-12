<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\LogUsers;

/**
 * LogUsersSearch represents the model behind the search form about `app\models\LogUsers`.
 */
class LogUsersSearch extends LogUsers
{
	public $createdatrange;
	public $user;
	
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'createdby'], 'integer'],
            [['remarks', 'createdat', 'createdatrange'], 'safe'],
            [['user'], 'string'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = LogUsers::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'sort' => [
					  'defaultOrder' => ['createdat' => SORT_DESC,]
					  ]
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
            'user_id' => $this->user_id,
            'createdby' => $this->createdby,
            'createdat' => $this->createdat,
        ]);

        $query->andFilterWhere(['like', 'LOWER(remarks)', strtolower($this->remarks)])
        	->andFilterWhere(['like', 'LOWER(users.name)', strtolower($this->user)]);
		
		if(!empty($this->createdatrange) && strpos($this->createdatrange, '-') !== false)
		{
			list($start_date, $end_date) = explode(' - ', $this->createdatrange);
			$query->andFilterWhere(['between', 'log_users.createdat', $start_date, $end_date]);
		}

        return $dataProvider;
    }
}
