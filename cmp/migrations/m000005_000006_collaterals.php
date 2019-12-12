<?php

use yii\db\Migration;

class m000005_000006_collaterals extends Migration
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
		$this->createTable("collaterals", array(
		"id" => "pk",
		"project_id" => "int(11) NOT NULL",
		"title" => "varchar(255) NOT NULL",
		"permalink" => "varchar(255) NOT NULL",
		"summary" => "text DEFAULT NULL",
		"description" => "longtext DEFAULT NULL",
		"thumb_image" => "varchar(255) DEFAULT NULL",
		"published_date_start" => "datetime NOT NULL",
		"published_date_end" => "datetime DEFAULT NULL",
		"sort" => "int(11) DEFAULT 0",
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
		$this->truncateTable('collaterals');
		$this->dropTable('collaterals');
    }
}
