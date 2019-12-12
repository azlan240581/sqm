<?php

use yii\db\Migration;

class m000002_000005_lookup_points_actions extends Migration
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
		$this->createTable("lookup_points_actions", array(
		"id" => "pk",
		"name" => "varchar(100) NOT NULL",
		"deleted" => "tinyint(1) DEFAULT 0",
		), "ENGINE=InnoDB");
		
		$this->insert('lookup_points_actions',array(
					  'id'=>'1',
					  'name'=>'Pending',
					  ));
		
		$this->insert('lookup_points_actions',array(
					  'id'=>'2',
					  'name'=>'Received',
					  ));
		
		$this->insert('lookup_points_actions',array(
					  'id'=>'3',
					  'name'=>'Redeemed',
					  ));
		
		$this->insert('lookup_points_actions',array(
					  'id'=>'4',
					  'name'=>'Deduction',
					  ));
		
    }

    public function safeDown()
    {
		$this->truncateTable('lookup_points_actions');
		$this->dropTable('lookup_points_actions');
    }
}
