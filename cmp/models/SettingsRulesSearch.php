<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SettingsRules;

/**
 * SettingsRulesSearch represents the model behind the search form about `app\models\SettingsRules`.
 */
class SettingsRulesSearch extends SettingsRules
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'settings_categories_id', 'settings_rules_sort'], 'integer'],
            [['settings_rules_key', 'settings_rules_desc', 'settings_rules_config_type', 'settings_rules_config', 'updatedat'], 'safe'],
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
        $query = SettingsRules::find();

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
            'settings_categories_id' => $this->settings_categories_id,
            'settings_rules_sort' => $this->settings_rules_sort,
            'updatedat' => $this->updatedat,
        ]);

        $query->andFilterWhere(['like', 'settings_rules_key', $this->settings_rules_key])
            ->andFilterWhere(['like', 'settings_rules_desc', $this->settings_rules_desc])
            ->andFilterWhere(['like', 'settings_rules_config_type', $this->settings_rules_config_type])
            ->andFilterWhere(['like', 'settings_rules_config', $this->settings_rules_config]);

        return $dataProvider;
    }
}
