<?php

use yii\db\Migration;

class m000004_000009_prospect_bookings extends Migration
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
		$this->createTable("prospect_bookings", array(
			"id" => "pk",
			"ref_no" => "varchar(255) DEFAULT NULL",
			"prospect_id" => "int(11) NOT NULL",
			"agent_id" => "int(11) NOT NULL",
			"member_id" => "int(11) NOT NULL",
			"dedicated_agent_id" => "int(11) NOT NULL",
			"referrer_member_id" => "int(11) DEFAULT NULL",
			"developer_id" => "int(11) NOT NULL",
			"project_id" => "int(11) NOT NULL",
			"product_id" => "int(11) DEFAULT NULL", //from project_products
			"product_unit" => "varchar(100) DEFAULT NULL",
			"product_unit_type" => "int(11) DEFAULT NULL", //from project_product_unit_types
			"building_size_sm" => "decimal(10,4) DEFAULT NULL", //from project_product_unit_types
			"land_size_sm" => "decimal(10,4) DEFAULT NULL", //from project_product_unit_types
			"product_unit_price" => "decimal(20,4) DEFAULT NULL",
			"product_unit_vat_price" => "decimal(20,4) DEFAULT NULL",
			"express_downpayment" => "tinyint(1) DEFAULT NULL",
			"eoi_ref_no" => "varchar(255) DEFAULT NULL",
			"payment_method_eoi" => "int(11) DEFAULT NULL",
			"booking_eoi_amount" => "decimal(20,4) DEFAULT NULL",
			"proof_of_payment_eoi" => "varchar(255) DEFAULT NULL",
			"booking_date_eoi" => "date DEFAULT NULL",
			"booking_ref_no" => "varchar(255) DEFAULT NULL",
			"payment_method" => "int(11) DEFAULT NULL",
			"booking_amount" => "decimal(20,4) DEFAULT NULL",
			"proof_of_payment" => "varchar(255) DEFAULT NULL",
			"booking_date" => "date DEFAULT NULL",
			"sp_file" => "varchar(255) DEFAULT NULL",
			"ppjb_file" => "varchar(255) DEFAULT NULL",
			"cancel_ref_no" => "varchar(255) DEFAULT NULL",
			"cancellation_attachment" => "varchar(255) DEFAULT NULL",
			"remarks" => "text DEFAULT NULL",
			"status" => "int(11) NOT NULL",
			"createdby" => "int(11) NOT NULL",
			"createdat" => "datetime NOT NULL",
			"updatedby" => "int(11) DEFAULT NULL",
			"updatedat" => "datetime DEFAULT NULL",
			"deletedby" => "int(11) DEFAULT NULL",
			"deletedat" => "datetime DEFAULT NULL",
		), "ENGINE=InnoDB");
    }

    public function safeDown()
    {
		$this->truncateTable('prospect_bookings');
		$this->dropTable('prospect_bookings');
    }
}
