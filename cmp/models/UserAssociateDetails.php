<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_associate_details".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $referrer_id
 * @property integer $agent_id
 * @property integer $assistant_id
 * @property integer $assistant_approval
 * @property integer $agent_approval
 * @property integer $admin_approval
 * @property integer $approval_status
 * @property integer $id_number
 * @property integer $tax_license_number
 * @property integer $bank_id
 * @property integer $account_name
 * @property integer $account_number
 * @property string $domicile
 * @property string $occupation
 * @property string $industry_background
 * @property string $nricpass
 * @property string $tax_license
 * @property string $bank_account
 * @property string $udf1
 * @property string $udf2
 * @property string $udf3
 * @property string $udf4
 * @property string $udf5
 */
class UserAssociateDetails extends \yii\db\ActiveRecord
{
	public $file,$file2,$file3,$file4;
	
    public static function tableName()
    {
        return 'user_associate_details';
    }

    public function rules()
    {
        return [
            [['user_id', 'agent_id', 'approval_status'], 'required'],
            [['user_id', 'referrer_id', 'agent_id', 'assistant_id', 'approval_status', 'productivity_status'], 'integer'],
            [['assistant_approval', 'agent_approval', 'admin_approval'], 'integer'],
            [['bank_id'], 'integer'],
            [['account_name', 'account_number'], 'string', 'max' => 100],
            [['id_number', 'tax_license_number', 'domicile', 'occupation', 'industry_background', 'nricpass', 'tax_license', 'bank_account', 'udf1', 'udf2', 'udf3', 'udf4', 'udf5'], 'string', 'max' => 255],
			[['file','file2','file3','file4'], 'file', 'extensions' => ['png','jpg','jpeg'], 'mimeTypes' => 'image/jpeg,image/jpg,image/png', 'maxFiles' => 1],
		];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'referrer_id' => 'Referrer ID',
            'agent_id' => 'Agent ID',
            'assistant_id' => 'Assistant ID',
            'assistant_approval' => 'Assistant Approval',
            'agent_approval' => 'Agent Approval',
            'admin_approval' => 'Admin Approval',
            'approval_status' => 'Approval Status',
            'productivity_status' => 'Productivity Status',
            'id_number' => 'Identity Document Number',
            'tax_license_number' => 'Tax License Number',
            'bank_id' => 'Bank ID',
            'account_name' => 'Account Name',
            'account_number' => 'Account Number',
            'domicile' => 'Domicile',
            'occupation' => 'Occupation',
            'industry_background' => 'Industry Background',
            'nricpass' => 'Identity Document',
            'tax_license' => 'Tax License',
            'bank_account' => 'Bank Statement',
            'udf1' => 'Associate Hold ID Picture',
            'udf2' => 'Udf2',
            'udf3' => 'Udf3',
            'udf4' => 'Udf4',
            'udf5' => 'Udf5',
        ];
    }
	
	public function getAgent()
    {
		return $this->hasOne(Users::className(), ['id' => 'agent_id'])->from(['agent' => Users::tableName()]);
    }

	public function getAssociateFirstName()
    {
		return $this->hasOne(Users::className(), ['id' => 'user_id'])->from(['associateFirstName' => Users::tableName()]);
    }

	public function getAssociateLastName()
    {
		return $this->hasOne(Users::className(), ['id' => 'user_id'])->from(['associateLastName' => Users::tableName()]);
    }

	public function getAssociateEmail()
    {
		return $this->hasOne(Users::className(), ['id' => 'user_id'])->from(['associateEmail' => Users::tableName()]);
    }

	public function getAssociateContactNo()
    {
		return $this->hasOne(Users::className(), ['id' => 'user_id'])->from(['associateContactNo' => Users::tableName()]);
    }

	public function getAssociateCreatedAt()
    {
		return $this->hasOne(Users::className(), ['id' => 'user_id'])->from(['associateCreatedAt' => Users::tableName()]);
    }

	public function getAssociateLastLoginAt()
    {
		return $this->hasOne(Users::className(), ['id' => 'user_id'])->from(['associateLastLoginAt' => Users::tableName()]);
    }

	public function getLookupAssociateApprovalStatus()
    {
		return $this->hasOne(LookupAssociateApprovalStatus::className(), ['id' => 'approval_status']);
    }

	public function getLookupAssociateProductivityStatus()
    {
		return $this->hasOne(LookupAssociateProductivityStatus::className(), ['id' => 'productivity_status']);
    }

	public function getLookupDomicile()
    {
		return $this->hasOne(LookupDomicile::className(), ['id' => 'domicile']);
    }
	
	public function getLookupOccupation()
    {
		return $this->hasOne(LookupOccupation::className(), ['id' => 'occupation']);
    }
	
	public function getLookupIndustryBackground()
    {
		return $this->hasOne(LookupIndustryBackground::className(), ['id' => 'industry_background']);
    }
	
	public function getLookupCountry()
    {
		return $this->hasOne(LookupCountry::className(), ['id' => 'country']);
    }
	
	public function getLookupBank()
    {
		return $this->hasOne(LookupBanks::className(), ['id' => 'bank_id']);
    }
	
}
