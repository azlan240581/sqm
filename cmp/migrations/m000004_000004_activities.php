<?php

use yii\db\Migration;

class m000004_000004_activities extends Migration
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
		$this->createTable("activities", array(
		"id" => "pk",
		"activity_code" => "varchar(255) NOT NULL",
		"activity_name" => "varchar(255) NOT NULL",
		"activity_description" => "text DEFAULT NULL",
		"points_value" => "decimal(20,4) NOT NULL DEFAULT 0",
		"status" => "tinyint(11) DEFAULT 1",
		"createdby" => "int(11) NOT NULL",
		"createdat" => "datetime NOT NULL",
		"updatedby" => "int(11) DEFAULT NULL",
		"updatedat" => "datetime DEFAULT NULL",
		"deletedby" => "int(11) DEFAULT NULL",
		"deletedat" => "datetime DEFAULT NULL",
		), "ENGINE=InnoDB");
		
		$this->insert("activities",array(
				"activity_code"=>"PROSPECT_FULL_BOOK",
				"activity_name"=>"Prospect Status : Full book",
				"points_value"=>"300",
				"status"=>"1",
				"createdby"=>"1",
				"createdat"=>date("Y-m-d H:i:s"),
			));
		$this->insert("activities",array(
				"activity_code"=>"PROSPECT_VISIT_MARKETING_GALLERY",
				"activity_name"=>"Prospect Status : Visit Marketing Gallery",
				"points_value"=>"20",
				"status"=>"1",
				"createdby"=>"1",
				"createdat"=>date("Y-m-d H:i:s"),
			));
		$this->insert("activities",array(
				"activity_code"=>"PROSPECT_NEW",
				"activity_name"=>"Prospect Status : New Prospect Registered",
				"points_value"=>"0",
				"status"=>"1",
				"createdby"=>"1",
				"createdat"=>date("Y-m-d H:i:s"),
			));
		$this->insert("activities",array(
				"activity_code"=>"PROSPECT_FOLLOW_UP",
				"activity_name"=>"Prospect Status : Follow Up",
				"points_value"=>"0",
				"status"=>"1",
				"createdby"=>"1",
				"createdat"=>date("Y-m-d H:i:s"),
			));
		$this->insert("activities",array(
				"activity_code"=>"PROSPECT_SET_APPOINTMENT",
				"activity_name"=>"Prospect Status : Appointment Scheduled",
				"points_value"=>"10",
				"status"=>"1",
				"createdby"=>"1",
				"createdat"=>date("Y-m-d H:i:s"),
			));
		$this->insert("activities",array(
				"activity_code"=>"ASSOCIATE_REGISTRATION",
				"activity_name"=>"Associate Management : New Associate Registered",
				"points_value"=>"5",
				"status"=>"1",
				"createdby"=>"1",
				"createdat"=>date("Y-m-d H:i:s"),
			));
		$this->insert("activities",array(
				"activity_code"=>"ASSOCIATE_GET_ASSOCIATE",
				"activity_name"=>"Associate Management: Invite Associate",
				"points_value"=>"5",
				"status"=>"1",
				"createdby"=>"1",
				"createdat"=>date("Y-m-d H:i:s"),
			));
		$this->insert("activities",array(
				"activity_code"=>"NEWS_FEED_SHARE_SOCIAL_MEDIA",
				"activity_name"=>"News Feed : Share to Social Media/Messenger",
				"points_value"=>"1",
				"status"=>"1",
				"createdby"=>"1",
				"createdat"=>date("Y-m-d H:i:s"),
			));
		$this->insert("activities",array(
				"activity_code"=>"BANNER_SHARE_SOCIAL_MEDIA",
				"activity_name"=>"Banner : Share to Social Media/Messenger",
				"points_value"=>"0",
				"status"=>"1",
				"createdby"=>"1",
				"createdat"=>date("Y-m-d H:i:s"),
			));
		$this->insert("activities",array(
				"activity_code"=>"ASSOCIATE_DAILY_ACTIVE_POINTS",
				"activity_name"=>"Associate Daily Active Points",
				"points_value"=>"1",
				"status"=>"1",
				"createdby"=>"1",
				"createdat"=>date("Y-m-d H:i:s"),
			));
		$this->insert("activities",array(
				"activity_code"=>"ASSOCIATE_7_DAYS_ACTIVE_POINTS",
				"activity_name"=>"Associate 7 Days Active Points",
				"points_value"=>"5",
				"status"=>"1",
				"createdby"=>"1",
				"createdat"=>date("Y-m-d H:i:s"),
			));
    }

    public function safeDown()
    {
		$this->truncateTable('activities');
		$this->dropTable('activities');
    }
}
