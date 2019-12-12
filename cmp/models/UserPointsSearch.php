<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\UserPoints;

/**
 * UserPointsSearch represents the model behind the search form about `app\models\UserPoints`.
 */
class UserPointsSearch extends UserPoints
{
	public $agentName, $associateName, $associateEmail, $associateContactNo;
	
    public function rules()
    {
        return [
            [['id', 'user_id', 'createdby', 'updatedby', 'deletedby'], 'integer'],
            [['total_points_value'], 'number'],
            [['createdat', 'updatedat', 'deletedat'], 'safe'],
            [['agentName', 'associateName', 'associateEmail', 'associateContactNo'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = UserPoints::find();

        // add conditions that should always apply here
		$query->andWhere(['associateName.status' => 1])
		->andWhere(['associateName.deletedat' => NULL, 'associateName.deletedby' => NULL]);

		if($_SESSION['user']['groups']!=NULL and array_intersect(array(7,8,9,10),$_SESSION['user']['groups']))
        {
			//get associate user id
			$memberList = Yii::$app->AccessMod->getMemberList($_SESSION['user']['id']);
			$query->andWhere(['user_associate_details.user_id' => array_column($memberList,'id')]);
		}

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'sort' => [
					  'defaultOrder' => ['total_points_value' => SORT_DESC,]
					  ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

		$query->joinWith(['user']);
		$query->joinWith(['agentName', 'associateName', 'associateEmail', 'associateContactNo']);
		$dataProvider->sort->attributes['agentName'] = [
			'asc' => ['agentName.name' => SORT_ASC],
			'desc' => ['agentName.name' => SORT_DESC],
		];
		$dataProvider->sort->attributes['associateName'] = [
			'asc' => ['associateName.name' => SORT_ASC],
			'desc' => ['associateName.name' => SORT_DESC],
		];
		$dataProvider->sort->attributes['associateEmail'] = [
			'asc' => ['associateEmail.email' => SORT_ASC],
			'desc' => ['associateEmail.email' => SORT_DESC],
		];
		$dataProvider->sort->attributes['associateContactNo'] = [
			'asc' => ['associateContactNo.contact_number' => SORT_ASC],
			'desc' => ['associateContactNo.contact_number' => SORT_DESC],
		];

        // grid filtering conditions
        $query->andFilterWhere([
            'user_points.id' => $this->id,
            'user_points.user_id' => $this->user_id,
            'user_points.total_points_value' => $this->total_points_value,
            'user_points.createdby' => $this->createdby,
            'user_points.createdat' => $this->createdat,
            'user_points.updatedby' => $this->updatedby,
            'user_points.updatedat' => $this->updatedat,
            'user_points.deletedby' => $this->deletedby,
            'user_points.deletedat' => $this->deletedat,
        ]);

        $query->andFilterWhere(['like', 'LOWER(agentName.name)', strtolower($this->agentName)])
			->andFilterWhere(['like', 'LOWER(associateName.name)', strtolower($this->associateName)])
			->andFilterWhere(['like', 'LOWER(associateEmail.email)', strtolower($this->associateEmail)])
			->andFilterWhere(['like', 'LOWER(associateContactNo.contact_number)', strtolower($this->associateContactNo)]);

        return $dataProvider;
    }
}
