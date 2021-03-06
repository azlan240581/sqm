<?php

use yii\db\Migration;

class m000004_000002_user_points extends Migration
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
		$this->createTable("user_points", array(
		"id" => "pk",
		"user_id" => "int(11) NOT NULL",
		"total_points_value" => "decimal(20,4) NOT NULL",
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
		$this->truncateTable('user_points');
		$this->dropTable('user_points');
    }
}
