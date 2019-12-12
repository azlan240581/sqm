<?php

use yii\db\Migration;

class m000005_000003_developer_commission_paid extends Migration
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
		$this->createTable("developer_commission_paid", array(
		"id" => "pk",
		"developer_id" => "int(11) NOT NULL",
		"project_id" => "int(11) NOT NULL",
		"prospect_id" => "int(11) NOT NULL",
		"associate_id" => "int(11) NOT NULL",
		"agent_id" => "int(11) NOT NULL",
		"commission_amount" => "decimal(20,4) NOT NULL",
		"udf1" => "varchar(255) DEFAULT NULL",
		"udf2" => "varchar(255) DEFAULT NULL",
		"udf3" => "varchar(255) DEFAULT NULL",
		"status" => "tinyint(1) DEFAULT 1",
		"createdby" => "int(11) NOT NULL",
		"createdat" => "datetime NOT NULL",
		"updatedby" => "datetime DEFAULT NULL",
		"updatedat" => "varchar(50) DEFAULT NULL",
		"deletedby" => "int(11) DEFAULT NULL",
		"deletedat" => "datetime DEFAULT NULL",
		), "ENGINE=InnoDB");
    }

    public function safeDown()
    {
		$this->truncateTable('developer_commission_paid');
		$this->dropTable('developer_commission_paid');
    }
}
