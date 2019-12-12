<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\LogAudit;

/**
 * LogAuditSearch represents the model behind the search form about `app\models\LogAudit`.
 */
class LogAuditSearch extends LogAudit
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'module_id', 'record_id', 'user_id'], 'integer'],
            [['action', 'newdata', 'olddata', 'createdat'], 'safe'],
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
        $query = LogAudit::find();

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
            'module_id' => $this->module_id,
            'record_id' => $this->record_id,
            'user_id' => $this->user_id,
            'createdat' => $this->createdat,
        ]);

        $query->andFilterWhere(['like', 'action', $this->action])
            ->andFilterWhere(['like', 'newdata', $this->newdata])
            ->andFilterWhere(['like', 'olddata', $this->olddata]);

        return $dataProvider;
    }
}
