<?php

use yii\db\Migration;

class m000002_000033_lookup_collateral_media_types extends Migration
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
		$this->createTable("lookup_collateral_media_types", array(
		"id" => "pk",
		"name" => "varchar(100) NOT NULL",
		"deleted" => "tinyint(1) DEFAULT 0",
		), "ENGINE=InnoDB");
		
		$this->insert('lookup_collateral_media_types',array(
						  'id'=>'1',
						  'name'=>'Image',
					  ));
		
		$this->insert('lookup_collateral_media_types',array(
						  'id'=>'2',
						  'name'=>'Flyer',
					  ));
		
		$this->insert('lookup_collateral_media_types',array(
						  'id'=>'3',
						  'name'=>'Brochure',
					  ));
		
		$this->insert('lookup_collateral_media_types',array(
						  'id'=>'4',
						  'name'=>'Video',
					  ));
    }

    public function safeDown()
    {
		$this->truncateTable('lookup_collateral_media_types');
		$this->dropTable('lookup_collateral_media_types');
    }
}
