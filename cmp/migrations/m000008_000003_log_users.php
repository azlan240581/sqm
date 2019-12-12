<?php

use yii\db\Migration;

class m000008_000003_log_users extends Migration
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
		$this->createTable("log_users", array(
		"id" => "pk",
		"user_id" => "int(11) NOT NULL",
		"PHPSESSID" => "varchar(50) NOT NULL",
		"user_ip" => "varchar(50) DEFAULT NULL",
		"device_token" => "varchar(250) DEFAULT NULL",
		"device_type" => "varchar(250) DEFAULT NULL",
		"authorization_code" => "varchar(250) DEFAULT NULL",
		"remarks" => "text DEFAULT NULL",
		"createdby" => "int(11) NOT NULL",
		"createdat" => "datetime NOT NULL",
		), "ENGINE=InnoDB");
    }

    public function safeDown()
    {
		$this->truncateTable('log_users');
		$this->dropTable('log_users');
    }
}
