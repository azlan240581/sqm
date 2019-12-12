<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ProjectProductUnitTypes;

/**
 * ProjectProductUnitTypesSearch represents the model behind the search form about `app\models\ProjectProductUnitTypes`.
 */
class ProjectProductUnitTypesSearch extends ProjectProductUnitTypes
{
	public $createdatrange;
	
    public function rules()
    {
        return [
            [['id', 'project_id', 'project_product_id', 'createdby', 'updatedby', 'deletedby'], 'integer'],
            [['type_name', 'createdat', 'updatedat', 'deletedat'], 'safe'],
            [['building_size_sm', 'land_size_sm'], 'number'],
            [['createdatrange'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = ProjectProductUnitTypes::find();

        // add conditions that should always apply here
		$query->andWhere(['project_product_unit_types.deletedby' => NULL, 'project_product_unit_types.deletedat' => NULL]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'sort' => [
					  'defaultOrder' => ['type_name' => SORT_ASC, 'createdat' => SORT_DESC,]
					  ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'project_product_unit_types.id' => $this->id,
            'project_product_unit_types.project_id' => $this->project_id,
            'project_product_unit_types.project_product_id' => $this->project_product_id,
            'project_product_unit_types.building_size_sm' => $this->building_size_sm,
            'project_product_unit_types.land_size_sm' => $this->land_size_sm,
            'project_product_unit_types.createdby' => $this->createdby,
            'project_product_unit_types.createdat' => $this->createdat,
            'project_product_unit_types.updatedby' => $this->updatedby,
            'project_product_unit_types.updatedat' => $this->updatedat,
            'project_product_unit_types.deletedby' => $this->deletedby,
            'project_product_unit_types.deletedat' => $this->deletedat,
        ]);

        $query->andFilterWhere(['like', 'project_product_unit_types.type_name', $this->type_name]);

		if(!empty($this->createdatrange) && strpos($this->createdatrange, '-') !== false)
		{
			list($start_date, $end_date) = explode(' - ', $this->createdatrange);
			$query->andFilterWhere(['between', 'project_product_unit_types.createdat', $start_date, $end_date]);
		}

        return $dataProvider;
    }
}
