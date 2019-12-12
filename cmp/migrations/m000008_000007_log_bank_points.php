<?php

use yii\db\Migration;

class m000008_000007_log_bank_points extends Migration
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
		$this->createTable("log_bank_points", array(
		"id" => "pk",
		"points_value" => "decimal(20,4) NOT NULL",
		"remarks" => "text DEFAULT NULL",
		"createdby" => "int(11) NOT NULL",
		"createdat" => "datetime NOT NULL",
		), "ENGINE=InnoDB");
    }

    public function safeDown()
    {
		$this->truncateTable('log_bank_points');
		$this->dropTable('log_bank_points');
    }
}
