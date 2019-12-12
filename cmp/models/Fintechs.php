<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "fintech".
 *
 * @property integer $id
 * @property string $company_name
 * @property string $company_registration_no
 * @property string $company_description
 * @property string $contact_person_name
 * @property string $contact_person_email
 * @property string $contact_person_contactno
 * @property integer $status
 * @property integer $createdby
 * @property string $createdat
 * @property integer $updatedby
 * @property string $updatedat
 * @property integer $deletedby
 * @property string $deletedat
 */
class Fintechs extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'fintechs';
    }

    public function rules()
    {
        return [
            [['company_name', 'createdby', 'createdat'], 'required'],
            [['company_description'], 'string'],
            [['createdby', 'updatedby', 'deletedby'], 'integer'],
            [['createdat', 'updatedat', 'deletedat'], 'safe'],
            [['company_name', 'contact_person_name', 'contact_person_email', 'contact_person_contactno'], 'string', 'max' => 255],
            [['company_registration_no'], 'string', 'max' => 100],
            [['status'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'company_name' => 'Company Name',
            'company_registration_no' => 'Company Registration No',
            'company_description' => 'Company Description',
            'contact_person_name' => 'Contact Person Name',
            'contact_person_email' => 'Contact Person Email',
            'contact_person_contactno' => 'Contact Person Contact Number',
            'status' => 'Status',
            'createdby' => 'Created By',
            'createdat' => 'Created At',
            'updatedby' => 'Updated By',
            'updatedat' => 'Updated At',
            'deletedby' => 'Deleted By',
            'deletedat' => 'Deleted At',
        ];
    }
}
