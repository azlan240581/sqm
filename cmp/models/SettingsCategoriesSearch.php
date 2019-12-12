<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SettingsCategories;

/**
 * SettingsCategoriesSearch represents the model behind the search form about `app\models\SettingsCategories`.
 */
class SettingsCategoriesSearch extends SettingsCategories
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['settings_category_name', 'settings_category_description', 'updatedat'], 'safe'],
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
        $query = SettingsCategories::find();

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
            'updatedat' => $this->updatedat,
        ]);

        $query->andFilterWhere(['like', 'LOWER(settings_category_name)', strtolower($this->settings_category_name)])
            ->andFilterWhere(['like', 'LOWER(settings_category_description)', strtolower($this->settings_category_description)]);

        return $dataProvider;
    }
}
