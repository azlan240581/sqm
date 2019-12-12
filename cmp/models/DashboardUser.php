<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dashboard_user".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $total_normal
 * @property integer $total_active
 * @property integer $total_productive
 * @property integer $total_new_prospect_registered
 * @property integer $total_follow_up
 * @property integer $total_appointment_scheduled
 * @property integer $total_level_of_interest
 * @property integer $total_waiting_booking_eoi_approval
 * @property integer $total_eoi_rejected
 * @property integer $total_eoi_verified
 * @property integer $total_waiting_booking_approval
 * @property integer $total_booking_rejected
 * @property integer $total_booking_approved
 * @property integer $total_waiting_booking_contract_signed_approval
 * @property integer $total_contract_signed_rejected
 * @property integer $total_contract_signed_approved
 * @property integer $total_waiting_cancel_approved
 * @property integer $total_cancel_rejected
 * @property integer $total_cancel_approved
 * @property integer $total_completed
 * @property integer $total_drop
 */
class DashboardUser extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dashboard_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id', 'total_normal', 'total_active', 'total_productive', 'total_new_prospect_registered', 'total_follow_up', 'total_appointment_scheduled', 'total_level_of_interest', 'total_waiting_booking_eoi_approval', 'total_eoi_rejected', 'total_eoi_verified', 'total_waiting_booking_approval', 'total_booking_rejected', 'total_booking_approved', 'total_waiting_booking_contract_signed_approval', 'total_contract_signed_rejected', 'total_contract_signed_approved', 'total_waiting_cancel_approved', 'total_cancel_rejected', 'total_cancel_approved', 'total_completed', 'total_drop'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'total_normal' => 'Total Normal',
            'total_active' => 'Total Active',
            'total_productive' => 'Total Productive',
            'total_new_prospect_registered' => 'Total New Prospect Registered',
            'total_follow_up' => 'Total Follow Up',
            'total_appointment_scheduled' => 'Total Appointment Scheduled',
            'total_level_of_interest' => 'Total Level Of Interest',
            'total_waiting_booking_eoi_approval' => 'Total Waiting Booking Eoi Approval',
            'total_eoi_rejected' => 'Total Eoi Rejected',
            'total_eoi_verified' => 'Total Eoi Verified',
            'total_waiting_booking_approval' => 'Total Waiting Booking Approval',
            'total_booking_rejected' => 'Total Booking Rejected',
            'total_booking_approved' => 'Total Booking Approved',
            'total_waiting_booking_contract_signed_approval' => 'Total Waiting Booking Contract Signed Approval',
            'total_contract_signed_rejected' => 'Total Contract Signed Rejected',
            'total_contract_signed_approved' => 'Total Contract Signed Approved',
            'total_waiting_cancel_approved' => 'Total Waiting Cancel Approved',
            'total_cancel_rejected' => 'Total Cancel Rejected',
            'total_cancel_approved' => 'Total Cancel Approved',
            'total_completed' => 'Total Completed',
            'total_drop' => 'Total Drop',
        ];
    }
}
