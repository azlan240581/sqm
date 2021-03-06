<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\LogNewsFeedApproval;

/**
 * LogNewsFeedApprovalSearch represents the model behind the search form about `app\models\LogNewsFeedApproval`.
 */
class LogNewsFeedApprovalSearch extends LogNewsFeedApproval
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'news_feed_id', 'status', 'createdby'], 'integer'],
            [['remarks', 'createdat'], 'safe'],
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
        $query = LogNewsFeedApproval::find();

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
            'news_feed_id' => $this->news_feed_id,
            'status' => $this->status,
            'createdby' => $this->createdby,
            'createdat' => $this->createdat,
        ]);

        $query->andFilterWhere(['like', 'remarks', $this->remarks]);

        return $dataProvider;
    }
}
