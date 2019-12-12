<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "project_products".
 *
 * @property integer $id
 * @property integer $project_id
 * @property string $product_name
 * @property string $product_tier
 * @property integer $product_type_id
 * @property integer $createdby
 * @property string $createdat
 * @property integer $updatedby
 * @property string $updatedat
 * @property integer $deletedby
 * @property string $deletedat
 */
class ProjectProducts extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'project_products';
    }

    public function rules()
    {
        return [
            [['project_id', 'product_name', 'product_tier', 'product_type_id', 'createdby', 'createdat'], 'required'],
            [['project_id', 'product_tier', 'product_type_id', 'createdby', 'updatedby', 'deletedby'], 'integer'],
            [['createdat', 'updatedat', 'deletedat'], 'safe'],
            [['product_name'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'project_id' => 'Project',
            'product_name' => 'Product Name',
            'product_tier' => 'Product Tier',
            'product_type_id' => 'Product Type',
            'createdby' => 'Created by',
            'createdat' => 'Created at',
            'updatedby' => 'Updated by',
            'updatedat' => 'Updated at',
            'deletedby' => 'Deleted by',
            'deletedat' => 'Deleted at',
        ];
    }
	
	public function getProject()
    {
        return $this->hasOne(Projects::className(), ['id' => 'project_id']);
    }
	
	public function getLookupProductType()
    {
        return $this->hasOne(LookupProductType::className(), ['id' => 'product_tier']);
    }
	
	public function getLookupPropertyProductType()
    {
        return $this->hasOne(LookupPropertyProductTypes::className(), ['id' => 'product_type_id']);
    }
	
	public function getProjectProductList($project_id='',$project_product_id='')
	{
		$sql = "SELECT * ";
		$sql .= "FROM project_products ";
		$sql .= "WHERE 0=0 ";
		
		if(strlen($project_id))
		$sql .= "AND project_id = '".$project_id."' ";
		if(strlen($project_product_id))
		$sql .= "AND id = '".$project_product_id."' ";
		
		$sql .= "AND deletedby IS NULL ";
		$sql .= "AND deletedat IS NULL ";
		$sql .= "ORDER BY product_name ASC ";
		$projectProductList = Yii::$app->db->createCommand($sql)->queryAll();
				
		if($projectProductList==NULL)
		return NULL;
		else
		return $projectProductList;
	}
	
	
	
	
}
