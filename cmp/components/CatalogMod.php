<?php
namespace app\components;

use Yii;
use yii\helpers\Html;
use yii\base\ErrorException;
use app\models\SettingsRules;
use app\models\LoginForm;
use yii\helpers\Json;

use app\models\Banners;
use app\models\LookupBannerCategories;

use app\models\Developers;
use app\models\Projects;
use app\models\Collaterals;
use app\models\CollateralsMedias;

use app\models\GroupListsTopics;

use app\models\Users;
use app\models\UserGroups;
use app\models\UserDevices;

use app\models\Rewards;

use app\models\LogApi;
use app\models\LogAudit;
use app\models\LogCustomers;
use app\models\LogCustomerVouchers;
use app\models\LogPushNotifications;
use app\models\LogStamps;
use app\models\LogUsers;
use app\models\LogMemberActivities;

class CatalogMod extends \yii\base\Component{


	public $errorMessage;


    public function init() {
        parent::init();
    }
	
	public function getBanners($banner_category='',$banner_id='',$permalink='')
	{
		//initialize
		$modelBanners = new Banners();
		$result = array();
		$error = '';
		
		$bannerList = $modelBanners->getBannerList($banner_category,$banner_id,$permalink);
		if(!$bannerList)
		{
			$this->errorMessage = $modelBanners->errorMessage;
			return false;
		}
				
		if(count($bannerList)!=0)
		{
			if(strlen($banner_id) or strlen($permalink))
			{
				//update banner total viewed
				$modelBanners = Banners::find()->where("id = '".$banner_id."' OR LOWER(permalink) = '".strtolower($permalink)."'")->one();
				$modelBanners->total_viewed = $modelBanners->total_viewed+1;
				$modelBanners->save();
			}
			
			foreach($bannerList as $key=>$value)
			{
				$result[$key]['banner_category_id'] = $value['banner_category_id'];
				$result[$key]['banner_category_name'] = $value['banner_category_name'];
				$result[$key]['banner_id'] = $value['id'];
				$result[$key]['banner_title'] = $value['banner_title'];
				$result[$key]['permalink'] = $value['permalink'];
				$result[$key]['banner_summary'] = $value['banner_summary'];
				$result[$key]['banner_description'] = html_entity_decode($value['banner_description']);
				$result[$key]['banner_img'] = $value['banner_img'];
				$result[$key]['banner_video'] = $value['banner_video'];
				$result[$key]['link_url'] = $value['link_url'];
			}
		}
		
		return $result;
	}
	
	public function getCollaterals($inputs)
	{
		//initialize
		$error = '';
		$result = array();
		$modelCollaterals = new Collaterals();
		$modelCollateralsMedias = new CollateralsMedias();
		
		//validate
		try
		{
			if(!is_array($inputs))
			throw new ErrorException("Invalid inputs(1).");

			if(count($inputs)==0)
			throw new ErrorException("Invalid inputs(2).");
			
			if(empty($inputs['action']))
			throw new ErrorException("Invalid action(1).");
			
			if(!in_array($inputs['action'],array('projectlist','collaterallist')))
			throw new ErrorException("Invalid action(2).");
		}
		catch(ErrorException $e)
		{
			$this->errorMessage = $e->getMessage();
			return false;
		}
		
		if($inputs['action']=='projectlist')
		{
			$projectList = $modelCollaterals->getProjectCollaterals();
			if(!$projectList)
			{
				$this->errorMessage = 'No Collateral Projects.';
				return false;
			}
			
			if(count($projectList)!=0)
			{
				foreach($projectList as $key=>$value)
				{
					$result[$key]['project_id'] = $value['id'];
					$result[$key]['project_name'] = $value['project_name'];
					$result[$key]['thumb_image'] = $value['thumb_image'];
				}
			}
		}
		else
		{
			$collateralList = $modelCollaterals->getCollaterals($inputs);
			if(!$collateralList)
			{
				$this->errorMessage = 'No collaterals.';
				return false;
			}

			if(count($collateralList)!=0)
			{
				foreach($collateralList as $key=>$value)
				{
					$result[$key]['project_id'] = $value['project_id'];
					$result[$key]['project_name'] = $value['project_name'];
					$result[$key]['collateral_id'] = $value['id'];
					$result[$key]['title'] = $value['title'];
					$result[$key]['permalink'] = $value['permalink'];
					$result[$key]['summary'] = $value['summary'];
					$result[$key]['description'] = html_entity_decode($value['description']);
					$result[$key]['thumb_image'] = $value['thumb_image'];
					$result[$key]['medias'] = array();
					
					//get collateral medias
					$collateralMediaList = $modelCollateralsMedias->getCollateralsMedias($value['id']);
					if($collateralMediaList)
					$result[$key]['medias'] = $collateralMediaList;
				}
			}
		}

		return $result;
	}
	
	public function getRewardsList($category_id='',$reward_id='')
	{
		//initialize
		$error = '';
		$result = array();
		$modelRewards = new Rewards();
		
		$rewardList = $modelRewards->getRewardsList($category_id,$reward_id);
		if(!$rewardList)
		{
			$this->errorMessage = 'No rewards.';
			return false;
		}
		
		if(count($rewardList)!=0)
		{
			//update reward total viewed
			if(strlen($reward_id))
			{
				$modelRewards = Rewards::find()->where(array('id'=>$reward_id))->one();
				$modelRewards->total_viewed = $modelRewards->total_viewed+1;
				$modelRewards->save();
			}
			
			foreach($rewardList as $key=>$value)
			{
				$result[$key]['category_id'] = $value['category_id'];
				$result[$key]['category_name'] = $value['category_name'];
				$result[$key]['id'] = $value['id'];
				$result[$key]['name'] = $value['name'];
				$result[$key]['summary'] = $value['summary'];
				$result[$key]['description'] = html_entity_decode($value['description']);
				$result[$key]['points'] = Yii::$app->AccessMod->getPointsFormat($value['points']);
				$result[$key]['images'] = $value['images'];
			}
		}

		return $result;
	}
	
}
?>