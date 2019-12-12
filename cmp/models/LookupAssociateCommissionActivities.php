<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "lookup_associate_commission_activities".
 *
 * @property integer $id
 * @property string $name
 * @property integer $deleted
 */
class LookupAssociateCommissionActivities extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'lookup_associate_commission_activities';
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
