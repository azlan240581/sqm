<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Users;

/**
 * UsersSearch represents the model behind the search form about `app\models\Users`.
 */
class UsersSearch extends Users
{
	public $lookupPosition, $groupAccess, $createdatrange, $lastloginatrange;
	
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'avatar_id', 'status', 'createdby', 'updatedby', 'deletedby'], 'integer'],
            [['uuid', 'username', 'password', 'password_salt', 'email', 'firstname', 'lastname', 'name', 'contact_number', 'dob', 'gender', 'address_1', 'address_2', 'address_3', 'city', 'postcode', 'state', 'country', 'lastloginat', 'createdat', 'updatedat', 'deletedat', 'createdatrange', 'lastloginatrange'], 'safe'],
			[['lookupPosition', 'groupAccess', 'fb_info', 'gmail_info', 'twitter_info'], 'string'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Users::find();

        // add conditions that should always apply here
		$query->andWhere(['users.deletedby' => NULL, 'users.deletedat' => NULL])
			->andWhere(['<>','users.id',1]);

		$query->andWhere(['<>','users.id',$_SESSION['user']['id']]);
		
        if($_SESSION['user']['id']==1)
		$query->andWhere(['group_access.id'=>array(1,2,3,4,5,6,7,8,9,10)]);
		elseif($_SESSION['user']['groups']!=NULL and in_array(1,$_SESSION['user']['groups']))
		$query->andWhere(['group_access.id'=>array(2,3,4,5,6,7,8,9,10)]);
		elseif($_SESSION['user']['groups']!=NULL and in_array(2,$_SESSION['user']['groups']))
		$query->andWhere(['group_access.id'=>array(7,8,9,10)]);
		elseif($_SESSION['user']['groups']!=NULL and in_array(7,$_SESSION['user']['groups']))
		$query->andWhere(['group_access.id'=>array(9)]);
		elseif($_SESSION['user']['groups']!=NULL and in_array(8,$_SESSION['user']['groups']))
		$query->andWhere(['group_access.id'=>array(10)]);

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
			
		$query->joinWith(['lookupPosition']);
		$dataProvider->sort->attributes['lookupPosition'] = [
			'asc' => ['lookup_positions.name' => SORT_ASC],
			'desc' => ['lookup_positions.name' => SORT_DESC],
		];
				
		$query->joinWith(['groupAccess']);
		$dataProvider->sort->attributes['groupAccess'] = [
			'asc' => ['group_access.group_access_name' => SORT_ASC],
			'desc' => ['group_access.group_access_name' => SORT_DESC],
		];
				
        // grid filtering conditions
        $query->andFilterWhere([
            'users.id' => $this->id,
            'users.avatar_id' => $this->avatar_id,
            'users.status' => $this->status,
            'users.dob' => $this->dob,
            'users.lastloginat' => $this->lastloginat,
            'users.createdby' => $this->createdby,
            'users.createdat' => $this->createdat,
            'users.updatedby' => $this->updatedby,
            'users.updatedat' => $this->updatedat,
            'users.deletedby' => $this->deletedby,
            'users.deletedat' => $this->deletedat,
        ]);

        $query->andFilterWhere(['like', 'LOWER(users.uuid)', strtolower($this->uuid)])
            ->andFilterWhere(['like', 'LOWER(users.username)', strtolower($this->username)])
            ->andFilterWhere(['like', 'LOWER(users.password)', strtolower($this->password)])
            ->andFilterWhere(['like', 'LOWER(users.password_salt)', strtolower($this->password_salt)])
            ->andFilterWhere(['like', 'LOWER(users.email)', strtolower($this->email)])
            ->andFilterWhere(['like', 'LOWER(users.firstname)', strtolower($this->firstname)])
            ->andFilterWhere(['like', 'LOWER(users.lastname)', strtolower($this->lastname)])
            ->andFilterWhere(['like', 'LOWER(users.name)', strtolower($this->name)])
            ->andFilterWhere(['like', 'LOWER(users.contact_number)', strtolower($this->contact_number)])
            ->andFilterWhere(['like', 'LOWER(users.gender)', strtolower($this->gender)])
            ->andFilterWhere(['like', 'LOWER(users.address_1)', strtolower($this->address_1)])
            ->andFilterWhere(['like', 'LOWER(users.address_2)', strtolower($this->address_2)])
            ->andFilterWhere(['like', 'LOWER(users.address_3)', strtolower($this->address_3)])
            ->andFilterWhere(['like', 'LOWER(users.city)', strtolower($this->city)])
            ->andFilterWhere(['like', 'LOWER(users.postcode)', strtolower($this->postcode)])
            ->andFilterWhere(['like', 'LOWER(users.state)', strtolower($this->state)])
            ->andFilterWhere(['like', 'LOWER(users.country)', strtolower($this->country)])
            ->andFilterWhere(['like', 'LOWER(users.fb_info)', strtolower($this->fb_info)])
            ->andFilterWhere(['like', 'LOWER(users.gmail_info)', strtolower($this->gmail_info)])
            ->andFilterWhere(['like', 'LOWER(users.twitter_info)', strtolower($this->twitter_info)])
			->andFilterWhere(['like', 'LOWER(lookup_positions.name)', strtolower($this->lookupPosition)])
			->andFilterWhere(['like', 'LOWER(group_access.group_access_name)', strtolower($this->groupAccess)]);

		if(!empty($this->createdatrange) && strpos($this->createdatrange, '-') !== false)
		{
			list($start_date, $end_date) = explode(' - ', $this->createdatrange);
			$query->andFilterWhere(['between', 'users.createdat', $start_date, $end_date]);
		}
		        
		if(!empty($this->lastloginatrange) && strpos($this->lastloginatrange, '-') !== false)
		{
			list($lastloginatstart_date, $lastloginatend_date) = explode(' - ', $this->lastloginatrange);
			$query->andFilterWhere(['between', 'users.lastloginat', $lastloginatstart_date, $lastloginatend_date]);
		}
		        
        return $dataProvider;
    }
}
