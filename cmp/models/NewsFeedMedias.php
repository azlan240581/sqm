<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "news_feed_medias".
 *
 * @property integer $id
 * @property integer $news_feed_id
 * @property integer $media_type_id
 * @property string $thumb_image
 * @property string $media_title
 * @property string $media_value
 * @property integer $published
 * @property integer $sort
 * @property integer $createdby
 * @property string $createdat
 * @property integer $deletedby
 * @property string $deletedat
 */
class NewsFeedMedias extends \yii\db\ActiveRecord
{
	public $file,$image,$youtube;
	
    public static function tableName()
    {
        return 'news_feed_medias';
    }

    public function rules()
    {
        return [
            [['news_feed_id', 'media_type_id', 'thumb_image', 'media_title', 'media_value', 'createdby', 'createdat'], 'required'],
            [['news_feed_id', 'media_type_id', 'sort', 'createdby', 'deletedby'], 'integer'],
            [['createdat', 'deletedat'], 'safe'],
            [['thumb_image', 'media_title', 'media_value'], 'string', 'max' => 255],
            [['published'], 'integer'],
            [['sort'], 'integer', 'min'=>0],
			[['file','image','youtube'], 'required', 'on' => 'create'],
			[['file','image'], 'file', 'extensions' => ['png','jpg','jpeg'], 'mimeTypes' => 'image/jpeg,image/jpg,image/png', 'maxFiles' => 1],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'news_feed_id' => 'News Feed ID',
            'media_type_id' => 'Media Type ID',
            'thumb_image' => 'Thumb Image',
            'media_title' => 'Media Title',
            'media_value' => 'Media Value',
            'published' => 'Published',
            'sort' => 'Sort',
            'createdby' => 'Createdby',
            'createdat' => 'Createdat',
            'deletedby' => 'Deletedby',
            'deletedat' => 'Deletedat',
        ];
    }
	
	public function getLookupMediaType()
    {
        return $this->hasOne(LookupMediaTypes::className(), ['id' => 'media_type_id']);
    }
	
	public function getNewsFeedMedias($news_feed_id)
	{
		$sql = "SELECT nfm.media_type_id, lmt.name as media_type_name, nfm.id, nfm.thumb_image, nfm.media_title, nfm.media_value ";
		$sql .= "FROM news_feed_medias nfm, lookup_media_types lmt ";
		$sql .= "WHERE 0=0 ";
		$sql .= "AND nfm.media_type_id = lmt.id ";
		$sql .= "AND nfm.news_feed_id = '".$news_feed_id."' ";
		$sql .= "AND nfm.published=1 ";
		$sql .= "AND nfm.deletedby IS NULL ";
		$sql .= "AND nfm.deletedat IS NULL ";
		$sql .= "ORDER BY nfm.sort DESC ";
		$newsFeedMediaList = Yii::$app->db->createCommand($sql)->queryAll();
				
		if($newsFeedMediaList==NULL)
		return FALSE;
		else
		return $newsFeedMediaList;
	}
	
	
}
