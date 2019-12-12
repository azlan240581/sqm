<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "associate_points".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $total_points_value
 * @property integer $createdby
 * @property string $createdat
 * @property integer $updatedby
 * @property string $updatedat
 * @property integer $deletedby
 * @property string $deletedat
 */
class AssociatePoints extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'associate_points';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'total_points_value', 'createdby', 'createdat'], 'required'],
            [['user_id', 'createdby', 'updatedby', 'deletedby'], 'integer'],
            [['total_points_value'], 'number'],
            [['createdat', 'updatedat', 'deletedat'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'total_points_value' => 'Total Points Value',
            'createdby' => 'Createdby',
            'createdat' => 'Createdat',
            'updatedby' => 'Updatedby',
            'updatedat' => 'Updatedat',
            'deletedby' => 'Deletedby',
            'deletedat' => 'Deletedat',
        ];
    }
}
