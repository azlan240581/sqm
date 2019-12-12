<?php

use yii\db\Migration;

class m000002_000037_lookup_news_feed_categories extends Migration
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
		$this->createTable("lookup_news_feed_categories", array(
		"id" => "pk",
		"name" => "varchar(100) NOT NULL",
		"deleted" => "tinyint(1) DEFAULT 0",
		), "ENGINE=InnoDB");
		
		$this->insert('lookup_news_feed_categories',array(
					  'name'=>'News',
					  ));
		
		$this->insert('lookup_news_feed_categories',array(
					  'name'=>'Promotions',
					  ));
				
		$this->insert('lookup_news_feed_categories',array(
					  'name'=>'Events',
					  ));
		
		$this->insert('lookup_news_feed_categories',array(
					  'name'=>'Featured',
					  ));
		
    }

    public function safeDown()
    {
		$this->truncateTable('lookup_news_feed_categories');
		$this->dropTable('lookup_news_feed_categories');
    }
}
