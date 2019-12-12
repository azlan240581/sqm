<?php

use yii\db\Migration;

class m000002_000023_lookup_downpayment_paid_status extends Migration
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
		$this->createTable("lookup_downpayment_paid_status", array(
		"id" => "pk",
		"name" => "varchar(100) NOT NULL",
		"deleted" => "tinyint(1) DEFAULT 0",
		), "ENGINE=InnoDB");
		
		$this->insert('lookup_downpayment_paid_status',array(
						  'id'=>'1',
						  'name'=>'Pending',
					  ));
		
		$this->insert('lookup_downpayment_paid_status',array(
						  'id'=>'2',
						  'name'=>'Rejected',
					  ));
		
		$this->insert('lookup_downpayment_paid_status',array(
						  'id'=>'3',
						  'name'=>'Approved',
					  ));
    }

    public function safeDown()
    {
		$this->truncateTable('lookup_downpayment_paid_status');
		$this->dropTable('lookup_downpayment_paid_status');
    }
}
