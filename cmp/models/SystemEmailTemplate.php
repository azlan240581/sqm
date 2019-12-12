<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "system_email_template".
 *
 * @property integer $id
 * @property string $code
 * @property string $name
 * @property string $description
 * @property string $subject
 * @property string $template
 */
class SystemEmailTemplate extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'system_email_template';
    }

    public function rules()
    {
        return [
            [['code', 'name', 'subject'], 'required'],
            [['template'], 'string'],
            [['code', 'name'], 'string', 'max' => 100],
            [['description', 'subject'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Code',
            'name' => 'Name',
            'description' => 'Description',
            'subject' => 'Subject',
            'template' => 'Template',
        ];
    }
	
	public function getTemplate($template)
	{
		$template = Yii::$app->AccessMod->multipleReplace($template,array('site_url'=>$_SESSION['settings']['SITE_URL']));
		return $template;
	}
	
}
