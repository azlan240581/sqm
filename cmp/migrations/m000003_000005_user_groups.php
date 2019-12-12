<?php

use yii\db\Migration;

class m000003_000005_user_groups extends Migration
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
		$this->createTable("user_groups", array(
		"id" => "pk",
		"user_id" => "int(11) NOT NULL",
		"groupaccess_id" => "int(11) NOT NULL",
		), "ENGINE=InnoDB");
		
    }

    public function safeDown()
    {

		$this->truncateTable('user_groups');
		$this->dropTable('user_groups');
    }
}
