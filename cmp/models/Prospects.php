<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "prospects".
 *
 * @property integer $id
 * @property integer $agent_id
 * @property integer $member_id
 * @property string $prospect_name
 * @property string $prospect_email
 * @property string $prospect_contact_number
 * @property integer $prospect_purpose_of_buying
 * @property integer $how_prospect_know_us
 * @property string $prospect_age
 * @property string $prospect_dob
 * @property integer $prospect_marital_status
 * @property integer $prospect_occupation
 * @property integer $prospect_domicile
 * @property string $prospect_identity_document
 * @property string $tax_license
 * @property string $remarks
 * @property integer $status
 * @property integer $createdby
 * @property string $createdat
 * @property integer $updatedby
 * @property string $updatedat
 * @property integer $deletedby
 * @property string $deletedat
 */
class Prospects extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'prospects';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['agent_id', 'member_id', 'prospect_name', 'prospect_email', 'prospect_contact_number', 'status', 'createdby', 'createdat'], 'required'],
            [['agent_id', 'member_id', 'prospect_purpose_of_buying', 'how_prospect_know_us', 'prospect_marital_status', 'prospect_occupation', 'prospect_domicile', 'status', 'createdby', 'updatedby', 'deletedby'], 'integer'],
            [['remarks'], 'string'],
            [['prospect_dob', 'createdat', 'updatedat', 'deletedat'], 'safe'],
            [['prospect_name', 'prospect_email', 'prospect_contact_number', 'prospect_identity_document', 'tax_license'], 'string', 'max' => 255],
            [['prospect_age'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'agent_id' => 'SQM Account Manager',
            'agent_name' => 'SQM Account Manager',
            'member_id' => 'Associate',
            'member_name' => 'Associate',
            'prospect_name' => 'Name',
            'prospect_email' => 'Email',
            'prospect_contact_number' => 'Contact Number',
            'prospect_purpose_of_buying' => 'Purpose Of Buying',
            'how_prospect_know_us' => 'How Do You Know About Us',
            'prospect_age' => 'Age',
            'prospect_dob' => 'Date of Birth',
            'prospect_marital_status' => 'Marital Status',
            'prospect_occupation' => 'Occupation',
			'prospect_domicile' => 'Domicile',
            'prospect_identity_document' => 'Identity Document',
            'tax_license' => 'Tax License',
            'remarks' => 'Remarks',
            'status' => 'Status',
            'createdby' => 'Registered By',
            'createdat' => 'Registered At',
            'updatedby' => 'Updatedby',
            'updatedat' => 'Updatedat',
            'deletedby' => 'Deletedby',
            'deletedat' => 'Deletedat',
        ];
    }

	public function getProjects()
    {
		return $this->hasOne(Projects::className(), ['id' => 'project_id'])->via('interestedProjects');
    }

	public function getInterestedProjects()
    {
        return $this->hasMany(ProspectInterestedProjects::className(), ['prospect_id' => 'id']);
    }

	public function getAgent()
    {
        return $this->hasOne(Users::className(), ['id' => 'agent_id'])->from(['agent_name' => Users::tableName()]);
    }

	public function getMember()
    {
        return $this->hasOne(Users::className(), ['id' => 'member_id'])->from(['member_name' => Users::tableName()]);
    }

	public function getLookupProspectStatus()
	{		
		return $this->hasOne(LookupProspectStatus::className(), ['id' => 'status']);
	}	

	public function getLookupPurposeOfBuying()
	{	
		return $this->hasOne(LookupPurposeOfBuying::className(), ['id' => 'prospect_purpose_of_buying']);
	}	

	public function getLookupHowYouKnowAboutUs()
	{	
		return $this->hasOne(LookupHowYouKnowAboutUs::className(), ['id' => 'how_prospect_know_us']);
	}	

	public function getLookupMaritalStatus()
	{	
		return $this->hasOne(LookupMaritalStatus::className(), ['id' => 'prospect_marital_status']);
	}	

	public function getLookupOccupation()
	{	
		return $this->hasOne(LookupOccupation::className(), ['id' => 'prospect_occupation']);
	}

	public function getLookupDomicile()
	{	
		return $this->hasOne(LookupDomicile::className(), ['id' => 'prospect_domicile']);
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
}
