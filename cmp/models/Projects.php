<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "projects".
 *
 * @property integer $id
 * @property integer $developer_id
 * @property string $project_name
 * @property string $project_description
 * @property string $thumb_image
 * @property integer $status
 * @property integer $createdby
 * @property string $createdat
 * @property integer $updatedby
 * @property string $updatedat
 * @property integer $deletedby
 * @property string $deletedat
 */
class Projects extends \yii\db\ActiveRecord
{
	public $file;
	
    public static function tableName()
    {
        return 'projects';
    }

    public function rules()
    {
        return [
            [['developer_id', 'project_name', 'createdby', 'createdat'], 'required'],
            [['developer_id', 'createdby', 'updatedby', 'deletedby'], 'integer'],
            [['project_description'], 'string'],
            [['createdat', 'updatedat', 'deletedat'], 'safe'],
            [['project_name', 'thumb_image'], 'string', 'max' => 255],
            [['status'], 'integer'],
			[['file'], 'required', 'on' => 'create'],
			[['file'], 'file', 'extensions' => ['png','jpg','jpeg'], 'mimeTypes' => 'image/jpeg,image/jpg,image/png', 'maxFiles' => 1],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'developer_id' => 'Developer ID',
            'project_name' => 'Project Name',
            'project_description' => 'Project Description',
            'thumb_image' => 'Image',
            'file' => 'Image',
            'status' => 'Status',
            'createdby' => 'Created By',
            'createdat' => 'Created At',
            'updatedby' => 'Updated By',
            'updatedat' => 'Updated At',
            'deletedby' => 'Deleted By',
            'deletedat' => 'Deleted At',
        ];
    }
	
	public function checkUnique($attribute)
	{
		if(empty($this->$attribute))
		return true;
		
		$model = $this->find()->where("LOWER(".$attribute.") = '" . strtolower($this->$attribute) . "' AND status = 1 AND deletedby IS NULL AND deletedat IS NULL " . (!empty($this->id)?" AND id <> '".$this->id."'":''))->all();
		if (count($model) > 0) {
			$this->addError($attribute,  $this->getAttributeLabel($attribute).' is already exists.');
			return false;
		}
		else
		return true;
	}
	
	
	public function getDeveloper()
    {
        return $this->hasOne(Developers::className(), ['id' => 'developer_id']);
    }
	
	public function getProjectAgent()
    {
        return $this->hasMany(ProjectAgents::className(), ['project_id' => 'id']);
    }
	
	public function getAgent()
    {
        return $this->hasOne(Users::className(), ['id' => 'agent_id'])->via('projectAgent');
    }
	
	public function getProjectHandler($id)
	{
		$sql = "SELECT agent_id FROM project_agents WHERE project_id = ".$id;
		$result = Yii::$app->db->createCommand($sql)->queryAll();
		
		return $result;
	}
	
	
}
