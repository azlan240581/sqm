<?php

use yii\db\Migration;

class m000005_000010_property_products extends Migration
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
		$this->createTable("property_products", array(
		"id" => "pk",
		"project_id" => "int(11) NOT NULL",
		"project_product_id" => "int(11) NOT NULL",
		"property_type_id" => "int(11) NOT NULL",
		"title" => "varchar(255) NOT NULL",
		"permalink" => "varchar(255) NOT NULL",
		"summary" => "text DEFAULT NULL",
		"description" => "longtext DEFAULT NULL",
		"thumb_image" => "varchar(255) DEFAULT NULL",
		"product_type" => "int(11) DEFAULT NULL",
		"address" => "varchar(255) DEFAULT NULL",
		"latitude" => "varchar(50) DEFAULT NULL",
		"longitude" => "varchar(50) DEFAULT NULL",
		"price" => "decimal(20,4) DEFAULT 0",
		"building_size" => "decimal(10,4) DEFAULT 0",
		"land_size" => "decimal(10,4) DEFAULT 0",
		"total_floor" => "int(11) DEFAULT 0",
		"bedroom" => "int(11) DEFAULT 0",
		"bathroom" => "int(11) DEFAULT 0",
		"parking_lot" => "int(11) DEFAULT 0",
		"collaterals_id" => "varchar(100) DEFAULT NULL",
		"published_date_start" => "datetime NOT NULL",
		"published_date_end" => "datetime DEFAULT NULL",
		"total_viewed" => "int(11) DEFAULT 0",
		"status" => "int(11) NOT NULL",
		"createdby" => "int(11) NOT NULL",
		"createdat" => "datetime NOT NULL",
		"updatedby" => "int(11) DEFAULT NULL",
		"updatedat" => "datetime DEFAULT NULL",
		"deletedby" => "int(11) DEFAULT NULL",
		"deletedat" => "datetime DEFAULT NULL",
		), "ENGINE=InnoDB");

    }

    public function safeDown()
    {
		$this->truncateTable('property_products');
		$this->dropTable('property_products');
    }
}
