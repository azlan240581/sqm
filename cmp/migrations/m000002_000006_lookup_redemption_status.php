<?php

use yii\db\Migration;

class m000002_000006_lookup_redemption_status extends Migration
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
		$this->createTable("lookup_redemption_status", array(
		"id" => "pk",
		"name" => "varchar(100) NOT NULL",
		"deleted" => "tinyint(1) DEFAULT 0",
		), "ENGINE=InnoDB");
		
		$this->insert('lookup_redemption_status',array(
					  'id'=>'1',
					  'name'=>'Pending',
					  ));
		
		$this->insert('lookup_redemption_status',array(
					  'id'=>'2',
					  'name'=>'Canceled',
					  ));
		
		$this->insert('lookup_redemption_status',array(
					  'id'=>'3',
					  'name'=>'Redeemed',
					  ));
    }

    public function safeDown()
    {
		$this->truncateTable('lookup_redemption_status');
		$this->dropTable('lookup_redemption_status');
    }
}
