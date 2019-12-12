<?php

use yii\db\Migration;

class m000005_000004_projects extends Migration
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
		$this->createTable("projects", array(
		"id" => "pk",
		"developer_id" => "int(11) NOT NULL",
		"project_name" => "varchar(255) NOT NULL",
		"project_description" => "text DEFAULT NULL",
		"thumb_image" => "varchar(255) DEFAULT NULL",
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
		$this->truncateTable('projects');
		$this->dropTable('projects');
    }
}
