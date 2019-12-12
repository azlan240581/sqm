<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\UserCommissions;

/**
 * UserCommissionsSearch represents the model behind the search form about `app\models\UserCommissions`.
 */
class UserCommissionsSearch extends UserCommissions
{
	public $userFirstName, $userLastName, $userEmail, $userGroup;
	
    public function rules()
    {
        return [
            [['id', 'user_id', 'status', 'createdby', 'updatedby', 'deletedby'], 'integer'],
            [['total_commission_amount'], 'number'],
            [['remarks', 'createdat', 'updatedat', 'deletedat'], 'safe'],
            [['userFirstName', 'userLastName', 'userEmail', 'userGroup'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = UserCommissions::find();

        // add conditions that should always apply here
		$query->andWhere(['userFirstName.status' => 1, 'userFirstName.deletedby' => NULL, 'userFirstName.deletedat' => NULL]);
			
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'sort' => [
					  'defaultOrder' => ['total_commission_amount' => SORT_DESC,]
					  ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

		$query->joinWith(['userFirstName', 'userLastName', 'userEmail',]);
		$dataProvider->sort->attributes['userFirstName'] = [
			'asc' => ['userFirstName.firstname' => SORT_ASC],
			'desc' => ['userFirstName.firstname' => SORT_DESC],
		];
		$dataProvider->sort->attributes['userLastName'] = [
			'asc' => ['userLastName.lastname' => SORT_ASC],
			'desc' => ['userLastName.lastname' => SORT_DESC],
		];
		$dataProvider->sort->attributes['userEmail'] = [
			'asc' => ['userEmail.email' => SORT_ASC],
			'desc' => ['userEmail.email' => SORT_DESC],
		];

		$query->joinWith(['userGroup']);
		$dataProvider->sort->attributes['userGroup'] = [
			'asc' => ['user_groups.groupaccess_id' => SORT_ASC],
			'desc' => ['user_groups.groupaccess_id' => SORT_DESC],
		];

        // grid filtering conditions
        $query->andFilterWhere([
            'user_commissions.id' => $this->id,
            'user_commissions.user_id' => $this->user_id,
            'user_commissions.total_commission_amount' => $this->total_commission_amount,
            'user_groups.groupaccess_id' => $this->userGroup,
            'user_commissions.status' => $this->status,
            'user_commissions.createdby' => $this->createdby,
            'user_commissions.createdat' => $this->createdat,
            'user_commissions.updatedby' => $this->updatedby,
            'user_commissions.updatedat' => $this->updatedat,
            'user_commissions.deletedby' => $this->deletedby,
            'user_commissions.deletedat' => $this->deletedat,
        ]);

        $query->andFilterWhere(['like', 'user_commissions.remarks', $this->remarks])
            ->andFilterWhere(['like', 'LOWER(userFirstName.firstname)', strtolower($this->userFirstName)])
            ->andFilterWhere(['like', 'LOWER(userLastName.lastname)', strtolower($this->userLastName)])
            ->andFilterWhere(['like', 'LOWER(userEmail.email)', strtolower($this->userEmail)]);

        return $dataProvider;
    }
}
