<?php

use yii\db\Migration;

class m000007_000004_bank_loan_proposals extends Migration
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
		$this->createTable("bank_loan_proposals", array(
		"id" => "pk",
		"bank_id" => "int(11) NOT NULL",
		"loan_application_id" => "int(11) NOT NULL",
		"interest_rate" => "decimal(7,4) DEFAULT NULL",
		"floating_rate" => "decimal(7,4) DEFAULT NULL",
		"debt_period" => "int(11) DEFAULT NULL",
		"monthly_amount" => "decimal(20,4) DEFAULT NULL",
		"status" => "int(11) NOT NULL",
		"createdby" => "int(11) NOT NULL",
		"createdat" => "datetime NOT NULL",
		"updatedby" => "int(11) DEFAULT NULL",
		"updatedat" => "datetime DEFAULT NULL",
		), "ENGINE=InnoDB");
    }

    public function safeDown()
    {
		$this->truncateTable('bank_loan_proposals');
		$this->dropTable('bank_loan_proposals');
    }
}
