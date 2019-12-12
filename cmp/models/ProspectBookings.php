<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "prospect_bookings".
 *
 * @property integer $id
 * @property integer $ref_no
 * @property integer $prospect_id
 * @property integer $agent_id
 * @property integer $member_id
 * @property integer $dedicated_agent_id
 * @property integer $referrer_member_id
 * @property integer $developer_id
 * @property integer $project_id
 * @property integer $product_id
 * @property string $product_unit
 * @property integer $product_unit_type
 * @property integer $building_size_sm
 * @property integer $land_size_sm
 * @property string $product_unit_price
 * @property string $product_unit_vat_price
 * @property integer $express_downpayment
 * @property integer $payment_method_eoi
 * @property integer $eoi_ref_no
 * @property string $booking_eoi_amount
 * @property string $proof_of_payment_eoi
 * @property string $booking_date_eoi
 * @property integer $booking_ref_no
 * @property integer $payment_method
 * @property string $booking_amount
 * @property string $proof_of_payment
 * @property string $booking_date
 * @property string $sp_file
 * @property string $ppjb_file
 * @property integer $cancel_ref_no
 * @property string $cancellation_attachment
 * @property string $remarks
 * @property integer $status
 * @property integer $createdby
 * @property string $createdat
 * @property integer $updatedby
 * @property string $updatedat
 * @property integer $deletedby
 * @property string $deletedat
 */
class ProspectBookings extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
	 
    public static function tableName()
    {
        return 'prospect_bookings';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['prospect_id', 'agent_id', 'member_id', 'createdby', 'createdat'], 'required'],
            [['prospect_id', 'agent_id', 'member_id', 'dedicated_agent_id', 'referrer_member_id', 'developer_id', 'project_id', 'product_id', 'product_unit_type', 'payment_method_eoi', 'payment_method', 'createdby', 'updatedby', 'deletedby'], 'integer'],
            [['building_size_sm', 'land_size_sm', 'product_unit_price', 'product_unit_vat_price', 'booking_eoi_amount', 'booking_amount'], 'number'],
            [['remarks'], 'string'],
            [['prospect_name', 'createdat', 'updatedat', 'deletedat'], 'safe'],
            [['product_unit'], 'string', 'max' => 100],
            [['express_downpayment', 'status'], 'integer'],
            [['ref_no', 'eoi_ref_no', 'booking_ref_no', 'cancel_ref_no', 'proof_of_payment_eoi', 'proof_of_payment', 'sp_file', 'ppjb_file', 'cancellation_attachment'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ref_no' => 'Reference Number',
            'prospect_id' => 'Prospect',
            'prospect_name' => 'Prospect',
            'agent_id' => 'SQM Account Manager',
            'agent_name' => 'SQM Account Manager',
            'member_id' => 'Associate',
            'dedicated_agent_id' => 'Dedicated SQM Account Manager',
            'referrer_member_id' => 'Associate Referrer',
            'developer_id' => 'Developer',
            'project_id' => 'Project',
            'product_id' => 'Product',
            'product_unit' => 'Unit Details',
            'product_unit_type' => 'Unit Type',
            'building_size_sm' => 'Building Size SM',
            'land_size_sm' => 'Land Size SM',
            'product_unit_price' => 'Unit Price',
            'product_unit_vat_price' => 'Unit VAT Price',
            'payment_method_eoi' => 'Payment Method EOI',
            'express_downpayment' => 'Express Downpayment',
            'eoi_ref_no' => 'EOI Reference Number',
            'booking_eoi_amount' => 'Booking EOI Amount',
            'proof_of_payment_eoi' => 'Proof Of Payment EOI',
            'booking_date_eoi' => 'Booking Date EOI',
            'booking_ref_no' => 'Booking Reference Number',
            'payment_method' => 'Payment Method',
            'booking_amount' => 'Booking Amount',
            'proof_of_payment' => 'Proof Of Payment',
            'booking_date' => 'Booking Date',
            'sp_file' => 'Acceptance Confirmation by Developer',
            'ppjb_file' => 'PPJB File',
            'cancel_ref_no' => 'Cancel Reference Number',
            'cancellation_attachment' => 'Cancellation Attachment',
            'remarks' => 'Remarks',
            'status' => 'Status',
            'createdby' => 'Created by',
            'createdat' => 'Created at',
            'updatedby' => 'Updated by',
            'updatedat' => 'Updated at',
            'deletedby' => 'Deleted by',
            'deletedat' => 'Deleted at',
        ];
    }


	public function getProspect()
    {
        return $this->hasOne(Prospects::className(), ['id' => 'prospect_id']);
    }

	public function getDeveloper()
    {
        return $this->hasOne(Developers::className(), ['id' => 'developer_id']);
    }

	public function getProject()
    {
        return $this->hasOne(Projects::className(), ['id' => 'project_id']);
    }

	public function getProjectProducts()
    {
        return $this->hasOne(ProjectProducts::className(), ['id' => 'product_id']);
    }

	public function getProjectProductUnitTypes()
	{		
		return $this->hasOne(ProjectProductUnitTypes::className(), ['id' => 'product_unit_type']);
	}	

	public function getProspectBookingBuyers()
	{		
		return $this->hasMany(ProspectBookingBuyers::className(), ['prospect_booking_id' => 'id']);
	}	

	public function getAgent()
    {
        return $this->hasOne(Users::className(), ['id' => 'agent_id'])->from(['agent_name' => Users::tableName()]);
    }

	public function getDedicatedAgent()
    {
        return $this->hasOne(Users::className(), ['id' => 'dedicated_agent_id'])->from(['dedicated_agent_name' => Users::tableName()]);
    }

	public function getMember()
    {
        return $this->hasOne(Users::className(), ['id' => 'member_id'])->from(['member_name' => Users::tableName()]);
    }

	public function getReferrerMember()
    {
        return $this->hasOne(Users::className(), ['id' => 'referrer_member_id'])->from(['referrer_member_name' => Users::tableName()]);
    }

	public function getCreatedbyusername()
    {
        return $this->hasOne(Users::className(), ['id' => 'createdby']);
    }

	public function getUpdatedbyusername()
    {
        return $this->hasOne(Users::className(), ['id' => 'updatedby']);
    }

	public function getDeletedbyusername()
    {
        return $this->hasOne(Users::className(), ['id' => 'deletedby']);
    }

	public function getLookupBookingStatus()
	{		
		return $this->hasOne(LookupBookingStatus::className(), ['id' => 'status']);
	}

	public function getLookupPaymentMethodEoi()
    {
		return $this->hasOne(LookupPaymentMethod::className(), ['id' => 'payment_method_eoi']);
    }

	public function getLookupPaymentMethod()
    {
		return $this->hasOne(LookupPaymentMethod::className(), ['id' => 'payment_method']);
    }

}
