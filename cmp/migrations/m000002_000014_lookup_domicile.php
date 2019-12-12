<?php

use yii\db\Migration;

class m000002_000014_lookup_domicile extends Migration
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
		$this->createTable("lookup_domicile", array(
		"id" => "pk",
		"name" => "varchar(100) NOT NULL",
		"deleted" => "tinyint(1) DEFAULT 0",
		), "ENGINE=InnoDB");
		
		$this->insert('lookup_domicile',array('name'=>'East Jakarta',));
		$this->insert('lookup_domicile',array('name'=>'Surabaya',));
		$this->insert('lookup_domicile',array('name'=>'Medan',));
		$this->insert('lookup_domicile',array('name'=>'Bekasi',));
		$this->insert('lookup_domicile',array('name'=>'Bandung',));
		$this->insert('lookup_domicile',array('name'=>'West Jakarta',));
		$this->insert('lookup_domicile',array('name'=>'South Jakarta',));
		$this->insert('lookup_domicile',array('name'=>'Makassar',));
		$this->insert('lookup_domicile',array('name'=>'North Jakarta',));
		$this->insert('lookup_domicile',array('name'=>'Depok',));
		$this->insert('lookup_domicile',array('name'=>'Semarang',));
		$this->insert('lookup_domicile',array('name'=>'Tangerang',));
		$this->insert('lookup_domicile',array('name'=>'Palembang',));
		$this->insert('lookup_domicile',array('name'=>'South Tangerang',));
		$this->insert('lookup_domicile',array('name'=>'Bandar Lampung',));
		$this->insert('lookup_domicile',array('name'=>'Central Jakarta',));
		$this->insert('lookup_domicile',array('name'=>'Batam',));
		$this->insert('lookup_domicile',array('name'=>'Bogor',));
		$this->insert('lookup_domicile',array('name'=>'Padang',));
		$this->insert('lookup_domicile',array('name'=>'Pekanbaru',));
		$this->insert('lookup_domicile',array('name'=>'Malang',));
		$this->insert('lookup_domicile',array('name'=>'Samarinda',));
		$this->insert('lookup_domicile',array('name'=>'Tasikmalaya',));
		$this->insert('lookup_domicile',array('name'=>'Pontianak',));
		$this->insert('lookup_domicile',array('name'=>'Banjarmasin',));
		$this->insert('lookup_domicile',array('name'=>'Denpasar',));
		$this->insert('lookup_domicile',array('name'=>'Serang',));
		$this->insert('lookup_domicile',array('name'=>'Jambi',));
		$this->insert('lookup_domicile',array('name'=>'Balikpapan',));
		$this->insert('lookup_domicile',array('name'=>'Surakarta',));
		$this->insert('lookup_domicile',array('name'=>'Cimahi',));
		$this->insert('lookup_domicile',array('name'=>'Manado',));
		$this->insert('lookup_domicile',array('name'=>'Kupang',));
		$this->insert('lookup_domicile',array('name'=>'Jayapura',));
		$this->insert('lookup_domicile',array('name'=>'Mataram',));
		$this->insert('lookup_domicile',array('name'=>'Yogyakarta',));
		$this->insert('lookup_domicile',array('name'=>'Cilegon',));
		$this->insert('lookup_domicile',array('name'=>'Ambon',));
		$this->insert('lookup_domicile',array('name'=>'Bengkulu',));
		$this->insert('lookup_domicile',array('name'=>'Palu',));
		$this->insert('lookup_domicile',array('name'=>'Kendari',));
		$this->insert('lookup_domicile',array('name'=>'Sukabumi',));
		$this->insert('lookup_domicile',array('name'=>'Cirebon',));
		$this->insert('lookup_domicile',array('name'=>'Pekalongan',));
		$this->insert('lookup_domicile',array('name'=>'Kediri',));
		$this->insert('lookup_domicile',array('name'=>'Pematangsiantar',));
		$this->insert('lookup_domicile',array('name'=>'Tegal',));
		$this->insert('lookup_domicile',array('name'=>'Sorong',));
		$this->insert('lookup_domicile',array('name'=>'Binjai',));
		$this->insert('lookup_domicile',array('name'=>'Dumai',));
		$this->insert('lookup_domicile',array('name'=>'Palangka Raya',));
		$this->insert('lookup_domicile',array('name'=>'Banda Aceh',));
		$this->insert('lookup_domicile',array('name'=>'Singkawang',));
		$this->insert('lookup_domicile',array('name'=>'Probolinggo',));
		$this->insert('lookup_domicile',array('name'=>'Padang Sidempuan',));
		$this->insert('lookup_domicile',array('name'=>'Bitung',));
		$this->insert('lookup_domicile',array('name'=>'Banjarbaru',));
		$this->insert('lookup_domicile',array('name'=>'Ternate',));
		$this->insert('lookup_domicile',array('name'=>'Lubuklinggau',));
		$this->insert('lookup_domicile',array('name'=>'Pasuruan',));
		$this->insert('lookup_domicile',array('name'=>'Tanjung Pinang',));
		$this->insert('lookup_domicile',array('name'=>'Pangkal Pinang',));
		$this->insert('lookup_domicile',array('name'=>'Madiun',));
		$this->insert('lookup_domicile',array('name'=>'Tarakan',));
		$this->insert('lookup_domicile',array('name'=>'Batu',));
		$this->insert('lookup_domicile',array('name'=>'Gorontalo',));
		$this->insert('lookup_domicile',array('name'=>'Banjar',));
		$this->insert('lookup_domicile',array('name'=>'Lhokseumawe',));
		$this->insert('lookup_domicile',array('name'=>'Prabumulih',));
		$this->insert('lookup_domicile',array('name'=>'Palopo',));
		$this->insert('lookup_domicile',array('name'=>'Langsa',));
		$this->insert('lookup_domicile',array('name'=>'Salatiga',));
		$this->insert('lookup_domicile',array('name'=>'Parepare',));
		$this->insert('lookup_domicile',array('name'=>'Tebing Tinggi',));
		$this->insert('lookup_domicile',array('name'=>'Tanjungbalai',));
		$this->insert('lookup_domicile',array('name'=>'Metro',));
		$this->insert('lookup_domicile',array('name'=>'Bontang',));
		$this->insert('lookup_domicile',array('name'=>'Baubau',));
		$this->insert('lookup_domicile',array('name'=>'Blitar',));
		$this->insert('lookup_domicile',array('name'=>'Gunungsitoli',));
		$this->insert('lookup_domicile',array('name'=>'Bima',));
		$this->insert('lookup_domicile',array('name'=>'Pagar Alam',));
		$this->insert('lookup_domicile',array('name'=>'Mojokerto',));
		$this->insert('lookup_domicile',array('name'=>'Payakumbuh',));
		$this->insert('lookup_domicile',array('name'=>'Magelang',));
		$this->insert('lookup_domicile',array('name'=>'Kotamobagu',));
		$this->insert('lookup_domicile',array('name'=>'Bukittinggi',));
		$this->insert('lookup_domicile',array('name'=>'Tidore',));
		$this->insert('lookup_domicile',array('name'=>'Sungai Penuh',));
		$this->insert('lookup_domicile',array('name'=>'Tomohon',));
		$this->insert('lookup_domicile',array('name'=>'Sibolga',));
		$this->insert('lookup_domicile',array('name'=>'Pariaman',));
		$this->insert('lookup_domicile',array('name'=>'Tual',));
		$this->insert('lookup_domicile',array('name'=>'Subulussalam',));
		$this->insert('lookup_domicile',array('name'=>'Solok',));
		$this->insert('lookup_domicile',array('name'=>'Sawahlunto',));
		$this->insert('lookup_domicile',array('name'=>'Padang Panjang',));
		$this->insert('lookup_domicile',array('name'=>'Sabang',));
			}

    public function safeDown()
    {
		$this->truncateTable('lookup_domicile');
		$this->dropTable('lookup_domicile');
    }
}
