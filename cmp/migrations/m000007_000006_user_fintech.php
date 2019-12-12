<?php

use yii\db\Migration;

class m000007_000006_user_fintech extends Migration
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
		$this->createTable("user_fintech", array(
		"id" => "pk",
		"fintech_id" => "int(11) NOT NULL",
		"user_id" => "int(11) NOT NULL",
		), "ENGINE=InnoDB");
    }

    public function safeDown()
    {
		$this->truncateTable('user_fintech');
		$this->dropTable('user_fintech');
    }
}
