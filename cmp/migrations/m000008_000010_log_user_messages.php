<?php

use yii\db\Migration;

class m000008_000010_log_user_messages extends Migration
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
		$this->createTable("log_user_messages", array(
		"id" => "pk",
		"subject" => "varchar(500) NOT NULL",
		"message" => "text NOT NULL",
		"long_message" => "longtext DEFAULT NULL",
		"recepients_list" => "text NOT NULL",
		"priority" => "tinyint(1) DEFAULT 1",
		"createdby" => "int(11) NOT NULL",
		"createdat" => "datetime NOT NULL",
		), "ENGINE=InnoDB");
    }

    public function safeDown()
    {
		$this->truncateTable('log_user_messages');
		$this->dropTable('log_user_messages');
    }
}
