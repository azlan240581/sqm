<?php

use yii\db\Migration;

class m000002_000002_lookup_country extends Migration
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
		$this->createTable("lookup_country", array(
		"id" => "pk",
		"name" => "varchar(100) NOT NULL",
		"iso2" => "varchar(2) NOT NULL",
		"iso3" => "varchar(3) NOT NULL",
		"deleted" => "tinyint(1) DEFAULT 0",
		), "ENGINE=InnoDB");
		
		$this->insert("lookup_country",array("id"=>"1","name"=>"Afghanistan","iso2"=>"AF","iso3"=>"AFG",));
		$this->insert("lookup_country",array("id"=>"2","name"=>"Albania","iso2"=>"AL","iso3"=>"ALB",));
		$this->insert("lookup_country",array("id"=>"3","name"=>"Algeria","iso2"=>"DZ","iso3"=>"DZA",));
		$this->insert("lookup_country",array("id"=>"4","name"=>"American Samoa","iso2"=>"AS","iso3"=>"ASM",));
		$this->insert("lookup_country",array("id"=>"5","name"=>"Andorra","iso2"=>"AD","iso3"=>"AND",));
		$this->insert("lookup_country",array("id"=>"6","name"=>"Angola","iso2"=>"AO","iso3"=>"AGO",));
		$this->insert("lookup_country",array("id"=>"7","name"=>"Anguilla","iso2"=>"AI","iso3"=>"AIA",));
		$this->insert("lookup_country",array("id"=>"8","name"=>"Antarctica","iso2"=>"AQ","iso3"=>"ATA",));
		$this->insert("lookup_country",array("id"=>"9","name"=>"Antigua and Barbuda","iso2"=>"AG","iso3"=>"ATG",));
		$this->insert("lookup_country",array("id"=>"10","name"=>"Argentina","iso2"=>"AR","iso3"=>"ARG",));
		$this->insert("lookup_country",array("id"=>"11","name"=>"Armenia","iso2"=>"AM","iso3"=>"ARM",));
		$this->insert("lookup_country",array("id"=>"12","name"=>"Aruba","iso2"=>"AW","iso3"=>"ABW",));
		$this->insert("lookup_country",array("id"=>"13","name"=>"Australia","iso2"=>"AU","iso3"=>"AUS",));
		$this->insert("lookup_country",array("id"=>"14","name"=>"Austria","iso2"=>"AT","iso3"=>"AUT",));
		$this->insert("lookup_country",array("id"=>"15","name"=>"Azerbaijan","iso2"=>"AZ","iso3"=>"AZE",));
		$this->insert("lookup_country",array("id"=>"16","name"=>"Bahamas","iso2"=>"BS","iso3"=>"BHS",));
		$this->insert("lookup_country",array("id"=>"17","name"=>"Bahrain","iso2"=>"BH","iso3"=>"BHR",));
		$this->insert("lookup_country",array("id"=>"18","name"=>"Bangladesh","iso2"=>"BD","iso3"=>"BGD",));
		$this->insert("lookup_country",array("id"=>"19","name"=>"Barbados","iso2"=>"BB","iso3"=>"BRB",));
		$this->insert("lookup_country",array("id"=>"20","name"=>"Belarus","iso2"=>"BY","iso3"=>"BLR",));
		$this->insert("lookup_country",array("id"=>"21","name"=>"Belgium","iso2"=>"BE","iso3"=>"BEL",));
		$this->insert("lookup_country",array("id"=>"22","name"=>"Belize","iso2"=>"BZ","iso3"=>"BLZ",));
		$this->insert("lookup_country",array("id"=>"23","name"=>"Benin","iso2"=>"BJ","iso3"=>"BEN",));
		$this->insert("lookup_country",array("id"=>"24","name"=>"Bermuda","iso2"=>"BM","iso3"=>"BMU",));
		$this->insert("lookup_country",array("id"=>"25","name"=>"Bhutan","iso2"=>"BT","iso3"=>"BTN",));
		$this->insert("lookup_country",array("id"=>"26","name"=>"Bolivia","iso2"=>"BO","iso3"=>"BOL",));
		$this->insert("lookup_country",array("id"=>"27","name"=>"Bosnia and Herzegowina","iso2"=>"BA","iso3"=>"BIH",));
		$this->insert("lookup_country",array("id"=>"28","name"=>"Botswana","iso2"=>"BW","iso3"=>"BWA",));
		$this->insert("lookup_country",array("id"=>"29","name"=>"Bouvet Island","iso2"=>"BV","iso3"=>"BVT",));
		$this->insert("lookup_country",array("id"=>"30","name"=>"Brazil","iso2"=>"BR","iso3"=>"BRA",));
		$this->insert("lookup_country",array("id"=>"31","name"=>"British Indian Ocean Territory","iso2"=>"IO","iso3"=>"IOT",));
		$this->insert("lookup_country",array("id"=>"32","name"=>"Brunei Darussalam","iso2"=>"BN","iso3"=>"BRN",));
		$this->insert("lookup_country",array("id"=>"33","name"=>"Bulgaria","iso2"=>"BG","iso3"=>"BGR",));
		$this->insert("lookup_country",array("id"=>"34","name"=>"Burkina Faso","iso2"=>"BF","iso3"=>"BFA",));
		$this->insert("lookup_country",array("id"=>"35","name"=>"Burundi","iso2"=>"BI","iso3"=>"BDI",));
		$this->insert("lookup_country",array("id"=>"36","name"=>"Cambodia","iso2"=>"KH","iso3"=>"KHM",));
		$this->insert("lookup_country",array("id"=>"37","name"=>"Cameroon","iso2"=>"CM","iso3"=>"CMR",));
		$this->insert("lookup_country",array("id"=>"38","name"=>"Canada","iso2"=>"CA","iso3"=>"CAN",));
		$this->insert("lookup_country",array("id"=>"39","name"=>"Cape Verde","iso2"=>"CV","iso3"=>"CPV",));
		$this->insert("lookup_country",array("id"=>"40","name"=>"Cayman Islands","iso2"=>"KY","iso3"=>"CYM",));
		$this->insert("lookup_country",array("id"=>"41","name"=>"Central African Republic","iso2"=>"CF","iso3"=>"CAF",));
		$this->insert("lookup_country",array("id"=>"42","name"=>"Chad","iso2"=>"TD","iso3"=>"TCD",));
		$this->insert("lookup_country",array("id"=>"43","name"=>"Chile","iso2"=>"CL","iso3"=>"CHL",));
		$this->insert("lookup_country",array("id"=>"44","name"=>"China","iso2"=>"CN","iso3"=>"CHN",));
		$this->insert("lookup_country",array("id"=>"45","name"=>"Christmas Island","iso2"=>"CX","iso3"=>"CXR",));
		$this->insert("lookup_country",array("id"=>"46","name"=>"Cocos (Keeling) Islands","iso2"=>"CC","iso3"=>"CCK",));
		$this->insert("lookup_country",array("id"=>"47","name"=>"Colombia","iso2"=>"CO","iso3"=>"COL",));
		$this->insert("lookup_country",array("id"=>"48","name"=>"Comoros","iso2"=>"KM","iso3"=>"COM",));
		$this->insert("lookup_country",array("id"=>"49","name"=>"Congo","iso2"=>"CG","iso3"=>"COG",));
		$this->insert("lookup_country",array("id"=>"50","name"=>"Cook Islands","iso2"=>"CK","iso3"=>"COK",));
		$this->insert("lookup_country",array("id"=>"51","name"=>"Costa Rica","iso2"=>"CR","iso3"=>"CRI",));
		$this->insert("lookup_country",array("id"=>"52","name"=>"Cote D'Ivoire","iso2"=>"CI","iso3"=>"CIV",));
		$this->insert("lookup_country",array("id"=>"53","name"=>"Croatia","iso2"=>"HR","iso3"=>"HRV",));
		$this->insert("lookup_country",array("id"=>"54","name"=>"Cuba","iso2"=>"CU","iso3"=>"CUB",));
		$this->insert("lookup_country",array("id"=>"55","name"=>"Cyprus","iso2"=>"CY","iso3"=>"CYP",));
		$this->insert("lookup_country",array("id"=>"56","name"=>"Czech Republic","iso2"=>"CZ","iso3"=>"CZE",));
		$this->insert("lookup_country",array("id"=>"57","name"=>"Denmark","iso2"=>"DK","iso3"=>"DNK",));
		$this->insert("lookup_country",array("id"=>"58","name"=>"Djibouti","iso2"=>"DJ","iso3"=>"DJI",));
		$this->insert("lookup_country",array("id"=>"59","name"=>"Dominica","iso2"=>"DM","iso3"=>"DMA",));
		$this->insert("lookup_country",array("id"=>"60","name"=>"Dominican Republic","iso2"=>"DO","iso3"=>"DOM",));
		$this->insert("lookup_country",array("id"=>"61","name"=>"East Timor","iso2"=>"TP","iso3"=>"TMP",));
		$this->insert("lookup_country",array("id"=>"62","name"=>"Ecuador","iso2"=>"EC","iso3"=>"ECU",));
		$this->insert("lookup_country",array("id"=>"63","name"=>"Egypt","iso2"=>"EG","iso3"=>"EGY",));
		$this->insert("lookup_country",array("id"=>"64","name"=>"El Salvador","iso2"=>"SV","iso3"=>"SLV",));
		$this->insert("lookup_country",array("id"=>"65","name"=>"Equatorial Guinea","iso2"=>"GQ","iso3"=>"GNQ",));
		$this->insert("lookup_country",array("id"=>"66","name"=>"Eritrea","iso2"=>"ER","iso3"=>"ERI",));
		$this->insert("lookup_country",array("id"=>"67","name"=>"Estonia","iso2"=>"EE","iso3"=>"EST",));
		$this->insert("lookup_country",array("id"=>"68","name"=>"Ethiopia","iso2"=>"ET","iso3"=>"ETH",));
		$this->insert("lookup_country",array("id"=>"69","name"=>"Falkland Islands (Malvinas)","iso2"=>"FK","iso3"=>"FLK",));
		$this->insert("lookup_country",array("id"=>"70","name"=>"Faroe Islands","iso2"=>"FO","iso3"=>"FRO",));
		$this->insert("lookup_country",array("id"=>"71","name"=>"Fiji","iso2"=>"FJ","iso3"=>"FJI",));
		$this->insert("lookup_country",array("id"=>"72","name"=>"Finland","iso2"=>"FI","iso3"=>"FIN",));
		$this->insert("lookup_country",array("id"=>"73","name"=>"France","iso2"=>"FR","iso3"=>"FRA",));
		$this->insert("lookup_country",array("id"=>"74","name"=>"France, Metropolitan","iso2"=>"FX","iso3"=>"FXX",));
		$this->insert("lookup_country",array("id"=>"75","name"=>"French Guiana","iso2"=>"GF","iso3"=>"GUF",));
		$this->insert("lookup_country",array("id"=>"76","name"=>"French Polynesia","iso2"=>"PF","iso3"=>"PYF",));
		$this->insert("lookup_country",array("id"=>"77","name"=>"French Southern Territories","iso2"=>"TF","iso3"=>"ATF",));
		$this->insert("lookup_country",array("id"=>"78","name"=>"Gabon","iso2"=>"GA","iso3"=>"GAB",));
		$this->insert("lookup_country",array("id"=>"79","name"=>"Gambia","iso2"=>"GM","iso3"=>"GMB",));
		$this->insert("lookup_country",array("id"=>"80","name"=>"Georgia","iso2"=>"GE","iso3"=>"GEO",));
		$this->insert("lookup_country",array("id"=>"81","name"=>"Germany","iso2"=>"DE","iso3"=>"DEU",));
		$this->insert("lookup_country",array("id"=>"82","name"=>"Ghana","iso2"=>"GH","iso3"=>"GHA",));
		$this->insert("lookup_country",array("id"=>"83","name"=>"Gibraltar","iso2"=>"GI","iso3"=>"GIB",));
		$this->insert("lookup_country",array("id"=>"84","name"=>"Greece","iso2"=>"GR","iso3"=>"GRC",));
		$this->insert("lookup_country",array("id"=>"85","name"=>"Greenland","iso2"=>"GL","iso3"=>"GRL",));
		$this->insert("lookup_country",array("id"=>"86","name"=>"Grenada","iso2"=>"GD","iso3"=>"GRD",));
		$this->insert("lookup_country",array("id"=>"87","name"=>"Guadeloupe","iso2"=>"GP","iso3"=>"GLP",));
		$this->insert("lookup_country",array("id"=>"88","name"=>"Guam","iso2"=>"GU","iso3"=>"GUM",));
		$this->insert("lookup_country",array("id"=>"89","name"=>"Guatemala","iso2"=>"GT","iso3"=>"GTM",));
		$this->insert("lookup_country",array("id"=>"90","name"=>"Guinea","iso2"=>"GN","iso3"=>"GIN",));
		$this->insert("lookup_country",array("id"=>"91","name"=>"Guinea-bissau","iso2"=>"GW","iso3"=>"GNB",));
		$this->insert("lookup_country",array("id"=>"92","name"=>"Guyana","iso2"=>"GY","iso3"=>"GUY",));
		$this->insert("lookup_country",array("id"=>"93","name"=>"Haiti","iso2"=>"HT","iso3"=>"HTI",));
		$this->insert("lookup_country",array("id"=>"94","name"=>"Heard and Mc Donald Islands","iso2"=>"HM","iso3"=>"HMD",));
		$this->insert("lookup_country",array("id"=>"95","name"=>"Honduras","iso2"=>"HN","iso3"=>"HND",));
		$this->insert("lookup_country",array("id"=>"96","name"=>"Hong Kong","iso2"=>"HK","iso3"=>"HKG",));
		$this->insert("lookup_country",array("id"=>"97","name"=>"Hungary","iso2"=>"HU","iso3"=>"HUN",));
		$this->insert("lookup_country",array("id"=>"98","name"=>"Iceland","iso2"=>"IS","iso3"=>"ISL",));
		$this->insert("lookup_country",array("id"=>"99","name"=>"India","iso2"=>"IN","iso3"=>"IND",));
		$this->insert("lookup_country",array("id"=>"100","name"=>"Indonesia","iso2"=>"ID","iso3"=>"IDN",));
		$this->insert("lookup_country",array("id"=>"101","name"=>"Iran","iso2"=>"IR","iso3"=>"IRN",));
		$this->insert("lookup_country",array("id"=>"102","name"=>"Iraq","iso2"=>"IQ","iso3"=>"IRQ",));
		$this->insert("lookup_country",array("id"=>"103","name"=>"Ireland","iso2"=>"IE","iso3"=>"IRL",));
		$this->insert("lookup_country",array("id"=>"104","name"=>"Israel","iso2"=>"IL","iso3"=>"ISR",));
		$this->insert("lookup_country",array("id"=>"105","name"=>"Italy","iso2"=>"IT","iso3"=>"ITA",));
		$this->insert("lookup_country",array("id"=>"106","name"=>"Jamaica","iso2"=>"JM","iso3"=>"JAM",));
		$this->insert("lookup_country",array("id"=>"107","name"=>"Japan","iso2"=>"JP","iso3"=>"JPN",));
		$this->insert("lookup_country",array("id"=>"108","name"=>"Jordan","iso2"=>"JO","iso3"=>"JOR",));
		$this->insert("lookup_country",array("id"=>"109","name"=>"Kazakhstan","iso2"=>"KZ","iso3"=>"KAZ",));
		$this->insert("lookup_country",array("id"=>"110","name"=>"Kenya","iso2"=>"KE","iso3"=>"KEN",));
		$this->insert("lookup_country",array("id"=>"111","name"=>"Kiribati","iso2"=>"KI","iso3"=>"KIR",));
		$this->insert("lookup_country",array("id"=>"112","name"=>"Korea, North","iso2"=>"KP","iso3"=>"PRK",));
		$this->insert("lookup_country",array("id"=>"113","name"=>"Korea, South","iso2"=>"KR","iso3"=>"KOR",));
		$this->insert("lookup_country",array("id"=>"114","name"=>"Kuwait","iso2"=>"KW","iso3"=>"KWT",));
		$this->insert("lookup_country",array("id"=>"115","name"=>"Kyrgyzstan","iso2"=>"KG","iso3"=>"KGZ",));
		$this->insert("lookup_country",array("id"=>"116","name"=>"Laos","iso2"=>"LA","iso3"=>"LAO",));
		$this->insert("lookup_country",array("id"=>"117","name"=>"Latvia","iso2"=>"LV","iso3"=>"LVA",));
		$this->insert("lookup_country",array("id"=>"118","name"=>"Lebanon","iso2"=>"LB","iso3"=>"LBN",));
		$this->insert("lookup_country",array("id"=>"119","name"=>"Lesotho","iso2"=>"LS","iso3"=>"LSO",));
		$this->insert("lookup_country",array("id"=>"120","name"=>"Liberia","iso2"=>"LR","iso3"=>"LBR",));
		$this->insert("lookup_country",array("id"=>"121","name"=>"Libyan Arab Jamahiriya","iso2"=>"LY","iso3"=>"LBY",));
		$this->insert("lookup_country",array("id"=>"122","name"=>"Liechtenstein","iso2"=>"LI","iso3"=>"LIE",));
		$this->insert("lookup_country",array("id"=>"123","name"=>"Lithuania","iso2"=>"LT","iso3"=>"LTU",));
		$this->insert("lookup_country",array("id"=>"124","name"=>"Luxembourg","iso2"=>"LU","iso3"=>"LUX",));
		$this->insert("lookup_country",array("id"=>"125","name"=>"Macau","iso2"=>"MO","iso3"=>"MAC",));
		$this->insert("lookup_country",array("id"=>"126","name"=>"Macedonia","iso2"=>"MK","iso3"=>"MKD",));
		$this->insert("lookup_country",array("id"=>"127","name"=>"Madagascar","iso2"=>"MG","iso3"=>"MDG",));
		$this->insert("lookup_country",array("id"=>"128","name"=>"Malawi","iso2"=>"MW","iso3"=>"MWI",));
		$this->insert("lookup_country",array("id"=>"129","name"=>"Malaysia","iso2"=>"MY","iso3"=>"MYS",));
		$this->insert("lookup_country",array("id"=>"130","name"=>"Maldives","iso2"=>"MV","iso3"=>"MDV",));
		$this->insert("lookup_country",array("id"=>"131","name"=>"Mali","iso2"=>"ML","iso3"=>"MLI",));
		$this->insert("lookup_country",array("id"=>"132","name"=>"Malta","iso2"=>"MT","iso3"=>"MLT",));
		$this->insert("lookup_country",array("id"=>"133","name"=>"Marshall Islands","iso2"=>"MH","iso3"=>"MHL",));
		$this->insert("lookup_country",array("id"=>"134","name"=>"Martinique","iso2"=>"MQ","iso3"=>"MTQ",));
		$this->insert("lookup_country",array("id"=>"135","name"=>"Mauritania","iso2"=>"MR","iso3"=>"MRT",));
		$this->insert("lookup_country",array("id"=>"136","name"=>"Mauritius","iso2"=>"MU","iso3"=>"MUS",));
		$this->insert("lookup_country",array("id"=>"137","name"=>"Mayotte","iso2"=>"YT","iso3"=>"MYT",));
		$this->insert("lookup_country",array("id"=>"138","name"=>"Mexico","iso2"=>"MX","iso3"=>"MEX",));
		$this->insert("lookup_country",array("id"=>"139","name"=>"Micronesia","iso2"=>"FM","iso3"=>"FSM",));
		$this->insert("lookup_country",array("id"=>"140","name"=>"Moldova","iso2"=>"MD","iso3"=>"MDA",));
		$this->insert("lookup_country",array("id"=>"141","name"=>"Monaco","iso2"=>"MC","iso3"=>"MCO",));
		$this->insert("lookup_country",array("id"=>"142","name"=>"Mongolia","iso2"=>"MN","iso3"=>"MNG",));
		$this->insert("lookup_country",array("id"=>"143","name"=>"Montserrat","iso2"=>"MS","iso3"=>"MSR",));
		$this->insert("lookup_country",array("id"=>"144","name"=>"Morocco","iso2"=>"MA","iso3"=>"MAR",));
		$this->insert("lookup_country",array("id"=>"145","name"=>"Mozambique","iso2"=>"MZ","iso3"=>"MOZ",));
		$this->insert("lookup_country",array("id"=>"146","name"=>"Myanmar","iso2"=>"MM","iso3"=>"MMR",));
		$this->insert("lookup_country",array("id"=>"147","name"=>"Namibia","iso2"=>"NA","iso3"=>"NAM",));
		$this->insert("lookup_country",array("id"=>"148","name"=>"Nauru","iso2"=>"NR","iso3"=>"NRU",));
		$this->insert("lookup_country",array("id"=>"149","name"=>"Nepal","iso2"=>"NP","iso3"=>"NPL",));
		$this->insert("lookup_country",array("id"=>"150","name"=>"Netherlands","iso2"=>"NL","iso3"=>"NLD",));
		$this->insert("lookup_country",array("id"=>"151","name"=>"Netherlands Antilles","iso2"=>"AN","iso3"=>"ANT",));
		$this->insert("lookup_country",array("id"=>"152","name"=>"New Caledonia","iso2"=>"NC","iso3"=>"NCL",));
		$this->insert("lookup_country",array("id"=>"153","name"=>"New Zealand","iso2"=>"NZ","iso3"=>"NZL",));
		$this->insert("lookup_country",array("id"=>"154","name"=>"Nicaragua","iso2"=>"NI","iso3"=>"NIC",));
		$this->insert("lookup_country",array("id"=>"155","name"=>"Niger","iso2"=>"NE","iso3"=>"NER",));
		$this->insert("lookup_country",array("id"=>"156","name"=>"Nigeria","iso2"=>"NG","iso3"=>"NGA",));
		$this->insert("lookup_country",array("id"=>"157","name"=>"Niue","iso2"=>"NU","iso3"=>"NIU",));
		$this->insert("lookup_country",array("id"=>"158","name"=>"Norfolk Island","iso2"=>"NF","iso3"=>"NFK",));
		$this->insert("lookup_country",array("id"=>"159","name"=>"Northern Mariana Islands","iso2"=>"MP","iso3"=>"MNP",));
		$this->insert("lookup_country",array("id"=>"160","name"=>"Norway","iso2"=>"NO","iso3"=>"NOR",));
		$this->insert("lookup_country",array("id"=>"161","name"=>"Oman","iso2"=>"OM","iso3"=>"OMN",));
		$this->insert("lookup_country",array("id"=>"162","name"=>"Pakistan","iso2"=>"PK","iso3"=>"PAK",));
		$this->insert("lookup_country",array("id"=>"163","name"=>"Palau","iso2"=>"PW","iso3"=>"PLW",));
		$this->insert("lookup_country",array("id"=>"164","name"=>"Panama","iso2"=>"PA","iso3"=>"PAN",));
		$this->insert("lookup_country",array("id"=>"165","name"=>"Papua New Guinea","iso2"=>"PG","iso3"=>"PNG",));
		$this->insert("lookup_country",array("id"=>"166","name"=>"Paraguay","iso2"=>"PY","iso3"=>"PRY",));
		$this->insert("lookup_country",array("id"=>"167","name"=>"Peru","iso2"=>"PE","iso3"=>"PER",));
		$this->insert("lookup_country",array("id"=>"168","name"=>"Philippines","iso2"=>"PH","iso3"=>"PHL",));
		$this->insert("lookup_country",array("id"=>"169","name"=>"Pitcairn","iso2"=>"PN","iso3"=>"PCN",));
		$this->insert("lookup_country",array("id"=>"170","name"=>"Poland","iso2"=>"PL","iso3"=>"POL",));
		$this->insert("lookup_country",array("id"=>"171","name"=>"Portugal","iso2"=>"PT","iso3"=>"PRT",));
		$this->insert("lookup_country",array("id"=>"172","name"=>"Puerto Rico","iso2"=>"PR","iso3"=>"PRI",));
		$this->insert("lookup_country",array("id"=>"173","name"=>"Qatar","iso2"=>"QA","iso3"=>"QAT",));
		$this->insert("lookup_country",array("id"=>"174","name"=>"Reunion","iso2"=>"RE","iso3"=>"REU",));
		$this->insert("lookup_country",array("id"=>"175","name"=>"Romania","iso2"=>"RO","iso3"=>"ROM",));
		$this->insert("lookup_country",array("id"=>"176","name"=>"Russian Federation","iso2"=>"RU","iso3"=>"RUS",));
		$this->insert("lookup_country",array("id"=>"177","name"=>"Rwanda","iso2"=>"RW","iso3"=>"RWA",));
		$this->insert("lookup_country",array("id"=>"178","name"=>"Saint Kitts and Nevis","iso2"=>"KN","iso3"=>"KNA",));
		$this->insert("lookup_country",array("id"=>"179","name"=>"Saint Lucia","iso2"=>"LC","iso3"=>"LCA",));
		$this->insert("lookup_country",array("id"=>"180","name"=>"Saint Vincent and the Grenadines","iso2"=>"VC","iso3"=>"VCT",));
		$this->insert("lookup_country",array("id"=>"181","name"=>"Samoa","iso2"=>"WS","iso3"=>"WSM",));
		$this->insert("lookup_country",array("id"=>"182","name"=>"San Marino","iso2"=>"SM","iso3"=>"SMR",));
		$this->insert("lookup_country",array("id"=>"183","name"=>"Sao Tome and Principe","iso2"=>"ST","iso3"=>"STP",));
		$this->insert("lookup_country",array("id"=>"184","name"=>"Saudi Arabia","iso2"=>"SA","iso3"=>"SAU",));
		$this->insert("lookup_country",array("id"=>"185","name"=>"Senegal","iso2"=>"SN","iso3"=>"SEN",));
		$this->insert("lookup_country",array("id"=>"186","name"=>"Seychelles","iso2"=>"SC","iso3"=>"SYC",));
		$this->insert("lookup_country",array("id"=>"187","name"=>"Sierra Leone","iso2"=>"SL","iso3"=>"SLE",));
		$this->insert("lookup_country",array("id"=>"188","name"=>"Singapore","iso2"=>"SG","iso3"=>"SGP",));
		$this->insert("lookup_country",array("id"=>"189","name"=>"Slovakia","iso2"=>"SK","iso3"=>"SVK",));
		$this->insert("lookup_country",array("id"=>"190","name"=>"Slovenia","iso2"=>"SI","iso3"=>"SVN",));
		$this->insert("lookup_country",array("id"=>"191","name"=>"Solomon Islands","iso2"=>"SB","iso3"=>"SLB",));
		$this->insert("lookup_country",array("id"=>"192","name"=>"Somalia","iso2"=>"SO","iso3"=>"SOM",));
		$this->insert("lookup_country",array("id"=>"193","name"=>"South Africa","iso2"=>"ZA","iso3"=>"ZAF",));
		$this->insert("lookup_country",array("id"=>"194","name"=>"South Georgia and the South Sandwich Islands","iso2"=>"GS","iso3"=>"SGS",));
		$this->insert("lookup_country",array("id"=>"195","name"=>"Spain","iso2"=>"ES","iso3"=>"ESP",));
		$this->insert("lookup_country",array("id"=>"196","name"=>"Sri Lanka","iso2"=>"LK","iso3"=>"LKA",));
		$this->insert("lookup_country",array("id"=>"197","name"=>"St. Helena","iso2"=>"SH","iso3"=>"SHN",));
		$this->insert("lookup_country",array("id"=>"198","name"=>"St. Pierre and Miquelon","iso2"=>"PM","iso3"=>"SPM",));
		$this->insert("lookup_country",array("id"=>"199","name"=>"Sudan","iso2"=>"SD","iso3"=>"SDN",));
		$this->insert("lookup_country",array("id"=>"200","name"=>"Suriname","iso2"=>"SR","iso3"=>"SUR",));
		$this->insert("lookup_country",array("id"=>"201","name"=>"Svalbard and Jan Mayen Islands","iso2"=>"SJ","iso3"=>"SJM",));
		$this->insert("lookup_country",array("id"=>"202","name"=>"Swaziland","iso2"=>"SZ","iso3"=>"SWZ",));
		$this->insert("lookup_country",array("id"=>"203","name"=>"Sweden","iso2"=>"SE","iso3"=>"SWE",));
		$this->insert("lookup_country",array("id"=>"204","name"=>"Switzerland","iso2"=>"CH","iso3"=>"CHE",));
		$this->insert("lookup_country",array("id"=>"205","name"=>"Syria","iso2"=>"SY","iso3"=>"SYR",));
		$this->insert("lookup_country",array("id"=>"206","name"=>"Taiwan","iso2"=>"TW","iso3"=>"TWN",));
		$this->insert("lookup_country",array("id"=>"207","name"=>"Tajikistan","iso2"=>"TJ","iso3"=>"TJK",));
		$this->insert("lookup_country",array("id"=>"208","name"=>"Tanzania","iso2"=>"TZ","iso3"=>"TZA",));
		$this->insert("lookup_country",array("id"=>"209","name"=>"Thailand","iso2"=>"TH","iso3"=>"THA",));
		$this->insert("lookup_country",array("id"=>"210","name"=>"Togo","iso2"=>"TG","iso3"=>"TGO",));
		$this->insert("lookup_country",array("id"=>"211","name"=>"Tokelau","iso2"=>"TK","iso3"=>"TKL",));
		$this->insert("lookup_country",array("id"=>"212","name"=>"Tonga","iso2"=>"TO","iso3"=>"TON",));
		$this->insert("lookup_country",array("id"=>"213","name"=>"Trinidad and Tobago","iso2"=>"TT","iso3"=>"TTO",));
		$this->insert("lookup_country",array("id"=>"214","name"=>"Tunisia","iso2"=>"TN","iso3"=>"TUN",));
		$this->insert("lookup_country",array("id"=>"215","name"=>"Turkey","iso2"=>"TR","iso3"=>"TUR",));
		$this->insert("lookup_country",array("id"=>"216","name"=>"Turkmenistan","iso2"=>"TM","iso3"=>"TKM",));
		$this->insert("lookup_country",array("id"=>"217","name"=>"Turks and Caicos Islands","iso2"=>"TC","iso3"=>"TCA",));
		$this->insert("lookup_country",array("id"=>"218","name"=>"Tuvalu","iso2"=>"TV","iso3"=>"TUV",));
		$this->insert("lookup_country",array("id"=>"219","name"=>"Uganda","iso2"=>"UG","iso3"=>"UGA",));
		$this->insert("lookup_country",array("id"=>"220","name"=>"Ukraine","iso2"=>"UA","iso3"=>"UKR",));
		$this->insert("lookup_country",array("id"=>"221","name"=>"United Arab Emirates","iso2"=>"AE","iso3"=>"ARE",));
		$this->insert("lookup_country",array("id"=>"222","name"=>"United Kingdom","iso2"=>"GB","iso3"=>"GBR",));
		$this->insert("lookup_country",array("id"=>"223","name"=>"United States","iso2"=>"US","iso3"=>"USA",));
		$this->insert("lookup_country",array("id"=>"224","name"=>"United States Minor Outlying Islands","iso2"=>"UM","iso3"=>"UMI",));
		$this->insert("lookup_country",array("id"=>"225","name"=>"Uruguay","iso2"=>"UY","iso3"=>"URY",));
		$this->insert("lookup_country",array("id"=>"226","name"=>"Uzbekistan","iso2"=>"UZ","iso3"=>"UZB",));
		$this->insert("lookup_country",array("id"=>"227","name"=>"Vanuatu","iso2"=>"VU","iso3"=>"VUT",));
		$this->insert("lookup_country",array("id"=>"228","name"=>"Vatican City","iso2"=>"VA","iso3"=>"VAT",));
		$this->insert("lookup_country",array("id"=>"229","name"=>"Venezuela","iso2"=>"VE","iso3"=>"VEN",));
		$this->insert("lookup_country",array("id"=>"230","name"=>"Viet Nam","iso2"=>"VN","iso3"=>"VNM",));
		$this->insert("lookup_country",array("id"=>"231","name"=>"Virgin Islands (British)","iso2"=>"VG","iso3"=>"VGB",));
		$this->insert("lookup_country",array("id"=>"232","name"=>"Virgin Islands (U.S.)","iso2"=>"VI","iso3"=>"VIR",));
		$this->insert("lookup_country",array("id"=>"233","name"=>"Wallis and Futuna Islands","iso2"=>"WF","iso3"=>"WLF",));
		$this->insert("lookup_country",array("id"=>"234","name"=>"Western Sahara","iso2"=>"EH","iso3"=>"ESH",));
		$this->insert("lookup_country",array("id"=>"235","name"=>"Yemen","iso2"=>"YE","iso3"=>"YEM",));
		$this->insert("lookup_country",array("id"=>"236","name"=>"Yugoslavia","iso2"=>"YU","iso3"=>"YUG",));
		$this->insert("lookup_country",array("id"=>"237","name"=>"Zaire","iso2"=>"ZR","iso3"=>"ZAR",));
		$this->insert("lookup_country",array("id"=>"238","name"=>"Zambia","iso2"=>"ZM","iso3"=>"ZMB",));
		$this->insert("lookup_country",array("id"=>"239","name"=>"Zimbabwe","iso2"=>"ZW","iso3"=>"ZWE",));

    }

    public function safeDown()
    {
		$this->truncateTable('lookup_country');
		$this->dropTable('lookup_country');
    }
}
