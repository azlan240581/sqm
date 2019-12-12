<?php

use yii\db\Migration;

class m000007_000007_fintech_packages extends Migration
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
		$this->createTable("fintech_packages", array(
		"id" => "pk",
		"fintech_id" => "int(11) NOT NULL",
		"month" => "int(11) NOT NULL",
		"interest" => "decimal(10,4) NOT NULL",
		), "ENGINE=InnoDB");
    }

    public function safeDown()
    {
		$this->truncateTable('fintech_packages');
		$this->dropTable('fintech_packages');
    }
}
