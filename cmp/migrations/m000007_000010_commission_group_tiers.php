<?php

use yii\db\Migration;

class m000007_000010_commission_group_tiers extends Migration
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
		$this->createTable("commission_group_tiers", array(
		"id" => "pk",
		"product_type_id" => "int(11) NOT NULL",
		"commission_group_id" => "int(11) NOT NULL",
		"commission_tier_id" => "int(11) NOT NULL",
		"minimum_transaction_value" => "decimal(20,4) NOT NULL",
		"maximum_transaction_value" => "decimal(20,4) DEFAULT NULL",
		"commission_type" => "int(11) NOT NULL",
		"commission_value" => "decimal(20,4) NOT NULL",
		"expiration_period" => "int(11) NOT NULL",
		"createdby" => "int(11) NOT NULL",
		"createdat" => "datetime NOT NULL",
		"updatedby" => "int(11) DEFAULT NULL",
		"updatedat" => "datetime DEFAULT NULL",
		"deletedby" => "int(11) DEFAULT NULL",
		"deletedat" => "datetime DEFAULT NULL",
		), "ENGINE=InnoDB");
		
		$sql = "INSERT INTO commission_group_tiers (`product_type_id`, `commission_group_id`, `commission_tier_id`, `minimum_transaction_value`, `maximum_transaction_value`, `commission_type`, `commission_value`, `expiration_period`, `createdby`, `createdat`, `updatedby`, `updatedat`, `deletedby`, `deletedat`) VALUES 
				(1, 1, 1, '0.0000', '30000000000.0000', 1, '0.5000', 12, 1, '2019-09-26 16:31:23', 2, '2019-09-27 10:33:34', NULL, NULL),
				(1, 1, 2, '30000000001.0000', '60000000000.0000', 1, '0.6500', 12, 1, '2019-09-26 16:31:23', 2, '2019-09-27 10:33:34', NULL, NULL),
				(1, 1, 3, '60000000001.0000', '0.0000', 1, '0.8000', 12, 1, '2019-09-26 16:31:23', 2, '2019-09-27 10:33:34', NULL, NULL),
				(1, 2, 1, '0.0000', '0.0000', 1, '1.5000', 12, 1, '2019-09-26 16:32:01', 2, '2019-09-27 10:33:34', NULL, NULL),
				(1, 2, 2, '0.0000', '0.0000', 1, '1.5000', 12, 1, '2019-09-26 16:32:01', 2, '2019-09-27 10:33:34', NULL, NULL),
				(1, 2, 3, '0.0000', '0.0000', 1, '1.5000', 12, 1, '2019-09-26 16:32:01', 2, '2019-09-27 10:33:34', NULL, NULL),
				(1, 3, 1, '0.0000', '2000000000.0000', 1, '1.0000', 12, 1, '2019-09-26 16:32:42', 2, '2019-09-27 10:33:34', NULL, NULL),
				(1, 3, 2, '2000000001.0000', '5000000000.0000', 1, '1.2500', 12, 1, '2019-09-26 16:32:42', 2, '2019-09-27 10:33:34', NULL, NULL),
				(1, 3, 3, '5000000001.0000', '0.0000', 1, '1.5000', 12, 1, '2019-09-26 16:32:42', 2, '2019-09-27 10:33:34', NULL, NULL),
				(1, 4, 1, '0.0000', '0.0000', 1, '1.5000', 12, 1, '2019-09-26 16:33:06', 2, '2019-09-27 10:33:34', NULL, NULL),
				(1, 4, 2, '0.0000', '0.0000', 1, '1.5000', 12, 1, '2019-09-26 16:33:06', 2, '2019-09-27 10:33:34', NULL, NULL),
				(1, 4, 3, '0.0000', '0.0000', 1, '1.5000', 12, 1, '2019-09-26 16:33:06', 2, '2019-09-27 10:33:34', NULL, NULL),
				(1, 5, 1, '0.0000', '0.0000', 1, '0.4000', 12, 1, '2019-09-26 16:33:51', 2, '2019-09-27 10:33:34', NULL, NULL),
				(1, 5, 2, '0.0000', '0.0000', 1, '0.4000', 12, 1, '2019-09-26 16:33:51', 2, '2019-09-27 10:33:34', NULL, NULL),
				(1, 5, 3, '0.0000', '0.0000', 1, '0.4000', 12, 1, '2019-09-26 16:33:51', 2, '2019-09-27 10:33:34', NULL, NULL),
				(1, 6, 1, '0.0000', '0.0000', 1, '0.5000', 12, 1, '2019-09-26 16:36:24', 2, '2019-09-27 10:33:34', NULL, NULL),
				(1, 6, 2, '0.0000', '0.0000', 1, '0.5000', 12, 1, '2019-09-26 16:36:24', 2, '2019-09-27 10:33:34', NULL, NULL),
				(1, 6, 3, '0.0000', '0.0000', 1, '0.5000', 12, 1, '2019-09-26 16:36:24', 2, '2019-09-27 10:33:34', NULL, NULL),
				(1, 7, 1, '1000000000.0000', '0.0000', 2, '1000000.0000', 12, 1, '2019-09-26 16:37:00', 2, '2019-09-27 10:33:34', NULL, NULL),
				(1, 7, 2, '1000000000.0000', '0.0000', 2, '1000000.0000', 12, 1, '2019-09-26 16:37:00', 2, '2019-09-27 10:33:34', NULL, NULL),
				(1, 7, 3, '1000000000.0000', '0.0000', 2, '1000000.0000', 12, 1, '2019-09-26 16:37:00', 2, '2019-09-27 10:33:34', NULL, NULL);
			 ";
		
		$this->execute($sql);
		
		
    }

    public function safeDown()
    {
		$this->truncateTable('commission_group_tiers');
		$this->dropTable('commission_group_tiers');
    }
}
