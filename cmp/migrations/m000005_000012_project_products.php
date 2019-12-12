<?php

use yii\db\Migration;

class m000005_000012_project_products extends Migration
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
		$this->createTable("project_products", array(
		"id" => "pk",
		"project_id" => "int(11) NOT NULL",
		"product_name" => "varchar(255) NOT NULL",
		"product_tier" => "int(11) NOT NULL",
		"product_type_id" => "int(11) NOT NULL",
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
		$this->truncateTable('project_products');
		$this->dropTable('project_products');
    }
}
