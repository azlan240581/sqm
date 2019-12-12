<?php

use yii\db\Migration;

class m000009_000004_alter_modules extends Migration
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
		//Stop Checking foreign key
		$this->execute("SET foreign_key_checks = 0;");

		//Clear Modules
		$this->truncateTable('modules');
		
		//Modules Information
		//dashboard
 		$this->insert('modules',array(
									  'name'=>'Dashboard',
									  'controller'=>'dashboard',
									  'icon'=>'glyphicon glyphicon-dashboard',
									  'parentid'=>'0',
									  'class'=>'',
									  'sort'=>'1',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));

		//announcements management
		$this->insert('modules',array(
									  'name'=>'Announcements Management',
									  'controller'=>'',
									  'icon'=>'glyphicon glyphicon-bullhorn',
									  'parentid'=>'0',
									  'class'=>'',
									  'sort'=>'2',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
									  
		$this->insert('modules',array(
									  'name'=>'Push Notifications',
									  'controller'=>'',
									  'icon'=>'',
									  'parentid'=>'2',
									  'class'=>'',
									  'sort'=>'3',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
									  
		$this->insert('modules',array(
									  'name'=>'Group Lists / Topics',
									  'controller'=>'group-lists-topics',
									  'icon'=>'',
									  'parentid'=>'3',
									  'class'=>'',
									  'sort'=>'4',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
									  
		$this->insert('modules',array(
									  'name'=>'Send Notification',
									  'controller'=>'send-notification',
									  'icon'=>'',
									  'parentid'=>'3',
									  'class'=>'',
									  'sort'=>'5',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
									  
		//associates management
		$this->insert('modules',array(
									  'name'=>'Associates Management',
									  'controller'=>'',
									  'icon'=>'glyphicon glyphicon-phone',
									  'parentid'=>'0',
									  'class'=>'',
									  'sort'=>'6',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
									  
		$this->insert('modules',array(
									  'name'=>'List',
									  'controller'=>'associates',
									  'icon'=>'',
									  'parentid'=>'6',
									  'class'=>'',
									  'sort'=>'7',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
									  
		$this->insert('modules',array(
									  'name'=>'Potential Associates',
									  'controller'=>'potential-associates',
									  'icon'=>'',
									  'parentid'=>'6',
									  'class'=>'',
									  'sort'=>'8',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
									  
		$this->insert('modules',array(
									  'name'=>'Pending Approval',
									  'controller'=>'associates/pending-approval',
									  'icon'=>'',
									  'parentid'=>'6',
									  'class'=>'',
									  'sort'=>'9',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
		
		$this->insert('modules',array(
									  'name'=>'+ Invite New Associate',
									  'controller'=>'associates/invite',
									  'icon'=>'',
									  'parentid'=>'6',
									  'class'=>'',
									  'sort'=>'10',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
		
		//developer management
		$this->insert('modules',array(
									  'name'=>'Developer Management',
									  'controller'=>'',
									  'icon'=>'glyphicon glyphicon-home',
									  'parentid'=>'0',
									  'class'=>'',
									  'sort'=>'11',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
									  
		$this->insert('modules',array(
									  'name'=>'List',
									  'controller'=>'developers',
									  'icon'=>'',
									  'parentid'=>'11',
									  'class'=>'',
									  'sort'=>'12',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
				
		$this->insert('modules',array(
									  'name'=>'+ Add New Developer',
									  'controller'=>'developers/create',
									  'icon'=>'',
									  'parentid'=>'11',
									  'class'=>'',
									  'sort'=>'13',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
									  
		$this->insert('modules',array(
									  'name'=>'Buyer List',
									  'controller'=>'buyer-list',
									  'icon'=>'',
									  'parentid'=>'11',
									  'class'=>'',
									  'sort'=>'14',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
									  
		//projects management
		$this->insert('modules',array(
									  'name'=>'Projects Management',
									  'controller'=>'',
									  'icon'=>'glyphicon glyphicon-home',
									  'parentid'=>'0',
									  'class'=>'',
									  'sort'=>'15',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
									  
		$this->insert('modules',array(
									  'name'=>'List',
									  'controller'=>'projects',
									  'icon'=>'',
									  'parentid'=>'15',
									  'class'=>'',
									  'sort'=>'16',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
		
		$this->insert('modules',array(
									  'name'=>'Products',
									  'controller'=>'project-products',
									  'icon'=>'',
									  'parentid'=>'15',
									  'class'=>'',
									  'sort'=>'17',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
		
		$this->insert('modules',array(
									  'name'=>'+ Add New Project',
									  'controller'=>'projects/create',
									  'icon'=>'',
									  'parentid'=>'15',
									  'class'=>'',
									  'sort'=>'18',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
									  
		$this->insert('modules',array(
									  'name'=>'+ Add New Product',
									  'controller'=>'project-products/create',
									  'icon'=>'',
									  'parentid'=>'15',
									  'class'=>'',
									  'sort'=>'19',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
									  
		//collaterals management
		$this->insert('modules',array(
									  'name'=>'Collaterals Management',
									  'controller'=>'',
									  'icon'=>'glyphicon glyphicon-home',
									  'parentid'=>'0',
									  'class'=>'',
									  'sort'=>'20',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
									  
		$this->insert('modules',array(
									  'name'=>'List',
									  'controller'=>'collaterals',
									  'icon'=>'',
									  'parentid'=>'20',
									  'class'=>'',
									  'sort'=>'21',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
		
		$this->insert('modules',array(
									  'name'=>'+ Add New Collaterals',
									  'controller'=>'collaterals/create',
									  'icon'=>'',
									  'parentid'=>'20',
									  'class'=>'',
									  'sort'=>'22',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
		
		//property product management						  
		$this->insert('modules',array(
									  'name'=>'Property Products Management',
									  'controller'=>'',
									  'icon'=>'glyphicon glyphicon-home',
									  'parentid'=>'0',
									  'class'=>'',
									  'sort'=>'23',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
									  
		$this->insert('modules',array(
									  'name'=>'List',
									  'controller'=>'property-products',
									  'icon'=>'',
									  'parentid'=>'23',
									  'class'=>'',
									  'sort'=>'24',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
									  									  
		$this->insert('modules',array(
									  'name'=>'+ Add Property Product',
									  'controller'=>'property-products/create',
									  'icon'=>'',
									  'parentid'=>'23',
									  'class'=>'',
									  'sort'=>'25',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
		
		//news feed management							  
		$this->insert('modules',array(
									  'name'=>'News Feed Management',
									  'controller'=>'',
									  'icon'=>'glyphicon glyphicon-list-alt',
									  'parentid'=>'0',
									  'class'=>'',
									  'sort'=>'26',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
									  
		$this->insert('modules',array(
									  'name'=>'List',
									  'controller'=>'news-feeds',
									  'icon'=>'',
									  'parentid'=>'26',
									  'class'=>'',
									  'sort'=>'27',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
									  
		$this->insert('modules',array(
									  'name'=>'+ Add News Feed',
									  'controller'=>'news-feeds/create',
									  'icon'=>'',
									  'parentid'=>'26',
									  'class'=>'',
									  'sort'=>'28',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
		
		//banners management							  
		$this->insert('modules',array(
									  'name'=>'Banners Management',
									  'controller'=>'',
									  'icon'=>'glyphicon glyphicon-bookmark',
									  'parentid'=>'0',
									  'class'=>'',
									  'sort'=>'29',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
									  
		$this->insert('modules',array(
									  'name'=>'List',
									  'controller'=>'banners',
									  'icon'=>'',
									  'parentid'=>'29',
									  'class'=>'',
									  'sort'=>'30',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
									  									  
		$this->insert('modules',array(
									  'name'=>'+ Add New Banner',
									  'controller'=>'banners/create',
									  'icon'=>'',
									  'parentid'=>'29',
									  'class'=>'',
									  'sort'=>'31',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
		
		//prospects management							  
		$this->insert('modules',array(
									  'name'=>'Prospects Management',
									  'controller'=>'',
									  'icon'=>'glyphicon glyphicon-briefcase',
									  'parentid'=>'0',
									  'class'=>'',
									  'sort'=>'32',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
									  
		$this->insert('modules',array(
									  'name'=>'List',
									  'controller'=>'prospects',
									  'icon'=>'',
									  'parentid'=>'32',
									  'class'=>'',
									  'sort'=>'33',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
									  
		$this->insert('modules',array(
									  'name'=>'My Associate Prospects',
									  'controller'=>'prospects/my-associate-prospects',
									  'icon'=>'',
									  'parentid'=>'32',
									  'class'=>'',
									  'sort'=>'34',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
									  
		$this->insert('modules',array(
									  'name'=>'Pending EOI Approval',
									  'controller'=>'prospects/pending-eoi-approval',
									  'icon'=>'',
									  'parentid'=>'32',
									  'class'=>'',
									  'sort'=>'35',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
									  									  
		$this->insert('modules',array(
									  'name'=>'Pending Booking Approval',
									  'controller'=>'prospects/pending-booking-approval',
									  'icon'=>'',
									  'parentid'=>'32',
									  'class'=>'',
									  'sort'=>'36',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
									  									  									  									  
		$this->insert('modules',array(
									  'name'=>'Pending Contract Signed Approval',
									  'controller'=>'prospects/pending-contract-signed-approval',
									  'icon'=>'',
									  'parentid'=>'32',
									  'class'=>'',
									  'sort'=>'37',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
									  
		$this->insert('modules',array(
									  'name'=>'Pending Cancellation Approval',
									  'controller'=>'prospects/pending-cancellation-approval',
									  'icon'=>'',
									  'parentid'=>'32',
									  'class'=>'',
									  'sort'=>'38',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
									  
		//commission management							  
		$this->insert('modules',array(
									  'name'=>'Commission Management',
									  'controller'=>'',
									  'icon'=>'glyphicon glyphicon-shopping-cart',
									  'parentid'=>'0',
									  'class'=>'',
									  'sort'=>'39',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
									  
		$this->insert('modules',array(
									  'name'=>'Commission Tiers Manager',
									  'controller'=>'commission-group-tiers',
									  'icon'=>'',
									  'parentid'=>'39',
									  'class'=>'',
									  'sort'=>'40',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
									  								
		$this->insert('modules',array(
									  'name'=>'Account Manager Commission List',
									  'controller'=>'account-manager-commissions',
									  'icon'=>'',
									  'parentid'=>'39',
									  'class'=>'',
									  'sort'=>'41',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
		
		$this->insert('modules',array(
									  'name'=>'Account Manager Eligible Commisision',
									  'controller'=>'account-manager-eligible-commissions',
									  'icon'=>'',
									  'parentid'=>'39',
									  'class'=>'',
									  'sort'=>'42',
									  'status'=>0,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
		
		$this->insert('modules',array(
									  'name'=>'Associate Commission List',
									  'controller'=>'associate-commissions',
									  'icon'=>'',
									  'parentid'=>'39',
									  'class'=>'',
									  'sort'=>'43',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
		
		$this->insert('modules',array(
									  'name'=>'Associate Eligible Commission',
									  'controller'=>'associate-eligible-commissions',
									  'icon'=>'',
									  'parentid'=>'39',
									  'class'=>'',
									  'sort'=>'44',
									  'status'=>0,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
		
		
		//rewards management							  
		$this->insert('modules',array(
									  'name'=>'Rewards Management',
									  'controller'=>'',
									  'icon'=>'glyphicon glyphicon-shopping-cart',
									  'parentid'=>'0',
									  'class'=>'',
									  'sort'=>'45',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
									  
		$this->insert('modules',array(
									  'name'=>'List',
									  'controller'=>'rewards',
									  'icon'=>'',
									  'parentid'=>'45',
									  'class'=>'',
									  'sort'=>'46',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
									  									  
		$this->insert('modules',array(
									  'name'=>'+ Add New Reward',
									  'controller'=>'rewards/create',
									  'icon'=>'',
									  'parentid'=>'45',
									  'class'=>'',
									  'sort'=>'47',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
		
		//points management							  
		$this->insert('modules',array(
									  'name'=>'Points Management',
									  'controller'=>'',
									  'icon'=>'glyphicon glyphicon-ruble',
									  'parentid'=>'0',
									  'class'=>'',
									  'sort'=>'48',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
									  
		$this->insert('modules',array(
									  'name'=>'Bank Points',
									  'controller'=>'bank-points',
									  'icon'=>'',
									  'parentid'=>'48',
									  'class'=>'',
									  'sort'=>'49',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
									  
		$this->insert('modules',array(
									  'name'=>'Activities',
									  'controller'=>'activities',
									  'icon'=>'',
									  'parentid'=>'48',
									  'class'=>'',
									  'sort'=>'50',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
									  
		$this->insert('modules',array(
									  'name'=>'Associate Points',
									  'controller'=>'user-points',
									  'icon'=>'',
									  'parentid'=>'48',
									  'class'=>'',
									  'sort'=>'51',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
									  									  
		$this->insert('modules',array(
									  'name'=>'Associate Redemptions List',
									  'controller'=>'user-reward-redemptions',
									  'icon'=>'',
									  'parentid'=>'48',
									  'class'=>'',
									  'sort'=>'52',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
									  
					
		//banks management
		$this->insert('modules',array(
									  'name'=>'Banks Management',
									  'controller'=>'',
									  'icon'=>'glyphicon glyphicon-user',
									  'parentid'=>'0',
									  'class'=>'',
									  'sort'=>'53',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
									  
		$this->insert('modules',array(
									  'name'=>'List',
									  'controller'=>'banks',
									  'icon'=>'',
									  'parentid'=>'53',
									  'class'=>'',
									  'sort'=>'54',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
									  											  									  
		$this->insert('modules',array(
									  'name'=>'+ Add New Bank',
									  'controller'=>'banks/create',
									  'icon'=>'',
									  'parentid'=>'53',
									  'class'=>'',
									  'sort'=>'55',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
											  									  
		$this->insert('modules',array(
									  'name'=>'Calculator',
									  'controller'=>'calculator',
									  'icon'=>'',
									  'parentid'=>'53',
									  'class'=>'',
									  'sort'=>'56',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
											  									  
		$this->insert('modules',array(
									  'name'=>'Loan Applications',
									  'controller'=>'loan-applications',
									  'icon'=>'',
									  'parentid'=>'53',
									  'class'=>'',
									  'sort'=>'57',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
											  									  
		$this->insert('modules',array(
									  'name'=>'Loan Proposals',
									  'controller'=>'bank-loan-proposals',
									  'icon'=>'',
									  'parentid'=>'53',
									  'class'=>'',
									  'sort'=>'58',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
									  
		//fintech management									  
		$this->insert('modules',array(
									  'name'=>'Fintech Management',
									  'controller'=>'',
									  'icon'=>'glyphicon glyphicon-user',
									  'parentid'=>'0',
									  'class'=>'',
									  'sort'=>'59',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
											
		$this->insert('modules',array(
									  'name'=>'List',
									  'controller'=>'fintechs',
									  'icon'=>'',
									  'parentid'=>'59',
									  'class'=>'',
									  'sort'=>'60',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
											  									  
		$this->insert('modules',array(
									  'name'=>'Fintech Packages',
									  'controller'=>'fintech-packages',
									  'icon'=>'',
									  'parentid'=>'59',
									  'class'=>'',
									  'sort'=>'61',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
																				  									  
		$this->insert('modules',array(
									  'name'=>'+ Add New Fintech',
									  'controller'=>'fintechs/create',
									  'icon'=>'',
									  'parentid'=>'59',
									  'class'=>'',
									  'sort'=>'62',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
											  									  
		$this->insert('modules',array(
									  'name'=>'Fintech Application',
									  'controller'=>'fintech-application',
									  'icon'=>'',
									  'parentid'=>'59',
									  'class'=>'',
									  'sort'=>'63',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
											  									  
		$this->insert('modules',array(
									  'name'=>'Fintech Paid Developer',
									  'controller'=>'fintech-paid-developer',
									  'icon'=>'',
									  'parentid'=>'59',
									  'class'=>'',
									  'sort'=>'64',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
											  									  
		//user manager									  
		$this->insert('modules',array(
									  'name'=>'User Management',
									  'controller'=>'',
									  'icon'=>'glyphicon glyphicon-user',
									  'parentid'=>'0',
									  'class'=>'',
									  'sort'=>'65',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
		
		$this->insert('modules',array(
									  'name'=>'Groups',
									  'controller'=>'group-access',
									  'icon'=>'',
									  'parentid'=>'65',
									  'class'=>'',
									  'sort'=>'66',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
									  
		$this->insert('modules',array(
									  'name'=>'Users',
									  'controller'=>'users',
									  'icon'=>'',
									  'parentid'=>'65',
									  'class'=>'',
									  'sort'=>'67',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
									  
		$this->insert('modules',array(
									  'name'=>'Profile',
									  'controller'=>'users/profile',
									  'icon'=>'',
									  'parentid'=>'65',
									  'class'=>'',
									  'sort'=>'68',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
		
		//reports management
		$this->insert('modules',array(
									  'name'=>'Reports Management',
									  'controller'=>'',
									  'icon'=>'glyphicon glyphicon-duplicate',
									  'parentid'=>'0',
									  'class'=>'',
									  'sort'=>'69',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));

		$this->insert('modules',array(
									  'name'=>'Associates',
									  'controller'=>'',
									  'icon'=>'',
									  'parentid'=>'69',
									  'class'=>'',
									  'sort'=>'70',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));

		$this->insert('modules',array(
									  'name'=>'Registered Associates',
									  'controller'=>'report-registered-member',
									  'icon'=>'',
									  'parentid'=>'70',
									  'class'=>'',
									  'sort'=>'71',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));

		$this->insert('modules',array(
									  'name'=>'Points Collections',
									  'controller'=>'report-points-collections',
									  'icon'=>'',
									  'parentid'=>'70',
									  'class'=>'',
									  'sort'=>'72',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
									  
		$this->insert('modules',array(
									  'name'=>'Used Points',
									  'controller'=>'report-used-points',
									  'icon'=>'',
									  'parentid'=>'70',
									  'class'=>'',
									  'sort'=>'73',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
									  
		$this->insert('modules',array(
									  'name'=>'Prospects',
									  'controller'=>'',
									  'icon'=>'',
									  'parentid'=>'69',
									  'class'=>'',
									  'sort'=>'74',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));

		$this->insert('modules',array(
									  'name'=>'Registered Prospects',
									  'controller'=>'report-prospects',
									  'icon'=>'',
									  'parentid'=>'74',
									  'class'=>'',
									  'sort'=>'75',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));

		$this->insert('modules',array(
									  'name'=>'Property Products',
									  'controller'=>'',
									  'icon'=>'',
									  'parentid'=>'69',
									  'class'=>'',
									  'sort'=>'76',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));

		$this->insert('modules',array(
									  'name'=>'List',
									  'controller'=>'report-property-products',
									  'icon'=>'',
									  'parentid'=>'76',
									  'class'=>'',
									  'sort'=>'77',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));

		$this->insert('modules',array(
									  'name'=>'News Feeds',
									  'controller'=>'',
									  'icon'=>'',
									  'parentid'=>'69',
									  'class'=>'',
									  'sort'=>'78',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));

		$this->insert('modules',array(
									  'name'=>'List',
									  'controller'=>'report-news-feeds',
									  'icon'=>'',
									  'parentid'=>'78',
									  'class'=>'',
									  'sort'=>'79',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));

		$this->insert('modules',array(
									  'name'=>'Rewards',
									  'controller'=>'',
									  'icon'=>'',
									  'parentid'=>'79',
									  'class'=>'',
									  'sort'=>'80',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));

		$this->insert('modules',array(
									  'name'=>'Most Viewed',
									  'controller'=>'report-prize-most-viewed',
									  'icon'=>'',
									  'parentid'=>'80',
									  'class'=>'',
									  'sort'=>'81',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));

		$this->insert('modules',array(
									  'name'=>'Most Redeemed',
									  'controller'=>'report-prize-most-redeemed',
									  'icon'=>'',
									  'parentid'=>'80',
									  'class'=>'',
									  'sort'=>'82',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));

		$this->insert('modules',array(
									  'name'=>'Logs',
									  'controller'=>'',
									  'icon'=>'',
									  'parentid'=>'69',
									  'class'=>'',
									  'sort'=>'83',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));

		$this->insert('modules',array(
									  'name'=>'Bank Points Transaction',
									  'controller'=>'log-bank-points',
									  'icon'=>'',
									  'parentid'=>'83',
									  'class'=>'',
									  'sort'=>'84',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));

		$this->insert('modules',array(
									  'name'=>'Points Transaction',
									  'controller'=>'log-user-points',
									  'icon'=>'',
									  'parentid'=>'83',
									  'class'=>'',
									  'sort'=>'85',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));

		$this->insert('modules',array(
									  'name'=>'Associates Activities',
									  'controller'=>'log-associates-activities',
									  'icon'=>'',
									  'parentid'=>'83',
									  'class'=>'',
									  'sort'=>'86',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));

		$this->insert('modules',array(
									  'name'=>'Reward Redemptions',
									  'controller'=>'log-user-reward-redemptions',
									  'icon'=>'',
									  'parentid'=>'83',
									  'class'=>'',
									  'sort'=>'87',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
									  
		$this->insert('modules',array(
									  'name'=>'Prospect History',
									  'controller'=>'log-prospect-history',
									  'icon'=>'',
									  'parentid'=>'83',
									  'class'=>'',
									  'sort'=>'88',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
									  
		$this->insert('modules',array(
									  'name'=>'Users',
									  'controller'=>'log-users',
									  'icon'=>'',
									  'parentid'=>'83',
									  'class'=>'',
									  'sort'=>'89',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));

		$this->insert('modules',array(
									  'name'=>'Messages',
									  'controller'=>'log-messages',
									  'icon'=>'',
									  'parentid'=>'83',
									  'class'=>'',
									  'sort'=>'90',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));

		$this->insert('modules',array(
									  'name'=>'API Request',
									  'controller'=>'log-api',
									  'icon'=>'',
									  'parentid'=>'83',
									  'class'=>'',
									  'sort'=>'91',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));

		//system management 
		$this->insert('modules',array(
									  'name'=>'System Management',
									  'controller'=>'',
									  'icon'=>'glyphicon glyphicon-cog',
									  'parentid'=>'0',
									  'class'=>'',
									  'sort'=>'92',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
									  
		$this->insert('modules',array(
									  'name'=>'Settings',
									  'controller'=>'settings',
									  'icon'=>'',
									  'parentid'=>'92',
									  'class'=>'',
									  'sort'=>'93',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
									  
		$this->insert('modules',array(
									  'name'=>'Manage Email Template',
									  'controller'=>'system-email-template',
									  'icon'=>'',
									  'parentid'=>'92',
									  'class'=>'',
									  'sort'=>'94',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
									  
		$this->insert('modules',array(
									  'name'=>'Manage Avatars',
									  'controller'=>'lookup-avatars',
									  'icon'=>'',
									  'parentid'=>'92',
									  'class'=>'',
									  'sort'=>'95',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
									  
		$this->insert('modules',array(
									  'name'=>'Manage Countries',
									  'controller'=>'lookup-country',
									  'icon'=>'',
									  'parentid'=>'92',
									  'class'=>'',
									  'sort'=>'96',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
									  
		$this->insert('modules',array(
									  'name'=>'Manage Positions',
									  'controller'=>'lookup-positions',
									  'icon'=>'',
									  'parentid'=>'92',
									  'class'=>'',
									  'sort'=>'97',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
									  
		$this->insert('modules',array(
									  'name'=>'Manage Marital Status',
									  'controller'=>'lookup-marital-status',
									  'icon'=>'',
									  'parentid'=>'92',
									  'class'=>'',
									  'sort'=>'98',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
									  
		$this->insert('modules',array(
									  'name'=>'Manage Points Actions',
									  'controller'=>'lookup-points-actions',
									  'icon'=>'',
									  'parentid'=>'92',
									  'class'=>'',
									  'sort'=>'99',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
									  		
		$this->insert('modules',array(
									  'name'=>'Manage Redemption Status',
									  'controller'=>'lookup-redemption-status',
									  'icon'=>'',
									  'parentid'=>'92',
									  'class'=>'',
									  'sort'=>'100',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
																		  
		$this->insert('modules',array(
									  'name'=>'Manage User Status',
									  'controller'=>'lookup-user-status',
									  'icon'=>'',
									  'parentid'=>'92',
									  'class'=>'',
									  'sort'=>'101',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
									  
		$this->insert('modules',array(
									  'name'=>'Manage Salutations',
									  'controller'=>'lookup-salutations',
									  'icon'=>'',
									  'parentid'=>'92',
									  'class'=>'',
									  'sort'=>'102',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
									  
		$this->insert('modules',array(
									  'name'=>'Manage Associate Approval Status',
									  'controller'=>'lookup-associate-approval-status',
									  'icon'=>'',
									  'parentid'=>'92',
									  'class'=>'',
									  'sort'=>'103',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
			
		$this->insert('modules',array(
									  'name'=>'Manage Prospect Status',
									  'controller'=>'lookup-prospect-status',
									  'icon'=>'',
									  'parentid'=>'92',
									  'class'=>'',
									  'sort'=>'104',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
									  
		$this->insert('modules',array(
									  'name'=>'Manage Prospect History',
									  'controller'=>'lookup-prospect-history',
									  'icon'=>'',
									  'parentid'=>'92',
									  'class'=>'',
									  'sort'=>'105',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
									  
		$this->insert('modules',array(
									  'name'=>'Manage Product Status',
									  'controller'=>'lookup-product-status',
									  'icon'=>'',
									  'parentid'=>'92',
									  'class'=>'',
									  'sort'=>'106',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
									  
									  
		$this->insert('modules',array(
									  'name'=>'Manage News Feed Status',
									  'controller'=>'lookup-news-feed-status',
									  'icon'=>'',
									  'parentid'=>'92',
									  'class'=>'',
									  'sort'=>'107',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
									  
		$this->insert('modules',array(
									  'name'=>'Manage Domicile List',
									  'controller'=>'lookup-domicile',
									  'icon'=>'',
									  'parentid'=>'92',
									  'class'=>'',
									  'sort'=>'108',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
									  
		$this->insert('modules',array(
									  'name'=>'Manage Occupation List',
									  'controller'=>'lookup-occupation',
									  'icon'=>'',
									  'parentid'=>'92',
									  'class'=>'',
									  'sort'=>'109',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
									  
		$this->insert('modules',array(
									  'name'=>'Manage Industry Background List',
									  'controller'=>'lookup-industry-background',
									  'icon'=>'',
									  'parentid'=>'92',
									  'class'=>'',
									  'sort'=>'110',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
									  
		$this->insert('modules',array(
									  'name'=>'Manage Payment Method',
									  'controller'=>'lookup-payment-method',
									  'icon'=>'',
									  'parentid'=>'92',
									  'class'=>'',
									  'sort'=>'111',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
									  									  									  									  									  									  
		$this->insert('modules',array(
									  'name'=>'Manage Associate Productivity Status',
									  'controller'=>'lookup-associate-productivity-status',
									  'icon'=>'',
									  'parentid'=>'92',
									  'class'=>'',
									  'sort'=>'112',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
									  	
		$this->insert('modules',array(
									  'name'=>'Manage Associate Commission Activities',
									  'controller'=>'lookup-associate-commission-activities',
									  'icon'=>'',
									  'parentid'=>'92',
									  'class'=>'',
									  'sort'=>'113',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
																		  
		$this->insert('modules',array(
									  'name'=>'Manage How You Know About Us List',
									  'controller'=>'lookup-how-you-know-about-us',
									  'icon'=>'',
									  'parentid'=>'92',
									  'class'=>'',
									  'sort'=>'114',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
									  									  
		$this->insert('modules',array(
									  'name'=>'Manage Purpose of Buying List',
									  'controller'=>'lookup-purpose-of-buying',
									  'icon'=>'',
									  'parentid'=>'92',
									  'class'=>'',
									  'sort'=>'115',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
									  									  
		$this->insert('modules',array(
									  'name'=>'Manage Downpayment Application Status',
									  'controller'=>'lookup-downpayment-application-status',
									  'icon'=>'',
									  'parentid'=>'92',
									  'class'=>'',
									  'sort'=>'116',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
									  									  
		$this->insert('modules',array(
									  'name'=>'Manage Downpayment Paid Status',
									  'controller'=>'lookup-downpayment-paid-status',
									  'icon'=>'',
									  'parentid'=>'92',
									  'class'=>'',
									  'sort'=>'117',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
									  									  
		$this->insert('modules',array(
									  'name'=>'Manage Developer Commission Paid Status',
									  'controller'=>'lookup-developer-commission-paid-status',
									  'icon'=>'',
									  'parentid'=>'92',
									  'class'=>'',
									  'sort'=>'118',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
									  		
		$this->insert('modules',array(
									  'name'=>'Manage Commission Group',
									  'controller'=>'lookup-commission-group',
									  'icon'=>'',
									  'parentid'=>'92',
									  'class'=>'',
									  'sort'=>'119',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
									  									  
		$this->insert('modules',array(
									  'name'=>'Manage Commission Tier',
									  'controller'=>'lookup-commission-tier',
									  'icon'=>'',
									  'parentid'=>'92',
									  'class'=>'',
									  'sort'=>'120',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
									  
		$this->insert('modules',array(
									  'name'=>'Manage Commission Type',
									  'controller'=>'lookup-commission-type',
									  'icon'=>'',
									  'parentid'=>'92',
									  'class'=>'',
									  'sort'=>'121',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
									  									  
		$this->insert('modules',array(
									  'name'=>'Manage Commission Status',
									  'controller'=>'lookup-user-commission-status',
									  'icon'=>'',
									  'parentid'=>'92',
									  'class'=>'',
									  'sort'=>'122',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
				
		$this->insert('modules',array(
									  'name'=>'Manage Job Type',
									  'controller'=>'lookup-job-type',
									  'icon'=>'',
									  'parentid'=>'92',
									  'class'=>'',
									  'sort'=>'123',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
				
		$this->insert('modules',array(
									  'name'=>'Manage Product Type',
									  'controller'=>'lookup-product-type',
									  'icon'=>'',
									  'parentid'=>'92',
									  'class'=>'',
									  'sort'=>'124',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
				
		$this->insert('modules',array(
									  'name'=>'Manage Loan Application Status',
									  'controller'=>'lookup-loan-application-status',
									  'icon'=>'',
									  'parentid'=>'92',
									  'class'=>'',
									  'sort'=>'125',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
									  									  
		$this->insert('modules',array(
									  'name'=>'Manage Bank Loan Proposal Status',
									  'controller'=>'lookup-bank-loan-proposal-status',
									  'icon'=>'',
									  'parentid'=>'92',
									  'class'=>'',
									  'sort'=>'126',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
									  									  
		$this->insert('modules',array(
									  'name'=>'Manage Collateral Media Types',
									  'controller'=>'lookup-collateral-media-types',
									  'icon'=>'',
									  'parentid'=>'92',
									  'class'=>'',
									  'sort'=>'127',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
									  									  
		$this->insert('modules',array(
									  'name'=>'Manage Media Types',
									  'controller'=>'lookup-media-types',
									  'icon'=>'',
									  'parentid'=>'92',
									  'class'=>'',
									  'sort'=>'128',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
									  									  
		$this->insert('modules',array(
									  'name'=>'Manage Property Product Types',
									  'controller'=>'lookup-property-product-types',
									  'icon'=>'',
									  'parentid'=>'92',
									  'class'=>'',
									  'sort'=>'129',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
									  									  
		$this->insert('modules',array(
									  'name'=>'Manage Banner Categories',
									  'controller'=>'lookup-banner-categories',
									  'icon'=>'',
									  'parentid'=>'92',
									  'class'=>'',
									  'sort'=>'130',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
									  									  
		$this->insert('modules',array(
									  'name'=>'Manage News Feed Categories',
									  'controller'=>'lookup-news-feed-categories',
									  'icon'=>'',
									  'parentid'=>'92',
									  'class'=>'',
									  'sort'=>'131',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
									  									  
		$this->insert('modules',array(
									  'name'=>'Manage Reward Categories',
									  'controller'=>'lookup-reward-categories',
									  'icon'=>'',
									  'parentid'=>'92',
									  'class'=>'',
									  'sort'=>'132',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
									  									  
		$this->insert('modules',array(
									  'name'=>'Manage Booking Status',
									  'controller'=>'lookup-booking-status',
									  'icon'=>'',
									  'parentid'=>'92',
									  'class'=>'',
									  'sort'=>'133',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
									  									  
		$this->insert('modules',array(
									  'name'=>'Manage Banks',
									  'controller'=>'lookup-banks',
									  'icon'=>'',
									  'parentid'=>'92',
									  'class'=>'',
									  'sort'=>'134',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
									  
		$this->insert('modules',array(
									  'name'=>'Assign Virtual Associate',
									  'controller'=>'assign-virtual-associate',
									  'icon'=>'',
									  'parentid'=>'92',
									  'class'=>'',
									  'sort'=>'135',
									  'status'=>1,
									  'updatedat'=>date("Y-m-d H:i:s"),
									  ));
		
		//Start Checking foreign key
		$this->execute("SET foreign_key_checks = 1;");
	}

    public function safeDown()
    {
    }
}
