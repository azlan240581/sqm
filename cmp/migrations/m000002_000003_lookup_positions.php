<?php

use yii\db\Migration;

class m000002_000003_lookup_positions extends Migration
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
		$this->createTable("lookup_positions", array(
		"id" => "pk",
		"name" => "varchar(100) NOT NULL",
		"deleted" => "tinyint(1) DEFAULT 0",
		), "ENGINE=InnoDB");
		
		$this->insert('lookup_positions',array(
					  'id'=>'1',
					  'name'=>'SQM Account Manager',
					  ));
		
		$this->insert('lookup_positions',array(
					  'id'=>'2',
					  'name'=>'Associate Broker',
					  ));
		
		$this->insert('lookup_positions',array(
					  'id'=>'3',
					  'name'=>'SQM Account Executive',
					  ));
		
		$this->insert('lookup_positions',array(
					  'id'=>'4',
					  'name'=>'Associate Broker Assistant',
					  ));
    }

    public function safeDown()
    {
		$this->truncateTable('lookup_positions');
		$this->dropTable('lookup_positions');
    }
}
