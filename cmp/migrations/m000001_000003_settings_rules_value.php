<?php

use yii\db\Migration;

class m000001_000003_settings_rules_value extends Migration
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
		$this->createTable("settings_rules_value", array(
		"id" => 'pk',
		"settings_rules_id" => "int(11) NOT NULL",
		"value" => "varchar(1000) DEFAULT NULL",
		"updatedat" => "datetime DEFAULT NULL",
		), "ENGINE=InnoDB");
		
		//System Information
		$this->insert('settings_rules_value',array(
									  'settings_rules_id'=>1,
									  'value'=>'SQM PROPERTY Administration',
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
		$this->insert('settings_rules_value',array(
									  'settings_rules_id'=>2,
									  'value'=>'/contents/img/favicon.ico',
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
		$this->insert('settings_rules_value',array(
									  'settings_rules_id'=>3,
									  'value'=>'/contents/img/logo-small.png',
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
		$this->insert('settings_rules_value',array(
									  'settings_rules_id'=>4,
									  'value'=>'/contents/img/logo-medium.png',
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
		$this->insert('settings_rules_value',array(
									  'settings_rules_id'=>5,
									  'value'=>'/contents/img/logo.png',
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
		$this->insert('settings_rules_value',array(
									  'settings_rules_id'=>6,
									  'value'=>'Ffs12345',
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
		$this->insert('settings_rules_value',array(
									  'settings_rules_id'=>7,
									  'value'=>'en',
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
		$this->insert('settings_rules_value',array(
									  'settings_rules_id'=>8,
									  'value'=>'+7',
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
		$this->insert('settings_rules_value',array(
									  'settings_rules_id'=>9,
									  'value'=>'M j, Y',
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));


		//Owner Information
		$this->insert('settings_rules_value',array(
									  'settings_rules_id'=>10,
									  'value'=>'Forefront Studio Sdn Bhd',
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
		$this->insert('settings_rules_value',array(
									  'settings_rules_id'=>11,
									  'value'=>'',
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
		$this->insert('settings_rules_value',array(
									  'settings_rules_id'=>12,
									  'value'=>'D9-3A, Dana 1 Commercial Centre',
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
		$this->insert('settings_rules_value',array(
									  'settings_rules_id'=>13,
									  'value'=>'Jalan PJU 1A/46',
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
		$this->insert('settings_rules_value',array(
									  'settings_rules_id'=>14,
									  'value'=>'47301',
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
		$this->insert('settings_rules_value',array(
									  'settings_rules_id'=>15,
									  'value'=>'Petaling Jaya',
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
		$this->insert('settings_rules_value',array(
									  'settings_rules_id'=>16,
									  'value'=>'Selangor',
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
		$this->insert('settings_rules_value',array(
									  'settings_rules_id'=>17,
									  'value'=>'Malaysia',
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
		$this->insert('settings_rules_value',array(
									  'settings_rules_id'=>18,
									  'value'=>'+603 7842 8226',
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
		$this->insert('settings_rules_value',array(
									  'settings_rules_id'=>19,
									  'value'=>'+603 7842 8227',
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));


		//Email Settings
		$this->insert('settings_rules_value',array(
									  'settings_rules_id'=>20,
									  'value'=>'srv42.niagahoster.com',
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
		$this->insert('settings_rules_value',array(
									  'settings_rules_id'=>21,
									  'value'=>'support@sqmproperty.co.id',
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
		$this->insert('settings_rules_value',array(
									  'settings_rules_id'=>22,
									  'value'=>'l4v0n-ff5',
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
		$this->insert('settings_rules_value',array(
									  'settings_rules_id'=>23,
									  'value'=>'465',
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
		$this->insert('settings_rules_value',array(
									  'settings_rules_id'=>24,
									  'value'=>'1',
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
		$this->insert('settings_rules_value',array(
									  'settings_rules_id'=>25,
									  'value'=>'ssl',
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
		$this->insert('settings_rules_value',array(
									  'settings_rules_id'=>26,
									  'value'=>'support@forefront.com.my',
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
		$this->insert('settings_rules_value',array(
									  'settings_rules_id'=>27,
									  'value'=>'azlan@forefront.com.my,amir.aiman@forefront.com.my',
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
									  
 		//SMS Settings
		$this->insert('settings_rules_value',array(
									  'settings_rules_id'=>28,
									  'value'=>'',
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
		$this->insert('settings_rules_value',array(
									  'settings_rules_id'=>29,
									  'value'=>'',
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
		$this->insert('settings_rules_value',array(
									  'settings_rules_id'=>30,
									  'value'=>'',
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
		$this->insert('settings_rules_value',array(
									  'settings_rules_id'=>31,
									  'value'=>'',
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
									  
 		//Push Notifications Settings
		$this->insert('settings_rules_value',array(
									  'settings_rules_id'=>32,
									  'value'=>'AAAA38pazdI:APA91bHMuo1ClAAXR3455f1zUSFG0k1_x_nzsw5_Q-H7-3MzTKE4pw-u_W5A1sXM5gVvCaxFxOm9ejzZNXr4xK_SWmwnPOoESUx-y1ptVnsZ9scFDqeXzS0n-Z1Ue2ZB08zQ9mHd5kg-',
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
		$this->insert('settings_rules_value',array(
									  'settings_rules_id'=>33,
									  'value'=>'961172655570',
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
									  
 		//User Log Settings
		$this->insert('settings_rules_value',array(
									  'settings_rules_id'=>34,
									  'value'=>'0',
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
		$this->insert('settings_rules_value',array(
									  'settings_rules_id'=>35,
									  'value'=>'Normal,Facebook,Google',
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
		$this->insert('settings_rules_value',array(
									  'settings_rules_id'=>36,
									  'value'=>'1',
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
		$this->insert('settings_rules_value',array(
									  'settings_rules_id'=>37,
									  'value'=>'0',
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
		$this->insert('settings_rules_value',array(
									  'settings_rules_id'=>38,
									  'value'=>'0',
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
		$this->insert('settings_rules_value',array(
									  'settings_rules_id'=>39,
									  'value'=>'0',
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
		$this->insert('settings_rules_value',array(
									  'settings_rules_id'=>40,
									  'value'=>'180',
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
									  
		//Notifications Settings
		$this->insert('settings_rules_value',array(
									  'settings_rules_id'=>41,
									  'value'=>'1000000',
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
		$this->insert('settings_rules_value',array(
									  'settings_rules_id'=>42,
									  'value'=>'',
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
		$this->insert('settings_rules_value',array(
									  'settings_rules_id'=>43,
									  'value'=>'5',
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
   
   }

    public function safeDown()
    {
		$this->truncateTable('settings_rules_value');
		$this->dropTable('settings_rules_value');
    }
}
