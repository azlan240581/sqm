<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "lookup_bank_loan_proposal_status".
 *
 * @property integer $id
 * @property string $name
 * @property integer $deleted
 */
class LookupBankLoanProposalStatus extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'lookup_bank_loan_proposal_status';
    }

    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 100],
            [['deleted'], 'string', 'max' => 1],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'deleted' => 'Deleted',
        ];
    }
}
