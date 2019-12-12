<?php

use yii\db\Migration;

class m000002_000036_lookup_banner_categories extends Migration
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
		$this->createTable("lookup_banner_categories", array(
		"id" => "pk",
		"name" => "varchar(100) NOT NULL",
		"deleted" => "tinyint(1) DEFAULT 0",
		), "ENGINE=InnoDB");
		
		$this->insert('lookup_banner_categories',array(
						  'name'=>'Introduction',
					  ));
		
		$this->insert('lookup_banner_categories',array(
						  'name'=>'Highlights',
					  ));
		
		$this->insert('lookup_banner_categories',array(
						  'name'=>'Footer',
						  'deleted'=>1,
					  ));
    }

    public function safeDown()
    {
		$this->truncateTable('lookup_banner_categories');
		$this->dropTable('lookup_banner_categories');
    }
}
