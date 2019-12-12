<?php

use yii\db\Migration;

class m000002_000034_lookup_media_types extends Migration
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
		$this->createTable("lookup_media_types", array(
		"id" => "pk",
		"name" => "varchar(100) NOT NULL",
		"deleted" => "tinyint(1) DEFAULT 0",
		), "ENGINE=InnoDB");
		
		$this->insert('lookup_media_types',array(
						  'id'=>'1',
						  'name'=>'Image',
					  ));
				
		$this->insert('lookup_media_types',array(
						  'id'=>'2',
						  'name'=>'Video',
					  ));
    }

    public function safeDown()
    {
		$this->truncateTable('lookup_media_types');
		$this->dropTable('lookup_media_types');
    }
}
