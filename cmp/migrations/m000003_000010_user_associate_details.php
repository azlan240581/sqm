<?php

use yii\db\Migration;

class m000003_000010_user_associate_details extends Migration
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
		$this->createTable("user_associate_details", array(
		"id" => "pk",
		"user_id" => "int(11) NOT NULL",
		"referrer_id" => "int(11) DEFAULT NULL",
		"agent_id" => "int(11) NOT NULL",
		"assistant_id" => "int(11) DEFAULT NULL",
		"assistant_approval" => "tinyint(1) DEFAULT 0",
		"agent_approval" => "tinyint(1) DEFAULT 0",
		"admin_approval" => "tinyint(1) DEFAULT 0",
		"approval_status" => "int(11) NOT NULL",
		"productivity_status" => "int(11) DEFAULT 1",
		"id_number" => "varchar(255) DEFAULT NULL",
		"tax_license_number" => "varchar(255) DEFAULT NULL",
		"bank_id" => "int(11) DEFAULT NULL",
		"account_name" => "varchar(100) DEFAULT NULL",
		"account_number" => "varchar(100) DEFAULT NULL",
		"domicile" => "varchar(255) DEFAULT NULL",
		"occupation" => "varchar(255) DEFAULT NULL",
		"industry_background" => "varchar(255) DEFAULT NULL",
		"nricpass" => "varchar(255) DEFAULT NULL",
		"tax_license" => "varchar(255) DEFAULT NULL",
		"bank_account" => "varchar(255) DEFAULT NULL",
		"udf1" => "varchar(255) DEFAULT NULL",
		"udf2" => "varchar(255) DEFAULT NULL",
		"udf3" => "varchar(255) DEFAULT NULL",
		"udf4" => "varchar(255) DEFAULT NULL",
		"udf5" => "varchar(255) DEFAULT NULL",
		), "ENGINE=InnoDB");
    }

    public function safeDown()
    {
		$this->truncateTable('user_associate_details');
		$this->dropTable('user_associate_details');
    }
}
