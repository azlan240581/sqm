<?php

use yii\db\Migration;

class m000002_000008_lookup_salutations extends Migration
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
		$this->createTable("lookup_salutations", array(
		"id" => "pk",
		"name" => "varchar(100) NOT NULL",
		"deleted" => "tinyint(1) DEFAULT 0",
		), "ENGINE=InnoDB");
		
		$this->insert('lookup_salutations',array(
						  'id'=>'1',
						  'name'=>'Mr',
					  ));
		$this->insert('lookup_salutations',array(
						  'id'=>'2',
						  'name'=>'Mrs',
					  ));
		$this->insert('lookup_salutations',array(
						  'id'=>'3',
						  'name'=>'Ms',
					  ));
		$this->insert('lookup_salutations',array(
						  'id'=>'4',
						  'name'=>'Miss',
					  ));
    }

    public function safeDown()
    {
		$this->truncateTable('lookup_salutations');
		$this->dropTable('lookup_salutations');
    }
}
