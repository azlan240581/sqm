<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\NewsFeedMedias;

/**
 * NewsFeedMediasSearch represents the model behind the search form about `app\models\NewsFeedMedias`.
 */
class NewsFeedMediasSearch extends NewsFeedMedias
{
	public $createdatrange;
	
    public function rules()
    {
        return [
            [['id', 'news_feed_id', 'media_type_id', 'sort', 'createdby', 'deletedby'], 'integer'],
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
        $query = NewsFeedMedias::find();

        // add conditions that should always apply here
		$query->andWhere(['news_feed_medias.deletedby' => NULL, 'news_feed_medias.deletedat' => NULL]);

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
            'news_feed_medias.id' => $this->id,
            'news_feed_medias.news_feed_id' => $this->news_feed_id,
            'news_feed_medias.media_type_id' => $this->media_type_id,
            'news_feed_medias.sort' => $this->sort,
            'news_feed_medias.createdby' => $this->createdby,
            'news_feed_medias.createdat' => $this->createdat,
            'news_feed_medias.deletedby' => $this->deletedby,
            'news_feed_medias.deletedat' => $this->deletedat,
        ]);

        $query->andFilterWhere(['like', 'news_feed_medias.thumb_image', $this->thumb_image])
            ->andFilterWhere(['like', 'news_feed_medias.media_title', $this->media_title])
            ->andFilterWhere(['like', 'news_feed_medias.media_value', $this->media_value])
            ->andFilterWhere(['like', 'news_feed_medias.published', $this->published]);

		if(!empty($this->createdatrange) && strpos($this->createdatrange, '-') !== false)
		{
			list($start_date, $end_date) = explode(' - ', $this->createdatrange);
			$query->andFilterWhere(['between', 'news_feed_medias.createdat', $start_date, $end_date]);
		}

        return $dataProvider;
    }
}
