<?php

use yii\db\Migration;

class m000002_000017_lookup_payment_method extends Migration
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
		$this->createTable("lookup_payment_method", array(
		"id" => "pk",
		"name" => "varchar(100) NOT NULL",
		"deleted" => "tinyint(1) DEFAULT 0",
		), "ENGINE=InnoDB");
		
		$this->insert('lookup_payment_method',array(
					  'id'=>'1',
					  'name'=>'Cash',
					  ));
		
		$this->insert('lookup_payment_method',array(
					  'id'=>'2',
					  'name'=>'Credit Card',
					  ));
		
		$this->insert('lookup_payment_method',array(
					  'id'=>'3',
					  'name'=>'Debit Card',
					  ));
		
		$this->insert('lookup_payment_method',array(
					  'id'=>'4',
					  'name'=>'Bank Transfer',
					  ));
    }

    public function safeDown()
    {
		$this->truncateTable('lookup_payment_method');
		$this->dropTable('lookup_payment_method');
    }
}
