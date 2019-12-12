<?php

use yii\db\Migration;

class m000003_000007_user_messages extends Migration
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
		$this->createTable("user_messages", array(
		"id" => "pk",
		"user_id" => "int(11) NOT NULL",
		"subject" => "varchar(500) NOT NULL",
		"message" => "text NOT NULL",
		"long_message" => "longtext DEFAULT NULL",
		"priority" => "tinyint(1) DEFAULT 1",
		"mark_as_read" => "tinyint(1) DEFAULT 0",
		"createdby" => "int(11) NOT NULL",
		"createdat" => "datetime NOT NULL",
		), "ENGINE=InnoDB");
    }

    public function safeDown()
    {
		$this->truncateTable('user_messages');
		$this->dropTable('user_messages');
    }
}
