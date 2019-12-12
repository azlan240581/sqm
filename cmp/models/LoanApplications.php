<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "loan_applications".
 *
 * @property integer $id
 * @property integer $bank_id
 * @property integer $prospect_id
 * @property string $loan_amount
 * @property integer $status
 * @property integer $createdby
 * @property string $createdat
 * @property integer $updatedby
 * @property string $updatedat
 * @property integer $deletedby
 * @property string $deletedat
 */
class LoanApplications extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'loan_applications';
    }

    public function rules()
    {
        return [
            [['bank_id', 'prospect_id', 'loan_amount', 'status', 'createdby', 'createdat'], 'required'],
            [['bank_id', 'prospect_id', 'status', 'createdby', 'updatedby', 'deletedby'], 'integer'],
            [['loan_amount'], 'number'],
            [['createdat', 'updatedat', 'deletedat'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'bank_id' => 'Bank ID',
            'prospect_id' => 'Prospect ID',
            'loan_amount' => 'Loan Amount',
            'status' => 'Status',
            'createdby' => 'Createdby',
            'createdat' => 'Createdat',
            'updatedby' => 'Updatedby',
            'updatedat' => 'Updatedat',
            'deletedby' => 'Deletedby',
            'deletedat' => 'Deletedat',
        ];
    }
}
