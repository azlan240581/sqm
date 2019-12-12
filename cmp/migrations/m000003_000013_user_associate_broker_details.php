<?php

use yii\db\Migration;

class m000003_000013_user_associate_broker_details extends Migration
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
		$this->createTable("user_associate_broker_details", array(
		"id" => "pk",
		"user_id" => "int(11) NOT NULL",
		"company_name" => "varchar(100) NOT NULL",
		"brand_name" => "varchar(100) NOT NULL",
		"akta_perusahaan" => "varchar(255) NOT NULL",
		"nib" => "varchar(255) NOT NULL",
		"sk_menkeh" => "varchar(255) NOT NULL",
		"npwp" => "varchar(255) NOT NULL",
		"ktp_direktur" => "varchar(255) NOT NULL",
		"bank_account" => "varchar(255) NOT NULL",
		"credits" => "decimal(20,4) DEFAULT 0",
		"createdby" => "int(11) NOT NULL",
		"createdat" => "datetime NOT NULL",
		"updatedby" => "int(11) DEFAULT NULL",
		"updatedat" => "datetime DEFAULT NULL",
		), "ENGINE=InnoDB");
    }

    public function safeDown()
    {
		$this->truncateTable('user_associate_broker_details');
		$this->dropTable('user_associate_broker_details');
    }
}
