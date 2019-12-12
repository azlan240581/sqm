<?php

use yii\db\Migration;

class m000006_000001_rewards extends Migration
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
		$this->createTable("rewards", array(
		"id" => "pk",
		"category_id" => "int(11) NOT NULL",
		"name" => "varchar(255) NOT NULL",
		"summary" => "text DEFAULT NULL",
		"description" => "longtext DEFAULT NULL",
		"quantity" => "int(11) DEFAULT 0",
		"minimum_quantity" => "int(11) DEFAULT 0",
		"points" => "decimal(20,4) NOT NULL DEFAULT 0",
		"images" => "text NOT NULL",
		"url" => "varchar(255) DEFAULT NULL",
		"rule_expirary_in_days" => "int(11) DEFAULT 0",
		"published_date_start" => "datetime NOT NULL",
		"published_date_end" => "datetime DEFAULT NULL",
		"total_viewed" => "int(11) NOT NULL DEFAULT 0",
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
		$this->truncateTable('rewards');
		$this->dropTable('rewards');
    }
}
