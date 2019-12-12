<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "log_user_reward_redemptions".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $reward_id
 * @property integer $associate_reward_redemption_id
 * @property string $points_value
 * @property string $ticket_no
 * @property integer $status
 * @property string $remarks
 * @property integer $createdby
 * @property string $createdat
 */
class LogUserRewardRedemptions extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log_user_reward_redemptions';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'reward_id', 'associate_reward_redemption_id', 'points_value', 'status', 'createdby', 'createdat'], 'required'],
            [['user_id', 'reward_id', 'associate_reward_redemption_id', 'status', 'createdby'], 'integer'],
            [['points_value'], 'number'],
            [['remarks'], 'string'],
            [['createdat'], 'safe'],
            [['ticket_no'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'reward_id' => 'Reward ID',
            'associate_reward_redemption_id' => 'Associate Reward Redemption ID',
            'points_value' => 'Points Value',
            'ticket_no' => 'Ticket No',
            'status' => 'Status',
            'remarks' => 'Remarks',
            'createdby' => 'Createdby',
            'createdat' => 'Createdat',
        ];
    }
}
