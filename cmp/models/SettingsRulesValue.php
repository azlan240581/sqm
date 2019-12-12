<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "settings_rules_value".
 *
 * @property integer $id
 * @property integer $settings_rules_id
 * @property integer $employer_id
 * @property string $value
 * @property string $updatedat
 */
class SettingsRulesValue extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'settings_rules_value';
    }

    public function rules()
    {
        return [
            [['settings_rules_id'], 'required'],
            [['settings_rules_id'], 'integer'],
            [['updatedat'], 'safe'],
            [['value'], 'string', 'max' => 1000],
            [['settings_rules_id'], 'exist', 'skipOnError' => true, 'targetClass' => SettingsRules::className(), 'targetAttribute' => ['settings_rules_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'settings_rules_id' => 'Settings Rules ID',
            'value' => 'Value',
            'updatedat' => 'Updatedat',
        ];
    }
	
    public function getSettingsRules()
    {
        return $this->hasOne(SettingsRules::className(), ['id' => 'settings_rules_id']);
    }
	
}
