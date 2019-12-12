<?php

use yii\db\Migration;

class m000008_000012_log_associate_activities extends Migration
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
		$this->createTable("log_associate_activities", array(
		"id" => "pk",
		"associate_id" => "int(11) NOT NULL",
		"activity_id" => "int(11) NOT NULL",
		"points_value" => "decimal(20,4) DEFAULT 0",
		"news_feed_id" => "int(11) DEFAULT NULL",
		"product_id" => "int(11) DEFAULT NULL",
		"banner_id" => "int(11) DEFAULT NULL",
		"createdby" => "int(11) NOT NULL",
		"createdat" => "datetime NOT NULL",
		), "ENGINE=InnoDB");
    }

    public function safeDown()
    {
		$this->truncateTable('log_associate_activities');
		$this->dropTable('log_associate_activities');
    }
}
