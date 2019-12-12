<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\CollateralsMedias;

/**
 * CollateralsMediasSearch represents the model behind the search form about `app\models\CollateralsMedias`.
 */
class CollateralsMediasSearch extends CollateralsMedias
{
	public $createdatrange;
	
    public function rules()
    {
        return [
            [['id', 'collateral_id', 'collateral_media_type_id', 'sort', 'createdby', 'deletedby'], 'integer'],
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
        $query = CollateralsMedias::find();

        // add conditions that should always apply here
		$query->andWhere(['collaterals_medias.deletedby' => NULL, 'collaterals_medias.deletedat' => NULL]);

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
            'collaterals_medias.id' => $this->id,
            'collaterals_medias.collateral_id' => $this->collateral_id,
            'collaterals_medias.collateral_media_type_id' => $this->collateral_media_type_id,
            'collaterals_medias.sort' => $this->sort,
            'collaterals_medias.createdby' => $this->createdby,
            'collaterals_medias.createdat' => $this->createdat,
            'collaterals_medias.deletedby' => $this->deletedby,
            'collaterals_medias.deletedat' => $this->deletedat,
        ]);

        $query->andFilterWhere(['like', 'collaterals_medias.thumb_image', $this->thumb_image])
            ->andFilterWhere(['like', 'collaterals_medias.media_title', $this->media_title])
            ->andFilterWhere(['like', 'collaterals_medias.media_value', $this->media_value])
            ->andFilterWhere(['like', 'collaterals_medias.published', $this->published]);

		if(!empty($this->createdatrange) && strpos($this->createdatrange, '-') !== false)
		{
			list($start_date, $end_date) = explode(' - ', $this->createdatrange);
			$query->andFilterWhere(['between', 'collaterals_medias.createdat', $start_date, $end_date]);
		}

        return $dataProvider;
    }
}
