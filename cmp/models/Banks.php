<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "banks".
 *
 * @property integer $id
 * @property string $bank_name
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
class Banks extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'banks';
    }

    public function rules()
    {
        return [
            [['bank_name', 'createdby', 'createdat'], 'required'],
            [['company_description'], 'string'],
            [['createdby', 'updatedby', 'deletedby'], 'integer'],
            [['createdat', 'updatedat', 'deletedat'], 'safe'],
            [['bank_name', 'company_name', 'contact_person_name', 'contact_person_email', 'contact_person_contactno'], 'string', 'max' => 255],
            [['company_registration_no'], 'string', 'max' => 100],
            [['status'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'bank_name' => 'Bank Name',
            'company_name' => 'Company Name',
            'company_registration_no' => 'Company Registration No',
            'company_description' => 'Company Description',
            'contact_person_name' => 'Contact Person Name',
            'contact_person_email' => 'Contact Person Email',
            'contact_person_contactno' => 'Contact Person Contact No',
            'status' => 'Status',
            'createdby' => 'Created By',
            'createdat' => 'Created At',
            'updatedby' => 'Updated By',
            'updatedat' => 'Updated At',
            'deletedby' => 'Deleted By',
            'deletedat' => 'Deletedn At',
        ];
    }
}
