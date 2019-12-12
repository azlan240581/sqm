<?php

use yii\db\Migration;

class m000008_000008_log_news_feed_approval extends Migration
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
		$this->createTable("log_news_feed_approval", array(
		"id" => "pk",
		"news_feed_id" => "int(11) NOT NULL",
		"status" => "int(11) NOT NULL",
		"remarks" => "text DEFAULT NULL",
		"createdby" => "int(11) NOT NULL",
		"createdat" => "datetime NOT NULL",
		), "ENGINE=InnoDB");
		
    }

    public function safeDown()
    {
		$this->truncateTable('log_news_feed_approval');
		$this->dropTable('log_news_feed_approval');
    }
}
