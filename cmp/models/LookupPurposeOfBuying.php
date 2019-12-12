<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "lookup_purpose_of_buying".
 *
 * @property integer $id
 * @property string $name
 * @property integer $deleted
 */
class LookupPurposeOfBuying extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'lookup_purpose_of_buying';
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

    public function getPurposeOfBuyingName($id)
    {
		$record = LookupPurposeOfBuying::find()->where(['id' => $id])->one();

		if($record == null)
        return null;

		return $record->name; 
    }
}
