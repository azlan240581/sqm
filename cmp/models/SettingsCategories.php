<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "settings_categories".
 *
 * @property integer $id
 * @property string $settings_category_name
 * @property string $settings_category_description
 * @property string $updatedat
 *
 * @property SettingsRules[] $settingsRules
 */
class SettingsCategories extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'settings_categories';
    }

    public function rules()
    {
        return [
            [['settings_category_name'], 'required'],
            [['updatedat'], 'safe'],
            [['settings_category_name'], 'string', 'max' => 255],
            [['settings_category_description'], 'string', 'max' => 1000],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'settings_category_name' => 'Settings Category Name',
            'settings_category_description' => 'Settings Category Description',
            'updatedat' => 'Updatedat',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSettingsRules()
    {
        return $this->hasMany(SettingsRules::className(), ['settings_categories_id' => 'id']);
    }
}
