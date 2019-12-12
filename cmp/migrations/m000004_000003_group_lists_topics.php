<?php

use yii\db\Migration;

class m000004_000003_group_lists_topics extends Migration
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
		$this->createTable("group_lists_topics", array(
		"id" => "pk",
		"topic_name" => "varchar(255) NOT NULL",
		"user_id" => "text DEFAULT NULL",
		"status" => "tinyint(1) NOT NULL DEFAULT 0",
		"createdby" => "int(11) NOT NULL",
		"createdat" => "datetime NOT NULL",
		"updatedby" => "int(11) DEFAULT NULL",
		"updatedat" => "datetime DEFAULT NULL",
		"deletedby" => "int(11) DEFAULT NULL",
		"deletedat" => "datetime DEFAULT NULL",
		), "ENGINE=InnoDB");
		
		$this->insert("group_lists_topics",array(
				"topic_name"=>"all",
				"status"=>"1",
				"createdby"=>"1",
				"createdat"=>date("Y-m-d H:i:s"),
			));
    }

    public function safeDown()
    {
		$this->truncateTable('group_lists_topics');
		$this->dropTable('group_lists_topics');
    }
}
