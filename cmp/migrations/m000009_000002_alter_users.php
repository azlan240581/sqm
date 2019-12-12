<?php

use yii\db\Migration;

class m000009_000002_alter_users extends Migration
{
    /*
    public function up()
    {
    }

    public function down()
    {
    }
    */

    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
		$salt = md5(time());

		$this->truncateTable('users');
		$this->truncateTable('user_groups');
		
		//ffsadmin
		$str = md5('1'.'ffsadmin'.date("Y-m-d H:i:s"));
		$uuid = substr($str,0,8).'-'.substr($str,8,4).'-'.substr($str,12,4).'-'.substr($str,16,4).'-'.substr($str,20,12);
		$this->insert('users',array (
									  'id'=>1,
									  'uuid'=>$uuid,
									  'username'=>'ffsadmin',
									  'password'=>md5('Ff-1943s'.$salt),
									  'password_salt'=>$salt,
									  'email'=>'support@forefront.com.my',
									  'name'=>'Dev Admin',
									  'avatar_id'=>'1',
									  'status'=>'1',
									  'createdby'=>'1',
									  'createdat'=>date("Y-m-d H:i:s"),
									  ));
		
		//administrator
		$str = md5('2'.'administrator'.date("Y-m-d H:i:s"));
		$uuid = substr($str,0,8).'-'.substr($str,8,4).'-'.substr($str,12,4).'-'.substr($str,16,4).'-'.substr($str,20,12);
		$this->insert('users',array (
					'id'=>2,
					'uuid'=>$uuid,
					'username'=>'administrator',
					'password'=>md5('default'.$salt),
					'password_salt'=>$salt,
					'email'=>'maria@swancity.co.id',
					'name'=>'Maria',
					'contact_number'=>'62081214034277',
					'avatar_id'=>'1',
					'status'=>'1',
					'createdby'=>'1',
					'createdat'=>date("Y-m-d H:i:s"),
				));
		$this->insert('user_groups',array(
					'user_id'=>2,
					'groupaccess_id'=>1,
				));
		
	}

    public function safeDown()
    {
    }
}
