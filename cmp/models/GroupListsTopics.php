<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "group_lists_topics".
 *
 * @property integer $id
 * @property string $topic_name
 * @property string $user_id
 * @property integer $status
 * @property integer $createdby
 * @property string $createdat
 * @property integer $updatedby
 * @property string $updatedat
 * @property integer $deletedby
 * @property string $deletedat
 */
class GroupListsTopics extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'group_lists_topics';
    }

    public function rules()
    {
        return [
            [['status', 'createdby', 'updatedby', 'deletedby'], 'integer'],
            [['topic_name', 'user_id', 'createdby', 'createdat'], 'required'],
            [['createdat', 'updatedat', 'deletedat'], 'safe'],
            [['topic_name', 'user_id'], 'string', 'max' => 255],
			[['topic_name'], 'unique'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'topic_name' => 'Topic Name',
            'user_id' => 'User ID',
            'status' => 'Status',
            'createdby' => 'Createdby',
            'createdat' => 'Createdat',
            'updatedby' => 'Updatedby',
            'updatedat' => 'Updatedat',
            'deletedby' => 'Deletedby',
            'deletedat' => 'Deletedat',
        ];
    }
	
	public function getAllGroupListsTopics($topic_name = '', $status=1)
	{
		$sql = "SELECT * ";
		$sql .= "FROM group_lists_topics ";
		$sql .= "WHERE 0=0 ";
		if(strlen($topic_name))
		$sql .= "AND topic_name = '".$topic_name."' ";
		$sql .= "AND status = '".$status."' ";
		$sql .= "AND deletedby IS NULL ";
		$sql .= "AND deletedat IS NULL ";
		$result = Yii::$app->db->createCommand($sql)->queryAll();
		
		return $result;
	}
	
	public function getAllTopicListExceptAll($status=1)
	{
		$sql = "SELECT * ";
		$sql .= "FROM group_lists_topics ";
		$sql .= "WHERE 0=0 ";
		$sql .= "AND id <> 1 ";
		$sql .= "AND status = '".$status."' ";
		$sql .= "AND deletedby IS NULL ";
		$sql .= "AND deletedat IS NULL ";
		$result = Yii::$app->db->createCommand($sql)->queryAll();
		
		return $result;
	}
	
}
