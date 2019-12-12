<?php

use yii\db\Migration;

class m000004_000006_banners extends Migration
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
		$this->createTable("banners", array(
		"id" => "pk",
		"banner_category_id" => "int(11) NOT NULL",
		"banner_title" => "varchar(255) NOT NULL",
		"permalink" => "varchar(255) NOT NULL",
		"banner_summary" => "text DEFAULT NULL",
		"banner_description" => "longtext DEFAULT NULL",
		"banner_img" => "varchar(255) DEFAULT NULL",
		"banner_video" => "varchar(255) DEFAULT NULL",
		"link_url" => "varchar(255) DEFAULT NULL",
		"published_date_start" => "datetime NOT NULL",
		"published_date_end" => "datetime DEFAULT NULL",
		"sort" => "int(11) DEFAULT 0",
		"total_viewed" => "int(11) DEFAULT 0",
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
		$this->truncateTable('banners');
		$this->dropTable('banners');
    }
}
