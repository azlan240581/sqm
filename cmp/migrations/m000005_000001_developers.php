<?php

use yii\db\Migration;

class m000005_000001_developers extends Migration
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
		$this->createTable("developers", array(
		"id" => "pk",
		"company_name" => "varchar(100) NOT NULL",
		"company_registration_no" => "varchar(50) DEFAULT NULL",
		"contact_person_name" => "varchar(100) DEFAULT NULL",
		"contact_person_email" => "varchar(100) DEFAULT NULL",
		"contact_person_contactno" => "varchar(100) DEFAULT NULL",
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
		$this->truncateTable('developers');
		$this->dropTable('developers');
    }
}
