<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "prospect_interested_projects".
 *
 * @property integer $id
 * @property integer $prospect_id
 * @property integer $project_id
 */
class ProspectInterestedProjects extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'prospect_interested_projects';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['prospect_id', 'project_id'], 'required'],
            [['prospect_id', 'project_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'prospect_id' => 'Prospect ID',
            'project_id' => 'Project ID',
        ];
    }
}
