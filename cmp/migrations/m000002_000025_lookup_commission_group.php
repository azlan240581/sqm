<?php

use yii\db\Migration;

class m000002_000025_lookup_commission_group extends Migration
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
		$this->createTable("lookup_commission_group", array(
		"id" => "pk",
		"name" => "varchar(100) NOT NULL",
		"deleted" => "tinyint(1) DEFAULT 0",
		), "ENGINE=InnoDB");
		
		$this->insert('lookup_commission_group',array(
						  'id'=>'1',
						  'name'=>'SQM Account Manager',
					  ));
		
		$this->insert('lookup_commission_group',array(
						  'id'=>'2',
						  'name'=>'Associate Broker',
					  ));
		
		$this->insert('lookup_commission_group',array(
						  'id'=>'3',
						  'name'=>'SQM Associate',
					  ));
		
		$this->insert('lookup_commission_group',array(
						  'id'=>'4',
						  'name'=>'Virtual SQM Associate',
					  ));
		
		$this->insert('lookup_commission_group',array(
						  'id'=>'5',
						  'name'=>'Dedicated SQM Account Manager X Source SQM Account Manager',
					  ));
		
		$this->insert('lookup_commission_group',array(
						  'id'=>'6',
						  'name'=>'Dedicated SQM Account Manager X Source Associate Broker',
					  ));
		
		$this->insert('lookup_commission_group',array(
						  'id'=>'7',
						  'name'=>'Associate Referrer',
					  ));
    }

    public function safeDown()
    {
		$this->truncateTable('lookup_commission_group');
		$this->dropTable('lookup_commission_group');
    }
}
