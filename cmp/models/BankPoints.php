<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "bank_points".
 *
 * @property integer $id
 * @property string $credits
 * @property integer $createdby
 * @property string $createdat
 * @property integer $updatedby
 * @property string $updatedat
 */
class BankPoints extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'bank_points';
    }

    public function rules()
    {
        return [
            [['credits'], 'number'],
            [['createdby', 'createdat'], 'required'],
            [['createdby', 'updatedby'], 'integer'],
            [['createdat', 'updatedat'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'credits' => 'Credits',
            'createdby' => 'Createdby',
            'createdat' => 'Createdat',
            'updatedby' => 'Updatedby',
            'updatedat' => 'Updatedat',
        ];
    }
}
