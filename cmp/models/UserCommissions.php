<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_commissions".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $total_commission_amount
 * @property string $remarks
 * @property integer $status
 * @property integer $createdby
 * @property string $createdat
 * @property integer $updatedby
 * @property string $updatedat
 * @property integer $deletedby
 * @property string $deletedat
 */
class UserCommissions extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'user_commissions';
    }

    public function rules()
    {
        return [
            [['user_id', 'total_commission_amount', 'status', 'createdby', 'createdat'], 'required'],
            [['user_id', 'status', 'createdby', 'updatedby', 'deletedby'], 'integer'],
            [['total_commission_amount'], 'number'],
            [['remarks'], 'string'],
            [['createdat', 'updatedat', 'deletedat'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'total_commission_amount' => 'Total Commission Amount',
            'remarks' => 'Remarks',
            'status' => 'Status',
            'createdby' => 'Created By',
            'createdat' => 'Created At',
            'updatedby' => 'Updated By',
            'updatedat' => 'Updated At',
            'deletedby' => 'Deleted By',
            'deletedat' => 'Deleted At',
        ];
    }
	
	public function getUserFirstName()
    {
		return $this->hasOne(Users::className(), ['id' => 'user_id'])->from(['userFirstName' => Users::tableName()]);
    }

	public function getUserLastName()
    {
		return $this->hasOne(Users::className(), ['id' => 'user_id'])->from(['userLastName' => Users::tableName()]);
    }
	
	public function getUserEmail()
    {
		return $this->hasOne(Users::className(), ['id' => 'user_id'])->from(['userEmail' => Users::tableName()]);
    }
	
	public function getLookupUserCommissionStatus()
    {
        return $this->hasOne(LookupUserCommissionStatus::className(), ['id' => 'status']);
    }
	
	public function getUserGroup()
    {
        return $this->hasOne(UserGroups::className(), ['user_id' => 'user_id']);
    }
	
	
	
}
