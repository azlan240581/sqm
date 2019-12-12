<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_groups".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $groupaccess_id
 *
 * @property Users $user
 * @property GroupAccess $groupaccess
 */
class UserGroups extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_groups';
    }

    public function rules()
    {
        return [
            [['user_id', 'groupaccess_id'], 'required'],
            [['user_id', 'groupaccess_id'], 'integer'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['groupaccess_id'], 'exist', 'skipOnError' => true, 'targetClass' => GroupAccess::className(), 'targetAttribute' => ['groupaccess_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'groupaccess_id' => 'Groupaccess ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }

    public function getGroupaccess()
    {
        return $this->hasOne(GroupAccess::className(), ['id' => 'groupaccess_id']);
    }
	
	//****************************//
	
    public function getUserGroups($user_id)
    {
		$usergroupsRaw = UserGroups::find()->where(['user_id' => $user_id])->all();

		if($usergroupsRaw == null)
        return null;
		
		$usergroups = [];
		foreach($usergroupsRaw as $usergroup)
		{
			$usergroups[] = $usergroup->groupaccess_id;
		}

		return $usergroups; 
    }
}
