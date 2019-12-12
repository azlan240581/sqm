<?php

use yii\db\Migration;

class m000003_000001_group_access extends Migration
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
		$this->createTable("group_access", array(
		"id" => 'pk',
		"group_access_name" => "varchar(255) NOT NULL",
		"sort" => "int(11) DEFAULT 0",
		"updatedat" => "datetime DEFAULT NULL",
		"status" => "int(11) DEFAULT 1",
		), "ENGINE=InnoDB");
		
		$this->insert('group_access',array(
									  'group_access_name'=>'Administrator',
									  'sort'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  'status'=>1,
									  ));
		$this->insert('group_access',array(
									  'group_access_name'=>'SQM Admin',
									  'sort'=>2,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  'status'=>1,
									  ));
		$this->insert('group_access',array(
									  'group_access_name'=>'Digital / Creative',
									  'sort'=>3,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  'status'=>1,
									  ));
		$this->insert('group_access',array(
									  'group_access_name'=>'Bank',
									  'sort'=>4,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  'status'=>1,
									  ));
		$this->insert('group_access',array(
									  'group_access_name'=>'Developer',
									  'sort'=>5,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  'status'=>1,
									  ));
		$this->insert('group_access',array(
									  'group_access_name'=>'Fintech',
									  'sort'=>6,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  'status'=>1,
									  ));
		$this->insert('group_access',array(
									  'group_access_name'=>'SQM Account Manager',
									  'sort'=>7,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  'status'=>1,
									  ));
		$this->insert('group_access',array(
									  'group_access_name'=>'Associate Broker',
									  'sort'=>8,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  'status'=>1,
									  ));
		$this->insert('group_access',array(
									  'group_access_name'=>'SQM Account Executive',
									  'sort'=>9,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  'status'=>0,
									  ));
		$this->insert('group_access',array(
									  'group_access_name'=>'Associate Broker Assistant',
									  'sort'=>10,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  'status'=>0,
									  ));
		$this->insert('group_access',array(
									  'group_access_name'=>'Associate',
									  'sort'=>11,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  'status'=>1,
									  ));
		$this->insert('group_access',array(
									  'group_access_name'=>'Virtual Associate',
									  'sort'=>12,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  'status'=>1,
									  ));
    }

    public function safeDown()
    {
		$this->truncateTable('group_access');
		$this->dropTable('group_access');
    }
}
