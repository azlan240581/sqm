<?php

use yii\db\Migration;

class m000008_000017_log_developer_commission_paid extends Migration
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
		$this->createTable("log_developer_commission_paid", array(
		"id" => "pk",
		"developer_id" => "int(11) NOT NULL",
		"project_id" => "int(11) NOT NULL",
		"prospect_id" => "int(11) NOT NULL",
		"commission_amount" => "decimal(20,4) NOT NULL",
		"status" => "int(11) NOT NULL",
		"remarks" => "text DEFAULT NULL",
		"createdby" => "int(11) NOT NULL",
		"createdat" => "datetime NOT NULL",
		), "ENGINE=InnoDB");
    }

    public function safeDown()
    {
		$this->truncateTable('log_developer_commission_paid');
		$this->dropTable('log_developer_commission_paid');
    }
}
