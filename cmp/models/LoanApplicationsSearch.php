<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\LoanApplications;

/**
 * LoanApplicationsSearch represents the model behind the search form about `app\models\LoanApplications`.
 */
class LoanApplicationsSearch extends LoanApplications
{
    public function rules()
    {
        return [
            [['id', 'bank_id', 'prospect_id', 'status', 'createdby', 'updatedby', 'deletedby'], 'integer'],
            [['loan_amount'], 'number'],
            [['createdat', 'updatedat', 'deletedat'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = LoanApplications::find();

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
            'bank_id' => $this->bank_id,
            'prospect_id' => $this->prospect_id,
            'loan_amount' => $this->loan_amount,
            'status' => $this->status,
            'createdby' => $this->createdby,
            'createdat' => $this->createdat,
            'updatedby' => $this->updatedby,
            'updatedat' => $this->updatedat,
            'deletedby' => $this->deletedby,
            'deletedat' => $this->deletedat,
        ]);

        return $dataProvider;
    }
}
