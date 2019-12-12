<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "collaterals".
 *
 * @property integer $id
 * @property integer $project_id
 * @property string $title
 * @property string $permalink
 * @property string $summary
 * @property string $description
 * @property string $thumb_image
 * @property string $published_date_start
 * @property string $published_date_end
 * @property integer $sort
 * @property integer $status
 * @property integer $createdby
 * @property string $createdat
 * @property integer $updatedby
 * @property string $updatedat
 * @property integer $deletedby
 * @property string $deletedat
 */
class Collaterals extends \yii\db\ActiveRecord
{
	public $file;
	
    public static function tableName()
    {
        return 'collaterals';
    }

    public function rules()
    {
        return [
            [['project_id', 'title', 'permalink', 'published_date_start', 'createdby', 'createdat'], 'required'],
            [['project_id', 'sort', 'createdby', 'updatedby', 'deletedby'], 'integer'],
            [['summary', 'description'], 'string'],
            [['published_date_start', 'published_date_end', 'createdat', 'updatedat', 'deletedat'], 'safe'],
            [['title', 'permalink', 'thumb_image'], 'string', 'max' => 255],
            [['sort'], 'integer', 'min'=>0],
            [['status'], 'integer'],
			[['published_date_start','published_date_end'], 'date', 'format' => 'php:Y-m-d H:i:s'],
			[['published_date_start','published_date_end'], 'validateTwoDates', 'skipOnEmpty' => true, 'skipOnError' => false],
			[['file'], 'required', 'on' => 'create'],
			[['file'], 'file', 'extensions' => ['png','jpg','jpeg'], 'mimeTypes' => 'image/jpeg,image/jpg,image/png', 'maxFiles' => 1],
		];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'project_id' => 'Project ID',
            'title' => 'Title',
            'permalink' => 'Permalink',
            'summary' => 'Summary',
            'description' => 'Description',
            'thumb_image' => 'Thumb Image',
            'file' => 'Thumb Image',
            'published_date_start' => 'Published Date Start',
            'published_date_end' => 'Published Date End',
            'sort' => 'Sort',
            'status' => 'Status',
            'createdby' => 'Createdby',
            'createdat' => 'Createdat',
            'updatedby' => 'Updatedby',
            'updatedat' => 'Updatedat',
            'deletedby' => 'Deletedby',
            'deletedat' => 'Deletedat',
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
	
	public function validateTwoDates()
	{
		if(strlen($this->published_date_start) and strlen($this->published_date_end))
		{
			if(strtotime($this->published_date_end) <= strtotime($this->published_date_start))
			{
				$this->addError('published_date_end','End Date need to be greater than Start Date');
			}
		}
	}
	
	public function getProject()
    {
        return $this->hasOne(Projects::className(), ['id' => 'project_id']);
    }
	
	public function getCollateralType()
    {
        return $this->hasOne(CollateralsMedias::className(), ['collateral_id' => 'id'])->from(['collateralType' => CollateralsMedias::tableName()]);
    }
	
	public function getCollateralLink()
    {
        return $this->hasOne(CollateralsMedias::className(), ['collateral_id' => 'id'])->from(['collateralLink' => CollateralsMedias::tableName()]);
    }
	
	public function getLookupCollateralMediaType()
    {
        return $this->hasOne(LookupCollateralMediaTypes::className(), ['id' => 'collateral_media_type_id'])->via('collateralType');
    }
	
	public function getCollateralList($project_id='',$collateral_id='',$createdby='')
	{
		$sql = "SELECT * ";
		$sql .= "FROM collaterals ";
		$sql .= "WHERE 0=0 ";
		
		if(strlen($project_id))
		$sql .= "AND project_id = '".$project_id."' ";
		if(strlen($collateral_id))
		$sql .= "AND id = '".$collateral_id."' ";
		if(strlen($createdby))
		$sql .= "AND createdby = '".$createdby."' ";
		
		$sql .= "AND published_date_start <= NOW() ";
		$sql .= "AND ( published_date_end > NOW() OR published_date_end IS NULL ) ";
		$sql .= "AND status=1 ";
		$sql .= "AND deletedby IS NULL ";
		$sql .= "AND deletedat IS NULL ";
		$sql .= "ORDER BY title ASC ";
		$collateralList = Yii::$app->db->createCommand($sql)->queryAll();
				
		if($collateralList==NULL)
		return NULL;
		else
		return $collateralList;
	}
	
	public function getProjectCollaterals()
	{		
		$sql = "SELECT p.id, p.project_name, p.thumb_image ";
		$sql .= "FROM projects p ";
		$sql .= "WHERE 0=0 ";
		$sql .= "AND p.id IN (SELECT project_id FROM collaterals WHERE status=1 AND deletedby IS NULL AND deletedat IS NULL) ";
		$sql .= "ORDER BY p.project_name ASC ";
		$projectList = Yii::$app->db->createCommand($sql)->queryAll();
			
		if($projectList==NULL)
		return FALSE;
		else
		return $projectList;
	}
	
	public function getCollaterals($inputs)
	{		
		$sql = "SELECT c.id, c.project_id, c.title, c.permalink, c.summary, c.description, c.thumb_image, p.project_name ";
		$sql .= "FROM collaterals c, projects p ";
		$sql .= "WHERE 0=0 ";
		$sql .= "AND c.project_id = p.id ";
		$sql .= "AND p.status = 1 ";
		$sql .= "AND p.deletedby IS NULL ";
		$sql .= "AND p.deletedat IS NULL ";
		
		if(strlen($inputs['project']))
		$sql .= "AND (p.id = '".$inputs['project']."' OR LOWER(p.project_name) = '".strtolower($inputs['project'])."') ";
		if(strlen($inputs['collateral_id']))
		$sql .= "AND c.id = '".$inputs['project']."' ";
		if(strlen($inputs['permalink']))
		$sql .= "AND LOWER(c.permalink) = '".$inputs['permalink']."' ";
		
		$sql .= "AND c.published_date_start <= NOW() ";
		$sql .= "AND ( c.published_date_end > NOW() OR c.published_date_end IS NULL ) ";
		$sql .= "AND c.status=1 ";
		$sql .= "AND c.deletedby IS NULL ";
		$sql .= "AND c.deletedat IS NULL ";
		$sql .= "ORDER BY c.sort DESC, c.createdat DESC, c.title ASC ";
		$collateralList = Yii::$app->db->createCommand($sql)->queryAll();
			
		if($collateralList==NULL)
		return FALSE;
		else
		return $collateralList;
	}
	
	
}
