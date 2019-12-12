<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "property_product_medias".
 *
 * @property integer $id
 * @property integer $product_id
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
class PropertyProductMedias extends \yii\db\ActiveRecord
{
	public $file,$image,$youtube;
	
    public static function tableName()
    {
        return 'property_product_medias';
    }

    public function rules()
    {
        return [
            [['product_id', 'media_type_id', 'thumb_image', 'media_title', 'media_value', 'createdby', 'createdat'], 'required'],
            [['product_id', 'media_type_id', 'sort', 'createdby', 'deletedby'], 'integer'],
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
            'product_id' => 'Product ID',
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
	
	public function getPropertyProductMedias($product_id)
	{
		$sql = "SELECT ppm.media_type_id, lmt.name as media_type_name, ppm.id, ppm.thumb_image, ppm.media_title, ppm.media_value ";
		$sql .= "FROM property_product_medias ppm, lookup_media_types lmt ";
		$sql .= "WHERE 0=0 ";
		$sql .= "AND ppm.media_type_id = lmt.id ";
		$sql .= "AND ppm.product_id = '".$product_id."' ";
		$sql .= "AND ppm.published=1 ";
		$sql .= "AND ppm.deletedby IS NULL ";
		$sql .= "AND ppm.deletedat IS NULL ";
		$sql .= "ORDER BY ppm.sort DESC ";
		$productMediaList = Yii::$app->db->createCommand($sql)->queryAll();
				
		if($productMediaList==NULL)
		return FALSE;
		else
		return $productMediaList;
	}
	
}
