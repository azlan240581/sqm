<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_devices".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $device_token
 * @property string $device_os
 * @property string $device_details
 */
class UserDevices extends \yii\db\ActiveRecord
{
	public $errorMessage;
	
    public static function tableName()
    {
        return 'user_devices';
    }

    public function rules()
    {
        return [
            [['user_id', 'device_token', 'device_os'], 'required'],
            [['user_id'], 'integer'],
            [['device_token', 'device_details'], 'string', 'max' => 250],
            [['device_os'], 'string', 'max' => 50],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'device_token' => 'Device Token',
            'device_os' => 'Device Os',
            'device_details' => 'Device Details',
        ];
    }
	
	public function getUserDevices($user_id, $device_token='')
	{
		$sql = "SELECT ud.* ";
		$sql .= "FROM user_devices ud ";
		$sql .= "WHERE 0=0 ";
		$sql .= "AND ud.user_id = '".$user_id."' ";
		if(strlen($device_token))
		$sql .= "AND ud.device_token = '".$device_token."' ";
		$connection = Yii::$app->getDb();
		$query = $connection->createCommand($sql);
		$result = $query->queryAll();
		
		if(count($result)==0)
		{
			$this->errorMessage = 'User device not exist';
			return false;
		}
		else
		return $result;
	}

}
