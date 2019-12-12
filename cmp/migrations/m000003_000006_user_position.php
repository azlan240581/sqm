<?php

use yii\db\Migration;

class m000003_000006_user_position extends Migration
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
		$this->createTable("user_position", array(
		"id" => "pk",
		"user_id" => "int(11) NOT NULL",
		"position_id" => "int(11) NOT NULL",
		), "ENGINE=InnoDB");
		
    }

    public function safeDown()
    {
		$this->truncateTable('user_position');
		$this->dropTable('user_position');
    }
}
