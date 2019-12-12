<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Collaterals;

/**
 * CollateralsSearch represents the model behind the search form about `app\models\Collaterals`.
 */
class CollateralsSearch extends Collaterals
{
	public $project, $collateralType, $collateralLink, $publishedDdateStartRange, $publishedDateEndRange, $createdatrange;
	
    public function rules()
    {
        return [
            [['id', 'project_id', 'sort', 'createdby', 'updatedby', 'deletedby'], 'integer'],
            [['title', 'permalink', 'summary', 'description', 'thumb_image', 'published_date_start', 'published_date_end', 'status', 'createdat', 'updatedat', 'deletedat'], 'safe'],
            [['project', 'collateralType', 'collateralLink', 'publishedDdateStartRange', 'publishedDateEndRange', 'createdatrange'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Collaterals::find();

        // add conditions that should always apply here
		$query->andWhere(['collaterals.deletedby' => NULL, 'collaterals.deletedat' => NULL])
			->andWhere(['projects.status' => 1, 'projects.deletedby' => NULL, 'projects.deletedat' => NULL]);

		if($_SESSION['user']['groups']!=NULL and array_intersect(array(7,8,9,10),$_SESSION['user']['groups']))
        {
			//get project agents
			$projectAgents = ProjectAgents::find()->where(array('agent_id'=>$_SESSION['user']['id']))->asArray()->all();
			$query->andWhere(['collaterals.project_id' => array_column($projectAgents,'project_id')]);
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
		
		$query->joinWith(['collateralType', 'collateralLink']);
		$dataProvider->sort->attributes['collateralType'] = [
			'asc' => ['collateralType.collateral_media_type_id' => SORT_ASC],
			'desc' => ['collateralType.collateral_media_type_id' => SORT_DESC],
		];
		$dataProvider->sort->attributes['collateralLink'] = [
			'asc' => ['collateralLink.media_value' => SORT_ASC],
			'desc' => ['collateralLink.media_value' => SORT_DESC],
		];
		
        // grid filtering conditions
        $query->andFilterWhere([
            'collaterals.id' => $this->id,
            'collaterals.project_id' => $this->project_id,
            'collateralType.collateral_media_type_id' => $this->collateralType,
            'collaterals.published_date_start' => $this->published_date_start,
            'collaterals.published_date_end' => $this->published_date_end,
            'collaterals.sort' => $this->sort,
            'collaterals.createdby' => $this->createdby,
            'collaterals.createdat' => $this->createdat,
            'collaterals.updatedby' => $this->updatedby,
            'collaterals.updatedat' => $this->updatedat,
            'collaterals.deletedby' => $this->deletedby,
            'collaterals.deletedat' => $this->deletedat,
        ]);

        $query->andFilterWhere(['like', 'collaterals.title', $this->title])
            ->andFilterWhere(['like', 'collateralLink.media_value', $this->collateralLink])
            ->andFilterWhere(['like', 'collaterals.permalink', $this->permalink])
            ->andFilterWhere(['like', 'collaterals.summary', $this->summary])
            ->andFilterWhere(['like', 'collaterals.description', $this->description])
            ->andFilterWhere(['like', 'collaterals.thumb_image', $this->thumb_image])
            ->andFilterWhere(['like', 'collaterals.status', $this->status])
            ->andFilterWhere(['like', 'projects.project_name', $this->project]);

		if(!empty($this->publishedDdateStartRange) && strpos($this->publishedDdateStartRange, '-') !== false)
		{
			list($publishedDdateStartstart_date, $publishedDdateStartend_date) = explode(' - ', $this->publishedDdateStartRange);
			$query->andFilterWhere(['between', 'collaterals.published_date_start', $publishedDdateStartstart_date, $publishedDdateStartend_date]);
		}

		if(!empty($this->publishedDateEndRange) && strpos($this->publishedDateEndRange, '-') !== false)
		{
			list($publishedDateEndstart_date, $publishedDateEndend_date) = explode(' - ', $this->publishedDateEndRange);
			$query->andFilterWhere(['between', 'collaterals.published_date_end', $publishedDateEndstart_date, $publishedDateEndend_date]);
		}

		if(!empty($this->createdatrange) && strpos($this->createdatrange, '-') !== false)
		{
			list($start_date, $end_date) = explode(' - ', $this->createdatrange);
			$query->andFilterWhere(['between', 'collaterals.createdat', $start_date, $end_date]);
		}

        return $dataProvider;
    }
}
