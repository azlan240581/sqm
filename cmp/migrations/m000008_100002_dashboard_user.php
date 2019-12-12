<?php

use yii\db\Migration;

class m000008_100002_dashboard_user extends Migration
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
		/*$this->createTable("dashboard_user", array(
		"id" => "pk",
		"user_id" => "int(11) NOT NULL",
		"total_normal" => "int(11) DEFAULT 0",
		"total_active" => "int(11) DEFAULT 0",
		"total_productive" => "int(11) DEFAULT 0",
		"total_new_prospect_registered" => "int(11) DEFAULT 0",
		"total_follow_up" => "int(11) DEFAULT 0",
		"total_appointment_scheduled" => "int(11) DEFAULT 0",
		"total_level_of_interest" => "int(11) DEFAULT 0",
		"total_waiting_booking_eoi_approval" => "int(11) DEFAULT 0",
		"total_eoi_rejected" => "int(11) DEFAULT 0",
		"total_eoi_verified" => "int(11) DEFAULT 0",
		"total_waiting_booking_approval" => "int(11) DEFAULT 0",
		"total_booking_rejected" => "int(11) DEFAULT 0",
		"total_booking_approved" => "int(11) DEFAULT 0",
		"total_waiting_booking_contract_signed_approval" => "int(11) DEFAULT 0",
		"total_contract_signed_rejected" => "int(11) DEFAULT 0",
		"total_contract_signed_approved" => "int(11) DEFAULT 0",
		"total_waiting_cancel_approved" => "int(11) DEFAULT 0",
		"total_cancel_rejected" => "int(11) DEFAULT 0",
		"total_cancel_approved" => "int(11) DEFAULT 0",
		"total_completed" => "int(11) DEFAULT 0",
		"total_drop" => "int(11) DEFAULT 0",
		), "ENGINE=InnoDB");*/
    }

    public function safeDown()
    {
		$this->truncateTable('dashboard_user');
		$this->dropTable('dashboard_user');
    }
}
