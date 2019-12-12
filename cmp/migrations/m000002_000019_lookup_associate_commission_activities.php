<?php

use yii\db\Migration;

class m000002_000019_lookup_associate_commission_activities extends Migration
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
		$this->createTable("lookup_associate_commission_activities", array(
		"id" => "pk",
		"name" => "varchar(100) NOT NULL",
		"deleted" => "tinyint(1) DEFAULT 0",
		), "ENGINE=InnoDB");
		
		$this->insert('lookup_associate_commission_activities',array(
						  'id'=>'1',
						  'name'=>'Deduction',
					  ));
		
		$this->insert('lookup_associate_commission_activities',array(
						  'id'=>'2',
						  'name'=>'Prospect to buyer',
					  ));
    }

    public function safeDown()
    {
		$this->truncateTable('lookup_associate_commission_activities');
		$this->dropTable('lookup_associate_commission_activities');
    }
}
