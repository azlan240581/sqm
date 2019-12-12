<?php

use yii\db\Migration;

class m000008_100001_associate_email_verification extends Migration
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
		$this->createTable("associate_email_verification", array(
		"id" => "pk",
		"firstname" => "varchar(100) NOT NULL",
		"lastname" => "varchar(100) NOT NULL",
		"email" => "varchar(100) NOT NULL",
		"verification_code" => "varchar(50) NOT NULL",
		"createdat" => "datetime NOT NULL",
		), "ENGINE=InnoDB");
    }

    public function safeDown()
    {
		$this->truncateTable('associate_email_verification');
		$this->dropTable('associate_email_verification');
    }
}
