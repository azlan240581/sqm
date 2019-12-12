<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "associate_get_associate".
 *
 * @property integer $id
 * @property integer $inviter_id
 * @property integer $invited_id
 */
class AssociateGetAssociate extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'associate_get_associate';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['inviter_id', 'invited_id'], 'required'],
            [['inviter_id', 'invited_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'inviter_id' => 'Inviter ID',
            'invited_id' => 'Invited ID',
        ];
    }
}
