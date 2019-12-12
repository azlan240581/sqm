<?php

use yii\db\Migration;

class m000003_000008_user_devices extends Migration
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
		$this->createTable("user_devices", array(
		"id" => "pk",
		"user_id" => "int(11) NOT NULL",
		"device_token" => "varchar(250) NOT NULL",
		"device_os" => "varchar(50) NOT NULL",
		"device_details" => "varchar(250) DEFAULT NULL",
		), "ENGINE=InnoDB");
    }

    public function safeDown()
    {
		$this->truncateTable('user_devices');
		$this->dropTable('user_devices');
    }
}
