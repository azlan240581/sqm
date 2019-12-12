<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "lookup_avatar".
 *
 * @property integer $id
 * @property string $name
 * @property string $image
 * @property integer $deleted
 *
 * @property Users[] $users
 */
class LookupAvatars extends \yii\db\ActiveRecord
{
	public $file;
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'lookup_avatars';
    }

    public function rules()
    {
        return [
            [['name', 'image'], 'required'],
            [['name'], 'unique'],
            [['deleted'], 'integer'],
            [['name'], 'string', 'max' => 100],
            [['image'], 'string', 'max' => 255],
			[['file'], 'required', 'on' => 'create'],
			[['file'], 'file', 'maxFiles' => 1],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'image' => 'Image',
            'deleted' => 'Deleted',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(Users::className(), ['avatar_id' => 'id']);
    }
}
