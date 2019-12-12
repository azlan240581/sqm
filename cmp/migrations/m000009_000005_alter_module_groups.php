<?php

use yii\db\Migration;

class m000009_000005_alter_module_groups extends Migration
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
		//Clear Modules
		$this->truncateTable('module_groups');
		
		$sql = "INSERT INTO module_groups (`module_id`, `groupaccess_id`, `permission`) VALUES 
				(1, 1, 'a:1:{i:0;s:5:\"index\";}'),
				(2, 1, 'a:1:{i:0;s:5:\"index\";}'),
				(3, 1, 'a:1:{i:0;s:5:\"index\";}'),
				(4, 1, 'a:6:{i:0;s:5:\"index\";i:1;s:4:\"view\";i:2;s:6:\"create\";i:3;s:6:\"update\";i:4;s:13:\"toggle-status\";i:5;s:6:\"delete\";}'),
				(5, 1, 'a:2:{i:0;s:5:\"index\";i:1;s:4:\"view\";}'),
				(6, 1, 'a:1:{i:0;s:5:\"index\";}'),
				(7, 1, 'a:8:{i:0;s:5:\"index\";i:1;s:4:\"view\";i:2;s:6:\"invite\";i:3;s:6:\"update\";i:4;s:16:\"pending-approval\";i:5;s:12:\"set-approval\";i:6;s:22:\"change-associate-agent\";i:7;s:6:\"delete\";}'),
				(8, 1, 'a:1:{i:0;s:5:\"index\";}'),
				(9, 1, 'a:1:{i:0;s:5:\"index\";}'),
				(10, 1, 'a:1:{i:0;s:5:\"index\";}'),
				(11, 1, 'a:1:{i:0;s:5:\"index\";}'),
				(12, 1, 'a:5:{i:0;s:5:\"index\";i:1;s:4:\"view\";i:2;s:6:\"create\";i:3;s:6:\"update\";i:4;s:6:\"delete\";}'),
				(13, 1, 'a:1:{i:0;s:5:\"index\";}'),
				(15, 1, 'a:1:{i:0;s:5:\"index\";}'),
				(16, 1, 'a:5:{i:0;s:5:\"index\";i:1;s:4:\"view\";i:2;s:6:\"create\";i:3;s:6:\"update\";i:4;s:6:\"delete\";}'),
				(17, 1, 'a:7:{i:0;s:5:\"index\";i:1;s:4:\"view\";i:2;s:6:\"create\";i:3;s:16:\"create-unit-type\";i:4;s:6:\"update\";i:5;s:6:\"delete\";i:6;s:16:\"delete-unit-type\";}'),
				(18, 1, 'a:1:{i:0;s:5:\"index\";}'),
				(19, 1, 'a:1:{i:0;s:5:\"index\";}'),
				(20, 1, 'a:1:{i:0;s:5:\"index\";}'),
				(21, 1, 'a:9:{i:0;s:5:\"index\";i:1;s:4:\"view\";i:2;s:6:\"create\";i:3;s:6:\"update\";i:4;s:10:\"view-media\";i:5;s:12:\"create-media\";i:6;s:12:\"update-media\";i:7;s:6:\"delete\";i:8;s:12:\"delete-media\";}'),
				(22, 1, 'a:1:{i:0;s:5:\"index\";}'),
				(23, 1, 'a:1:{i:0;s:5:\"index\";}'),
				(24, 1, 'a:9:{i:0;s:5:\"index\";i:1;s:4:\"view\";i:2;s:6:\"create\";i:3;s:6:\"update\";i:4;s:10:\"view-media\";i:5;s:12:\"create-media\";i:6;s:12:\"update-media\";i:7;s:6:\"delete\";i:8;s:12:\"delete-media\";}'),
				(25, 1, 'a:1:{i:0;s:5:\"index\";}'),
				(26, 1, 'a:1:{i:0;s:5:\"index\";}'),
				(27, 1, 'a:9:{i:0;s:5:\"index\";i:1;s:4:\"view\";i:2;s:6:\"create\";i:3;s:6:\"update\";i:4;s:10:\"view-media\";i:5;s:12:\"create-media\";i:6;s:12:\"update-media\";i:7;s:6:\"delete\";i:8;s:12:\"delete-media\";}'),
				(28, 1, 'a:1:{i:0;s:5:\"index\";}'),
				(29, 1, 'a:1:{i:0;s:5:\"index\";}'),
				(30, 1, 'a:5:{i:0;s:5:\"index\";i:1;s:4:\"view\";i:2;s:6:\"create\";i:3;s:6:\"update\";i:4;s:6:\"delete\";}'),
				(31, 1, 'a:1:{i:0;s:5:\"index\";}'),
				(32, 1, 'a:1:{i:0;s:5:\"index\";}'),
				(33, 1, 'a:34:{i:0;s:11:\"index-admin\";i:1;s:20:\"pending-eoi-approval\";i:2;s:24:\"pending-booking-approval\";i:3;s:32:\"pending-contract-signed-approval\";i:4;s:29:\"pending-cancellation-approval\";i:5;s:10:\"view-admin\";i:6;s:8:\"view-eoi\";i:7;s:17:\"view-eoi-approval\";i:8;s:12:\"view-booking\";i:9;s:21:\"view-booking-approval\";i:10;s:20:\"view-contract-signed\";i:11;s:17:\"view-full-booking\";i:12;s:29:\"view-contract-signed-approval\";i:13;s:26:\"view-cancellation-approval\";i:14;s:6:\"create\";i:15;s:16:\"create-follow-up\";i:16;s:28:\"create-appointment-scheduled\";i:17;s:10:\"create-eoi\";i:18;s:8:\"edit-eoi\";i:19;s:14:\"create-booking\";i:20;s:12:\"edit-booking\";i:21;s:17:\"edit-full-booking\";i:22;s:20:\"edit-contract-signed\";i:23;s:14:\"cancel-booking\";i:24;s:19:\"cancel-booking-full\";i:25;s:6:\"delete\";i:26;s:29:\"file-identity-document-delete\";i:27;s:23:\"file-tax-license-delete\";i:28;s:16:\"file-udf1-delete\";i:29;s:15:\"file-eoi-delete\";i:30;s:19:\"file-booking-delete\";i:31;s:14:\"file-sp-delete\";i:32;s:16:\"file-ppjb-delete\";i:33;s:13:\"drop-interest\";}'),
				(35, 1, 'a:1:{i:0;s:5:\"index\";}'),
				(36, 1, 'a:1:{i:0;s:5:\"index\";}'),
				(37, 1, 'a:1:{i:0;s:5:\"index\";}'),
				(38, 1, 'a:1:{i:0;s:5:\"index\";}'),
				(39, 1, 'a:1:{i:0;s:5:\"index\";}'),
				(40, 1, 'a:1:{i:0;s:11:\"index-admin\";}'),
				(41, 1, 'a:6:{i:0;s:5:\"index\";i:1;s:4:\"view\";i:2;s:27:\"view-commission-transaction\";i:3;s:19:\"eligible-commission\";i:4;s:23:\"pay-eligible-commission\";i:5;s:26:\"cancel-eligible-commission\";}'),
				(43, 1, 'a:6:{i:0;s:5:\"index\";i:1;s:4:\"view\";i:2;s:27:\"view-commission-transaction\";i:3;s:19:\"eligible-commission\";i:4;s:23:\"pay-eligible-commission\";i:5;s:26:\"cancel-eligible-commission\";}'),
				(45, 1, 'a:1:{i:0;s:5:\"index\";}'),
				(46, 1, 'a:5:{i:0;s:5:\"index\";i:1;s:4:\"view\";i:2;s:6:\"create\";i:3;s:6:\"update\";i:4;s:6:\"delete\";}'),
				(47, 1, 'a:1:{i:0;s:5:\"index\";}'),
				(48, 1, 'a:1:{i:0;s:5:\"index\";}'),
				(49, 1, 'a:2:{i:0;s:5:\"index\";i:1;s:5:\"topup\";}'),
				(50, 1, 'a:3:{i:0;s:5:\"index\";i:1;s:4:\"view\";i:2;s:6:\"update\";}'),
				(51, 1, 'a:3:{i:0;s:5:\"index\";i:1;s:4:\"view\";i:2;s:13:\"toggle-points\";}'),
				(52, 1, 'a:4:{i:0;s:5:\"index\";i:1;s:4:\"view\";i:2;s:7:\"approve\";i:3;s:6:\"cancel\";}'),
				(53, 1, 'a:1:{i:0;s:5:\"index\";}'),
				(54, 1, 'a:5:{i:0;s:5:\"index\";i:1;s:4:\"view\";i:2;s:6:\"create\";i:3;s:6:\"update\";i:4;s:6:\"delete\";}'),
				(55, 1, 'a:1:{i:0;s:5:\"index\";}'),
				(59, 1, 'a:1:{i:0;s:5:\"index\";}'),
				(60, 1, 'a:5:{i:0;s:5:\"index\";i:1;s:4:\"view\";i:2;s:6:\"create\";i:3;s:6:\"update\";i:4;s:6:\"delete\";}'),
				(62, 1, 'a:1:{i:0;s:5:\"index\";}'),
				(65, 1, 'a:1:{i:0;s:5:\"index\";}'),
				(67, 1, 'a:8:{i:0;s:5:\"index\";i:1;s:4:\"view\";i:2;s:6:\"create\";i:3;s:6:\"update\";i:4;s:13:\"toggle-status\";i:5;s:12:\"export-excel\";i:6;s:6:\"delete\";i:7;s:7:\"profile\";}'),
				(68, 1, 'a:1:{i:0;s:5:\"index\";}'),
				(92, 1, 'a:1:{i:0;s:5:\"index\";}'),
				(135, 1, 'a:2:{i:0;s:5:\"index\";i:1;s:24:\"assign-virtual-associate\";}'),
				(1, 2, 'a:1:{i:0;s:5:\"index\";}'),
				(2, 2, 'a:1:{i:0;s:5:\"index\";}'),
				(3, 2, 'a:1:{i:0;s:5:\"index\";}'),
				(4, 2, 'a:6:{i:0;s:5:\"index\";i:1;s:4:\"view\";i:2;s:6:\"create\";i:3;s:6:\"update\";i:4;s:13:\"toggle-status\";i:5;s:6:\"delete\";}'),
				(5, 2, 'a:2:{i:0;s:5:\"index\";i:1;s:4:\"view\";}'),
				(6, 2, 'a:1:{i:0;s:5:\"index\";}'),
				(7, 2, 'a:8:{i:0;s:5:\"index\";i:1;s:4:\"view\";i:2;s:6:\"invite\";i:3;s:6:\"update\";i:4;s:16:\"pending-approval\";i:5;s:12:\"set-approval\";i:6;s:22:\"change-associate-agent\";i:7;s:6:\"delete\";}'),
				(8, 2, 'a:1:{i:0;s:5:\"index\";}'),
				(9, 2, 'a:1:{i:0;s:5:\"index\";}'),
				(10, 2, 'a:1:{i:0;s:5:\"index\";}'),
				(15, 2, 'a:1:{i:0;s:5:\"index\";}'),
				(16, 2, 'a:5:{i:0;s:5:\"index\";i:1;s:4:\"view\";i:2;s:6:\"create\";i:3;s:6:\"update\";i:4;s:6:\"delete\";}'),
				(17, 2, 'a:7:{i:0;s:5:\"index\";i:1;s:4:\"view\";i:2;s:6:\"create\";i:3;s:16:\"create-unit-type\";i:4;s:6:\"update\";i:5;s:6:\"delete\";i:6;s:16:\"delete-unit-type\";}'),
				(18, 2, 'a:1:{i:0;s:5:\"index\";}'),
				(19, 2, 'a:1:{i:0;s:5:\"index\";}'),
				(20, 2, 'a:1:{i:0;s:5:\"index\";}'),
				(21, 2, 'a:9:{i:0;s:5:\"index\";i:1;s:4:\"view\";i:2;s:6:\"create\";i:3;s:6:\"update\";i:4;s:10:\"view-media\";i:5;s:12:\"create-media\";i:6;s:12:\"update-media\";i:7;s:6:\"delete\";i:8;s:12:\"delete-media\";}'),
				(22, 2, 'a:1:{i:0;s:5:\"index\";}'),
				(23, 2, 'a:1:{i:0;s:5:\"index\";}'),
				(24, 2, 'a:9:{i:0;s:5:\"index\";i:1;s:4:\"view\";i:2;s:6:\"create\";i:3;s:6:\"update\";i:4;s:10:\"view-media\";i:5;s:12:\"create-media\";i:6;s:12:\"update-media\";i:7;s:6:\"delete\";i:8;s:12:\"delete-media\";}'),
				(25, 2, 'a:1:{i:0;s:5:\"index\";}'),
				(26, 2, 'a:1:{i:0;s:5:\"index\";}'),
				(27, 2, 'a:9:{i:0;s:5:\"index\";i:1;s:4:\"view\";i:2;s:6:\"create\";i:3;s:6:\"update\";i:4;s:10:\"view-media\";i:5;s:12:\"create-media\";i:6;s:12:\"update-media\";i:7;s:6:\"delete\";i:8;s:12:\"delete-media\";}'),
				(28, 2, 'a:1:{i:0;s:5:\"index\";}'),
				(29, 2, 'a:1:{i:0;s:5:\"index\";}'),
				(30, 2, 'a:5:{i:0;s:5:\"index\";i:1;s:4:\"view\";i:2;s:6:\"create\";i:3;s:6:\"update\";i:4;s:6:\"delete\";}'),
				(31, 2, 'a:1:{i:0;s:5:\"index\";}'),
				(32, 2, 'a:1:{i:0;s:5:\"index\";}'),
				(33, 2, 'a:34:{i:0;s:11:\"index-admin\";i:1;s:20:\"pending-eoi-approval\";i:2;s:24:\"pending-booking-approval\";i:3;s:32:\"pending-contract-signed-approval\";i:4;s:29:\"pending-cancellation-approval\";i:5;s:10:\"view-admin\";i:6;s:8:\"view-eoi\";i:7;s:17:\"view-eoi-approval\";i:8;s:12:\"view-booking\";i:9;s:21:\"view-booking-approval\";i:10;s:20:\"view-contract-signed\";i:11;s:17:\"view-full-booking\";i:12;s:29:\"view-contract-signed-approval\";i:13;s:26:\"view-cancellation-approval\";i:14;s:16:\"create-follow-up\";i:15;s:28:\"create-appointment-scheduled\";i:16;s:10:\"create-eoi\";i:17;s:8:\"edit-eoi\";i:18;s:14:\"create-booking\";i:19;s:11:\"eoi-booking\";i:20;s:12:\"edit-booking\";i:21;s:17:\"edit-full-booking\";i:22;s:20:\"edit-contract-signed\";i:23;s:14:\"cancel-booking\";i:24;s:19:\"cancel-booking-full\";i:25;s:6:\"delete\";i:26;s:29:\"file-identity-document-delete\";i:27;s:23:\"file-tax-license-delete\";i:28;s:16:\"file-udf1-delete\";i:29;s:15:\"file-eoi-delete\";i:30;s:19:\"file-booking-delete\";i:31;s:14:\"file-sp-delete\";i:32;s:16:\"file-ppjb-delete\";i:33;s:13:\"drop-interest\";}'),
				(35, 2, 'a:1:{i:0;s:5:\"index\";}'),
				(36, 2, 'a:1:{i:0;s:5:\"index\";}'),
				(37, 2, 'a:1:{i:0;s:5:\"index\";}'),
				(38, 2, 'a:1:{i:0;s:5:\"index\";}'),
				(39, 2, 'a:1:{i:0;s:5:\"index\";}'),
				(41, 2, 'a:6:{i:0;s:5:\"index\";i:1;s:4:\"view\";i:2;s:27:\"view-commission-transaction\";i:3;s:19:\"eligible-commission\";i:4;s:23:\"pay-eligible-commission\";i:5;s:26:\"cancel-eligible-commission\";}'),
				(43, 2, 'a:6:{i:0;s:5:\"index\";i:1;s:4:\"view\";i:2;s:27:\"view-commission-transaction\";i:3;s:19:\"eligible-commission\";i:4;s:23:\"pay-eligible-commission\";i:5;s:26:\"cancel-eligible-commission\";}'),
				(45, 2, 'a:1:{i:0;s:5:\"index\";}'),
				(46, 2, 'a:5:{i:0;s:5:\"index\";i:1;s:4:\"view\";i:2;s:6:\"create\";i:3;s:6:\"update\";i:4;s:6:\"delete\";}'),
				(47, 2, 'a:1:{i:0;s:5:\"index\";}'),
				(48, 2, 'a:1:{i:0;s:5:\"index\";}'),
				(51, 2, 'a:3:{i:0;s:5:\"index\";i:1;s:4:\"view\";i:2;s:13:\"toggle-points\";}'),
				(52, 2, 'a:4:{i:0;s:5:\"index\";i:1;s:4:\"view\";i:2;s:7:\"approve\";i:3;s:6:\"cancel\";}'),
				(65, 2, 'a:1:{i:0;s:5:\"index\";}'),
				(67, 2, 'a:8:{i:0;s:5:\"index\";i:1;s:4:\"view\";i:2;s:6:\"create\";i:3;s:6:\"update\";i:4;s:13:\"toggle-status\";i:5;s:12:\"export-excel\";i:6;s:6:\"delete\";i:7;s:7:\"profile\";}'),
				(68, 2, 'a:1:{i:0;s:5:\"index\";}'),
				(1, 7, 'a:1:{i:0;s:5:\"index\";}'),
				(6, 7, 'a:1:{i:0;s:5:\"index\";}'),
				(7, 7, 'a:3:{i:0;s:5:\"index\";i:1;s:4:\"view\";i:2;s:6:\"invite\";}'),
				(10, 7, 'a:1:{i:0;s:5:\"index\";}'),
				(20, 7, 'a:1:{i:0;s:5:\"index\";}'),
				(21, 7, 'a:9:{i:0;s:5:\"index\";i:1;s:4:\"view\";i:2;s:6:\"create\";i:3;s:6:\"update\";i:4;s:10:\"view-media\";i:5;s:12:\"create-media\";i:6;s:12:\"update-media\";i:7;s:6:\"delete\";i:8;s:12:\"delete-media\";}'),
				(22, 7, 'a:1:{i:0;s:5:\"index\";}'),
				(23, 7, 'a:1:{i:0;s:5:\"index\";}'),
				(24, 7, 'a:9:{i:0;s:5:\"index\";i:1;s:4:\"view\";i:2;s:6:\"create\";i:3;s:6:\"update\";i:4;s:10:\"view-media\";i:5;s:12:\"create-media\";i:6;s:12:\"update-media\";i:7;s:6:\"delete\";i:8;s:12:\"delete-media\";}'),
				(25, 7, 'a:1:{i:0;s:5:\"index\";}'),
				(26, 7, 'a:1:{i:0;s:5:\"index\";}'),
				(27, 7, 'a:9:{i:0;s:5:\"index\";i:1;s:4:\"view\";i:2;s:6:\"create\";i:3;s:6:\"update\";i:4;s:10:\"view-media\";i:5;s:12:\"create-media\";i:6;s:12:\"update-media\";i:7;s:6:\"delete\";i:8;s:12:\"delete-media\";}'),
				(28, 7, 'a:1:{i:0;s:5:\"index\";}'),
				(32, 7, 'a:1:{i:0;s:5:\"index\";}'),
				(33, 7, 'a:28:{i:0;s:5:\"index\";i:1;s:22:\"my-associate-prospects\";i:2;s:4:\"view\";i:3;s:27:\"view-my-associate-prospects\";i:4;s:8:\"view-eoi\";i:5;s:12:\"view-booking\";i:6;s:20:\"view-contract-signed\";i:7;s:17:\"view-full-booking\";i:8;s:16:\"create-follow-up\";i:9;s:28:\"create-appointment-scheduled\";i:10;s:21:\"create-level-interest\";i:11;s:10:\"create-eoi\";i:12;s:8:\"edit-eoi\";i:13;s:14:\"create-booking\";i:14;s:11:\"eoi-booking\";i:15;s:12:\"edit-booking\";i:16;s:22:\"update-contract-signed\";i:17;s:20:\"edit-contract-signed\";i:18;s:14:\"share-prospect\";i:19;s:14:\"cancel-booking\";i:20;s:29:\"file-identity-document-delete\";i:21;s:23:\"file-tax-license-delete\";i:22;s:16:\"file-udf1-delete\";i:23;s:15:\"file-eoi-delete\";i:24;s:19:\"file-booking-delete\";i:25;s:14:\"file-sp-delete\";i:26;s:16:\"file-ppjb-delete\";i:27;s:13:\"drop-interest\";}'),
				(34, 7, 'a:1:{i:0;s:5:\"index\";}'),
				(48, 7, 'a:1:{i:0;s:5:\"index\";}'),
				(51, 7, 'a:2:{i:0;s:5:\"index\";i:1;s:4:\"view\";}'),
				(65, 7, 'a:1:{i:0;s:5:\"index\";}'),
				(68, 7, 'a:1:{i:0;s:5:\"index\";}'),
				(1, 8, 'a:1:{i:0;s:5:\"index\";}'),
				(6, 8, 'a:1:{i:0;s:5:\"index\";}'),
				(7, 8, 'a:3:{i:0;s:5:\"index\";i:1;s:4:\"view\";i:2;s:6:\"invite\";}'),
				(10, 8, 'a:1:{i:0;s:5:\"index\";}'),
				(32, 8, 'a:1:{i:0;s:5:\"index\";}'),
				(33, 8, 'a:3:{i:0;s:5:\"index\";i:1;s:22:\"my-associate-prospects\";i:2;s:4:\"view\";}'),
				(34, 8, 'a:1:{i:0;s:5:\"index\";}'),
				(48, 8, 'a:1:{i:0;s:5:\"index\";}'),
				(51, 8, 'a:2:{i:0;s:5:\"index\";i:1;s:4:\"view\";}'),
				(65, 8, 'a:1:{i:0;s:5:\"index\";}'),
				(68, 8, 'a:1:{i:0;s:5:\"index\";}');
			 ";
		
		$this->execute($sql);

	}

    public function safeDown()
    {
    }
}
