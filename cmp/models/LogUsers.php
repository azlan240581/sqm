<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "log_users".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $remarks
 * @property integer $createdby
 * @property string $createdat
 *
 * @property Users $user
 */
class LogUsers extends \yii\db\ActiveRecord
{

	public $errorMessage;

    public static function tableName()
    {
        return 'log_users';
    }

    public function rules()
    {
        return [
            [['user_id', 'createdby', 'createdat'], 'required'],
            [['user_id', 'createdby'], 'integer'],
            [['PHPSESSID','user_ip','remarks'], 'string'],
            [['createdat'], 'safe'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'remarks' => 'Remarks',
            'createdby' => 'Createdby',
            'createdat' => 'Createdat',
        ];
    }

    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }

	public function getLoginHistory($user_id,$recordNo='')
	{
		if(strlen($recordNo) and !is_int($recordNo))
		{
			$this->errorMessage = 'Invalid record no.';
			return false;
		}
		
		$sql = "SELECT createdat as attempt_request_at, remarks as status ";
		$sql .= "FROM log_users ";
		$sql .= "WHERE 0=0 ";
		$sql .= "AND user_id='".$user_id."' ";
		if(strlen($recordNo))
		$sql .= "ORDER BY id DESC ";
		$sql .= "LIMIT ".$recordNo." ";
		$log = Yii::$app->db->createCommand($sql)->queryAll();
		
		if(count($log)==0)
		{
			$this->errorMessage = 'Invalid Log History.';
			return false;
		}
		else
		{
        	return $log;
		}
	}
	
	public function getLogUsers($user,$remarks,$createdatrange)
	{
		$sql = "SELECT (SELECT e.company_name FROM employers e, user_employer ue WHERE lu.user_id = ue.user_id AND ue.employer_id = e.id) as employer, ";
		$sql .= "u.name, lu.remarks, lu.createdby, lu.createdat ";
		$sql .= "FROM log_users lu, users u ";
		$sql .= "WHERE 0=0 ";
		$sql .= "AND lu.user_id = u.id ";
		if(strlen($user))
		$sql .= "AND LOWER(u.name) LIKE '%".strtolower($user)."%' ";
		if(strlen($remarks))
		$sql .= "AND LOWER(lu.remarks) LIKE '%".strtolower($remarks)."%' ";
		if(strlen($createdatrange))
		{
			list($start_date, $end_date) = explode(' - ', $createdatrange);
			$sql .= "AND lu.createdat >= '".$start_date."' ";
			$sql .= "AND lu.createdat <= '".$end_date."' ";
		}
		$sql .= "ORDER BY lu.createdat DESC ";
		$result = Yii::$app->db->createCommand($sql)->queryAll();
				
		if(count($result)==0)
		return false;
		else
		return $result;
	}
	
	public function getLogUsersByEmployer($employer_id,$user,$remarks,$createdatrange)
	{
		$sql = "SELECT u.name, lu.remarks, lu.createdby, lu.createdat ";
		$sql .= "FROM log_users lu, users u, user_employer ue ";
		$sql .= "WHERE 0=0 ";
		$sql .= "AND lu.user_id = u.id ";
		$sql .= "AND u.id = ue.user_id ";
		$sql .= "AND ue.employer_id = '".$employer_id."' ";
		if(strlen($user))
		$sql .= "AND LOWER(u.name) LIKE '%".strtolower($user)."%' ";
		if(strlen($remarks))
		$sql .= "AND LOWER(lu.remarks) LIKE '%".strtolower($remarks)."%' ";
		if(strlen($createdatrange))
		{
			list($start_date, $end_date) = explode(' - ', $createdatrange);
			$sql .= "AND lu.createdat >= '".$start_date."' ";
			$sql .= "AND lu.createdat <= '".$end_date."' ";
		}
		$sql .= "ORDER BY lu.createdat DESC ";
		$result = Yii::$app->db->createCommand($sql)->queryAll();
		
		if(count($result)==0)
		return false;
		else
		return $result;
	}
}
