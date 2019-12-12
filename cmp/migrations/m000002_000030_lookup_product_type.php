<?php

use yii\db\Migration;

class m000002_000030_lookup_product_type extends Migration
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
		$this->createTable("lookup_product_type", array(
		"id" => "pk",
		"name" => "varchar(100) NOT NULL",
		"deleted" => "tinyint(1) DEFAULT 0",
		), "ENGINE=InnoDB");
		
		$this->insert('lookup_product_type',array(
						  'id'=>'1',
						  'name'=>'Primary',
					  ));
		
		$this->insert('lookup_product_type',array(
						  'id'=>'2',
						  'name'=>'Secondary',
					  ));
    }

    public function safeDown()
    {
		$this->truncateTable('lookup_product_type');
		$this->dropTable('lookup_product_type');
    }
}
