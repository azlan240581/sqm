<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\BankPoints;

/**
 * BankPointsSearch represents the model behind the search form about `app\models\BankPoints`.
 */
class BankPointsSearch extends BankPoints
{
    public function rules()
    {
        return [
            [['id', 'createdby', 'updatedby'], 'integer'],
            [['credits'], 'number'],
            [['createdat', 'updatedat'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = BankPoints::find();

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
            'credits' => $this->credits,
            'createdby' => $this->createdby,
            'createdat' => $this->createdat,
            'updatedby' => $this->updatedby,
            'updatedat' => $this->updatedat,
        ]);

        return $dataProvider;
    }
}
