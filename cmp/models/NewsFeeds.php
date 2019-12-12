<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "news_feeds".
 *
 * @property integer $id
 * @property integer $category_id
 * @property integer $project_id
 * @property string $title
 * @property string $permalink
 * @property string $summary
 * @property string $description
 * @property string $thumb_image
 * @property integer $product_id
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
class NewsFeeds extends \yii\db\ActiveRecord
{
	public $file,$promotion_date_range;
	
    public static function tableName()
    {
        return 'news_feeds';
    }

    public function rules()
    {
        return [
            [['category_id', 'project_id', 'title', 'permalink', 'published_date_start', 'status', 'createdby', 'createdat'], 'required'],
            [['category_id', 'project_id', 'product_id', 'total_viewed', 'status', 'createdby', 'updatedby', 'deletedby'], 'integer'],
            [['summary', 'description', 'promotion_terms_conditions', 'event_location'], 'string'],
            [['promotion_start_date', 'promotion_end_date', 'promotion_date_range', 'event_at', 'published_date_start', 'published_date_end', 'createdat', 'updatedat', 'deletedat'], 'safe'],
            [['title', 'permalink', 'thumb_image'], 'string', 'max' => 255],
            [['event_location_longitude','event_location_latitude','collaterals_id'], 'string', 'max' => 100],
			[['promotion_start_date','promotion_end_date','event_at','published_date_start','published_date_end'], 'date', 'format' => 'php:Y-m-d H:i:s'],
			[['promotion_start_date','promotion_end_date'], 'validateTwoPromotionDates', 'skipOnEmpty' => true, 'skipOnError' => false],
			[['published_date_start','published_date_end'], 'validateTwoDates', 'skipOnEmpty' => true, 'skipOnError' => false],
			[['file'], 'required', 'on' => 'create'],
			[['file'], 'file', 'extensions' => ['png','jpg','jpeg'], 'mimeTypes' => 'image/jpeg,image/jpg,image/png', 'maxFiles' => 1],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Category ID',
            'project_id' => 'Project ID',
            'title' => 'Title',
            'permalink' => 'Permalink',
            'summary' => 'Summary',
            'description' => 'Description',
            'thumb_image' => 'Thumb Image',
            'file' => 'Thumb Image',
            'product_id' => 'Product ID',
            'promotion_start_date' => 'Promotion Start Date',
            'promotion_end_date' => 'Promotion End Date',
            'promotion_date_range' => 'Promotion Date Range',
            'promotion_terms_conditions' => 'Promotion Terms & Condition',
            'event_at' => 'Event At',
            'event_location' => 'Event Location',
            'event_location_longitude' => 'Event Location Longitude',
            'event_location_latitude' => 'Event Location Latitude',
            'collaterals_id' => 'Collaterals ID',
            'published_date_start' => 'Published Date Start',
            'published_date_end' => 'Published Date End',
            'total_viewed' => 'Total Viewed',
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
		
		$model = $this->find()->where("LOWER(".$attribute.") = '" . strtolower($this->$attribute) . "' AND deletedby IS NULL AND deletedat IS NULL " . (!empty($this->id)?" AND id <> '".$this->id."'":''))->all();
		if (count($model) > 0) {
			$this->addError($attribute,  $this->getAttributeLabel($attribute).' is already exists.');
			return false;
		}
		else
		return true;
	}
	
	public function validateTwoPromotionDates()
	{
		if(strlen($this->promotion_start_date) and strlen($this->promotion_end_date))
		{
			if(strtotime($this->promotion_end_date) <= strtotime($this->promotion_start_date))
			{
				$this->addError('promotion_end_date','Promotion End Date need to be greater than Start Date');
			}
		}
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
	
	public function getLookupNewsFeedCategory()
    {
        return $this->hasOne(LookupNewsFeedCategories::className(), ['id' => 'category_id']);
    }
	
	public function getLookupNewsFeedStatus()
    {
        return $this->hasOne(LookupNewsFeedStatus::className(), ['id' => 'status']);
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
