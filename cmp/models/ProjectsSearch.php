<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Projects;

/**
 * ProjectsSearch represents the model behind the search form about `app\models\Projects`.
 */
class ProjectsSearch extends Projects
{
	public $developer, $agent, $createdatrange;
	
    public function rules()
    {
        return [
            [['id', 'developer_id', 'createdby', 'updatedby', 'deletedby'], 'integer'],
            [['project_name', 'project_description', 'thumb_image', 'status', 'createdat', 'updatedat', 'deletedat'], 'safe'],
            [['developer', 'agent', 'createdatrange'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Projects::find();

        // add conditions that should always apply here
		$query->andWhere(['projects.deletedby' => NULL, 'projects.deletedat' => NULL]);

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
		
		$query->joinWith(['developer']);
		$dataProvider->sort->attributes['developer'] = [
			'asc' => ['developers.company_name' => SORT_ASC],
			'desc' => ['developers.company_name' => SORT_DESC],
		];
		
		$query->joinWith(['agent']);
		$dataProvider->sort->attributes['agent'] = [
			'asc' => ['users.name' => SORT_ASC],
			'desc' => ['users.name' => SORT_DESC],
		];
		
        // grid filtering conditions
        $query->andFilterWhere([
            'projects.id' => $this->id,
            'projects.developer_id' => $this->developer_id,
            'projects.createdby' => $this->createdby,
            'projects.createdat' => $this->createdat,
            'projects.updatedby' => $this->updatedby,
            'projects.updatedat' => $this->updatedat,
            'projects.deletedby' => $this->deletedby,
            'projects.deletedat' => $this->deletedat,
        ]);

        $query->andFilterWhere(['like', 'projects.project_name', $this->project_name])
            ->andFilterWhere(['like', 'projects.project_description', $this->project_description])
            ->andFilterWhere(['like', 'projects.thumb_image', $this->thumb_image])
            ->andFilterWhere(['like', 'projects.status', $this->status])
			->andFilterWhere(['like', 'developers.company_name', strtolower($this->developer)])
			->andFilterWhere(['like', 'users.name', strtolower($this->agent)]);

		if(!empty($this->createdatrange) && strpos($this->createdatrange, '-') !== false)
		{
			list($start_date, $end_date) = explode(' - ', $this->createdatrange);
			$query->andFilterWhere(['between', 'projects.createdat', $start_date, $end_date]);
		}

        return $dataProvider;
    }
}
