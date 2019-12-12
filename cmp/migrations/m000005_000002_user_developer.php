<?php

use yii\db\Migration;

class m000005_000002_user_developer extends Migration
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
		$this->createTable("user_developer", array(
		"id" => "pk",
		"developer_id" => "int(11) NOT NULL",
		"user_id" => "int(11) NOT NULL",
		), "ENGINE=InnoDB");
    }

    public function safeDown()
    {
		$this->truncateTable('user_developer');
		$this->dropTable('user_developer');
    }
}
