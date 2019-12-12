<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "potential_associates".
 *
 * @property integer $id
 * @property integer $inviter_id
 * @property string $name
 * @property string $email
 * @property string $contactno
 * @property integer $status
 * @property string $register_at
 * @property integer $user_id
 */
class PotentialAssociates extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'potential_associates';
    }

    public function rules()
    {
        return [
            [['inviter_id', 'createdat'], 'required'],
            [['inviter_id', 'user_id'], 'integer'],
            [['register_at', 'createdat'], 'safe'],
            [['name', 'email', 'contactno'], 'string', 'max' => 100],
            [['status'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'inviter_id' => 'Inviter ID',
            'name' => 'Name',
            'email' => 'Email',
            'contactno' => 'Contact Number',
            'status' => 'Status',
            'register_at' => 'Register At',
            'user_id' => 'User ID',
            'createdat' => 'Created At',
        ];
    }
	
	public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'inviter_id']);
    }
}
