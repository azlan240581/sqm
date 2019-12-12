<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Modules;

/**
 * ModulesSearch represents the model behind the search form about `app\models\Modules`.
 */
class ModulesSearch extends Modules
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'parentid', 'sort', 'status'], 'integer'],
            [['name', 'controller', 'icon', 'class', 'updatedat'], 'safe'],
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
        $query = Modules::find();

        // add conditions that should always apply here
		$query->andWhere(['status' => 1]);		

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
            'parentid' => $this->parentid,
            'sort' => $this->sort,
            'status' => $this->status,
            'updatedat' => $this->updatedat,
        ]);

        $query->andFilterWhere(['like', 'LOWER(name)', strtolower($this->name)])
            ->andFilterWhere(['like', 'LOWER(controller)', strtolower($this->controller)])
            ->andFilterWhere(['like', 'LOWER(icon)', strtolower($this->icon)])
            ->andFilterWhere(['like', 'LOWER(class)', strtolower($this->class)]);

        return $dataProvider;
    }
}
