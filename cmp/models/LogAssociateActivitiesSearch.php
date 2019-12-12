<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\LogAssociateActivities;

/**
 * LogAssociateActivitiesSearch represents the model behind the search form about `app\models\LogAssociateActivities`.
 */
class LogAssociateActivitiesSearch extends LogAssociateActivities
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'associate_id', 'activity_id', 'news_feed_id', 'product_id', 'banner_id', 'createdby'], 'integer'],
            [['points_value', 'createdat'], 'safe'],
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
        $query = LogAssociateActivities::find();

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
            'associate_id' => $this->associate_id,
            'activity_id' => $this->activity_id,
            'points_value' => $this->points_value,
            'news_feed_id' => $this->news_feed_id,
            'product_id' => $this->product_id,
            'banner_id' => $this->banner_id,
            'createdby' => $this->createdby,
            'createdat' => $this->createdat,
        ]);

        return $dataProvider;
    }
}
