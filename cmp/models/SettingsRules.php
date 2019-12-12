<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "settings_rules".
 *
 * @property integer $id
 * @property integer $settings_categories_id
 * @property string $settings_rules_key
 * @property string $settings_rules_desc
 * @property string $settings_rules_config_type
 * @property string $settings_rules_config
 * @property integer $settings_rules_sort
 * @property string $updatedat
 *
 * @property SettingsCategories $settingsCategories
 */
class SettingsRules extends \yii\db\ActiveRecord
{

	public $errorMessage;

    public static function tableName()
    {
        return 'settings_rules';
    }

    public function rules()
    {
        return [
            [['settings_categories_id', 'settings_rules_key'], 'required'],
            [['settings_categories_id', 'settings_rules_sort'], 'integer'],
            [['settings_rules_desc'], 'string'],
            [['updatedat'], 'safe'],
            [['settings_rules_key'], 'string', 'max' => 100],
            [['settings_rules_config'], 'string', 'max' => 1000],
            [['settings_rules_config_type'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'settings_categories_id' => 'Settings Categories ID',
            'settings_rules_key' => 'Settings Rules Key',
            'settings_rules_desc' => 'Settings Rules Desc',
            'settings_rules_config_type' => 'Settings Rules Config Type',
            'settings_rules_config' => 'Settings Rules Config',
            'settings_rules_sort' => 'Settings Rules Sort',
            'updatedat' => 'Updatedat',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */	
    public function getSettingsCategories()
    {
        return $this->hasOne(SettingsCategories::className(), ['id' => 'settings_categories_id']);
    }

    public function getSettingsRulesValue()
    {
        return $this->hasMany(SettingsRulesValue::className(), ['settings_rules_id' => 'id']);
    }
	
}
