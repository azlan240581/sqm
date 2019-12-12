<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Rewards;

/**
 * RewardsSearch represents the model behind the search form about `app\models\Rewards`.
 */
class RewardsSearch extends Rewards
{
	public $lookupRewardCategory, $publishedDdateStartRange, $publishedDateEndRange, $createdatrange;
	
    public function rules()
    {
        return [
            [['id', 'category_id', 'quantity', 'minimum_quantity', 'rule_expirary_in_days', 'total_viewed', 'createdby', 'updatedby', 'deletedby'], 'integer'],
            [['name', 'summary', 'description', 'images', 'url', 'published_date_start', 'published_date_end', 'status', 'createdat', 'updatedat', 'deletedat'], 'safe'],
            [['points'], 'number'],
            [['lookupRewardCategory', 'publishedDdateStartRange', 'publishedDateEndRange', 'createdatrange'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Rewards::find();

        // add conditions that should always apply here
		$query->andWhere(['rewards.deletedby' => NULL, 'rewards.deletedat' => NULL]);

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
		
		$query->joinWith(['lookupRewardCategory']);
		$dataProvider->sort->attributes['lookupRewardCategory'] = [
			'asc' => ['lookup_reward_categories.name' => SORT_ASC],
			'desc' => ['lookup_reward_categories.name' => SORT_DESC],
		];
		
        // grid filtering conditions
        $query->andFilterWhere([
            'rewards.id' => $this->id,
            'rewards.category_id' => $this->category_id,
            'rewards.quantity' => $this->quantity,
            'rewards.minimum_quantity' => $this->minimum_quantity,
            'rewards.points' => $this->points,
            'rewards.rule_expirary_in_days' => $this->rule_expirary_in_days,
            'rewards.published_date_start' => $this->published_date_start,
            'rewards.published_date_end' => $this->published_date_end,
            'rewards.total_viewed' => $this->total_viewed,
            'rewards.createdby' => $this->createdby,
            'rewards.createdat' => $this->createdat,
            'rewards.updatedby' => $this->updatedby,
            'rewards.updatedat' => $this->updatedat,
            'rewards.deletedby' => $this->deletedby,
            'rewards.deletedat' => $this->deletedat,
        ]);

        $query->andFilterWhere(['like', 'rewards.name', $this->name])
            ->andFilterWhere(['like', 'rewards.summary', $this->summary])
            ->andFilterWhere(['like', 'rewards.description', $this->description])
            ->andFilterWhere(['like', 'rewards.images', $this->images])
            ->andFilterWhere(['like', 'rewards.url', $this->url])
            ->andFilterWhere(['like', 'rewards.status', $this->status])
            ->andFilterWhere(['like', 'lookup_reward_categories.name', $this->lookupRewardCategory]);

		if(!empty($this->publishedDdateStartRange) && strpos($this->publishedDdateStartRange, '-') !== false)
		{
			list($publishedDdateStartstart_date, $publishedDdateStartend_date) = explode(' - ', $this->publishedDdateStartRange);
			$query->andFilterWhere(['between', 'rewards.published_date_start', $publishedDdateStartstart_date, $publishedDdateStartend_date]);
		}

		if(!empty($this->publishedDateEndRange) && strpos($this->publishedDateEndRange, '-') !== false)
		{
			list($publishedDateEndstart_date, $publishedDateEndend_date) = explode(' - ', $this->publishedDateEndRange);
			$query->andFilterWhere(['between', 'rewards.published_date_end', $publishedDateEndstart_date, $publishedDateEndend_date]);
		}

		if(!empty($this->createdatrange) && strpos($this->createdatrange, '-') !== false)
		{
			list($start_date, $end_date) = explode(' - ', $this->createdatrange);
			$query->andFilterWhere(['between', 'rewards.createdat', $start_date, $end_date]);
		}

        return $dataProvider;
    }
}
