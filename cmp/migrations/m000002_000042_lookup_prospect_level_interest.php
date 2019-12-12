<?php

use yii\db\Migration;

class m000002_000042_lookup_prospect_level_interest extends Migration
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
		$this->createTable("lookup_prospect_level_interest", array(
			"id" => "pk",
			"name" => "varchar(255) NOT NULL",
			"deleted" => "tinyint(1) DEFAULT 0",
		), "ENGINE=InnoDB");
		
		$this->insert('lookup_prospect_level_interest',array('name'=>'Low',));
		$this->insert('lookup_prospect_level_interest',array('name'=>'Medium',));
		$this->insert('lookup_prospect_level_interest',array('name'=>'High',));
    }

    public function safeDown()
    {
		$this->truncateTable('lookup_prospect_level_interest');
		$this->dropTable('lookup_prospect_level_interest');
    }
}
