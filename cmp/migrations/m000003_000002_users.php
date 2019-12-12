<?php

use yii\db\Migration;

class m000003_000002_users extends Migration
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
		$this->createTable("users", array(
		"id" => "pk",
		"uuid" => "varchar(50) DEFAULT NULL",
		"sqm_id" => "varchar(50) DEFAULT NULL",
		"username" => "varchar(100) NOT NULL",
		"password" => "varchar(50) NOT NULL",
		"password_salt" => "varchar(50) NOT NULL",
		"email" => "varchar(100) NOT NULL",
		"firstname" => "varchar(100) NOT NULL",
		"lastname" => "varchar(100) NOT NULL",
		"name" => "varchar(100) NOT NULL",
		"country_code" => "varchar(50) NOT NULL",
		"contact_number" => "varchar(50) NOT NULL",
		"dob" => "date DEFAULT NULL",
		"gender" => "varchar(50) DEFAULT NULL",
		"address_1" => "varchar(255) DEFAULT NULL",
		"address_2" => "varchar(255) DEFAULT NULL",
		"address_3" => "varchar(255) DEFAULT NULL",
		"city" => "varchar(255) DEFAULT NULL",
		"postcode" => "varchar(255) DEFAULT NULL",
		"state" => "varchar(255) DEFAULT NULL",
		"country" => "varchar(255) DEFAULT NULL",
		"profile_description" => "longtext DEFAULT NULL",
		"avatar" => "varchar(255) DEFAULT NULL",
		"avatar_id" => "int(11) DEFAULT NULL",		
		"fb_info" => "text DEFAULT NULL",		
		"gmail_info" => "text DEFAULT NULL",		
		"twitter_info" => "text DEFAULT NULL",		
		"commission_tier_id" => "int(11) DEFAULT NULL",
		"commission_tier_expiry_date" => "date DEFAULT NULL",
		"lastloginat" => "datetime DEFAULT NULL",
		"status" => "int(11) DEFAULT 1",
		"createdby" => "int(11) NOT NULL",
		"createdat" => "datetime NOT NULL",
		"updatedby" => "int(11) DEFAULT NULL",
		"updatedat" => "datetime DEFAULT NULL",
		"deletedby" => "int(11) DEFAULT NULL",
		"deletedat" => "datetime DEFAULT NULL",
		), "ENGINE=InnoDB");
				
		$salt = md5(time());
		
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

    }

    public function safeDown()
    {
		$this->truncateTable('users');
		$this->dropTable('users');
    }
}
