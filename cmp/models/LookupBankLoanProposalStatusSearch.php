<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\LookupBankLoanProposalStatus;

/**
 * LookupBankLoanProposalStatusSearch represents the model behind the search form about `app\models\LookupBankLoanProposalStatus`.
 */
class LookupBankLoanProposalStatusSearch extends LookupBankLoanProposalStatus
{
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name', 'deleted'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = LookupBankLoanProposalStatus::find();

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
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'deleted', $this->deleted]);

        return $dataProvider;
    }
}
