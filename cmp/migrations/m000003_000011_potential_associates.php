<?php

use yii\db\Migration;

class m000003_000011_potential_associates extends Migration
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
		$this->createTable("potential_associates", array(
		"id" => "pk",
		"inviter_id" => "int(11) NOT NULL",
		"name" => "varchar(100) DEFAULT NULL",
		"email" => "varchar(100) DEFAULT NULL",
		"contactno" => "varchar(100) DEFAULT NULL",
		"status" => "tinyint(1) DEFAULT 0",
		"register_at" => "datetime DEFAULT NULL",
		"user_id" => "int(11) DEFAULT NULL",
		"createdat" => "datetime NOT NULL",
		), "ENGINE=InnoDB");
    }

    public function safeDown()
    {
		$this->truncateTable('potential_associates');
		$this->dropTable('potential_associates');
    }
}
