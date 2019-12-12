<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "new_potential_prospects".
 *
 * @property integer $id
 * @property integer $associate_id
 * @property string $name
 * @property string $email
 * @property string $contactno
 * @property integer $registered
 */
class NewPotentialProspects extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'new_potential_prospects';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['associate_id'], 'required'],
            [['associate_id'], 'integer'],
            [['name', 'email', 'contactno'], 'string', 'max' => 100],
            [['registered'], 'string', 'max' => 1],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'associate_id' => 'Associate ID',
            'name' => 'Name',
            'email' => 'Email',
            'contactno' => 'Contactno',
            'registered' => 'Registered',
        ];
    }
}
