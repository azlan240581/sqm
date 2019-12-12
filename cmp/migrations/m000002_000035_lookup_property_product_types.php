<?php

use yii\db\Migration;

class m000002_000035_lookup_property_product_types extends Migration
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
		$this->createTable("lookup_property_product_types", array(
		"id" => "pk",
		"name" => "varchar(100) NOT NULL",
		"deleted" => "tinyint(1) DEFAULT 0",
		), "ENGINE=InnoDB");
		
		$this->insert('lookup_property_product_types',array(
						  'id'=>'1',
						  'name'=>'Landed House',
					  ));
				
		$this->insert('lookup_property_product_types',array(
						  'id'=>'2',
						  'name'=>'Apartment / Condo',
					  ));
				
		$this->insert('lookup_property_product_types',array(
						  'id'=>'3',
						  'name'=>'Shop House',
					  ));
    }

    public function safeDown()
    {
		$this->truncateTable('lookup_property_product_types');
		$this->dropTable('lookup_property_product_types');
    }
}
