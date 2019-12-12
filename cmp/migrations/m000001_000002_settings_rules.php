<?php

use yii\db\Migration;

class m000001_000002_settings_rules extends Migration
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
		$this->createTable("settings_rules", array(
		"id" => 'pk',
		"settings_categories_id" => "int(11) NOT NULL",
		"settings_rules_key" => "varchar(100) NOT NULL",
		"settings_rules_desc" => "text DEFAULT NULL",
		"settings_rules_config_type" => "varchar(255) DEFAULT NULL",
		"settings_rules_config" => "varchar(1000) DEFAULT NULL",
		"settings_rules_sort" => "int(11) DEFAULT 0",
		"updatedat" => "datetime DEFAULT NULL",
		), "ENGINE=InnoDB");
		
		//System Information
		$this->insert('settings_rules',array(
									  'id'=>1,
									  'settings_categories_id'=>1,
									  'settings_rules_key'=>'SITE_NAME',
									  'settings_rules_desc'=>'',
									  'settings_rules_config_type'=>'txt',
									  'settings_rules_config'=>'',
									  'settings_rules_sort'=>'',
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
		$this->insert('settings_rules',array(
									  'id'=>2,
									  'settings_categories_id'=>1,
									  'settings_rules_key'=>'SITE_LOGO_ICON',
									  'settings_rules_desc'=>'',
									  'settings_rules_config_type'=>'img',
									  'settings_rules_config'=>'',
									  'settings_rules_sort'=>'',
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
		$this->insert('settings_rules',array(
									  'id'=>3,
									  'settings_categories_id'=>1,
									  'settings_rules_key'=>'SITE_LOGO_SMALL',
									  'settings_rules_desc'=>'',
									  'settings_rules_config_type'=>'img',
									  'settings_rules_config'=>'',
									  'settings_rules_sort'=>'',
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
		$this->insert('settings_rules',array(
									  'id'=>4,
									  'settings_categories_id'=>1,
									  'settings_rules_key'=>'SITE_LOGO_MEDIUM',
									  'settings_rules_desc'=>'',
									  'settings_rules_config_type'=>'img',
									  'settings_rules_config'=>'',
									  'settings_rules_sort'=>'',
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
		$this->insert('settings_rules',array(
									  'id'=>5,
									  'settings_categories_id'=>1,
									  'settings_rules_key'=>'SITE_LOGO_BIG',
									  'settings_rules_desc'=>'',
									  'settings_rules_config_type'=>'img',
									  'settings_rules_config'=>'',
									  'settings_rules_sort'=>'',
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
		$this->insert('settings_rules',array(
									  'id'=>6,
									  'settings_categories_id'=>1,
									  'settings_rules_key'=>'SITE_PASSWORD',
									  'settings_rules_desc'=>'',
									  'settings_rules_config_type'=>'pwd',
									  'settings_rules_config'=>'',
									  'settings_rules_sort'=>'',
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
		$this->insert('settings_rules',array(
									  'id'=>7,
									  'settings_categories_id'=>1,
									  'settings_rules_key'=>'SITE_DEFAULT_LANGUAGE',
									  'settings_rules_desc'=>'',
									  'settings_rules_config_type'=>'txt',
									  'settings_rules_config'=>'',
									  'settings_rules_sort'=>'',
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
		$this->insert('settings_rules',array(
									  'id'=>8,
									  'settings_categories_id'=>1,
									  'settings_rules_key'=>'SITE_DATE_GMT',
									  'settings_rules_desc'=>'',
									  'settings_rules_config_type'=>'sel',
									  'settings_rules_config'=>serialize(array('-12','-11','-10','-9','-8','-7','-6','-5','-4','-3','-2','-1','0','+1','+2','+3','+4','+5','+6','+7','+8','+9','+10','+11','+12')),
									  'settings_rules_sort'=>'',
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
		$this->insert('settings_rules',array(
									  'id'=>9,
									  'settings_categories_id'=>1,
									  'settings_rules_key'=>'SITE_DATE_FORMAT',
									  'settings_rules_desc'=>'',
									  'settings_rules_config_type'=>'txt',
									  'settings_rules_config'=>'',
									  'settings_rules_sort'=>'',
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));


		//Owner Information
		$this->insert('settings_rules',array(
									  'id'=>10,
									  'settings_categories_id'=>2,
									  'settings_rules_key'=>'SITE_COMPANY_NAME',
									  'settings_rules_desc'=>'',
									  'settings_rules_config_type'=>'txt',
									  'settings_rules_config'=>'',
									  'settings_rules_sort'=>'',
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
		$this->insert('settings_rules',array(
									  'id'=>11,
									  'settings_categories_id'=>2,
									  'settings_rules_key'=>'SITE_COMPANY_NO',
									  'settings_rules_desc'=>'',
									  'settings_rules_config_type'=>'txt',
									  'settings_rules_config'=>'',
									  'settings_rules_sort'=>'',
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
		$this->insert('settings_rules',array(
									  'id'=>12,
									  'settings_categories_id'=>2,
									  'settings_rules_key'=>'SITE_ADDRESS_1',
									  'settings_rules_desc'=>'',
									  'settings_rules_config_type'=>'txt',
									  'settings_rules_config'=>'',
									  'settings_rules_sort'=>'',
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
		$this->insert('settings_rules',array(
									  'id'=>13,
									  'settings_categories_id'=>2,
									  'settings_rules_key'=>'SITE_ADDRESS_2',
									  'settings_rules_desc'=>'',
									  'settings_rules_config_type'=>'txt',
									  'settings_rules_config'=>'',
									  'settings_rules_sort'=>'',
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
		$this->insert('settings_rules',array(
									  'id'=>14,
									  'settings_categories_id'=>2,
									  'settings_rules_key'=>'SITE_POSTCODE',
									  'settings_rules_desc'=>'',
									  'settings_rules_config_type'=>'txt',
									  'settings_rules_config'=>'',
									  'settings_rules_sort'=>'',
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
		$this->insert('settings_rules',array(
									  'id'=>15,
									  'settings_categories_id'=>2,
									  'settings_rules_key'=>'SITE_CITY',
									  'settings_rules_desc'=>'',
									  'settings_rules_config_type'=>'txt',
									  'settings_rules_config'=>'',
									  'settings_rules_sort'=>'',
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
		$this->insert('settings_rules',array(
									  'id'=>16,
									  'settings_categories_id'=>2,
									  'settings_rules_key'=>'SITE_STATE',
									  'settings_rules_desc'=>'',
									  'settings_rules_config_type'=>'txt',
									  'settings_rules_config'=>'',
									  'settings_rules_sort'=>'',
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
		$this->insert('settings_rules',array(
									  'id'=>17,
									  'settings_categories_id'=>2,
									  'settings_rules_key'=>'SITE_COUNTRY',
									  'settings_rules_desc'=>'',
									  'settings_rules_config_type'=>'txt',
									  'settings_rules_config'=>'',
									  'settings_rules_sort'=>'',
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
		$this->insert('settings_rules',array(
									  'id'=>18,
									  'settings_categories_id'=>2,
									  'settings_rules_key'=>'SITE_PHONE_NO',
									  'settings_rules_desc'=>'',
									  'settings_rules_config_type'=>'txt',
									  'settings_rules_config'=>'',
									  'settings_rules_sort'=>'',
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
		$this->insert('settings_rules',array(
									  'id'=>19,
									  'settings_categories_id'=>2,
									  'settings_rules_key'=>'SITE_FAX_NO',
									  'settings_rules_desc'=>'',
									  'settings_rules_config_type'=>'txt',
									  'settings_rules_config'=>'',
									  'settings_rules_sort'=>'',
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));


		//Email Settings
		$this->insert('settings_rules',array(
									  'id'=>20,
									  'settings_categories_id'=>3,
									  'settings_rules_key'=>'SITE_EMAIL_HOST',
									  'settings_rules_desc'=>'',
									  'settings_rules_config_type'=>'txt',
									  'settings_rules_config'=>'',
									  'settings_rules_sort'=>'',
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
		$this->insert('settings_rules',array(
									  'id'=>21,
									  'settings_categories_id'=>3,
									  'settings_rules_key'=>'SITE_EMAIL_USERNAME',
									  'settings_rules_desc'=>'',
									  'settings_rules_config_type'=>'mail',
									  'settings_rules_config'=>'',
									  'settings_rules_sort'=>'',
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
		$this->insert('settings_rules',array(
									  'id'=>22,
									  'settings_categories_id'=>3,
									  'settings_rules_key'=>'SITE_EMAIL_PASSWORD',
									  'settings_rules_desc'=>'',
									  'settings_rules_config_type'=>'txt',
									  'settings_rules_config'=>'',
									  'settings_rules_sort'=>'',
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
		$this->insert('settings_rules',array(
									  'id'=>23,
									  'settings_categories_id'=>3,
									  'settings_rules_key'=>'SITE_EMAIL_PORT',
									  'settings_rules_desc'=>'',
									  'settings_rules_config_type'=>'txt',
									  'settings_rules_config'=>'',
									  'settings_rules_sort'=>'',
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
		$this->insert('settings_rules',array(
									  'id'=>24,
									  'settings_categories_id'=>3,
									  'settings_rules_key'=>'SITE_EMAIL_AUTH',
									  'settings_rules_desc'=>'',
									  'settings_rules_config_type'=>'sel',
									  'settings_rules_config'=>serialize([0,1]),
									  'settings_rules_sort'=>'',
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
		$this->insert('settings_rules',array(
									  'id'=>25,
									  'settings_categories_id'=>3,
									  'settings_rules_key'=>'SITE_EMAIL_SMTP_SECURE',
									  'settings_rules_desc'=>'',
									  'settings_rules_config_type'=>'txt',
									  'settings_rules_config'=>'',
									  'settings_rules_sort'=>'',
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
		$this->insert('settings_rules',array(
									  'id'=>26,
									  'settings_categories_id'=>3,
									  'settings_rules_key'=>'SITE_EMAIL_SYSTEM_ALERT',
									  'settings_rules_desc'=>"List of emails to notified developer. Split by ',' or ';'",
									  'settings_rules_config_type'=>'mail',
									  'settings_rules_config'=>'',
									  'settings_rules_sort'=>'',
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
		$this->insert('settings_rules',array(
									  'id'=>27,
									  'settings_categories_id'=>3,
									  'settings_rules_key'=>'SITE_EMAIL_RECEPIENTS',
									  'settings_rules_desc'=>"List of emails to notified system administrator. Split by ',' or ';'",
									  'settings_rules_config_type'=>'mail',
									  'settings_rules_config'=>'',
									  'settings_rules_sort'=>'',
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
		
		//SMS Settings
		$this->insert('settings_rules',array(
									  'id'=>28,
									  'settings_categories_id'=>4,
									  'settings_rules_key'=>'SMS_API_URL',
									  'settings_rules_desc'=>'',
									  'settings_rules_config_type'=>'txt',
									  'settings_rules_config'=>'',
									  'settings_rules_sort'=>'',
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
		$this->insert('settings_rules',array(
									  'id'=>29,
									  'settings_categories_id'=>4,
									  'settings_rules_key'=>'SMS_API_KEY',
									  'settings_rules_desc'=>'',
									  'settings_rules_config_type'=>'txt',
									  'settings_rules_config'=>'',
									  'settings_rules_sort'=>'',
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
		$this->insert('settings_rules',array(
									  'id'=>30,
									  'settings_categories_id'=>4,
									  'settings_rules_key'=>'SMS_API_SERVICE_NAME',
									  'settings_rules_desc'=>'',
									  'settings_rules_config_type'=>'txt',
									  'settings_rules_config'=>'',
									  'settings_rules_sort'=>'',
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
		$this->insert('settings_rules',array(
									  'id'=>31,
									  'settings_categories_id'=>4,
									  'settings_rules_key'=>'SMS_API_SENDER_ID',
									  'settings_rules_desc'=>'',
									  'settings_rules_config_type'=>'txt',
									  'settings_rules_config'=>'',
									  'settings_rules_sort'=>'',
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
									  
		//Push Notifications Settings
		$this->insert('settings_rules',array(
									  'id'=>32,
									  'settings_categories_id'=>5,
									  'settings_rules_key'=>'FCM_API_ACCESS_KEY',
									  'settings_rules_desc'=>'',
									  'settings_rules_config_type'=>'txtarea',
									  'settings_rules_config'=>'',
									  'settings_rules_sort'=>'',
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
		$this->insert('settings_rules',array(
									  'id'=>33,
									  'settings_categories_id'=>5,
									  'settings_rules_key'=>'FCM_SENDER_ID',
									  'settings_rules_desc'=>'',
									  'settings_rules_config_type'=>'txt',
									  'settings_rules_config'=>'',
									  'settings_rules_sort'=>'',
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));

		//User Settings
		$this->insert('settings_rules',array(
									  'id'=>34,
									  'settings_categories_id'=>6,
									  'settings_rules_key'=>'SITE_ALLOW_MULTIPLE_GROUPS',
									  'settings_rules_desc'=>'',
									  'settings_rules_config_type'=>'sel',
									  'settings_rules_config'=>serialize([0,1]),
									  'settings_rules_sort'=>'',
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
		$this->insert('settings_rules',array(
									  'id'=>35,
									  'settings_categories_id'=>6,
									  'settings_rules_key'=>'SITE_SIGNIN_TYPE',
									  'settings_rules_desc'=>'',
									  'settings_rules_config_type'=>'msel',
									  'settings_rules_config'=>serialize(['Normal','Facebook','Google']),
									  'settings_rules_sort'=>'',
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
		$this->insert('settings_rules',array(
									  'id'=>36,
									  'settings_categories_id'=>6,
									  'settings_rules_key'=>'SITE_AUTO_APPROVED_REGISTRATION',
									  'settings_rules_desc'=>'',
									  'settings_rules_config_type'=>'sel',
									  'settings_rules_config'=>serialize([0,1]),
									  'settings_rules_sort'=>'',
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
		$this->insert('settings_rules',array(
									  'id'=>37,
									  'settings_categories_id'=>6,
									  'settings_rules_key'=>'SITE_LIMIT_USER_LOGIN_PER_DAY',
									  'settings_rules_desc'=>'',
									  'settings_rules_config_type'=>'int',
									  'settings_rules_config'=>"",
									  'settings_rules_sort'=>'',
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
		$this->insert('settings_rules',array(
									  'id'=>38,
									  'settings_categories_id'=>6,
									  'settings_rules_key'=>'SITE_LIMIT_FAILED_LOGIN_ATTEMPT',
									  'settings_rules_desc'=>'',
									  'settings_rules_config_type'=>'int',
									  'settings_rules_config'=>"",
									  'settings_rules_sort'=>'',
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
		$this->insert('settings_rules',array(
									  'id'=>39,
									  'settings_categories_id'=>6,
									  'settings_rules_key'=>'SITE_ALLOW_USER_ALLOCATION',
									  'settings_rules_desc'=>'',
									  'settings_rules_config_type'=>'sel',
									  'settings_rules_config'=>serialize([0,1]),
									  'settings_rules_sort'=>'',
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
		$this->insert('settings_rules',array(
									  'id'=>40,
									  'settings_categories_id'=>6,
									  'settings_rules_key'=>'SITE_SIGNIN_BANNED_PERIOD',
									  'settings_rules_desc'=>'Ban period for signin in seconds',
									  'settings_rules_config_type'=>'int',
									  'settings_rules_config'=>"",
									  'settings_rules_sort'=>'',
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
									  
		//Notifications Settings
		$this->insert('settings_rules',array(
									  'id'=>41,
									  'settings_categories_id'=>7,
									  'settings_rules_key'=>'MINIMUM_BANK_POINTS_CREDITS',
									  'settings_rules_desc'=>'Set minimum bank points credits to send notification',
									  'settings_rules_config_type'=>'int',
									  'settings_rules_config'=>"",
									  'settings_rules_sort'=>'',
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
		$this->insert('settings_rules',array(
									  'id'=>42,
									  'settings_categories_id'=>7,
									  'settings_rules_key'=>'AUTO_ASSIGN_PROSPECT',
									  'settings_rules_desc'=>'',
									  'settings_rules_config_type'=>'sel',
									  'settings_rules_config'=>serialize(array()),
									  'settings_rules_sort'=>'',
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
		$this->insert('settings_rules',array(
									  'id'=>43,
									  'settings_categories_id'=>7,
									  'settings_rules_key'=>'MEMBER_GET_MEMBER_COMMISSION_LIMIT',
									  'settings_rules_desc'=>'',
									  'settings_rules_config_type'=>'int',
									  'settings_rules_config'=>'',
									  'settings_rules_sort'=>'',
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
									  
    }

    public function safeDown()
    {
		$this->truncateTable('settings_rules');
		$this->dropTable('settings_rules');
    }
}
