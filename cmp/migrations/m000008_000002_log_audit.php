<?php

use yii\db\Migration;

class m000008_000002_log_audit extends Migration
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
		$this->createTable("log_audit", array(
		"id" => "pk",
		"module_id" => "int(11) NOT NULL",
		"record_id" => "int(11) NOT NULL",
		"action" => "text NOT NULL",
		"newdata" => "text NOT NULL",
		"olddata" => "text NOT NULL",
		"user_id" => "int(11) NOT NULL",
		"createdat" => "datetime NOT NULL",
		), "ENGINE=InnoDB");
		
    }

    public function safeDown()
    {		
		$this->truncateTable('log_audit');
		$this->dropTable('log_audit');
    }
}
