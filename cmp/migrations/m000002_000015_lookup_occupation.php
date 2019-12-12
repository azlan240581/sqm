<?php

use yii\db\Migration;

class m000002_000015_lookup_occupation extends Migration
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
		$this->createTable("lookup_occupation", array(
		"id" => "pk",
		"name" => "varchar(100) NOT NULL",
		"deleted" => "tinyint(1) DEFAULT 0",
		), "ENGINE=InnoDB");
		
		$this->insert('lookup_occupation',array(
					  'id'=>'1',
					  'name'=>'Private Employee',
					  ));
		
		$this->insert('lookup_occupation',array(
					  'id'=>'2',
					  'name'=>'Government Employee',
					  ));
		
		$this->insert('lookup_occupation',array(
					  'id'=>'3',
					  'name'=>'Professionals',
					  ));
		
		$this->insert('lookup_occupation',array(
					  'id'=>'4',
					  'name'=>'Entreprenuer',
					  ));
		
		$this->insert('lookup_occupation',array(
					  'id'=>'5',
					  'name'=>'Housewife',
					  ));
		
		$this->insert('lookup_occupation',array(
					  'id'=>'6',
					  'name'=>'Traditional Broker',
					  ));
		
    }

    public function safeDown()
    {
		$this->truncateTable('lookup_occupation');
		$this->dropTable('lookup_occupation');
    }
}
