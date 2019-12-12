<?php

use yii\db\Migration;

class m000008_000013_log_loan_application extends Migration
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
		$this->createTable("log_loan_application", array(
		"id" => "pk",
		"loan_application_id" => "int(11) NOT NULL",
		"remarks" => "text DEFAULT NULL",
		"status" => "int(11) NOT NULL",
		"createdby" => "int(11) NOT NULL",
		"createdat" => "datetime NOT NULL",
		), "ENGINE=InnoDB");
    }

    public function safeDown()
    {
		$this->truncateTable('log_loan_application');
		$this->dropTable('log_loan_application');
    }
}
