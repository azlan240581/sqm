<?php

use yii\db\Migration;

class m000005_000008_news_feeds extends Migration
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
		$this->createTable("news_feeds", array(
		"id" => "pk",
		"category_id" => "int(11) NOT NULL",
		"project_id" => "int(11) NOT NULL",
		"title" => "varchar(255) NOT NULL",
		"permalink" => "varchar(255) NOT NULL",
		"summary" => "text DEFAULT NULL",
		"description" => "longtext DEFAULT NULL",
		"thumb_image" => "varchar(255) DEFAULT NULL",
		
		"product_id" => "int(11) DEFAULT NULL", //promotions
		"promotion_start_date" => "datetime DEFAULT NULL", //promotions
		"promotion_end_date" => "datetime DEFAULT NULL", //promotions
		"promotion_terms_conditions" => "longtext DEFAULT NULL", //promotions
		
		"event_at" => "datetime DEFAULT NULL", //events
		"event_location" => "text DEFAULT NULL", //events
		"event_location_longitude" => "varchar(100) DEFAULT NULL", //events
		"event_location_latitude" => "varchar(100) DEFAULT NULL", //events
		
		"collaterals_id" => "varchar(100) DEFAULT NULL",
		"published_date_start" => "datetime NOT NULL",
		"published_date_end" => "datetime DEFAULT NULL",
		"total_viewed" => "int(11) DEFAULT 0",
		"status" => "int(11) NOT NULL",
		"createdby" => "int(11) NOT NULL",
		"createdat" => "datetime NOT NULL",
		"updatedby" => "int(11) DEFAULT NULL",
		"updatedat" => "datetime DEFAULT NULL",
		"deletedby" => "int(11) DEFAULT NULL",
		"deletedat" => "datetime DEFAULT NULL",
		), "ENGINE=InnoDB");
		
    }

    public function safeDown()
    {
		$this->truncateTable('news_feeds');
		$this->dropTable('news_feeds');
    }
}
