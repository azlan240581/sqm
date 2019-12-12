<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_messages".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $subject
 * @property string $message
 * @property integer $mark_as_read
 * @property integer $createdby
 * @property string $createdat
 */
class UserMessages extends \yii\db\ActiveRecord
{
	public $errorMessage;

    public static function tableName()
    {
        return 'user_messages';
    }

    public function rules()
    {
        return [
            [['user_id', 'subject', 'message', 'createdby', 'createdat'], 'required'],
            [['user_id', 'priority', 'mark_as_read', 'createdby'], 'integer'],
            [['message', 'long_message'], 'string'],
            [['createdat'], 'safe'],
            [['subject'], 'string', 'max' => 500],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'subject' => 'Subject',
            'message' => 'Message',
            'long_message' => 'Long Message',
            'priority' => 'Priority',
            'mark_as_read' => 'Status',
            'createdby' => 'From',
            'createdat' => 'Date',
        ];
    }
	
	
	public function getUserMessage($user_id,$message_id='')
	{	
		$sql = "SELECT id, subject, message, long_message, priority, mark_as_read, createdat ";
		$sql .= "FROM user_messages ";
		$sql .= "WHERE 0=0 ";
		$sql .= "AND user_id='".$user_id."' ";
		
		if(strlen($message_id))
		$sql .= "AND id='".$message_id."' ";
		
		//$sql .= "ORDER BY priority DESC, createdat DESC ";
		$sql .= "ORDER BY priority DESC, createdat DESC ";

		$connection = Yii::$app->getDb();
		$query = $connection->createCommand($sql);
		$result = $query->queryAll();
					
		if(count($result)==0)
		{
			$this->errorMessage = 'No message.';
			return false;
		}
		else
		return $result;
	}
	
	
	
	
}
