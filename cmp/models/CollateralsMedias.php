<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "collaterals_medias".
 *
 * @property integer $id
 * @property integer $collateral_id
 * @property integer $collateral_media_type_id
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
class CollateralsMedias extends \yii\db\ActiveRecord
{
	public $file,$image,$brochure,$youtube;
	
    public static function tableName()
    {
        return 'collaterals_medias';
    }

    public function rules()
    {
        return [
            [['collateral_id', 'collateral_media_type_id', 'thumb_image', 'media_title', 'media_value', 'createdby', 'createdat'], 'required'],
            [['collateral_id', 'collateral_media_type_id', 'sort', 'createdby', 'deletedby'], 'integer'],
            [['createdat', 'deletedat'], 'safe'],
            [['thumb_image', 'media_title', 'media_value'], 'string', 'max' => 255],
            [['sort'], 'integer', 'min'=>0],
            [['published'], 'integer'],
			[['file','image','brochure','youtube'], 'required', 'on' => 'create'],
			[['file','image'], 'file', 'extensions' => ['png','jpg','jpeg'], 'mimeTypes' => 'image/jpeg,image/jpg,image/png', 'maxFiles' => 1],
			['brochure', 'file','extensions' => ['pdf'], 'wrongExtension' => 'Only PDF files are allowed for {attribute}.', 'wrongMimeType' => 'Only PDF files are allowed for {attribute}.', 'mimeTypes'=>['application/pdf']],
			['media_value', 'url', 'defaultScheme' => NULL],
		];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'collateral_id' => 'Collateral ID',
            'collateral_media_type_id' => 'Collateral Type',
            'thumb_image' => 'Thumb Image',
            'media_title' => 'Media Title',
            'media_value' => 'Collateral Link',
            'published' => 'Published',
            'sort' => 'Sort',
            'createdby' => 'Createdby',
            'createdat' => 'Createdat',
            'deletedby' => 'Deletedby',
            'deletedat' => 'Deletedat',
        ];
    }
	
	public function getLookupCollateralMediaType()
    {
        return $this->hasOne(LookupCollateralMediaTypes::className(), ['id' => 'collateral_media_type_id']);
    }
	
	public function getCollateralsMedias($collateral_id)
	{
		$sql = "SELECT cm.collateral_media_type_id, lcmd.name as collateral_media_type_name, cm.id, cm.thumb_image, cm.media_title, cm.media_value ";
		$sql .= "FROM collaterals_medias cm, lookup_collateral_media_types lcmd ";
		$sql .= "WHERE 0=0 ";
		$sql .= "AND cm.collateral_media_type_id = lcmd.id ";
		$sql .= "AND cm.collateral_id = '".$collateral_id."' ";
		$sql .= "AND cm.published=1 ";
		$sql .= "AND cm.deletedby IS NULL ";
		$sql .= "AND cm.deletedat IS NULL ";
		$sql .= "ORDER BY cm.sort DESC ";
		$collateralMediaList = Yii::$app->db->createCommand($sql)->queryAll();
				
		if($collateralMediaList==NULL)
		return FALSE;
		else
		return $collateralMediaList;
	}
	
}
