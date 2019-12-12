<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "log_api".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $api_actions
 * @property string $request
 * @property string $recepients_list
 * @property integer $createdby
 * @property string $createdat
 *
 * @property Users $user
 */
class LogApi extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log_api';
    }

    public function rules()
    {
        return [
            [['api_actions', 'request', 'createdat'], 'required'],
            [['user_id'], 'integer'],
            [['request', 'response'], 'string'],
            [['createdat'], 'safe'],
            [['api_actions'], 'string', 'max' => 500],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'api_actions' => 'Api Actions',
            'request' => 'Request',
            'response' => 'Response',
            'user_id' => 'User ID',
            'createdat' => 'Createdat',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }
	
	public function request($request)
	{
		return '<pre>'.var_export(json_decode($request), true).'</pre>';
	}
	
	public function response($response)
	{
		return '<pre>'.var_export(json_decode($response), true).'</pre>';
	}
	
	public function getLogApis($user,$api_actions,$createdatrange)
	{
		$sql = "SELECT la.api_actions, la.request, la.response, ";
		$sql .= "(SELECT u.name FROM users u WHERE u.id = la.user_id) as staff_name, la.createdat ";
		$sql .= "FROM log_api la ";
		$sql .= "WHERE 0=0 ";
		if(strlen($user))
		$sql .= "AND la.user_id IN (SELECT u.id FROM users u WHERE LOWER(u.name) LIKE '%".strtolower($user)."%' ) ";
		if(strlen($api_actions))
		$sql .= "AND LOWER(la.api_actions) LIKE '%".strtolower($api_actions)."%' ";
		if(strlen($createdatrange))
		{
			list($start_date, $end_date) = explode(' - ', $createdatrange);
			$sql .= "AND la.createdat >= '".$start_date."' ";
			$sql .= "AND la.createdat <= '".$end_date."' ";
		}
		$sql .= "ORDER BY la.createdat DESC ";
		$result = Yii::$app->db->createCommand($sql)->queryAll();
		
		if($result==NULL)
		return FALSE;
		else
		return $result;
	}
	
}
