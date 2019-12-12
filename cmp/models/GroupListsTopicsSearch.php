<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\GroupListsTopics;

/**
 * GroupListsTopicsSearch represents the model behind the search form about `app\models\GroupListsTopics`.
 */
class GroupListsTopicsSearch extends GroupListsTopics
{
	public $createdatrange;
	
    public function rules()
    {
        return [
            [['id', 'status', 'createdby', 'updatedby', 'deletedby'], 'integer'],
            [['topic_name', 'user_id', 'createdat', 'updatedat', 'deletedat', 'createdatrange'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = GroupListsTopics::find();

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
            'id' => $this->id,
            'status' => $this->status,
            'createdby' => $this->createdby,
            'createdat' => $this->createdat,
            'updatedby' => $this->updatedby,
            'updatedat' => $this->updatedat,
            'deletedby' => $this->deletedby,
            'deletedat' => $this->deletedat,
        ]);

        $query->andFilterWhere(['like', 'topic_name', $this->topic_name]);
        $query->andFilterWhere(['like', 'user_id', $this->user_id]);
		
		if(!empty($this->createdatrange) && strpos($this->createdatrange, '-') !== false)
		{
			list($start_date, $end_date) = explode(' - ', $this->createdatrange);
			$query->andFilterWhere(['between', 'createdat', $start_date, $end_date]);
		}
		
        return $dataProvider;
    }
}
