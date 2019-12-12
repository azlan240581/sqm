<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "property_products".
 *
 * @property integer $id
 * @property integer $project_id
 * @property integer $project_product_id
 * @property integer $property_type_id
 * @property string $title
 * @property string $permalink
 * @property string $summary
 * @property string $description
 * @property string $thumb_image
 * @property integer $product_type
 * @property string $address
 * @property string $latitude
 * @property string $longitude
 * @property string $price
 * @property string $building_size
 * @property string $land_size
 * @property integer $total_floor
 * @property integer $bedroom
 * @property integer $bathroom
 * @property integer $parking_lot
 * @property string $collaterals_id
 * @property string $published_date_start
 * @property string $published_date_end
 * @property integer $total_viewed
 * @property integer $status
 * @property integer $createdby
 * @property string $createdat
 * @property integer $updatedby
 * @property string $updatedat
 * @property integer $deletedby
 * @property string $deletedat
 */
class PropertyProducts extends \yii\db\ActiveRecord
{
	public $file;
	
    public static function tableName()
    {
        return 'property_products';
    }

    public function rules()
    {
        return [
            [['project_id', 'project_product_id', 'property_type_id', 'title', 'permalink', 'product_type', 'published_date_start', 'status', 'createdby', 'createdat'], 'required'],
            [['project_id', 'project_product_id', 'property_type_id', 'product_type', 'total_floor', 'bedroom', 'bathroom', 'parking_lot', 'total_viewed', 'status', 'createdby', 'updatedby', 'deletedby'], 'integer'],
            [['summary', 'description'], 'string'],
            [['price', 'building_size', 'land_size'], 'number', 'min'=>0],
            [['published_date_start', 'published_date_end', 'createdat', 'updatedat', 'deletedat'], 'safe'],
            [['title', 'permalink', 'thumb_image', 'address'], 'string', 'max' => 255],
            [['latitude', 'longitude'], 'string', 'max' => 50],
            [['collaterals_id'], 'string', 'max' => 100],
            [['total_floor', 'bedroom', 'bathroom', 'parking_lot'], 'integer', 'min'=>0],
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
            'project_product_id' => 'Project Product ID',
            'property_type_id' => 'Property Type ID',
            'title' => 'Title',
            'permalink' => 'Permalink',
            'summary' => 'Summary',
            'description' => 'Description',
            'thumb_image' => 'Thumb Image',
            'file' => 'Thumb Image',
            'product_type' => 'Product Type',
            'address' => 'Address',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
            'price' => 'Price (Rp)',
            'building_size' => 'Building Size (m2)',
            'land_size' => 'Land Size (m2)',
            'total_floor' => 'Total Floor',
            'bedroom' => 'Bedroom',
            'bathroom' => 'Bathroom',
            'parking_lot' => 'Parking Lot',
            'collaterals_id' => 'Collaterals ID',
            'published_date_start' => 'Published Date Start',
            'published_date_end' => 'Published Date End',
            'total_viewed' => 'Total Viewed',
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
		
		$model = $this->find()->where("LOWER(".$attribute.") = '" . strtolower($this->$attribute) . "' AND deletedby IS NULL AND deletedat IS NULL " . (!empty($this->id)?" AND id <> '".$this->id."'":''))->all();
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
	
	public function getProjectProduct()
    {
        return $this->hasOne(ProjectProducts::className(), ['id' => 'project_product_id']);
    }
	
	public function getLookupProductType()
    {
        return $this->hasOne(LookupProductType::className(), ['id' => 'property_type_id']);
    }
	
	public function getLookupPropertyProductType()
    {
        return $this->hasOne(LookupPropertyProductTypes::className(), ['id' => 'product_type']);
    }
	
	public function getLookupProductStatus()
    {
        return $this->hasOne(LookupProductStatus::className(), ['id' => 'status']);
    }
		
	public function getCollateralList($collateral_ids)
	{
		if(!strlen($collateral_ids))
		return NULL;
		else
		{
			$collateralIDs = unserialize($collateral_ids);
			$sql = "SELECT title ";
			$sql .= "FROM collaterals ";
			$sql .= "WHERE 0=0 ";
			$sql .= "AND id IN (".implode(',',$collateralIDs).") ";
			$sql .= "AND status = 1 ";
			$sql .= "AND published_date_start <= NOW() ";
			$sql .= "AND ( published_date_end > NOW() OR published_date_end IS NULL ) ";
			$sql .= "AND deletedby IS NULL ";
			$sql .= "AND deletedat IS NULL ";
			$sql .= "ORDER BY title ASC ";
			$collaterals = Yii::$app->db->createCommand($sql)->queryAll();
			
			$tmp = '';
			foreach($collaterals as $collateral)
			{
				$tmp .= $collateral['title'];
				$tmp .= '<br>';
			}
			
			return $tmp;
		}
	}
	
}
