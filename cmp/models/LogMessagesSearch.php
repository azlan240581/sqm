<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\LogMessages;

/**
 * LogMessagesSearch represents the model behind the search form about `app\models\LogMessages`.
 */
class LogMessagesSearch extends LogMessages
{
	public $createdatrange, $createdByUser;
	
    public function rules()
    {
        return [
            [['id', 'priority', 'createdby'], 'integer'],
            [['subject', 'message', 'recepients_list', 'createdat', 'createdatrange', 'createdByUser'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = LogMessages::find();

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

		$query->joinWith(['createdByUser']);
		$dataProvider->sort->attributes['createdByUser'] = [
			'asc' => ['users.username' => SORT_ASC],
			'desc' => ['users.username' => SORT_DESC],
		];

        // grid filtering conditions
        $query->andFilterWhere([
            'log_messages.id' => $this->id,
            'log_messages.priority' => $this->priority,
            'log_messages.createdby' => $this->createdby,
            'log_messages.createdat' => $this->createdat,
        ]);

        $query->andFilterWhere(['like', 'LOWER(log_messages.subject)', strtolower($this->subject)])
            ->andFilterWhere(['like', 'LOWER(log_messages.message)', strtolower($this->message)])
            ->andFilterWhere(['like', 'LOWER(log_messages.recepients_list)', strtolower($this->recepients_list)])
			->andFilterWhere(['like', 'LOWER(users.username)', strtolower($this->createdByUser)]);

		if(!empty($this->createdatrange) && strpos($this->createdatrange, '-') !== false)
		{
			list($start_date, $end_date) = explode(' - ', $this->createdatrange);
			$query->andFilterWhere(['between', 'log_messages.createdat', $start_date, $end_date]);
		}

        return $dataProvider;
    }
}
