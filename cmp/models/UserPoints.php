<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_points".
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
class UserPoints extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'user_points';
    }

    public function rules()
    {
        return [
            [['user_id', 'total_points_value', 'createdby', 'createdat'], 'required'],
            [['user_id', 'createdby', 'updatedby', 'deletedby'], 'integer'],
            [['total_points_value'], 'number'],
            [['createdat', 'updatedat', 'deletedat'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'total_points_value' => 'Total Points Value',
            'createdby' => 'Created By',
            'createdat' => 'Created At',
            'updatedby' => 'Updated By',
            'updatedat' => 'Updated At',
            'deletedby' => 'Deleted By',
            'deletedat' => 'Deleted At',
        ];
    }
	
	public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }
	
	public function getAssociateName()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id'])->from(['associateName' => Users::tableName()]);
    }
	
	public function getAssociateEmail()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id'])->from(['associateEmail' => Users::tableName()]);
    }
	
	public function getAssociateContactNo()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id'])->from(['associateContactNo' => Users::tableName()]);
    }
	
	public function getAgentName()
	{		
		return $this->hasOne(Users::className(), ['id' => 'agent_id'])
				->viaTable(UserAssociateDetails::tableName(), ['user_id' => 'user_id'])
				->from(['agentName' => Users::tableName()]);
	}
		
	
	
	
}
