<?php

use yii\db\Migration;

class m000002_000021_lookup_purpose_of_buying extends Migration
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
		$this->createTable("lookup_purpose_of_buying", array(
		"id" => "pk",
		"name" => "varchar(100) NOT NULL",
		"deleted" => "tinyint(1) DEFAULT 0",
		), "ENGINE=InnoDB");
		
		$this->insert('lookup_purpose_of_buying',array(
					  'id'=>'1',
					  'name'=>'Living',
					  ));
		
		$this->insert('lookup_purpose_of_buying',array(
					  'id'=>'2',
					  'name'=>'Investment',
					  ));
		
    }

    public function safeDown()
    {
		$this->truncateTable('lookup_purpose_of_buying');
		$this->dropTable('lookup_purpose_of_buying');
    }
}
