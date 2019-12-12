<?php

use yii\db\Migration;

class m000004_000001_bank_points extends Migration
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
		$this->createTable("bank_points", array(
		"id" => "pk",
		"credits" => "decimal(20,4) DEFAULT 0",
		"createdby" => "int(11) NOT NULL",
		"createdat" => "datetime NOT NULL",
		"updatedby" => "int(11) DEFAULT NULL",
		"updatedat" => "datetime DEFAULT NULL",
		), "ENGINE=InnoDB");
		
		$this->insert("bank_points",array("credits"=>1000000000000000,"createdby"=>"1","createdat"=>date("Y-m-d H:i:s"),));
    }

    public function safeDown()
    {
		$this->truncateTable('bank_points');
		$this->dropTable('bank_points');
    }
}
