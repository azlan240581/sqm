<?php

use yii\db\Migration;

class m000008_000014_log_bank_loan_proposal extends Migration
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
		$this->createTable("log_bank_loan_proposal", array(
		"id" => "pk",
		"bank_loan_proposal_id" => "int(11) NOT NULL",
		"bank_id" => "int(11) NOT NULL",
		"loan_application_id" => "int(11) NOT NULL",
		"remarks" => "text DEFAULT NULL",
		"status" => "int(11) NOT NULL",
		"createdby" => "int(11) NOT NULL",
		"createdat" => "datetime NOT NULL",
		), "ENGINE=InnoDB");
    }

    public function safeDown()
    {
		$this->truncateTable('log_bank_loan_proposal');
		$this->dropTable('log_bank_loan_proposal');
    }
}
