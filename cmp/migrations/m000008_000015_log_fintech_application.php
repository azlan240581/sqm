<?php

use yii\db\Migration;

class m000008_000015_log_fintech_application extends Migration
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
		$this->createTable("log_fintech_application", array(
		"id" => "pk",
		"fintech_application_id" => "int(11) NOT NULL",
		"fintech_id" => "int(11) NOT NULL",
		"package_id" => "int(11) NOT NULL",
		"prospect_id" => "int(11) NOT NULL",
		"developer_id" => "int(11) NOT NULL",
		"project_id" => "int(11) NOT NULL",
		"status" => "int(11) NOT NULL",
		"remarks" => "text DEFAULT NULL",
		"createdby" => "int(11) NOT NULL",
		"createdat" => "datetime NOT NULL",
		), "ENGINE=InnoDB");
    }

    public function safeDown()
    {
		$this->truncateTable('log_fintech_application');
		$this->dropTable('log_fintech_application');
    }
}
