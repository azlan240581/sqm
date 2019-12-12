<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\NewsFeeds;

/**
 * NewsFeedsSearch represents the model behind the search form about `app\models\NewsFeeds`.
 */
class NewsFeedsSearch extends NewsFeeds
{
	public $project, $publishedDdateStartRange, $publishedDateEndRange, $createdatrange;
	
    public function rules()
    {
        return [
            [['id', 'category_id', 'project_id', 'product_id', 'total_viewed', 'status', 'createdby', 'updatedby', 'deletedby'], 'integer'],
            [['title', 'permalink', 'summary', 'description', 'thumb_image', 'promotion_start_date', 'promotion_end_date', 'promotion_terms_conditions', 'event_at', 'event_location', 'event_location_longitude', 'event_location_latitude', 'collaterals_id', 'published_date_start', 'published_date_end', 'createdat', 'updatedat', 'deletedat'], 'safe'],
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
        $query = NewsFeeds::find();

        // add conditions that should always apply here
		$query->andWhere(['news_feeds.deletedby' => NULL, 'news_feeds.deletedat' => NULL])
			->andWhere(['projects.status' => 1, 'projects.deletedby' => NULL, 'projects.deletedat' => NULL]);

		if($_SESSION['user']['groups']!=NULL and array_intersect(array(7,8,9,10),$_SESSION['user']['groups']))
        {
			//get project agents
			$projectAgents = ProjectAgents::find()->where(array('agent_id'=>$_SESSION['user']['id']))->asArray()->all();
			$query->andWhere(['news_feeds.project_id' => array_column($projectAgents,'project_id')]);
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
            'news_feeds.id' => $this->id,
            'news_feeds.category_id' => $this->category_id,
            'news_feeds.project_id' => $this->project_id,
            'news_feeds.product_id' => $this->product_id,
            'news_feeds.promotion_start_date' => $this->promotion_start_date,
            'news_feeds.promotion_end_date' => $this->promotion_end_date,
            'news_feeds.event_at' => $this->event_at,
            'news_feeds.published_date_start' => $this->published_date_start,
            'news_feeds.published_date_end' => $this->published_date_end,
            'news_feeds.total_viewed' => $this->total_viewed,
            'news_feeds.status' => $this->status,
            'news_feeds.createdby' => $this->createdby,
            'news_feeds.createdat' => $this->createdat,
            'news_feeds.updatedby' => $this->updatedby,
            'news_feeds.updatedat' => $this->updatedat,
            'news_feeds.deletedby' => $this->deletedby,
            'news_feeds.deletedat' => $this->deletedat,
        ]);

        $query->andFilterWhere(['like', 'news_feeds.title', $this->title])
            ->andFilterWhere(['like', 'news_feeds.permalink', $this->permalink])
            ->andFilterWhere(['like', 'news_feeds.summary', $this->summary])
            ->andFilterWhere(['like', 'news_feeds.description', $this->description])
            ->andFilterWhere(['like', 'news_feeds.thumb_image', $this->thumb_image])
            ->andFilterWhere(['like', 'news_feeds.promotion_terms_conditions', $this->promotion_terms_conditions])
            ->andFilterWhere(['like', 'news_feeds.event_location', $this->event_location])
            ->andFilterWhere(['like', 'news_feeds.event_location_longitude', $this->event_location_longitude])
            ->andFilterWhere(['like', 'news_feeds.event_location_latitude', $this->event_location_latitude])
            ->andFilterWhere(['like', 'news_feeds.collaterals_id', $this->collaterals_id])
			->andFilterWhere(['like', 'projects.project_name', strtolower($this->project)]);

		if(!empty($this->publishedDdateStartRange) && strpos($this->publishedDdateStartRange, '-') !== false)
		{
			list($publishedDdateStartstart_date, $publishedDdateStartend_date) = explode(' - ', $this->publishedDdateStartRange);
			$query->andFilterWhere(['between', 'news_feeds.published_date_start', $publishedDdateStartstart_date, $publishedDdateStartend_date]);
		}

		if(!empty($this->publishedDateEndRange) && strpos($this->publishedDateEndRange, '-') !== false)
		{
			list($publishedDateEndstart_date, $publishedDateEndend_date) = explode(' - ', $this->publishedDateEndRange);
			$query->andFilterWhere(['between', 'news_feeds.published_date_end', $publishedDateEndstart_date, $publishedDateEndend_date]);
		}

		if(!empty($this->createdatrange) && strpos($this->createdatrange, '-') !== false)
		{
			list($start_date, $end_date) = explode(' - ', $this->createdatrange);
			$query->andFilterWhere(['between', 'news_feeds.createdat', $start_date, $end_date]);
		}

        return $dataProvider;
    }
}
