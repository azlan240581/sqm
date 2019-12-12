<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "potential_prospects".
 *
 * @property integer $id
 * @property integer $associate_id
 * @property string $name
 * @property string $email
 * @property string $contactno
 * @property integer $status
 * @property string $register_at
 * @property integer $prospect_id
 */
class PotentialProspects extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'potential_prospects';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['associate_id'], 'required'],
            [['associate_id', 'prospect_id'], 'integer'],
            [['register_at'], 'safe'],
            [['name', 'email', 'contactno'], 'string', 'max' => 100],
            [['status'], 'string', 'max' => 1],
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
            'status' => 'Status',
            'register_at' => 'Register At',
            'prospect_id' => 'Prospect ID',
        ];
    }
}
