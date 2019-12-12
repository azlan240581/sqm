<?php

use yii\db\Migration;

class m000004_000005_associate_available_activities extends Migration
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
		$this->createTable("associate_available_activities", array(
		"id" => "pk",
		"activity_id" => "int(11) NOT NULL",
		"associate_id" => "int(11) NOT NULL",
		), "ENGINE=InnoDB");
    }

    public function safeDown()
    {
		$this->truncateTable('associate_available_activities');
		$this->dropTable('associate_available_activities');
    }
}
