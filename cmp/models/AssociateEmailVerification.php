<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "associate_email_verification".
 *
 * @property integer $id
 * @property string $firstname
 * @property string $lastname
 * @property string $email
 * @property string $verification_code
 * @property string $createdat
 */
class AssociateEmailVerification extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'associate_email_verification';
    }

    public function rules()
    {
        return [
            [['firstname', 'lastname', 'email', 'verification_code', 'createdat'], 'required'],
            [['createdat'], 'safe'],
            [['firstname', 'lastname', 'email'], 'string', 'max' => 100],
            [['verification_code'], 'string', 'max' => 50],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'firstname' => 'Firstname',
            'lastname' => 'Lastname',
            'email' => 'Email',
            'verification_code' => 'Verification Code',
            'createdat' => 'Createdat',
        ];
    }
}
