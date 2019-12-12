<?php

use yii\db\Migration;

class m000007_000002_user_bank extends Migration
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
		$this->createTable("user_bank", array(
		"id" => "pk",
		"bank_id" => "int(11) NOT NULL",
		"user_id" => "int(11) NOT NULL",
		), "ENGINE=InnoDB");
    }

    public function safeDown()
    {
		$this->truncateTable('user_bank');
		$this->dropTable('user_bank');
    }
}
