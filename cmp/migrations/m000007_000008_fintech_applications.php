<?php

use yii\db\Migration;

class m000007_000008_fintech_applications extends Migration
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
		$this->createTable("fintech_applications", array(
		"id" => "pk",
		"fintech_id" => "int(11) NOT NULL",
		"package_id" => "int(11) NOT NULL",
		"prospect_id" => "int(11) NOT NULL",
		"project_id" => "int(11) NOT NULL",
		"developer_id" => "int(11) NOT NULL",
		"tax_payer" => "varchar(255) NOT NULL",
		"payslip" => "varchar(255) NOT NULL",
		"bank_statement" => "varchar(255) NOT NULL",
		"status" => "int(11) NOT NULL",
		"createdby" => "int(11) NOT NULL",
		"createdby" => "datetime NOT NULL",
		"updatedby" => "int(11) DEFAULT NULL",
		"updatedby" => "datetime DEFAULT NULL",
		"deletedby" => "int(11) DEFAULT NULL",
		"deletedby" => "datetime DEFAULT NULL",
		), "ENGINE=InnoDB");
    }

    public function safeDown()
    {
		$this->truncateTable('fintech_applications');
		$this->dropTable('fintech_applications');
    }
}
