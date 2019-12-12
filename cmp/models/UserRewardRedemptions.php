<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_reward_redemptions".
 *
 * @property integer $id
 * @property integer $reward_id
 * @property integer $user_id
 * @property string $receiver_name
 * @property string $receiver_email
 * @property string $receiver_country_code
 * @property string $receiver_contact_no
 * @property string $address_1
 * @property string $address_2
 * @property string $address_3
 * @property string $city
 * @property string $postcode
 * @property string $state
 * @property string $country
 * @property string $courier_name
 * @property string $tracking_number
 * @property integer $quantity
 * @property string $points_value
 * @property string $ticket_no
 * @property string $ticket_expirary
 * @property integer $status
 * @property integer $createdby
 * @property string $createdat
 * @property integer $updatedby
 * @property string $updatedat
 * @property integer $deletedby
 * @property string $deletedat
 */
class UserRewardRedemptions extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'user_reward_redemptions';
    }

    public function rules()
    {
        return [
            [['reward_id', 'user_id', 'receiver_name', 'receiver_email', 'receiver_country_code', 'receiver_contact_no', 'address_1', 'city', 'postcode', 'state', 'country', 'quantity', 'points_value', 'status', 'createdby', 'createdat'], 'required'],
            [['reward_id', 'user_id', 'quantity', 'status', 'createdby', 'updatedby', 'deletedby'], 'integer'],
            [['points_value'], 'number'],
            [['ticket_expirary', 'createdat', 'updatedat', 'deletedat'], 'safe'],
            [['receiver_name', 'receiver_email', 'address_1', 'address_2', 'address_3', 'city', 'postcode', 'state', 'country', 'courier_name', 'tracking_number'], 'string', 'max' => 255],
            [['receiver_country_code', 'receiver_contact_no', 'ticket_no'], 'string', 'max' => 100],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'reward_id' => 'Reward ID',
            'user_id' => 'User ID',
            'receiver_name' => 'Receiver Name',
            'receiver_email' => 'Receiver Email',
            'receiver_country_code' => 'Receiver Country Code',
            'receiver_contact_no' => 'Receiver Contact Number',
            'address_1' => 'Address 1',
            'address_2' => 'Address 2',
            'address_3' => 'Address 3',
            'city' => 'City',
            'postcode' => 'Postcode',
            'state' => 'State',
            'country' => 'Country',
            'courier_name' => 'Courier Name',
            'tracking_number' => 'Tracking Number',
            'quantity' => 'Quantity',
            'points_value' => 'Points Value',
            'ticket_no' => 'Ticket No',
            'ticket_expirary' => 'Ticket Expirary',
            'status' => 'Status',
            'createdby' => 'Createdby',
            'createdat' => 'Created At',
            'updatedby' => 'Updated By',
            'updatedat' => 'Updated At',
            'deletedby' => 'Deleted By',
            'deletedat' => 'Deleted At',
        ];
    }
	
	public function getReward()
    {
        return $this->hasOne(Rewards::className(), ['id' => 'reward_id']);
    }
	
	public function getAssociateFirstName()
    {
		return $this->hasOne(Users::className(), ['id' => 'user_id'])->from(['associateFirstName' => Users::tableName()]);
    }

	public function getAssociateLastName()
    {
		return $this->hasOne(Users::className(), ['id' => 'user_id'])->from(['associateLastName' => Users::tableName()]);
    }
	
	public function getLookupRedemptionStatus()
    {
        return $this->hasOne(LookupRedemptionStatus::className(), ['id' => 'status']);
    }
	
	public function getLookupCountry()
    {
        return $this->hasOne(LookupCountry::className(), ['id' => 'country']);
    }
	
	
	
}
