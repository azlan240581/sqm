<?php

use yii\db\Migration;

class m000007_000003_loan_applications extends Migration
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
		$this->createTable("loan_applications", array(
		"id" => "pk",
		"prospect_id" => "int(11) NOT NULL",
		"fullname" => "varchar(255) NOT NULL",
		"email" => "varchar(100) NOT NULL",
		"contact_number" => "varchar(100) NOT NULL",
		"nricpass" => "varchar(100) NOT NULL",
		"address" => "text NOT NULL",
		"dob" => "date NOT NULL",
		"job_type" => "int(11) NOT NULL",
		"monthly_income" => "decimal(20,4) NOT NULL",
		"bank_statement" => "varchar(255) NOT NULL",
		"identity_document" => "varchar(255) NOT NULL",
		"developer_id" => "int(11) NOT NULL",
		"project_id" => "int(11) NOT NULL",
		"product_type" => "int(11) NOT NULL",
		"property_address" => "text NOT NULL",
		"property_price" => "decimal(20,4) NOT NULL",
		"installment_period" => "int(11) NOT NULL",
		"downpayment_percentage" => "decimal(7,4) NOT NULL",
		"downpayment_amount" => "decimal(20,4) NOT NULL",
		"debt_amount" => "decimal(20,4) NOT NULL",
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
		$this->truncateTable('loan_applications');
		$this->dropTable('loan_applications');
    }
}
