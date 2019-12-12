<?php

use yii\db\Migration;

class m000007_000009_fintech_paid_developer extends Migration
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
		$this->createTable("fintech_paid_developer", array(
		"id" => "pk",
		"fintech_id" => "int(11) NOT NULL",
		"fintech_application_id" => "int(11) NOT NULL",
		"developer_id" => "int(11) NOT NULL",
		"project_id" => "int(11) NOT NULL",
		"prospect_id" => "int(11) NOT NULL",
		"paid_date" => "date NOT NULL",
		"paid_amount" => "decimal(20,4) NOT NULL",
		"udf1" => "varchar(255) DEFAULT NULL",
		"udf2" => "varchar(255) DEFAULT NULL",
		"udf3" => "varchar(255) DEFAULT NULL",
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
		$this->truncateTable('fintech_paid_developer');
		$this->dropTable('fintech_paid_developer');
    }
}
