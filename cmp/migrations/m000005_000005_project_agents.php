<?php

use yii\db\Migration;

class m000005_000005_project_agents extends Migration
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
		$this->createTable("project_agents", array(
		"id" => "pk",
		"project_id" => "int(11) NOT NULL",
		"agent_id" => "int(11) NOT NULL",
		), "ENGINE=InnoDB");
		
    }

    public function safeDown()
    {
		$this->truncateTable('project_agents');
		$this->dropTable('project_agents');
    }
}
