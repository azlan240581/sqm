<?php

use yii\db\Migration;

class m000008_000009_log_product_approval extends Migration
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
		$this->createTable("log_product_approval", array(
		"id" => "pk",
		"product_id" => "int(11) NOT NULL",
		"status" => "int(11) NOT NULL",
		"remarks" => "varchar(255) DEFAULT NULL",
		"createdby" => "int(11) NOT NULL",
		"createdat" => "datetime NOT NULL",
		), "ENGINE=InnoDB");
				
    }

    public function safeDown()
    {
		$this->truncateTable('log_product_approval');
		$this->dropTable('log_product_approval');
    }
}
