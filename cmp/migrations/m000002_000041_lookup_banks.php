<?php

use yii\db\Migration;

class m000002_000041_lookup_banks extends Migration
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
		$this->createTable("lookup_banks", array(
			"id" => "pk",
			"name" => "varchar(255) NOT NULL",
			"deleted" => "tinyint(1) DEFAULT 0",
		), "ENGINE=InnoDB");
		
		$this->insert('lookup_banks',array('name'=>'BANK BCA (BANK CENTRAL ASIA)',));
		$this->insert('lookup_banks',array('name'=>'BANK MANDIRI',));
		$this->insert('lookup_banks',array('name'=>'BANK BNI (BANK NEGARA INDONESIA)',));
		$this->insert('lookup_banks',array('name'=>'BANK BNI SYARIAH',));
		$this->insert('lookup_banks',array('name'=>'BANK BRI (BANK RAKYAT INDONESIA)',));
		$this->insert('lookup_banks',array('name'=>'BANK SYARIAH MANDIRI (BSM)',));
		$this->insert('lookup_banks',array('name'=>'BANK CIMB NIAGA',));
		$this->insert('lookup_banks',array('name'=>'BANK CIMB NIAGA SYARIAH',));
		$this->insert('lookup_banks',array('name'=>'BANK MUAMALAT',));
		$this->insert('lookup_banks',array('name'=>'BANK BTPN (BANK TABUNGAN PENSIUNAN NASIONAL)',));
		$this->insert('lookup_banks',array('name'=>'BANK BTPN SYARIAH',));
		$this->insert('lookup_banks',array('name'=>'BANK BRI SYARIAH',));
		$this->insert('lookup_banks',array('name'=>'BANK TABUNGAN NEGARA (BANK BTN)',));
		$this->insert('lookup_banks',array('name'=>'PERMATA BANK',));
		$this->insert('lookup_banks',array('name'=>'BANK DANAMON',));
		$this->insert('lookup_banks',array('name'=>'BANK BII MAYBANK',));
		$this->insert('lookup_banks',array('name'=>'BANK MEGA',));
		$this->insert('lookup_banks',array('name'=>'BANK SINARMAS',));
		$this->insert('lookup_banks',array('name'=>'BANK COMMONWEALTH',));
		$this->insert('lookup_banks',array('name'=>'BANK OCBC NISP',));
		$this->insert('lookup_banks',array('name'=>'BANK BUKOPIN',));
		$this->insert('lookup_banks',array('name'=>'BANK BUKOPIN SYARIAH',));
		$this->insert('lookup_banks',array('name'=>'BANK BCA SYARIAH',));
		$this->insert('lookup_banks',array('name'=>'BANK LIPPO',));
		$this->insert('lookup_banks',array('name'=>'CITIBANK',));
		$this->insert('lookup_banks',array('name'=>'INDOSAT DOMPETKU',));
		$this->insert('lookup_banks',array('name'=>'TELKOMSEL TCASH',));
		$this->insert('lookup_banks',array('name'=>'LINKAJA',));
		$this->insert('lookup_banks',array('name'=>'BANK JABAR',));
		$this->insert('lookup_banks',array('name'=>'BANK DKI JAKARTA',));
		$this->insert('lookup_banks',array('name'=>'BPD DIY (YOGYAKARTA)',));
		$this->insert('lookup_banks',array('name'=>'BANK JATENG (JAWA TENGAH)',));
		$this->insert('lookup_banks',array('name'=>'BANK JATIM (JAWA BARAT)',));
		$this->insert('lookup_banks',array('name'=>'BPD JAMBI',));
		$this->insert('lookup_banks',array('name'=>'BPD ACEH',));
		$this->insert('lookup_banks',array('name'=>'BPD ACEH SYARIAH',));
		$this->insert('lookup_banks',array('name'=>'BANK SUMUT',));
		$this->insert('lookup_banks',array('name'=>'BANK NAGARI (BANK SUMBAR)',));
		$this->insert('lookup_banks',array('name'=>'BANK RIAU KEPRI',));
		$this->insert('lookup_banks',array('name'=>'BANK SUMSEL BABEL',));
		$this->insert('lookup_banks',array('name'=>'BANK LAMPUNG',));
		$this->insert('lookup_banks',array('name'=>'BANK KALSEL (BANK KALIMANTAN SELATAN)',));
		$this->insert('lookup_banks',array('name'=>'BANK KALBAR (BANK KALIMANTAN BARAT)',));
		$this->insert('lookup_banks',array('name'=>'BANK KALTIMTARA (BANK KALIMANTAN TIMUR DAN UTARA)',));
		$this->insert('lookup_banks',array('name'=>'BANK KALTENG (BANK KALIMANTAN TENGAH)',));
		$this->insert('lookup_banks',array('name'=>'BANK SULSELBAR (BANK SULAWESI SELATAN DAN BARAT)',));
		$this->insert('lookup_banks',array('name'=>'BANK SULUTGO (BANK SULAWESI UTARA DAN GORONTALO)',));
		$this->insert('lookup_banks',array('name'=>'BANK NTB',));
		$this->insert('lookup_banks',array('name'=>'BANK NTB SYARIAH',));
		$this->insert('lookup_banks',array('name'=>'BANK BPD BALI',));
		$this->insert('lookup_banks',array('name'=>'BANK NTT',));
		$this->insert('lookup_banks',array('name'=>'BANK MALUKU MALUT',));
		$this->insert('lookup_banks',array('name'=>'BANK PAPUA',));
		$this->insert('lookup_banks',array('name'=>'BANK BENGKULU',));
		$this->insert('lookup_banks',array('name'=>'BANK SULTENG (BANK SULAWESI TENGAH)',));
		$this->insert('lookup_banks',array('name'=>'BANK SULTRA',));
		$this->insert('lookup_banks',array('name'=>'BANK BPD BANTEN',));
		$this->insert('lookup_banks',array('name'=>'BANK EKSPOR INDONESIA',));
		$this->insert('lookup_banks',array('name'=>'BANK PANIN',));
		$this->insert('lookup_banks',array('name'=>'BANK PANIN DUBAI SYARIAH',));
		$this->insert('lookup_banks',array('name'=>'BANK ARTA NIAGA KENCANA',));
		$this->insert('lookup_banks',array('name'=>'BANK UOB INDONESIA (BANK BUANA INDONESIA)',));
		$this->insert('lookup_banks',array('name'=>'AMERICAN EXPRESS BANK LTD',));
		$this->insert('lookup_banks',array('name'=>'CITIBANK N.A.',));
		$this->insert('lookup_banks',array('name'=>'JP. MORGAN CHASE BANK, N.A.',));
		$this->insert('lookup_banks',array('name'=>'BANK OF AMERICA, N.A',));
		$this->insert('lookup_banks',array('name'=>'ING INDONESIA BANK',));
		$this->insert('lookup_banks',array('name'=>'BANK MULTICOR',));
		$this->insert('lookup_banks',array('name'=>'BANK ARTHA GRAHA INTERNASIONAL',));
		$this->insert('lookup_banks',array('name'=>'BANK CREDIT AGRICOLE INDOSUEZ',));
		$this->insert('lookup_banks',array('name'=>'THE BANGKOK BANK COMP. LTD',));
		$this->insert('lookup_banks',array('name'=>'THE HONGKONG & SHANGHAI B.C. (BANK HSBC)',));
		$this->insert('lookup_banks',array('name'=>'THE BANK OF TOKYO MITSUBISHI UFJ LTD',));
		$this->insert('lookup_banks',array('name'=>'BANK SUMITOMO MITSUI INDONESIA',));
		$this->insert('lookup_banks',array('name'=>'BANK DBS INDONESIA',));
		$this->insert('lookup_banks',array('name'=>'DIGIBANK',));
		$this->insert('lookup_banks',array('name'=>'BANK RESONA PERDANIA',));
		$this->insert('lookup_banks',array('name'=>'BANK MIZUHO INDONESIA',));
		$this->insert('lookup_banks',array('name'=>'STANDARD CHARTERED BANK',));
		$this->insert('lookup_banks',array('name'=>'BANK ABN AMRO',));
		$this->insert('lookup_banks',array('name'=>'BANK KEPPEL TATLEE BUANA',));
		$this->insert('lookup_banks',array('name'=>'BANK CAPITAL INDONESIA',));
		$this->insert('lookup_banks',array('name'=>'BANK BNP PARIBAS INDONESIA',));
		$this->insert('lookup_banks',array('name'=>'BANK UOB INDONESIA',));
		$this->insert('lookup_banks',array('name'=>'KOREA EXCHANGE BANK DANAMON',));
		$this->insert('lookup_banks',array('name'=>'RABOBANK INTERNASIONAL INDONESIA',));
		$this->insert('lookup_banks',array('name'=>'BANK ANZ INDONESIA',));
		$this->insert('lookup_banks',array('name'=>'BANK WOORI SAUDARA',));
		$this->insert('lookup_banks',array('name'=>'BANK OF CHINA',));
		$this->insert('lookup_banks',array('name'=>'BANK BUMI ARTA',));
		$this->insert('lookup_banks',array('name'=>'BANK EKONOMI',));
		$this->insert('lookup_banks',array('name'=>'BANK ANTARDAERAH',));
		$this->insert('lookup_banks',array('name'=>'BANK HAGA',));
		$this->insert('lookup_banks',array('name'=>'BANK IFI',));
		$this->insert('lookup_banks',array('name'=>'BANK CENTURY',));
		$this->insert('lookup_banks',array('name'=>'BANK MAYAPADA',));
		$this->insert('lookup_banks',array('name'=>'BANK NUSANTARA PARAHYANGAN',));
		$this->insert('lookup_banks',array('name'=>'BANK SWADESI (BANK OF INDIA INDONESIA)',));
		$this->insert('lookup_banks',array('name'=>'BANK MESTIKA DHARMA',));
		$this->insert('lookup_banks',array('name'=>'BANK SHINHAN INDONESIA (BANK METRO EXPRESS)',));
		$this->insert('lookup_banks',array('name'=>'BANK MASPION INDONESIA',));
		$this->insert('lookup_banks',array('name'=>'BANK HAGAKITA',));
		$this->insert('lookup_banks',array('name'=>'BANK GANESHA',));
		$this->insert('lookup_banks',array('name'=>'BANK WINDU KENTJANA',));
		$this->insert('lookup_banks',array('name'=>'BANK ICBC INDONESIA (HALIM INDONESIA BANK)',));
		$this->insert('lookup_banks',array('name'=>'BANK HARMONI INTERNATIONAL',));
		$this->insert('lookup_banks',array('name'=>'BANK QNB KESAWAN (BANK QNB INDONESIA)',));
		$this->insert('lookup_banks',array('name'=>'BANK HIMPUNAN SAUDARA 1906',));
		$this->insert('lookup_banks',array('name'=>'BANK SWAGUNA',));
		$this->insert('lookup_banks',array('name'=>'BANK BISNIS INTERNASIONAL',));
		$this->insert('lookup_banks',array('name'=>'BANK SRI PARTHA',));
		$this->insert('lookup_banks',array('name'=>'BANK JASA JAKARTA',));
		$this->insert('lookup_banks',array('name'=>'BANK BINTANG MANUNGGAL',));
		$this->insert('lookup_banks',array('name'=>'BANK MNC INTERNASIONAL (BANK BUMIPUTERA)',));
		$this->insert('lookup_banks',array('name'=>'BANK YUDHA BHAKTI',));
		$this->insert('lookup_banks',array('name'=>'BANK MITRANIAGA',));
		$this->insert('lookup_banks',array('name'=>'BANK BRI AGRO NIAGA',));
		$this->insert('lookup_banks',array('name'=>'BANK SBI INDONESIA (BANK INDOMONEX)',));
		$this->insert('lookup_banks',array('name'=>'BANK ROYAL INDONESIA',));
		$this->insert('lookup_banks',array('name'=>'BANK NATIONAL NOBU (BANK ALFINDO)',));
		$this->insert('lookup_banks',array('name'=>'BANK MEGA SYARIAH',));
		$this->insert('lookup_banks',array('name'=>'BANK INA PERDANA',));
		$this->insert('lookup_banks',array('name'=>'BANK HARFA',));
		$this->insert('lookup_banks',array('name'=>'PRIMA MASTER BANK',));
		$this->insert('lookup_banks',array('name'=>'BANK PERSYARIKATAN INDONESIA',));
		$this->insert('lookup_banks',array('name'=>'BANK AKITA',));
		$this->insert('lookup_banks',array('name'=>'LIMAN INTERNATIONAL BANK',));
		$this->insert('lookup_banks',array('name'=>'ANGLOMAS INTERNASIONAL BANK',));
		$this->insert('lookup_banks',array('name'=>'BANK SAHABAT SAMPEORNA (BANK DIPO INTERNATIONAL)',));
		$this->insert('lookup_banks',array('name'=>'BANK KESEJAHTERAAN EKONOMI',));
		$this->insert('lookup_banks',array('name'=>'BANK ARTOS INDONESIA',));
		$this->insert('lookup_banks',array('name'=>'BANK PURBA DANARTA',));
		$this->insert('lookup_banks',array('name'=>'BANK MULTI ARTA SENTOSA',));
		$this->insert('lookup_banks',array('name'=>'BANK MAYORA INDONESIA',));
		$this->insert('lookup_banks',array('name'=>'BANK INDEX SELINDO',));
		$this->insert('lookup_banks',array('name'=>'BANK VICTORIA INTERNATIONAL',));
		$this->insert('lookup_banks',array('name'=>'BANK EKSEKUTIF',));
		$this->insert('lookup_banks',array('name'=>'CENTRATAMA NASIONAL BANK',));
		$this->insert('lookup_banks',array('name'=>'BANK FAMA INTERNASIONAL',));
		$this->insert('lookup_banks',array('name'=>'BANK MANDIRI TASPEN POS (BANK SINAR HARAPAN BALI)',));
		$this->insert('lookup_banks',array('name'=>'BANK HARDA',));
		$this->insert('lookup_banks',array('name'=>'BANK AGRIS (BANK FINCONESIA)',));
		$this->insert('lookup_banks',array('name'=>'BANK MERINCORP',));
		$this->insert('lookup_banks',array('name'=>'BANK MAYBANK INDOCORP',));
		$this->insert('lookup_banks',array('name'=>'BANK OCBC – INDONESIA',));
		$this->insert('lookup_banks',array('name'=>'BANK CTBC (CHINA TRUST) INDONESIA',));
		$this->insert('lookup_banks',array('name'=>'BANK BJB SYARIAH',));
		$this->insert('lookup_banks',array('name'=>'BPR KS (KARYAJATNIKA SEDAYA)',));		
    }

    public function safeDown()
    {
		$this->truncateTable('lookup_banks');
		$this->dropTable('lookup_banks');
    }
}
