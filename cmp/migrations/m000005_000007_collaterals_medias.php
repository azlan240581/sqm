<?php

use yii\db\Migration;

class m000005_000007_collaterals_medias extends Migration
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
		$this->createTable("collaterals_medias", array(
		"id" => "pk",
		"collateral_id" => "int(11) NOT NULL",
		"collateral_media_type_id" => "int(11) NOT NULL",
		"thumb_image" => "varchar(255) NOT NULL",
		"media_title" => "varchar(255) NOT NULL",
		"media_value" => "varchar(255) NOT NULL",
		"published" => "tinyint(1) DEFAULT 1",
		"sort" => "int(11) DEFAULT 0",
		"createdby" => "int(11) NOT NULL",
		"createdat" => "datetime NOT NULL",
		"deletedby" => "int(11) DEFAULT NULL",
		"deletedat" => "datetime DEFAULT NULL",
		), "ENGINE=InnoDB");
    }

    public function safeDown()
    {
		$this->truncateTable('collaterals_medias');
		$this->dropTable('collaterals_medias');
    }
}
