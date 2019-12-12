<?php

use yii\db\Migration;

class m000005_000013_project_product_unit_types extends Migration
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
		$this->createTable("project_product_unit_types", array(
		"id" => "pk",
		"project_id" => "int(11) NOT NULL",
		"project_product_id" => "int(11) NOT NULL",
		"type_name" => "varchar(255) NOT NULL",
		"building_size_sm" => "decimal(10,4) DEFAULT 0",
		"land_size_sm" => "decimal(10,4) DEFAULT 0",
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
		$this->truncateTable('project_product_unit_types');
		$this->dropTable('project_product_unit_types');
    }
}
