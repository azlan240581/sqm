<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "banners".
 *
 * @property integer $id
 * @property integer $banner_category_id
 * @property string $banner_title
 * @property string $permalink
 * @property string $banner_summary
 * @property string $banner_description
 * @property string $banner_img
 * @property string $banner_video
 * @property string $link_url
 * @property string $published_date_start
 * @property string $published_date_end
 * @property integer $sort
 * @property integer $total_viewed
 * @property integer $createdby
 * @property string $createdat
 * @property integer $updatedby
 * @property string $updatedat
 * @property integer $deletedby
 * @property string $deletedat
 */
class Banners extends \yii\db\ActiveRecord
{
	public $file, $errorMessage;
	
    public static function tableName()
    {
        return 'banners';
    }

    public function rules()
    {
        return [
            [['banner_category_id', 'banner_title', 'permalink', 'published_date_start', 'createdby', 'createdat'], 'required'],
            [['banner_category_id', 'sort', 'total_viewed', 'createdby', 'updatedby', 'deletedby'], 'integer'],
            [['banner_summary', 'banner_description'], 'string'],
            [['published_date_start', 'published_date_end', 'createdat', 'updatedat', 'deletedat'], 'safe'],
            [['banner_title', 'permalink', 'banner_img', 'banner_video', 'link_url'], 'string', 'max' => 255],
            [['sort'], 'integer', 'min'=>0],
			[['file'], 'file', 'extensions' => ['png','jpg','jpeg'], 'mimeTypes' => 'image/jpeg,image/jpg,image/png', 'maxFiles' => 1],
			['link_url', 'url', 'defaultScheme' => NULL],
			[['published_date_start','published_date_end'], 'date', 'format' => 'php:Y-m-d H:i:s'],
			[['published_date_start','published_date_end'], 'validateTwoDates', 'skipOnEmpty' => true, 'skipOnError' => false],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'banner_category_id' => 'Banner Category',
            'banner_title' => 'Banner Title',
            'permalink' => 'Permalink',
            'banner_summary' => 'Banner Summary',
            'banner_description' => 'Banner Description',
            'banner_img' => 'Banner Image',
            'banner_video' => 'Banner Video (Youtube ID)',
            'link_url' => 'Link Url',
            'published_date_start' => 'Published Date Start',
            'published_date_end' => 'Published Date End',
            'sort' => 'Sort',
            'total_viewed' => 'Total Viewed',
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
	
	public function getLookupBannerCategory()
    {
        return $this->hasOne(LookupBannerCategories::className(), ['id' => 'banner_category_id']);
    }
	
	public function getBannerList($banner_category='',$banner_id='',$permalink='')
	{	
		$sql = "SELECT b.*, lbc.name as banner_category_name  ";
		$sql .= "FROM banners b, lookup_banner_categories lbc ";
		$sql .= "WHERE 0=0 ";
		
		$sql .= "AND b.banner_category_id = lbc.id ";
		$sql .= "AND lbc.deleted = 0 ";
		if(strlen($banner_category))
		$sql .= "AND (lbc.id = '".$banner_category."' OR LOWER(lbc.name) LIKE '%".strtolower($banner_category)."%') ";
		if(strlen($banner_id))
		$sql .= "AND LOWER(b.id) = '".$banner_id."' ";
		if(strlen($permalink))
		$sql .= "AND LOWER(b.permalink) = '".strtolower($permalink)."' ";
		
		$sql .= "AND b.published_date_start <= NOW() ";
		$sql .= "AND ( b.published_date_end > NOW() OR b.published_date_end IS NULL ) ";
		$sql .= "AND b.deletedby IS NULL ";
		$sql .= "AND b.deletedat IS NULL ";
		$sql .= "ORDER BY b.sort DESC, b.createdat DESC ";
		
		$connection = Yii::$app->getDb();
		$query = $connection->createCommand($sql);
		$result = $query->queryAll();
		
		if($result==false)
		{
			$this->errorMessage = 'No Banners';
			return false;
		}
		else
		return $result;
	}
	
	
	
}
