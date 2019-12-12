<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "assistant_upline".
 *
 * @property integer $id
 * @property integer $upline_id
 * @property integer $assistant_id
 */
class AssistantUpline extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'assistant_upline';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['upline_id', 'assistant_id'], 'required'],
            [['upline_id', 'assistant_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'upline_id' => 'Upline ID',
            'assistant_id' => 'Assistant ID',
        ];
    }
}
