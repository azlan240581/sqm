<?php

use yii\db\Migration;

class m000002_000016_lookup_industry_background extends Migration
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
		$this->createTable("lookup_industry_background", array(
		"id" => "pk",
		"name" => "varchar(100) NOT NULL",
		"deleted" => "tinyint(1) DEFAULT 0",
		), "ENGINE=InnoDB");
		
		$this->insert('lookup_industry_background',array(
					  'id'=>'1',
					  'name'=>'Agriculture',
					  ));
		
		$this->insert('lookup_industry_background',array(
					  'id'=>'2',
					  'name'=>'Automotive',
					  ));
		
		$this->insert('lookup_industry_background',array(
					  'id'=>'3',
					  'name'=>'Asset & Wealth Management',
					  ));
		
		$this->insert('lookup_industry_background',array(
					  'id'=>'4',
					  'name'=>'Banking & Financial Services',
					  ));
		
		$this->insert('lookup_industry_background',array(
					  'id'=>'5',
					  'name'=>'Business Association',
					  ));
		
		$this->insert('lookup_industry_background',array(
					  'id'=>'6',
					  'name'=>'Capital project & Infrastructure',
					  ));
		
		$this->insert('lookup_industry_background',array(
					  'id'=>'7',
					  'name'=>'Consumer Market',
					  ));
		
		$this->insert('lookup_industry_background',array(
					  'id'=>'8',
					  'name'=>'Education',
					  ));
		
		$this->insert('lookup_industry_background',array(
					  'id'=>'9',
					  'name'=>'Energy, Utilities & Resources',
					  ));
		
		$this->insert('lookup_industry_background',array(
					  'id'=>'10',
					  'name'=>'Engineering & Construction',
					  ));
		
		$this->insert('lookup_industry_background',array(
					  'id'=>'11',
					  'name'=>'Forest, Paper & Packaging',
					  ));
		
		$this->insert('lookup_industry_background',array(
					  'id'=>'12',
					  'name'=>'Food & Bevarages',
					  ));
		
		$this->insert('lookup_industry_background',array(
					  'id'=>'13',
					  'name'=>'Government & Public services',
					  ));
		
		$this->insert('lookup_industry_background',array(
					  'id'=>'14',
					  'name'=>'Healthcare/ Medical',
					  ));
		
		$this->insert('lookup_industry_background',array(
					  'id'=>'15',
					  'name'=>'Hospitality & Leisure',
					  ));
		
		$this->insert('lookup_industry_background',array(
					  'id'=>'16',
					  'name'=>'Housewife',
					  ));
		
		$this->insert('lookup_industry_background',array(
					  'id'=>'17',
					  'name'=>'Insurance',
					  ));
		
		$this->insert('lookup_industry_background',array(
					  'id'=>'18',
					  'name'=>'Industrial Manufacturing',
					  ));
		
		$this->insert('lookup_industry_background',array(
					  'id'=>'19',
					  'name'=>'Legal',
					  ));
		
		$this->insert('lookup_industry_background',array(
					  'id'=>'20',
					  'name'=>'Media',
					  ));
		
		$this->insert('lookup_industry_background',array(
					  'id'=>'21',
					  'name'=>'Multilevel Management',
					  ));
		
		$this->insert('lookup_industry_background',array(
					  'id'=>'22',
					  'name'=>'Oil & Gas',
					  ));
		
		$this->insert('lookup_industry_background',array(
					  'id'=>'23',
					  'name'=>'Real Estate',
					  ));
		
		$this->insert('lookup_industry_background',array(
					  'id'=>'24',
					  'name'=>'Private Equity',
					  ));
		
		$this->insert('lookup_industry_background',array(
					  'id'=>'25',
					  'name'=>'Pharmaceuticals & life sciences',
					  ));
		
		$this->insert('lookup_industry_background',array(
					  'id'=>'26',
					  'name'=>'Retail',
					  ));
		
		$this->insert('lookup_industry_background',array(
					  'id'=>'27',
					  'name'=>'Technology',
					  ));
		
		$this->insert('lookup_industry_background',array(
					  'id'=>'28',
					  'name'=>'Transportation & Logistics',
					  ));
		
		$this->insert('lookup_industry_background',array(
					  'id'=>'29',
					  'name'=>'Telecomunication',
					  ));
		
		$this->insert('lookup_industry_background',array(
					  'id'=>'30',
					  'name'=>'Others',
					  ));
		
    }

    public function safeDown()
    {
		$this->truncateTable('lookup_industry_background');
		$this->dropTable('lookup_industry_background');
    }
}
