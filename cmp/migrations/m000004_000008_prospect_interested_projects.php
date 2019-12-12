<?php

use yii\db\Migration;

class m000004_000008_prospect_interested_projects extends Migration
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
		$this->createTable("prospect_interested_projects", array(
			"id" => "pk",
			"prospect_id" => "int(11) NOT NULL",
			"project_id" => "int(11) NOT NULL",
		), "ENGINE=InnoDB");
    }

    public function safeDown()
    {
		$this->truncateTable('prospect_interested_projects');
		$this->dropTable('prospect_interested_projects');
    }
}
