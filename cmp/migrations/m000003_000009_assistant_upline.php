<?php

use yii\db\Migration;

class m000003_000009_assistant_upline extends Migration
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
		$this->createTable("assistant_upline", array(
		"id" => "pk",
		"upline_id" => "int(11) NOT NULL",
		"assistant_id" => "int(11) NOT NULL",
		), "ENGINE=InnoDB");
    }

    public function safeDown()
    {
		$this->truncateTable('assistant_upline');
		$this->dropTable('assistant_upline');
    }
}
