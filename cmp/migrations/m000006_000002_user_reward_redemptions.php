<?php

use yii\db\Migration;

class m000006_000002_user_reward_redemptions extends Migration
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
		$this->createTable("user_reward_redemptions", array(
		"id" => "pk",
		"reward_id" => "int(11) NOT NULL",
		"user_id" => "int(11) NOT NULL",
		"receiver_name" => "varchar(255) NOT NULL",
		"receiver_email" => "varchar(255) NOT NULL",
		"receiver_country_code" => "varchar(100) NOT NULL",
		"receiver_contact_no" => "varchar(100) NOT NULL",
		"address_1" => "varchar(255) NOT NULL",
		"address_2" => "varchar(255) DEFAULT NULL",
		"address_3" => "varchar(255) DEFAULT NULL",
		"city" => "varchar(255) NOT NULL",
		"postcode" => "varchar(255) NOT NULL",
		"state" => "varchar(255) NOT NULL",
		"country" => "varchar(255) NOT NULL",
		"courier_name" => "varchar(255) DEFAULT NULL",
		"tracking_number" => "varchar(255) DEFAULT NULL",
		"quantity" => "int(11) NOT NULL",
		"points_value" => "decimal(20,4) NOT NULL",
		"ticket_no" => "varchar(100) DEFAULT NULL",
		"ticket_expirary" => "date DEFAULT NULL",
		"status" => "int(11) NOT NULL",
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
		$this->truncateTable('user_reward_redemptions');
		$this->dropTable('user_reward_redemptions');
    }
}
