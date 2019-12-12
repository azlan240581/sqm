<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "rewards".
 *
 * @property integer $id
 * @property integer $category_id
 * @property string $name
 * @property string $summary
 * @property string $description
 * @property integer $quantity
 * @property integer $minimum_quantity
 * @property string $points
 * @property string $images
 * @property string $url
 * @property integer $rule_expirary_in_days
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
class Rewards extends \yii\db\ActiveRecord
{
	public $file;
	
    public static function tableName()
    {
        return 'rewards';
    }

    public function rules()
    {
        return [
            [['category_id', 'name', 'images', 'published_date_start', 'createdby', 'createdat'], 'required'],
            [['category_id', 'quantity', 'minimum_quantity', 'rule_expirary_in_days', 'total_viewed', 'createdby', 'updatedby', 'deletedby'], 'integer'],
            [['summary', 'description', 'images'], 'string'],
            [['points'], 'number', 'min'=>0],
            [['published_date_start', 'published_date_end', 'createdat', 'updatedat', 'deletedat'], 'safe'],
            [['name', 'url'], 'string', 'max' => 255],
            [['status'], 'integer'],
			['url', 'url', 'defaultScheme' => NULL],
			[['quantity', 'minimum_quantity'], 'integer'],
			[['published_date_start','published_date_end'], 'date', 'format' => 'php:Y-m-d H:i:s'],
			[['published_date_start','published_date_end'], 'validateTwoDates', 'skipOnEmpty' => true, 'skipOnError' => false],
			[['file'], 'file', 'extensions' => ['png','jpg','jpeg'], 'mimeTypes' => 'image/jpeg,image/jpg,image/png', 'maxFiles' => 1],
			[['file'], 'required', 'on' => 'create'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Category ID',
            'name' => 'Name',
            'summary' => 'Summary',
            'description' => 'Description',
            'quantity' => 'Quantity',
            'minimum_quantity' => 'Minimum Quantity',
            'points' => 'Points',
            'images' => 'Images',
            'url' => 'Url',
            'rule_expirary_in_days' => 'Rule Expirary In Days',
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
	
	public function getLookupRewardCategory()
    {
        return $this->hasOne(LookupRewardCategories::className(), ['id' => 'category_id']);
    }
	
	public function getRewardsList($category_id,$reward_id)
	{
		$sql = "SELECT r.*, lrt.name as category_name ";
		$sql .= "FROM rewards r, lookup_reward_categories lrt ";
		$sql .= "WHERE 0=0 ";
		$sql .= "AND r.category_id = lrt.id ";
		
		if(strlen($reward_id))
		$sql .= "AND r.id = '".$reward_id."' ";
		if(strlen($category_id))
		$sql .= "AND r.category_id = '".$category_id."' ";
		
		$sql .= "AND r.published_date_start <= NOW() ";
		$sql .= "AND ( r.published_date_end > NOW() OR r.published_date_end IS NULL ) ";
		$sql .= "AND r.status=1 ";
		$sql .= "AND r.deletedby IS NULL ";
		$sql .= "AND r.deletedat IS NULL ";
		$sql .= "ORDER BY name ASC ";
		$rewardList = Yii::$app->db->createCommand($sql)->queryAll();
				
		if($rewardList==NULL)
		return false;
		else
		return $rewardList;
	}
	
	
}
