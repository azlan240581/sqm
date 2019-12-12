<?php

use yii\db\Migration;

class m000007_000001_banks extends Migration
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
		$this->createTable("banks", array(
		"id" => "pk",
		"bank_name" => "varchar(255) NOT NULL",
		"company_name" => "varchar(255) DEFAULT NULL",
		"company_registration_no" => "varchar(100) DEFAULT NULL",
		"company_description" => "text DEFAULT NULL",
		"contact_person_name" => "varchar(255) DEFAULT NULL",
		"contact_person_email" => "varchar(255) DEFAULT NULL",
		"contact_person_contactno" => "varchar(255) DEFAULT NULL",
		"status" => "tinyint(1) DEFAULT 1",
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
		$this->truncateTable('banks');
		$this->dropTable('banks');
    }
}
