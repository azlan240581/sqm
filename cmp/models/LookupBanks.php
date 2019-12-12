<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "lookup_banks".
 *
 * @property integer $id
 * @property string $name
 * @property integer $deleted
 */
class LookupBanks extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'lookup_banks';
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
