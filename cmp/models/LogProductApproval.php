<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "log_product_approval".
 *
 * @property integer $id
 * @property integer $product_id
 * @property integer $status
 * @property string $remarks
 * @property integer $createdby
 * @property string $createdat
 */
class LogProductApproval extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log_product_approval';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'status', 'createdby', 'createdat'], 'required'],
            [['product_id', 'status', 'createdby'], 'integer'],
            [['createdat'], 'safe'],
            [['remarks'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Product ID',
            'status' => 'Status',
            'remarks' => 'Remarks',
            'createdby' => 'Createdby',
            'createdat' => 'Createdat',
        ];
    }
}
