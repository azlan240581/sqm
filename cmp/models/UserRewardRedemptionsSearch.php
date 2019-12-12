<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\UserRewardRedemptions;

/**
 * UserRewardRedemptionsSearch represents the model behind the search form about `app\models\UserRewardRedemptions`.
 */
class UserRewardRedemptionsSearch extends UserRewardRedemptions
{
	public $reward, $associateFirstName, $associateLastName, $lookupRedemptionStatus, $createdatrange;
	
    public function rules()
    {
        return [
            [['id', 'reward_id', 'user_id', 'quantity', 'status', 'createdby', 'updatedby', 'deletedby'], 'integer'],
            [['receiver_name', 'receiver_email', 'receiver_country_code', 'receiver_contact_no', 'address_1', 'address_2', 'address_3', 'city', 'postcode', 'state', 'country', 'courier_name', 'tracking_number', 'ticket_no', 'ticket_expirary', 'createdat', 'updatedat', 'deletedat'], 'safe'],
            [['points_value'], 'number'],
            [['reward', 'associateFirstName', 'associateLastName', 'lookupRedemptionStatus', 'createdatrange'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = UserRewardRedemptions::find();

        // add conditions that should always apply here
		$query->andWhere(['user_reward_redemptions.deletedby' => NULL, 'user_reward_redemptions.deletedat' => NULL]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'sort' => [
					  'defaultOrder' => ['status' => SORT_ASC,'createdat' => SORT_DESC,]
					  ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

		$query->joinWith(['reward']);
		$dataProvider->sort->attributes['reward'] = [
			'asc' => ['rewards.name' => SORT_ASC],
			'desc' => ['rewards.name' => SORT_DESC],
		];

		$query->joinWith(['associateFirstName', 'associateLastName']);
		$dataProvider->sort->attributes['associateFirstName'] = [
			'asc' => ['associateFirstName.firstname' => SORT_ASC],
			'desc' => ['associateFirstName.firstname' => SORT_DESC],
		];
		$dataProvider->sort->attributes['associateLastName'] = [
			'asc' => ['associateLastName.lastname' => SORT_ASC],
			'desc' => ['associateLastName.lastname' => SORT_DESC],
		];

        // grid filtering conditions
        $query->andFilterWhere([
            'user_reward_redemptions.id' => $this->id,
            'user_reward_redemptions.reward_id' => $this->reward_id,
            'user_reward_redemptions.user_id' => $this->user_id,
            'user_reward_redemptions.quantity' => $this->quantity,
            'user_reward_redemptions.points_value' => $this->points_value,
            'user_reward_redemptions.ticket_expirary' => $this->ticket_expirary,
            'user_reward_redemptions.status' => $this->status,
            'user_reward_redemptions.createdby' => $this->createdby,
            'user_reward_redemptions.createdat' => $this->createdat,
            'user_reward_redemptions.updatedby' => $this->updatedby,
            'user_reward_redemptions.updatedat' => $this->updatedat,
            'user_reward_redemptions.deletedby' => $this->deletedby,
            'user_reward_redemptions.deletedat' => $this->deletedat,
        ]);

        $query->andFilterWhere(['like', 'user_reward_redemptions.receiver_name', $this->receiver_name])
            ->andFilterWhere(['like', 'user_reward_redemptions.receiver_email', $this->receiver_email])
            ->andFilterWhere(['like', 'user_reward_redemptions.receiver_country_code', $this->receiver_country_code])
            ->andFilterWhere(['like', 'user_reward_redemptions.receiver_contact_no', $this->receiver_contact_no])
            ->andFilterWhere(['like', 'user_reward_redemptions.address_1', $this->address_1])
            ->andFilterWhere(['like', 'user_reward_redemptions.address_2', $this->address_2])
            ->andFilterWhere(['like', 'user_reward_redemptions.address_3', $this->address_3])
            ->andFilterWhere(['like', 'user_reward_redemptions.city', $this->city])
            ->andFilterWhere(['like', 'user_reward_redemptions.postcode', $this->postcode])
            ->andFilterWhere(['like', 'user_reward_redemptions.state', $this->state])
            ->andFilterWhere(['like', 'user_reward_redemptions.country', $this->country])
            ->andFilterWhere(['like', 'user_reward_redemptions.courier_name', $this->courier_name])
            ->andFilterWhere(['like', 'user_reward_redemptions.tracking_number', $this->tracking_number])
            ->andFilterWhere(['like', 'user_reward_redemptions.ticket_no', $this->ticket_no])
            ->andFilterWhere(['like', 'rewards.name', $this->reward])
            ->andFilterWhere(['like', 'associateFirstName.firstname', $this->associateFirstName])
            ->andFilterWhere(['like', 'associateLastName.lastname', $this->associateLastName]);

		if(!empty($this->createdatrange) && strpos($this->createdatrange, '-') !== false)
		{
			list($start_date, $end_date) = explode(' - ', $this->createdatrange);
			$query->andFilterWhere(['between', 'user_reward_redemptions.createdat', $start_date, $end_date]);
		}
		        
        return $dataProvider;
    }
}
