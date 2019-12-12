<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\UserMessages;

/**
 * UserMessagesSearch represents the model behind the search form about `app\models\UserMessages`.
 */
class UserMessagesSearch extends UserMessages
{
    /**
     * @inheritdoc
     */

	public $createdatrange;

    public function rules()
    {
        return [
            [['id', 'user_id', 'mark_as_read', 'priority', 'createdby'], 'integer'],
            [['subject', 'message', 'createdat', 'createdatrange'], 'safe'],
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
        $query = UserMessages::find();

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
            'user_id' => $this->user_id,
            'mark_as_read' => $this->mark_as_read,
            'priority' => $this->priority,
            'createdby' => $this->createdby,
            'createdat' => $this->createdat,
        ]);

        $query->andFilterWhere(['like', 'subject', $this->subject])
            ->andFilterWhere(['like', 'message', $this->message]);

		if(!empty($this->createdatrange) && strpos($this->createdatrange, '-') !== false)
		{
			list($start_date, $end_date) = explode(' - ', $this->createdatrange);
			$query->andFilterWhere(['between', 'createdat', $start_date, $end_date]);
		}

        return $dataProvider;
    }
}
