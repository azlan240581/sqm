<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "log_news_feed_approval".
 *
 * @property integer $id
 * @property integer $news_feed_id
 * @property integer $status
 * @property string $remarks
 * @property integer $createdby
 * @property string $createdat
 */
class LogNewsFeedApproval extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log_news_feed_approval';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['news_feed_id', 'status', 'createdby', 'createdat'], 'required'],
            [['news_feed_id', 'status', 'createdby'], 'integer'],
            [['remarks'], 'string'],
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
            'news_feed_id' => 'News Feed ID',
            'status' => 'Status',
            'remarks' => 'Remarks',
            'createdby' => 'Createdby',
            'createdat' => 'Createdat',
        ];
    }
}
