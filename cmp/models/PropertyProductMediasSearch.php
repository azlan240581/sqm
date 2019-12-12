<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PropertyProductMedias;

/**
 * PropertyProductMediasSearch represents the model behind the search form about `app\models\PropertyProductMedias`.
 */
class PropertyProductMediasSearch extends PropertyProductMedias
{
	public $createdatrange;
	
    public function rules()
    {
        return [
            [['id', 'product_id', 'media_type_id', 'sort', 'createdby', 'deletedby'], 'integer'],
            [['thumb_image', 'media_title', 'media_value', 'published', 'createdat', 'deletedat'], 'safe'],
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
        $query = PropertyProductMedias::find();

        // add conditions that should always apply here
		$query->andWhere(['property_product_medias.deletedby' => NULL, 'property_product_medias.deletedat' => NULL]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'sort' => [
					  'defaultOrder' => ['sort' => SORT_DESC,'createdat' => SORT_DESC,]
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
            'property_product_medias.id' => $this->id,
            'property_product_medias.product_id' => $this->product_id,
            'property_product_medias.media_type_id' => $this->media_type_id,
            'property_product_medias.sort' => $this->sort,
            'property_product_medias.property_product_medias.createdby' => $this->createdby,
            'property_product_medias.createdat' => $this->createdat,
            'property_product_medias.deletedby' => $this->deletedby,
            'property_product_medias.deletedat' => $this->deletedat,
        ]);

        $query->andFilterWhere(['like', 'property_product_medias.thumb_image', $this->thumb_image])
            ->andFilterWhere(['like', 'property_product_medias.media_title', $this->media_title])
            ->andFilterWhere(['like', 'property_product_medias.media_value', $this->media_value])
            ->andFilterWhere(['like', 'property_product_medias.published', $this->published]);

		if(!empty($this->createdatrange) && strpos($this->createdatrange, '-') !== false)
		{
			list($start_date, $end_date) = explode(' - ', $this->createdatrange);
			$query->andFilterWhere(['between', 'property_product_medias.createdat', $start_date, $end_date]);
		}

        return $dataProvider;
    }
}
