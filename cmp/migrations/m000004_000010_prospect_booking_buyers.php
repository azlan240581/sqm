<?php

use yii\db\Migration;

class m000004_000010_prospect_booking_buyers extends Migration
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
		$this->createTable("prospect_booking_buyers", array(
			"id" => "pk",
			"prospect_id" => "int(11) NOT NULL",
			"prospect_booking_id" => "int(11) NOT NULL",
			"buyer_firstname" => "varchar(255) NOT NULL",
			"buyer_lastname" => "varchar(255) NOT NULL",
			"buyer_email" => "varchar(255) DEFAULT NULL",
			"buyer_contact_number" => "varchar(100) DEFAULT NULL",
		), "ENGINE=InnoDB");
    }

    public function safeDown()
    {
		$this->truncateTable('prospect_booking_buyers');
		$this->dropTable('prospect_booking_buyers');
    }
}
