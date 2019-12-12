<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "new_potential_associates".
 *
 * @property integer $id
 * @property integer $inviter_id
 * @property string $name
 * @property string $email
 * @property string $contactno
 * @property integer $registered
 */
class NewPotentialAssociates extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'new_potential_associates';
    }

    public function rules()
    {
        return [
            [['inviter_id'], 'required'],
            [['inviter_id'], 'integer'],
            [['name', 'email', 'contactno'], 'string', 'max' => 100],
            [['registered'], 'string', 'max' => 1],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'inviter_id' => 'Inviter ID',
            'name' => 'Name',
            'email' => 'Email',
            'contactno' => 'Contactno',
            'registered' => 'Registered',
        ];
    }
	
	public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'inviter_id']);
    }
}
