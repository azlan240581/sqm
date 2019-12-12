<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "prospect_booking_buyers".
 *
 * @property integer $id
 * @property integer $prospect_id
 * @property integer $prospect_booking_id
 * @property string $buyer_firstname
 * @property string $buyer_lastname
 * @property string $buyer_email
 * @property string $buyer_contact_number
 */
class ProspectBookingBuyers extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'prospect_booking_buyers';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['prospect_id', 'prospect_booking_id', 'buyer_firstname', 'buyer_lastname'], 'required'],
            [['prospect_id', 'prospect_booking_id'], 'integer'],
            [['buyer_firstname', 'buyer_lastname', 'buyer_email'], 'string', 'max' => 255],
            [['buyer_contact_number'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'prospect_id' => 'Prospect ID',
            'prospect_booking_id' => 'Prospect Booking ID',
            'buyer_firstname' => 'First Name',
            'buyer_lastname' => 'Last Name',
            'buyer_email' => 'Email',
            'buyer_contact_number' => 'Contact Number',
        ];
    }
}
