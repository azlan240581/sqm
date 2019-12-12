<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "developers".
 *
 * @property integer $id
 * @property string $company_name
 * @property string $company_registration_no
 * @property string $contact_person_name
 * @property string $contact_person_email
 * @property string $contact_person_contactno
 * @property integer $status
 * @property integer $createdby
 * @property string $createdat
 * @property string $updatedby
 * @property string $updatedat
 * @property integer $deletedby
 * @property string $deletedat
 */
class Developers extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'developers';
    }

    public function rules()
    {
        return [
            [['company_name', 'createdby', 'createdat'], 'required'],
            [['createdby', 'updatedby', 'deletedby'], 'integer'],
            [['createdat', 'updatedat', 'deletedat'], 'safe'],
            [['company_name', 'contact_person_name', 'contact_person_email', 'contact_person_contactno'], 'string', 'max' => 100],
            [['company_registration_no'], 'string', 'max' => 50],
            [['status'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'company_name' => 'Company Name',
            'company_registration_no' => 'Company Registration No',
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
	
	public function checkUnique($attribute)
	{
		if(empty($this->$attribute))
		return true;
		
		$model = $this->find()->where("LOWER(".$attribute.") = '" . strtolower($this->$attribute) . "' AND status = 1 AND deletedby IS NULL AND deletedat IS NULL " . (!empty($this->id)?" AND id <> '".$this->id."'":''))->all();
		if (count($model) > 0) {
			$this->addError($attribute,  $this->getAttributeLabel($attribute).' is already exists.');
			return false;
		}
		else
		return true;
	}
	
}
