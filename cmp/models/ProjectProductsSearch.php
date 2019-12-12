<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ProjectProducts;

/**
 * ProjectProductsSearch represents the model behind the search form about `app\models\ProjectProducts`.
 */
class ProjectProductsSearch extends ProjectProducts
{
	public $project, $lookupProductType, $lookupPropertyProductType, $createdatrange;
	
    public function rules()
    {
        return [
            [['id', 'project_id', 'product_tier', 'product_type_id', 'createdby', 'updatedby', 'deletedby'], 'integer'],
            [['product_name', 'createdat', 'updatedat', 'deletedat'], 'safe'],
            [['project', 'lookupProductType', 'lookupPropertyProductType', 'createdatrange'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = ProjectProducts::find();

        // add conditions that should always apply here
		$query->andWhere(['project_products.deletedby' => NULL, 'project_products.deletedat' => NULL]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'sort' => [
					  'defaultOrder' => ['product_name' => SORT_ASC, 'createdat' => SORT_DESC,]
					  ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

		$query->joinWith(['project']);
		$dataProvider->sort->attributes['project'] = [
			'asc' => ['projects.project_name' => SORT_ASC],
			'desc' => ['projects.project_name' => SORT_DESC],
		];

		$query->joinWith(['lookupProductType']);
		$dataProvider->sort->attributes['lookupProductType'] = [
			'asc' => ['lookup_product_type.name' => SORT_ASC],
			'desc' => ['lookup_product_type.name' => SORT_DESC],
		];

		$query->joinWith(['lookupPropertyProductType']);
		$dataProvider->sort->attributes['lookupPropertyProductType'] = [
			'asc' => ['lookup_property_product_types.name' => SORT_ASC],
			'desc' => ['lookup_property_product_types.name' => SORT_DESC],
		];

        // grid filtering conditions
        $query->andFilterWhere([
            'project_products.id' => $this->id,
            'project_products.project_id' => $this->project_id,
            'project_products.product_tier' => $this->product_tier,
            'project_products.product_type_id' => $this->product_type_id,
            'project_products.createdby' => $this->createdby,
            'project_products.createdat' => $this->createdat,
            'project_products.updatedby' => $this->updatedby,
            'project_products.updatedat' => $this->updatedat,
            'project_products.deletedby' => $this->deletedby,
            'project_products.deletedat' => $this->deletedat,
        ]);

        $query->andFilterWhere(['like', 'project_products.product_name', $this->product_name])
			->andFilterWhere(['like', 'projects.project_name', $this->project])
			->andFilterWhere(['like', 'lookup_property_product_types.name', $this->lookupPropertyProductType])
			->andFilterWhere(['like', 'lookup_property_product_types.name', $this->lookupPropertyProductType]);

		if(!empty($this->createdatrange) && strpos($this->createdatrange, '-') !== false)
		{
			list($start_date, $end_date) = explode(' - ', $this->createdatrange);
			$query->andFilterWhere(['between', 'project_products.createdat', $start_date, $end_date]);
		}

        return $dataProvider;
    }
}
