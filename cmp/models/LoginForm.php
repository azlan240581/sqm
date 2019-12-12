<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\Users;
use app\models\LogUsers;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;

    private $_user = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return array(
            // username and password are both required
            array(array('username', 'password'), 'required'),
            // rememberMe must be a boolean value
            array('rememberMe', 'boolean'),
            // password is validated by validatePassword()
            array('password', 'validatePassword'),
        );
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

			if($user)
			{
				if ($user->status == 0) {
					$this->addError($attribute, 'User is not active! Please contact administrator for more information.');
				}
			}
			
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return (Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600*24 : 0));
        }
		
		if($this->_user != NULL)
		{
			if(count($this->errors))
			$this->updateLastLogin($this->_user->id,'Login Failed');
		}
        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false)
		$this->_user = Users::findByUsername($this->username);
		
		/*if ($this->_user === false)
		$this->_user = Users::find()->where(['username'=>$this->username,'status'=>1])->one();*/

        return $this->_user;
    }
	
	public function updateLastLogin($user_id,$message)
	{
		/*
		echo '<pre>';
		print_r($_COOKIE);
		print_r($_SESSION);
		print_r($_SERVER);
		print_r(session_id());
		echo '</pre>';
		exit();
		*/
		$users = Users::find()->where(['id' => $user_id])->one();
		//$users->password_repeat = $users->password;
		unset($users->password);
		$users->lastloginat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
		$users->save();
		
		$logUsers = new LogUsers();
		$logUsers->user_id = $user_id;
		$logUsers->PHPSESSID = session_id();
		$logUsers->user_ip = $_SERVER['REMOTE_ADDR'];
		$logUsers->remarks = $message;
		$logUsers->createdby = $user_id;
		$logUsers->createdat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
		
		if ($logUsers->save() !== false) 
		return true;
		else
		return false;
	}
	
    public function getLastLogin($id)
    {
		$user = LogUsers::find()->where(['user_id' => $id])->orderBy(['id' => SORT_DESC])->one();
		return $user->createdat; 
    }
	
    public function getCountLoginPerDay($id)
    {
		$user = LogUsers::find()->where(['between', 'createdat', Yii::$app->AccessRule->dateFormat(time(),'Y-m-d').' 00:00:00', Yii::$app->AccessRule->dateFormat(time(),'Y-m-d H:i:s')])
				->andWhere(['user_id' => $id])
				->all();
		
		return count($user); 
    }
}
