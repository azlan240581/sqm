<?php

use yii\db\Migration;

class m000002_000027_lookup_commission_type extends Migration
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
		$this->createTable("lookup_commission_type", array(
		"id" => "pk",
		"name" => "varchar(100) NOT NULL",
		"deleted" => "tinyint(1) DEFAULT 0",
		), "ENGINE=InnoDB");
		
		$this->insert('lookup_commission_type',array(
						  'id'=>'1',
						  'name'=>'Percentage',
					  ));
		
		$this->insert('lookup_commission_type',array(
						  'id'=>'2',
						  'name'=>'Amount',
					  ));
    }

    public function safeDown()
    {
		$this->truncateTable('lookup_commission_type');
		$this->dropTable('lookup_commission_type');
    }
}
