<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PropertyProducts;

/**
 * PropertyProductsSearch represents the model behind the search form about `app\models\PropertyProducts`.
 */
class PropertyProductsSearch extends PropertyProducts
{
	public $project, $publishedDdateStartRange, $publishedDateEndRange, $createdatrange;
	
    public function rules()
    {
        return [
            [['id', 'project_id', 'project_product_id', 'property_type_id', 'product_type', 'total_floor', 'bedroom', 'bathroom', 'parking_lot', 'total_viewed', 'status', 'createdby', 'updatedby', 'deletedby'], 'integer'],
            [['title', 'permalink', 'summary', 'description', 'thumb_image', 'address', 'latitude', 'longitude', 'collaterals_id', 'published_date_start', 'published_date_end', 'createdat', 'updatedat', 'deletedat'], 'safe'],
            [['price', 'building_size', 'land_size'], 'number'],
            [['project', 'publishedDdateStartRange', 'publishedDateEndRange', 'createdatrange'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = PropertyProducts::find();

        // add conditions that should always apply here
		$query->andWhere(['property_products.deletedby' => NULL, 'property_products.deletedat' => NULL])
			->andWhere(['projects.status' => 1, 'projects.deletedby' => NULL, 'projects.deletedat' => NULL]);

		if($_SESSION['user']['groups']!=NULL and array_intersect(array(7,8,9,10),$_SESSION['user']['groups']))
        {
			//get project agents
			$projectAgents = ProjectAgents::find()->where(array('agent_id'=>$_SESSION['user']['id']))->asArray()->all();
			$query->andWhere(['property_products.project_id' => array_column($projectAgents,'project_id')]);
		}
		
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'sort' => [
					  'defaultOrder' => ['createdat' => SORT_DESC,]
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

        // grid filtering conditions
        $query->andFilterWhere([
            'property_products.id' => $this->id,
            'property_products.project_id' => $this->project_id,
            'property_products.project_product_id' => $this->project_product_id,
            'property_products.property_type_id' => $this->property_type_id,
            'property_products.product_type' => $this->product_type,
            'property_products.price' => $this->price,
            'property_products.building_size' => $this->building_size,
            'property_products.land_size' => $this->land_size,
            'property_products.total_floor' => $this->total_floor,
            'property_products.bedroom' => $this->bedroom,
            'property_products.bathroom' => $this->bathroom,
            'property_products.parking_lot' => $this->parking_lot,
            'property_products.published_date_start' => $this->published_date_start,
            'property_products.published_date_end' => $this->published_date_end,
            'property_products.total_viewed' => $this->total_viewed,
            'property_products.status' => $this->status,
            'property_products.createdby' => $this->createdby,
            'property_products.createdat' => $this->createdat,
            'property_products.updatedby' => $this->updatedby,
            'property_products.updatedat' => $this->updatedat,
            'property_products.deletedby' => $this->deletedby,
            'property_products.deletedat' => $this->deletedat,
        ]);

        $query->andFilterWhere(['like', 'property_products.title', $this->title])
            ->andFilterWhere(['like', 'property_products.permalink', $this->permalink])
            ->andFilterWhere(['like', 'property_products.summary', $this->summary])
            ->andFilterWhere(['like', 'property_products.description', $this->description])
            ->andFilterWhere(['like', 'property_products.thumb_image', $this->thumb_image])
            ->andFilterWhere(['like', 'property_products.address', $this->address])
            ->andFilterWhere(['like', 'property_products.latitude', $this->latitude])
            ->andFilterWhere(['like', 'property_products.longitude', $this->longitude])
            ->andFilterWhere(['like', 'property_products.collaterals_id', $this->collaterals_id])
			->andFilterWhere(['like', 'projects.project_name', strtolower($this->project)]);

		if(!empty($this->publishedDdateStartRange) && strpos($this->publishedDdateStartRange, '-') !== false)
		{
			list($publishedDdateStartstart_date, $publishedDdateStartend_date) = explode(' - ', $this->publishedDdateStartRange);
			$query->andFilterWhere(['between', 'property_products.published_date_start', $publishedDdateStartstart_date, $publishedDdateStartend_date]);
		}

		if(!empty($this->publishedDateEndRange) && strpos($this->publishedDateEndRange, '-') !== false)
		{
			list($publishedDateEndstart_date, $publishedDateEndend_date) = explode(' - ', $this->publishedDateEndRange);
			$query->andFilterWhere(['between', 'property_products.published_date_end', $publishedDateEndstart_date, $publishedDateEndend_date]);
		}

		if(!empty($this->createdatrange) && strpos($this->createdatrange, '-') !== false)
		{
			list($start_date, $end_date) = explode(' - ', $this->createdatrange);
			$query->andFilterWhere(['between', 'property_products.createdat', $start_date, $end_date]);
		}

        return $dataProvider;
    }
}
