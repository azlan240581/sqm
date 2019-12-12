<?php

use yii\db\Migration;

class m000002_000028_lookup_user_commission_status extends Migration
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
		$this->createTable("lookup_user_commission_status", array(
		"id" => "pk",
		"name" => "varchar(100) NOT NULL",
		"deleted" => "tinyint(1) DEFAULT 0",
		), "ENGINE=InnoDB");
		
		$this->insert('lookup_user_commission_status',array(
						  'id'=>'1',
						  'name'=>'Pending',
					  ));
		
		$this->insert('lookup_user_commission_status',array(
						  'id'=>'2',
						  'name'=>'Cancelled',
					  ));
		
		$this->insert('lookup_user_commission_status',array(
						  'id'=>'3',
						  'name'=>'Claiming',
					  ));
		
		$this->insert('lookup_user_commission_status',array(
						  'id'=>'4',
						  'name'=>'Fully Claimed',
					  ));
    }

    public function safeDown()
    {
		$this->truncateTable('lookup_user_commission_status');
		$this->dropTable('lookup_user_commission_status');
    }
}
