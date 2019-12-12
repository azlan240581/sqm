<?php

use yii\db\Migration;

class m000002_000004_lookup_marital_status extends Migration
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
		$this->createTable("lookup_marital_status", array(
		"id" => "pk",
		"name" => "varchar(100) NOT NULL",
		"deleted" => "tinyint(1) DEFAULT 0",
		), "ENGINE=InnoDB");
		
		$this->insert('lookup_marital_status',array(
					  'id'=>'1',
					  'name'=>'Single',
					  ));
		
		$this->insert('lookup_marital_status',array(
					  'id'=>'2',
					  'name'=>'Married',
					  ));
		
		$this->insert('lookup_marital_status',array(
					  'id'=>'3',
					  'name'=>'Widowed / Divorce',
					  ));
		
		$this->insert('lookup_marital_status',array(
					  'id'=>'4',
					  'name'=>'Others',
					  ));
    }

    public function safeDown()
    {
		$this->truncateTable('lookup_marital_status');
		$this->dropTable('lookup_marital_status');
    }
}
