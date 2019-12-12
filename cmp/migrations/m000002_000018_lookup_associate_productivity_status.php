<?php

use yii\db\Migration;

class m000002_000018_lookup_associate_productivity_status extends Migration
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
		$this->createTable("lookup_associate_productivity_status", array(
		"id" => "pk",
		"name" => "varchar(100) NOT NULL",
		"deleted" => "tinyint(1) DEFAULT 0",
		), "ENGINE=InnoDB");
		
		$this->insert('lookup_associate_productivity_status',array(
					  'id'=>'1',
					  'name'=>'Normal',
					  ));
		
		$this->insert('lookup_associate_productivity_status',array(
					  'id'=>'2',
					  'name'=>'Active',
					  ));
		
		$this->insert('lookup_associate_productivity_status',array(
					  'id'=>'3',
					  'name'=>'Productive',
					  ));
		
    }

    public function safeDown()
    {
		$this->truncateTable('lookup_associate_productivity_status');
		$this->dropTable('lookup_associate_productivity_status');
    }
}
