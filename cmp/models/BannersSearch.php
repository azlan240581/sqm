<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Banners;

/**
 * BannersSearch represents the model behind the search form about `app\models\Banners`.
 */
class BannersSearch extends Banners
{
	public $lookupBannerCategory, $publishedDdateStartRange, $publishedDateEndRange, $createdatrange;
	
    public function rules()
    {
        return [
            [['id', 'banner_category_id', 'sort', 'total_viewed', 'createdby', 'updatedby', 'deletedby'], 'integer'],
            [['banner_title', 'permalink', 'banner_summary', 'banner_description', 'banner_img', 'banner_video', 'link_url', 'published_date_start', 'published_date_end', 'createdat', 'updatedat', 'deletedat'], 'safe'],
            [['lookupBannerCategory', 'publishedDdateStartRange', 'publishedDateEndRange', 'createdatrange'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Banners::find();

        // add conditions that should always apply here
		$query->andWhere(['banners.deletedby' => NULL, 'banners.deletedat' => NULL]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'sort' => [
					  'defaultOrder' => ['sort' => SORT_DESC, 'createdat' => SORT_DESC,]
					  ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

		$query->joinWith(['lookupBannerCategory']);
		$dataProvider->sort->attributes['lookupBannerCategory'] = [
			'asc' => ['lookup_banner_categories.name' => SORT_ASC],
			'desc' => ['lookup_banner_categories.name' => SORT_DESC],
		];

        // grid filtering conditions
        $query->andFilterWhere([
            'banners.id' => $this->id,
            'banners.banner_category_id' => $this->banner_category_id,
            'banners.published_date_start' => $this->published_date_start,
            'banners.published_date_end' => $this->published_date_end,
            'banners.sort' => $this->sort,
            'banners.total_viewed' => $this->total_viewed,
            'banners.createdby' => $this->createdby,
            'banners.createdat' => $this->createdat,
            'banners.updatedby' => $this->updatedby,
            'banners.updatedat' => $this->updatedat,
            'banners.deletedby' => $this->deletedby,
            'banners.deletedat' => $this->deletedat,
        ]);

        $query->andFilterWhere(['like', 'banners.banner_title', $this->banner_title])
            ->andFilterWhere(['like', 'banners.permalink', $this->permalink])
            ->andFilterWhere(['like', 'banners.banner_summary', $this->banner_summary])
            ->andFilterWhere(['like', 'banners.banner_description', $this->banner_description])
            ->andFilterWhere(['like', 'banners.banner_img', $this->banner_img])
            ->andFilterWhere(['like', 'banners.banner_video', $this->banner_video])
            ->andFilterWhere(['like', 'banners.link_url', $this->link_url])
            ->andFilterWhere(['like', 'lookup_banner_categories.name', $this->lookupBannerCategory]);

		if(!empty($this->publishedDdateStartRange) && strpos($this->publishedDdateStartRange, '-') !== false)
		{
			list($publishedDdateStartstart_date, $publishedDdateStartend_date) = explode(' - ', $this->publishedDdateStartRange);
			$query->andFilterWhere(['between', 'banners.published_date_start', $publishedDdateStartstart_date, $publishedDdateStartend_date]);
		}

		if(!empty($this->publishedDateEndRange) && strpos($this->publishedDateEndRange, '-') !== false)
		{
			list($publishedDateEndstart_date, $publishedDateEndend_date) = explode(' - ', $this->publishedDateEndRange);
			$query->andFilterWhere(['between', 'banners.published_date_end', $publishedDateEndstart_date, $publishedDateEndend_date]);
		}

		if(!empty($this->createdatrange) && strpos($this->createdatrange, '-') !== false)
		{
			list($start_date, $end_date) = explode(' - ', $this->createdatrange);
			$query->andFilterWhere(['between', 'banners.createdat', $start_date, $end_date]);
		}

        return $dataProvider;
    }
}
