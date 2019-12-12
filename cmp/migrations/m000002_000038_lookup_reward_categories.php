<?php

use yii\db\Migration;

class m000002_000038_lookup_reward_categories extends Migration
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
		$this->createTable("lookup_reward_categories", array(
			"id" => "pk",
			"name" => "varchar(255) NOT NULL",
			"deleted" => "tinyint(1) DEFAULT 0",
		), "ENGINE=InnoDB");
		
		$this->insert('lookup_reward_categories',array(
						  'name'=>'Beauty & Fashion',
					  ));
		$this->insert('lookup_reward_categories',array(
						  'name'=>'Food & Beverages',
					  ));
		$this->insert('lookup_reward_categories',array(
						  'name'=>'Lifestyle',
					  ));
		$this->insert('lookup_reward_categories',array(
						  'name'=>'Merchandise',
					  ));
		$this->insert('lookup_reward_categories',array(
						  'name'=>'Movies',
					  ));
		$this->insert('lookup_reward_categories',array(
						  'name'=>'Tech & Gadgets',
					  ));
    }

    public function safeDown()
    {
		$this->truncateTable('lookup_reward_categories');
		$this->dropTable('lookup_reward_categories');
    }
}
