<?php

use yii\db\Migration;

class m000010_000001_truncate_table extends Migration
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
		/*$this->truncateTable('user_points');
		$this->truncateTable('user_associate_details');
		$this->truncateTable('user_groups');
		$this->truncateTable('log_associate_activities');
		$this->truncateTable('log_bank_points');
		$this->truncateTable('log_prospect_history');
		$this->truncateTable('log_user_commission');
		$this->truncateTable('log_user_messages');
		$this->truncateTable('log_user_points');
		$this->truncateTable('prospects');
		$this->truncateTable('prospect_bookings');
		$this->truncateTable('prospect_booking_buyers');
		$this->truncateTable('prospect_interested_projects');
		$this->truncateTable('user_commissions');
		$this->truncateTable('user_eligible_commissions');
		$this->truncateTable('user_messages');*/
	}

    public function safeDown()
    {
    }
}
