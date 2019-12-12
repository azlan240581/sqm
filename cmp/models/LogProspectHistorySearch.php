<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\LogProspectHistory;

/**
 * LogProspectHistorySearch represents the model behind the search form about `app\models\LogProspectHistory`.
 */
class LogProspectHistorySearch extends LogProspectHistory
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'prospect_id', 'prospect_booking_id', 'project_id', 'history_id', 'level_of_interest', 'site_visit', 'createdby'], 'integer'],
            [['appointment_at', 'appointment_location', 'udf1', 'udf2', 'udf3', 'remarks', 'createdat'], 'safe'],
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
        $query = LogProspectHistory::find();

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
            'prospect_id' => $this->prospect_id,
            'prospect_booking_id' => $this->prospect_booking_id,
            'project_id' => $this->project_id,
            'history_id' => $this->history_id,
            'appointment_at' => $this->appointment_at,
            'level_of_interest' => $this->level_of_interest,
            'site_visit' => $this->site_visit,
            'createdby' => $this->createdby,
            'createdat' => $this->createdat,
        ]);

        $query->andFilterWhere(['like', 'appointment_location', $this->appointment_location])
			->andFilterWhere(['like', 'udf1', $this->udf1])
            ->andFilterWhere(['like', 'udf2', $this->udf2])
            ->andFilterWhere(['like', 'udf3', $this->udf3])
            ->andFilterWhere(['like', 'remarks', $this->remarks]);

        return $dataProvider;
    }
}
