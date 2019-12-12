<?php

use yii\db\Migration;

class m000002_000011_lookup_prospect_history extends Migration
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
		$this->createTable("lookup_prospect_history", array(
		"id" => "pk",
		"name" => "varchar(100) NOT NULL",
		"deleted" => "tinyint(1) DEFAULT 0",
		), "ENGINE=InnoDB");
		
		$this->insert('lookup_prospect_history',array(
						  'name'=>'New Prospect Registered',
					  ));
		$this->insert('lookup_prospect_history',array(
						  'name'=>'Follow Up',
					  ));
		$this->insert('lookup_prospect_history',array(
						  'name'=>'Appointment Scheduled',
					  ));
		$this->insert('lookup_prospect_history',array(
						  'name'=>'Level of Interest',
					  ));
		$this->insert('lookup_prospect_history',array(
						  'name'=>'Waiting Booking EOI Approval',
					  ));
		$this->insert('lookup_prospect_history',array(
						  'name'=>'Booking EOI Rejected',
					  ));
		$this->insert('lookup_prospect_history',array(
						  'name'=>'Booking EOI Verified',
					  ));					  
		$this->insert('lookup_prospect_history',array(
						  'name'=>'Waiting Booking Approval',
					  ));
		$this->insert('lookup_prospect_history',array(
						  'name'=>'Booking Rejected',
					  ));
		$this->insert('lookup_prospect_history',array(
						  'name'=>'Booking Approved',
					  ));
		$this->insert('lookup_prospect_history',array(
						  'name'=>'Waiting Booking Contract Signed Approval',
					  ));
		$this->insert('lookup_prospect_history',array(
						  'name'=>'Booking Contract Signed Rejected',
					  ));
		$this->insert('lookup_prospect_history',array(
						  'name'=>'Booking Contract Signed Approved',
					  ));
		$this->insert('lookup_prospect_history',array(
						  'name'=>'Waiting Cancel Approval',
					  ));
		$this->insert('lookup_prospect_history',array(
						  'name'=>'Cancel Rejected',
					  ));
		$this->insert('lookup_prospect_history',array(
						  'name'=>'Cancel Approved',
					  ));
		$this->insert('lookup_prospect_history',array(
						  'name'=>'Completed',
					  ));
		$this->insert('lookup_prospect_history',array(
						  'name'=>'Drop',
					  ));
    }

    public function safeDown()
    {
		$this->truncateTable('lookup_prospect_history');
		$this->dropTable('lookup_prospect_history');
    }
}
