<?php

use yii\db\Migration;

class m000002_000020_lookup_how_you_know_about_us extends Migration
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
		$this->createTable("lookup_how_you_know_about_us", array(
		"id" => "pk",
		"name" => "varchar(100) NOT NULL",
		"deleted" => "tinyint(1) DEFAULT 0",
		), "ENGINE=InnoDB");
		
		$this->insert('lookup_how_you_know_about_us',array(
					  'id'=>'1',
					  'name'=>'Property Agent',
					  ));
		
		$this->insert('lookup_how_you_know_about_us',array(
					  'id'=>'2',
					  'name'=>'Billboard',
					  ));
		
		$this->insert('lookup_how_you_know_about_us',array(
					  'id'=>'3',
					  'name'=>'Email',
					  ));
		
		$this->insert('lookup_how_you_know_about_us',array(
					  'id'=>'4',
					  'name'=>'Radio Advertisement',
					  ));
		
		$this->insert('lookup_how_you_know_about_us',array(
					  'id'=>'5',
					  'name'=>'Internet',
					  ));
		
		$this->insert('lookup_how_you_know_about_us',array(
					  'id'=>'6',
					  'name'=>'Newspaper / Magazine',
					  ));
		
		$this->insert('lookup_how_you_know_about_us',array(
					  'id'=>'7',
					  'name'=>'Big Events',
					  ));
		
		$this->insert('lookup_how_you_know_about_us',array(
					  'id'=>'8',
					  'name'=>'Messaging Platform',
					  ));
		
		$this->insert('lookup_how_you_know_about_us',array(
					  'id'=>'9',
					  'name'=>'Expo / Exhibition / Open Tables',
					  ));
		
		$this->insert('lookup_how_you_know_about_us',array(
					  'id'=>'10',
					  'name'=>'SMS Blast',
					  ));
		
		$this->insert('lookup_how_you_know_about_us',array(
					  'id'=>'11',
					  'name'=>'Social Media',
					  ));
		
		$this->insert('lookup_how_you_know_about_us',array(
					  'id'=>'12',
					  'name'=>'Referral (Friends / Relatives)',
					  ));
		
		$this->insert('lookup_how_you_know_about_us',array(
					  'id'=>'13',
					  'name'=>'Website',
					  ));
				
    }

    public function safeDown()
    {
		$this->truncateTable('lookup_how_you_know_about_us');
		$this->dropTable('lookup_how_you_know_about_us');
    }
}
