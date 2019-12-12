<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "lookup_prospect_history".
 *
 * @property integer $id
 * @property string $name
 * @property integer $deleted
 */
class LookupProspectHistory extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'lookup_prospect_history';
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

    public function getHistoryName($id)
    {
		$record = LookupProspectHistory::find()->where(['id' => $id])->one();

		if($record == null)
        return null;

		return $record->name; 
    }
}
