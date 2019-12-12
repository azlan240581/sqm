<?php

use yii\db\Migration;

class m000004_000007_prospects extends Migration
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
		$this->createTable("prospects", array(
			"id" => "pk",
			"agent_id" => "int(11) NOT NULL",
			"member_id" => "int(11) NOT NULL",
			"prospect_name" => "varchar(255) NOT NULL",
			"prospect_email" => "varchar(255) NOT NULL",
			"prospect_contact_number" => "varchar(255) NOT NULL",
			"prospect_purpose_of_buying" => "int(11) DEFAULT NULL",
			"how_prospect_know_us" => "int(11) DEFAULT NULL",
			"prospect_age" => "varchar(50) DEFAULT NULL",
			"prospect_dob" => "date DEFAULT NULL",
			"prospect_marital_status" => "int(11) DEFAULT NULL",
			"prospect_occupation" => "int(11) DEFAULT NULL",
			"prospect_domicile" => "int(11) DEFAULT NULL",
			"prospect_identity_document" => "varchar(255) DEFAULT NULL",
			"tax_license" => "varchar(255) DEFAULT NULL",
			"remarks" => "text DEFAULT NULL",
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
		$this->truncateTable('prospects');
		$this->dropTable('prospects');
    }
}
