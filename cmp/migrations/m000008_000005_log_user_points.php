<?php

use yii\db\Migration;

class m000008_000005_log_user_points extends Migration
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
		$this->createTable("log_user_points", array(
		"id" => "pk",
		"user_id" => "int(11) NOT NULL",
		"points_value" => "decimal(20,4) NOT NULL",
		"status" => "tinyint(1) NOT NULL",
		"remarks" => "text DEFAULT NULL",
		"createdby" => "int(11) NOT NULL",
		"createdat" => "datetime NOT NULL",
		), "ENGINE=InnoDB");
    }

    public function safeDown()
    {
		$this->truncateTable('log_user_points');
		$this->dropTable('log_user_points');
    }
}
