<?php

use yii\db\Migration;

class m000002_000026_lookup_commission_tier extends Migration
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
		$this->createTable("lookup_commission_tier", array(
		"id" => "pk",
		"name" => "varchar(100) NOT NULL",
		"deleted" => "tinyint(1) DEFAULT 0",
		), "ENGINE=InnoDB");
		
		$this->insert('lookup_commission_tier',array(
						  'id'=>'1',
						  'name'=>'Silver',
					  ));
		
		$this->insert('lookup_commission_tier',array(
						  'id'=>'2',
						  'name'=>'Gold',
					  ));
		
		$this->insert('lookup_commission_tier',array(
						  'id'=>'3',
						  'name'=>'Platinum',
					  ));
    }

    public function safeDown()
    {
		$this->truncateTable('lookup_commission_tier');
		$this->dropTable('lookup_commission_tier');
    }
}
