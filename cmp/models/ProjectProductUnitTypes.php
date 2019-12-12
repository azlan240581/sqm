<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "project_product_unit_types".
 *
 * @property integer $id
 * @property integer $project_id
 * @property integer $project_product_id
 * @property string $type_name
 * @property string $building_size_sm
 * @property string $land_size_sm
 * @property integer $createdby
 * @property string $createdat
 * @property integer $updatedby
 * @property string $updatedat
 * @property integer $deletedby
 * @property string $deletedat
 */
class ProjectProductUnitTypes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'project_product_unit_types';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['project_id', 'project_product_id', 'type_name', 'building_size_sm', 'land_size_sm', 'createdby', 'createdat'], 'required'],
            [['project_id', 'project_product_id', 'createdby', 'updatedby', 'deletedby'], 'integer'],
            [['building_size_sm', 'land_size_sm'], 'number', 'min'=>0],
            [['createdat', 'updatedat', 'deletedat'], 'safe'],
            [['type_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'project_id' => 'Project ID',
            'project_product_id' => 'Project Product ID',
            'type_name' => 'Type Name',
            'building_size_sm' => 'Building Size (square meter)',
            'land_size_sm' => 'Land Size (square meter)',
            'createdby' => 'Created by',
            'createdat' => 'Created at',
            'updatedby' => 'Updated by',
            'updatedat' => 'Updated at',
            'deletedby' => 'Deleted by',
            'deletedat' => 'Deleted at',
        ];
    }
}
