<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PotentialProspects;

/**
 * PotentialProspectsSearch represents the model behind the search form about `app\models\PotentialProspects`.
 */
class PotentialProspectsSearch extends PotentialProspects
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'associate_id', 'prospect_id'], 'integer'],
            [['name', 'email', 'contactno', 'status', 'register_at'], 'safe'],
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
        $query = PotentialProspects::find();

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
            'register_at' => $this->register_at,
            'prospect_id' => $this->prospect_id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'contactno', $this->contactno])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
