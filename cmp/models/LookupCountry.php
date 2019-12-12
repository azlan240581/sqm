<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "lookup_country".
 *
 * @property integer $id
 * @property string $name
 * @property string $iso2
 * @property string $iso3
 * @property integer $deleted
 */
class LookupCountry extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'lookup_country';
    }

    public function rules()
    {
        return [
            [['name', 'iso2', 'iso3'], 'required'],
            [['name'], 'string', 'max' => 100],
            [['iso2'], 'string', 'max' => 2],
            [['iso3'], 'string', 'max' => 3],
            [['deleted'], 'string', 'max' => 1],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'iso2' => 'Iso2',
            'iso3' => 'Iso3',
            'deleted' => 'Deleted',
        ];
    }
	
}
