<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "log_associate_activities".
 *
 * @property integer $id
 * @property integer $associate_id
 * @property integer $activity_id
 * @property integer $news_feed_id
 * @property integer $product_id
 * @property integer $banner_id
 * @property integer $createdby
 * @property string $createdat
 */
class LogAssociateActivities extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log_associate_activities';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['associate_id', 'activity_id', 'createdby', 'createdat'], 'required'],
            [['associate_id', 'activity_id', 'news_feed_id', 'product_id', 'banner_id', 'createdby'], 'integer'],
            [['points_value'], 'number'],
			[['createdat'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'associate_id' => 'Associate ID',
            'activity_id' => 'Activity ID',
            'points_value' => 'Points Value',
            'news_feed_id' => 'News Feed ID',
            'product_id' => 'Product ID',
            'banner_id' => 'Banner ID',
            'createdby' => 'Createdby',
            'createdat' => 'Createdat',
        ];
    }
}
