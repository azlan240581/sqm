<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\LogUserMessages;

/**
 * LogUserMessagesSearch represents the model behind the search form about `app\models\LogUserMessages`.
 */
class LogUserMessagesSearch extends LogUserMessages
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'createdby'], 'integer'],
            [['subject', 'message', 'long_message', 'recepients_list', 'priority', 'createdat'], 'safe'],
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
        $query = LogUserMessages::find();

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
            'createdby' => $this->createdby,
            'createdat' => $this->createdat,
        ]);

        $query->andFilterWhere(['like', 'subject', $this->subject])
            ->andFilterWhere(['like', 'message', $this->message])
            ->andFilterWhere(['like', 'long_message', $this->long_message])
            ->andFilterWhere(['like', 'recepients_list', $this->recepients_list])
            ->andFilterWhere(['like', 'priority', $this->priority]);

        return $dataProvider;
    }
}
