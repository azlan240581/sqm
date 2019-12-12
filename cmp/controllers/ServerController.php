<?php

namespace app\controllers;

use Yii;
use yii\console\Controller;

class ServerController extends \yii\web\Controller
{
	
	public function beforeAction($action) 
	{ 
		$this->enableCsrfValidation = false;
		return parent::beforeAction($action);
	}

	
	//public $layout=false;
    public function actionApi($request)
    {
		header("Access-Control-Allow-Origin: *");
		
		if(!isset($_REQUEST['no_json']))
		header('Content-type: application/json');
		
		$request = strtolower(str_replace('/','',$request));
		
		switch(strtolower($request))
		{  
			case 'user-authentication':
				return $this->renderPartial('user-authentication');
			break;
		
			case 'social-auth':
				return $this->renderPartial('social-auth');
			break;
		
			case 'user-bugs-report':
				return $this->renderPartial('user-bugs-report');
			break;
		
			case 'user-message':
				return $this->renderPartial('user-message');
			break;
		
			case 'user-forgot-password':
				return $this->renderPartial('user-forgot-password');
			break;
		
			case 'user-commissions':
				return $this->renderPartial('user-commissions');
			break;
		
			case 'user-commission-transactions':
				return $this->renderPartial('user-commission-transactions');
			break;
		
			case 'user-log-commissions-transaction':
				return $this->renderPartial('user-log-commissions-transaction');
			break;
		
			case 'member-email-verification':
				return $this->renderPartial('member-email-verification');
			break;
			
			case 'member-registration':
				return $this->renderPartial('member-registration');
			break;
						
			case 'member-profile':
				return $this->renderPartial('member-profile');
			break;
			
			case 'member-upload-file':
				return $this->renderPartial('member-upload-file');
			break;
			
			case 'member-get-member':
				return $this->renderPartial('member-get-member');
			break;

			case 'member-points':
				return $this->renderPartial('member-points');
			break;

			case 'member-banners':
				return $this->renderPartial('member-banners');
			break;

			case 'member-collaterals':
				return $this->renderPartial('member-collaterals');
			break;

			case 'member-property-products':
				return $this->renderPartial('member-property-products');
			break;

			case 'member-news-feeds':
				return $this->renderPartial('member-news-feeds');
			break;

 			case 'member-register-prospect':
				return $this->renderPartial('member-register-prospect');
			break;

			case 'member-get-prospects':
				return $this->renderPartial('member-get-prospects');
			break;

			case 'member-get-prospect-histories':
				return $this->renderPartial('member-get-prospect-histories');
			break;

			case 'member-news-feed-categories':
				return $this->renderPartial('member-news-feed-categories');
			break;

			case 'member-share-banner':
				return $this->renderPartial('member-share-banner');
			break;

			case 'member-share-news-feed':
				return $this->renderPartial('member-share-news-feed');
			break;

			case 'member-share-product':
				return $this->renderPartial('member-share-product');
			break;

			case 'member-get-rewards-list':
				return $this->renderPartial('member-get-rewards-list');
			break;

			case 'member-redeem-rewards':
				return $this->renderPartial('member-redeem-rewards');
			break;

			case 'member-get-agent-details':
				return $this->renderPartial('member-get-agent-details');
			break;

			case 'member-daily-active-manager':
				return $this->renderPartial('member-daily-active-manager');
			break;

			case 'member-sync-fb-account':
				return $this->renderPartial('member-sync-fb-account');
			break;

			case 'scheduler-delete-old-log-api':
				return $this->renderPartial('scheduler-delete-old-log-api');
			break;

			case 'lookup-purpose-of-buying-list':
				return $this->renderPartial('lookup-purpose-of-buying-list');
			break;

			case 'lookup-country-list':
				return $this->renderPartial('lookup-country-list');
			break;

			case 'lookup-how-you-know-about-us-list':
				return $this->renderPartial('lookup-how-you-know-about-us-list');
			break;

			case 'lookup-domicile-list':
				return $this->renderPartial('lookup-domicile-list');
			break;

			case 'lookup-collateral-media-types-list':
				return $this->renderPartial('lookup-collateral-media-types-list');
			break;

			case 'lookup-industry-background-list':
				return $this->renderPartial('lookup-industry-background-list');
			break;

			case 'lookup-job-type-list':
				return $this->renderPartial('lookup-job-type-list');
			break;

			case 'lookup-marital-status-list':
				return $this->renderPartial('lookup-marital-status-list');
			break;

			case 'lookup-media-types-list':
				return $this->renderPartial('lookup-media-types-list');
			break;

			case 'lookup-news-feed-categories-list':
				return $this->renderPartial('lookup-news-feed-categories-list');
			break;

			case 'lookup-occupation-list':
				return $this->renderPartial('lookup-occupation-list');
			break;

			case 'lookup-payment-method-list':
				return $this->renderPartial('lookup-payment-method-list');
			break;

			case 'lookup-product-type-list':
				return $this->renderPartial('lookup-product-type-list');
			break;

			case 'lookup-salutations-list':
				return $this->renderPartial('lookup-salutations-list');
			break;

			case 'lookup-projects-list':
				return $this->renderPartial('lookup-projects-list');
			break;

			case 'lookup-project-products-list':
				return $this->renderPartial('lookup-project-products-list');
			break;

			case 'lookup-country-code-list':
				return $this->renderPartial('lookup-country-code-list');
			break;

			case 'lookup-banks-list':
				return $this->renderPartial('lookup-banks-list');
			break;

			case 'lookup-reward-categories-list':
				return $this->renderPartial('lookup-reward-categories-list');
			break;

			case 'lookup-prospect-level-interest-list':
				return $this->renderPartial('lookup-prospect-level-interest-list');
			break;

			case 'lookup-property-product-type-list':
				return $this->renderPartial('lookup-property-product-type-list');
			break;

			case 'agent-profile':
				return $this->renderPartial('agent-profile');
			break;

			case 'agent-invite-member':
				return $this->renderPartial('agent-invite-member');
			break;

			case 'get-default-sqm-associate':
				return $this->renderPartial('get-default-sqm-associate');
			break;

			case 'agent-get-prospects':
				return $this->renderPartial('agent-get-prospects');
			break;

			case 'agent-dedicated-get-prospects':
				return $this->renderPartial('agent-dedicated-get-prospects');
			break;
			
			case 'agent-upload-file':
				return $this->renderPartial('agent-upload-file');
			break;
			
			case 'public-banners':
				return $this->renderPartial('public-banners');
			break;
			
			case 'public-news-feeds':
				return $this->renderPartial('public-news-feeds');
			break;
			
			case 'public-property-products':
				return $this->renderPartial('public-property-products');
			break;
			
			case 'bank-loan-calculator':
				header('Content-type: text/html');
				return $this->renderAjax('bank-loan-calculator');
			break;
			
			default:
				//return $this->render('api');
				echo 'none';
		}
    }


    public function actionBackoffice($request)
    {
		header("Access-Control-Allow-Origin: *");
		
		if(!isset($_REQUEST['no_json']))
		header('Content-type: application/json');
		
		$request = strtolower(str_replace('/','',$request));
		
		switch(strtolower($request))
		{  
			case 'delete-old-log-api':
				return $this->renderPartial('backoffice/delete-old-log-api');
			break;

			case 'member-commission-reconciliation':
				return $this->renderPartial('backoffice/member-commission-reconciliation');
			break;

			case 'member-commission-ranking':
				return $this->renderPartial('backoffice/member-commission-ranking');
			break;
			
			case 'prospect-completed-assigning':
				return $this->renderPartial('backoffice/prospect-completed-assigning');
			break;
			
			case 'prospect-inactive-cancellation': 		//more than 6 months
				return $this->renderPartial('backoffice/prospect-inactive-cancellation');
			break;
			
			default:
				//return $this->render('api');
				echo 'none';
		}
    }

}
