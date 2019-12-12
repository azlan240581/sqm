<?php

use yii\db\Migration;

class m000008_000018_log_user_commission extends Migration
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
		$this->createTable("log_user_commission", array(
		"id" => "pk",
		"commission_group_tier_id" => "int(11) DEFAULT NULL",
		"prospect_id" => "int(11) DEFAULT NULL",
		"prospect_booking_id" => "int(11) DEFAULT NULL",
		"user_commission_id" => "int(11) DEFAULT NULL",
		"user_eligible_commission_id" => "int(11) DEFAULT NULL",
		"user_id" => "int(11) NOT NULL",
		"commission_amount" => "decimal(20,4) NOT NULL",
		"status" => "int(11) NOT NULL",
		"remarks" => "text DEFAULT NULL",
		"createdby" => "int(11) NOT NULL",
		"createdat" => "datetime NOT NULL",
		), "ENGINE=InnoDB");
    }

    public function safeDown()
    {
		$this->truncateTable('log_user_commission');
		$this->dropTable('log_user_commission');
    }
}
