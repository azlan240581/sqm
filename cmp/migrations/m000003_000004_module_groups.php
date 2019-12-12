<?php

use yii\db\Migration;

class m000003_000004_module_groups extends Migration
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
		$this->createTable("module_groups", array(
		"id" => "pk",
		"module_id" => "int(11) NOT NULL",
		"groupaccess_id" => "int(11) NOT NULL",
		"permission" => "text NOT NULL",
		), "ENGINE=InnoDB");
		
    }

    public function safeDown()
    {
		$this->truncateTable('module_groups');
		$this->dropTable('module_groups');
    }
}
