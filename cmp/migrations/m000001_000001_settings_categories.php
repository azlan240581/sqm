<?php

use yii\db\Migration;

class m000001_000001_settings_categories extends Migration
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
		$this->createTable("settings_categories", array(
		"id" => 'pk',
		"settings_category_name" => "varchar(255) NOT NULL",
		"settings_category_description" => "varchar(1000) DEFAULT NULL",
		"updatedat" => "datetime DEFAULT NULL",
		), "ENGINE=InnoDB");
		
		$this->insert('settings_categories',array(
									  'id'=>'1',
									  'settings_category_name'=>'System Information',
									  'settings_category_description'=>'Main system settings',
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
		
		$this->insert('settings_categories',array(
									  'id'=>'2',
									  'settings_category_name'=>'Owner Information',
									  'settings_category_description'=>'System Owner Profiles',
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
		
		$this->insert('settings_categories',array(
									  'id'=>'3',
									  'settings_category_name'=>'Email Settings',
									  'settings_category_description'=>'Email settings for notifications',
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
		$this->insert('settings_categories',array(
									  'id'=>'4',
									  'settings_category_name'=>'SMS Settings',
									  'settings_category_description'=>'SMS settings',
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
		$this->insert('settings_categories',array(
									  'id'=>'5',
									  'settings_category_name'=>'Push Notifications Settings',
									  'settings_category_description'=>'Push Notifications settings',
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
		$this->insert('settings_categories',array(
									  'id'=>'6',
									  'settings_category_name'=>'User Log Settings',
									  'settings_category_description'=>'User and log settings',
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
		$this->insert('settings_categories',array(
									  'id'=>'7',
									  'settings_category_name'=>'Business Settings',
									  'settings_category_description'=>'Business Settings',
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
    }

    public function safeDown()
    {
		$this->truncateTable('settings_categories');
		$this->dropTable('settings_categories');
    }
}
