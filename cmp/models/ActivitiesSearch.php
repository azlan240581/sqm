<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Activities;

/**
 * ActivitiesSearch represents the model behind the search form about `app\models\Activities`.
 */
class ActivitiesSearch extends Activities
{
    public function rules()
    {
        return [
            [['id', 'createdby', 'updatedby', 'deletedby'], 'integer'],
            [['activity_code', 'activity_name', 'activity_description', 'status', 'createdat', 'updatedat', 'deletedat'], 'safe'],
            [['points_value'], 'number'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Activities::find();

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
            'points_value' => $this->points_value,
            'createdby' => $this->createdby,
            'createdat' => $this->createdat,
            'updatedby' => $this->updatedby,
            'updatedat' => $this->updatedat,
            'deletedby' => $this->deletedby,
            'deletedat' => $this->deletedat,
        ]);

        $query->andFilterWhere(['like', 'activity_code', $this->activity_code])
            ->andFilterWhere(['like', 'activity_name', $this->activity_name])
            ->andFilterWhere(['like', 'activity_description', $this->activity_description])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
