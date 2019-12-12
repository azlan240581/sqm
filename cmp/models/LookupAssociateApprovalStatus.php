<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "lookup_associate_approval_status".
 *
 * @property integer $id
 * @property string $name
 * @property integer $deleted
 */
class LookupAssociateApprovalStatus extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'lookup_associate_approval_status';
    }

    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 100],
            [['deleted'], 'integer'],
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
