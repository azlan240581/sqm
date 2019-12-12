<?php

use yii\db\Migration;

class m000008_000006_log_user_reward_redemptions extends Migration
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
		$this->createTable("log_user_reward_redemptions", array(
		"id" => "pk",
		"user_id" => "int(11) NOT NULL",
		"reward_id" => "int(11) NOT NULL",
		"associate_reward_redemption_id" => "int(11) NOT NULL",
		"points_value" => "decimal(10,4) NOT NULL",
		"ticket_no" => "varchar(100) DEFAULT NULL",
		"status" => "int(11) NOT NULL",
		"remarks" => "text DEFAULT NULL",
		"createdby" => "int(11) NOT NULL",
		"createdat" => "datetime NOT NULL",
		), "ENGINE=InnoDB");
    }

    public function safeDown()
    {
		$this->truncateTable('log_user_reward_redemptions');
		$this->dropTable('log_user_reward_redemptions');
    }
}
