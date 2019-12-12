<?php

use yii\db\Migration;

class m000007_000012_user_eligible_commissions extends Migration
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
		$this->createTable("user_eligible_commissions", array(
		"id" => "pk",
		"user_commission_id" => "int(11) NOT NULL",
		"prospect_booking_id" => "int(11) NOT NULL",
		"user_id" => "int(11) NOT NULL",
		"commission_eligible_amount" => "decimal(20,4) NOT NULL",
		"status" => "tinyint(1) DEFAULT 0",
		"createdby" => "int(11) NOT NULL",
		"createdat" => "datetime NOT NULL",
		"updatedby" => "int(11) DEFAULT NULL",
		"updatedat" => "datetime DEFAULT NULL",
		"deletedby" => "int(11) DEFAULT NULL",
		"deletedat" => "datetime DEFAULT NULL",
		), "ENGINE=InnoDB");
    }

    public function safeDown()
    {
		$this->truncateTable('user_eligible_commissions');
		$this->dropTable('user_eligible_commissions');
    }
}
