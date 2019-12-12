<?php

use yii\db\Migration;

class m000008_000011_log_prospect_history extends Migration
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
		$this->createTable("log_prospect_history", array(
		"id" => "pk",
		"project_id" => "int(11) NOT NULL",
		"prospect_id" => "int(11) NOT NULL",
		"prospect_booking_id" => "int(11) DEFAULT NULL",
		"history_id" => "int(11) NOT NULL",
		"appointment_at" => "datetime DEFAULT NULL",
		"appointment_location" => "varchar(255) DEFAULT NULL",
		"level_of_interest" => "tinyint(1) DEFAULT 1", //1-Low,2-Medium,3-High
		"site_visit" => "tinyint(1) DEFAULT 0", //1-yes,0-no
		"udf1" => "varchar(255) DEFAULT NULL",
		"udf2" => "varchar(255) DEFAULT NULL",
		"udf3" => "varchar(255) DEFAULT NULL",
		"remarks" => "varchar(500) DEFAULT NULL",
		"createdby" => "int(11) NOT NULL",
		"createdat" => "datetime NOT NULL",
		), "ENGINE=InnoDB");
    }

    public function safeDown()
    {
		$this->truncateTable('log_prospect_history');
		$this->dropTable('log_prospect_history');
    }
}
