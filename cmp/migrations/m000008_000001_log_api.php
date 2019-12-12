<?php

use yii\db\Migration;

class m000008_000001_log_api extends Migration
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
		$this->createTable("log_api", array(
		"id" => "pk",
		"api_actions" => "varchar(500) NOT NULL",
		"request" => "longtext NOT NULL",
		"response" => "longtext DEFAULT NULL",
		"user_id" => "int(11) DEFAULT NULL",
		"customer_id" => "int(11) DEFAULT NULL",
		"createdat" => "datetime NOT NULL",
		), "ENGINE=InnoDB");
    }

    public function safeDown()
    {
		$this->truncateTable('log_api');
		$this->dropTable('log_api');
    }
}
