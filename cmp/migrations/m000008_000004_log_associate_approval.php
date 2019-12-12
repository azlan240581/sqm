<?php

use yii\db\Migration;

class m000008_000004_log_associate_approval extends Migration
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
		$this->createTable("log_associate_approval", array(
		"id" => "pk",
		"user_id" => "int(11) NOT NULL",
		"status" => "tinyint(1) NOT NULL",
		"remarks" => "text NOT NULL",
		"createdby" => "int(11) NOT NULL",
		"createdat" => "datetime NOT NULL",
		), "ENGINE=InnoDB");
    }

    public function safeDown()
    {
		$this->truncateTable('log_associate_approval');
		$this->dropTable('log_associate_approval');
    }
}
