<?php

use yii\db\Migration;

class m000002_000032_lookup_bank_loan_proposal_status extends Migration
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
		$this->createTable("lookup_bank_loan_proposal_status", array(
		"id" => "pk",
		"name" => "varchar(100) NOT NULL",
		"deleted" => "tinyint(1) DEFAULT 0",
		), "ENGINE=InnoDB");
		
		$this->insert('lookup_bank_loan_proposal_status',array(
						  'id'=>'1',
						  'name'=>'Pending',
					  ));
		
		$this->insert('lookup_bank_loan_proposal_status',array(
						  'id'=>'2',
						  'name'=>'Approved',
					  ));
		
		$this->insert('lookup_bank_loan_proposal_status',array(
						  'id'=>'3',
						  'name'=>'Rejected',
					  ));
		
		$this->insert('lookup_bank_loan_proposal_status',array(
						  'id'=>'4',
						  'name'=>'Applied',
					  ));
    }

    public function safeDown()
    {
		$this->truncateTable('lookup_bank_loan_proposal_status');
		$this->dropTable('lookup_bank_loan_proposal_status');
    }
}
