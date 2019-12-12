<?php

use yii\db\Migration;

class m000002_000029_lookup_job_type extends Migration
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
		$this->createTable("lookup_job_type", array(
		"id" => "pk",
		"name" => "varchar(100) NOT NULL",
		"deleted" => "tinyint(1) DEFAULT 0",
		), "ENGINE=InnoDB");
		
		$this->insert('lookup_job_type',array(
						  'id'=>'1',
						  'name'=>'Employee',
					  ));
		
		$this->insert('lookup_job_type',array(
						  'id'=>'2',
						  'name'=>'Entreprenuer',
					  ));
		
		$this->insert('lookup_job_type',array(
						  'id'=>'3',
						  'name'=>'Professional',
					  ));
    }

    public function safeDown()
    {
		$this->truncateTable('lookup_job_type');
		$this->dropTable('lookup_job_type');
    }
}
