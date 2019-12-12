<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\GroupAccess;

/**
 * GroupAccessSearch represents the model behind the search form about `app\models\GroupAccess`.
 */
class GroupAccessSearch extends GroupAccess
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'sort', 'status'], 'integer'],
            [['group_access_name', 'updatedat'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = GroupAccess::find();

        // add conditions that should always apply here
		//$query->andWhere(['status' => 1]);		

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
            'sort' => $this->sort,
            'updatedat' => $this->updatedat,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'LOWER(group_access_name)', strtolower($this->group_access_name)]);

        return $dataProvider;
    }
}
