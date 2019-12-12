<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "lookup_booking_status".
 *
 * @property integer $id
 * @property string $name
 * @property integer $deleted
 */
class LookupBookingStatus extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'lookup_booking_status';
    }

    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
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
