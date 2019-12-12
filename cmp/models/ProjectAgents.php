<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "project_agents".
 *
 * @property integer $id
 * @property integer $project_id
 * @property integer $agent_id
 */
class ProjectAgents extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'project_agents';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['project_id', 'agent_id'], 'required'],
            [['project_id', 'agent_id'], 'integer'],
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
            'agent_id' => 'Agent ID',
        ];
    }
}
