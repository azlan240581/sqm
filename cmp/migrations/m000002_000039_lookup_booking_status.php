<?php

use yii\db\Migration;

class m000002_000039_lookup_booking_status extends Migration
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
		$this->createTable("lookup_booking_status", array(
			"id" => "pk",
			"name" => "varchar(255) NOT NULL",
			"deleted" => "tinyint(1) DEFAULT 0",
		), "ENGINE=InnoDB");
		
		$this->insert('lookup_booking_status',array(
						  'name'=>'Waiting Booking EOI Approval',
					  ));
		$this->insert('lookup_booking_status',array(
						  'name'=>'Reject Booking EOI',
					  ));
		$this->insert('lookup_booking_status',array(
						  'name'=>'Approved Booking EOI',
					  ));
		$this->insert('lookup_booking_status',array(
						  'name'=>'Waiting Booking Approval',
					  ));
		$this->insert('lookup_booking_status',array(
						  'name'=>'Reject Booking',
					  ));
		$this->insert('lookup_booking_status',array(
						  'name'=>'Approved Booking',
					  ));
		$this->insert('lookup_booking_status',array(
						  'name'=>'Waiting Booking Contract Signed Approval',
					  ));
		$this->insert('lookup_booking_status',array(
						  'name'=>'Reject Booking Contract Signed',
					  ));
		$this->insert('lookup_booking_status',array(
						  'name'=>'Approved Booking Contract Signed',
					  ));
		$this->insert('lookup_booking_status',array(
						  'name'=>'Waiting Cancel Approval',
					  ));
		$this->insert('lookup_booking_status',array(
						  'name'=>'Reject Cancel',
					  ));
		$this->insert('lookup_booking_status',array(
						  'name'=>'Approved Cancel',
					  ));
    }

    public function safeDown()
    {
		$this->truncateTable('lookup_booking_status');
		$this->dropTable('lookup_booking_status');
    }
}
