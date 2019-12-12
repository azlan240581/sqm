<?php
namespace app\components;

use Yii;
use yii\helpers\Html;
use yii\base\ErrorException;

use app\models\Users;
use app\models\PropertyProducts;
use app\models\PropertyProductMedias;
use app\models\NewsFeeds;
use app\models\NewsFeedMedias;
use app\models\LookupNewsFeedCategories;
use app\models\Collaterals;
use app\models\CollateralsMedias;

use yii\helpers\Json;

class NewsFeedMod extends \yii\base\Component{


	public $errorMessage;


    public function init() {
        parent::init();
    }
	
	public function getNewsFeedCategory()
	{
		$newsFeedCategory = WhatsNewCategories::find()->select(array('id','category_name'))->where(array('deletedby'=>NULL,'deletedat'=>NULL))->asArray()->all();
		return $newsFeedCategory;
	}
	
	/*
	public function getNewsFeed($member_id,$category='',$news_feed_id='',$filter=array())
	{
		//initialize
		$newsFeedArray = array();
		
		//validate
		try
		{
			if(strlen($filter['filter_by_price_range']))
			{
				if(preg_match("/^([0-9]{0,20})\-([0-9]{0,20})$/",$filter['filter_by_price_range']) == 0)
				throw new ErrorException("Invalid filter price range format.");
			}
			
			if(strlen($filter['filter_by_size_range']))
			{
				if(preg_match("/^([0-9]{0,10})\-([0-9]{0,10})$/",$filter['filter_by_size_range']) == 0)
				throw new ErrorException("Invalid filter size range format.");
			}
			
			if(strlen($filter['filter_by_bedroom_range']))
			{
				if(preg_match("/^([0-9]{0,10})\-([0-9]{0,10})$/",$filter['filter_by_bedroom_range']) == 0)
				throw new ErrorException("Invalid filter bedroom range format.");
			}
			
			if(strlen($filter['filter_by_bathroom_range']))
			{
				if(preg_match("/^([0-9]{0,10})\-([0-9]{0,10})$/",$filter['filter_by_bathroom_range']) == 0)
				throw new ErrorException("Invalid filter bathroom range format.");
			}
		}
		catch(ErrorException $e)
		{
			$this->errorMessage = $e->getMessage();
			return false;
		}
		
		//get leads id
		$memberLeads = MemberLeads::find()->where(array('member_id'=>$member_id))->asArray()->one();
				
		if(strlen($category))
		{
			if($category==1 or $category=='Product Listing')
			{
				$sql = "SELECT '1' as category_id, '' as category_name, id, title, others as description, unit, type, address, latitude, longitude, price, building_size, land_size, total_floor, bedroom, bathroom, others, collaterals_link, images, createdat ";
				$sql .= "FROM product_listing ";
				$sql .= "WHERE 0=0 ";
				$sql .= "AND createdby='".$memberLeads['leads_id']."' ";
				$sql .= "AND status=3 ";
				
				if(strlen($news_feed_id))
				$sql .= "AND id = '".$news_feed_id."' ";
				if(strlen($filter['filter_by_unit']))
				$sql .= "AND unit LIKE '%".$filter['filter_by_unit']."%' ";
				if(strlen($filter['filter_by_type']))
				$sql .= "AND type LIKE '%".$filter['filter_by_type']."%' ";
				if(strlen($filter['filter_by_price_range']))
				{
					list($start_price, $end_price) = explode('-', $filter['filter_by_price_range']);
					$sql .= "AND price BETWEEN ".str_replace(',','',$start_price)." AND ".str_replace(',','',$end_price)." ";
				}
				if(strlen($filter['filter_by_size_range']))
				{
					list($start_size, $end_size) = explode('-', $filter['filter_by_size_range']);
					$sql .= "AND (building_size BETWEEN ".str_replace(',','',$start_size)." AND ".str_replace(',','',$end_size)." OR land_size BETWEEN ".str_replace(',','',$start_size)." AND ".str_replace(',','',$end_size).") ";
				}
				if(strlen($filter['filter_by_bedroom_range']))
				{
					list($start_bedroom, $end_bedroom) = explode('-', $filter['filter_by_bedroom_range']);
					$sql .= "AND bedroom BETWEEN ".str_replace(',','',$start_bedroom)." AND ".str_replace(',','',$end_bedroom)." ";
				}
				if(strlen($filter['filter_by_bathroom_range']))
				{
					list($start_bathroom, $end_bathroom) = explode('-', $filter['filter_by_bathroom_range']);
					$sql .= "AND bathroom BETWEEN ".str_replace(',','',$start_bathroom)." AND ".str_replace(',','',$end_bathroom)." ";
				}
				
				$sql .= "AND deletedby IS NULL AND deletedat IS NULL ";
				$sql .= "ORDER BY createdat DESC ";
				$newsFeedArray = Yii::$app->db->createCommand($sql)->queryAll();
								
				//update total viewed
				if(count($newsFeedArray)!=0 and strlen($news_feed_id))
				{
					$modelProductListing = ProductListing::findOne($news_feed_id);
					$modelProductListing->total_viewed = $modelProductListing->total_viewed+1;
					$modelProductListing->save();
				}
			}
			else
			{
				$sql = "SELECT wn.category_id, '' as category_name, wn.id, wn.title, wn.description, wn.images, wn.embedded_video, wn.createdat ";
				$sql .= "FROM whats_new wn, whats_new_categories wnc ";
				$sql .= "WHERE 0=0 ";
				$sql .= "AND wn.createdby='".$memberLeads['leads_id']."' ";
				$sql .= "AND wn.status=3 ";
				if(strlen($news_feed_id))
				$sql .= "AND wn.id='".$news_feed_id."' ";
				$sql .= "AND wn.category_id=wnc.id ";
				$sql .= "AND (wnc.id='".$category."' OR wnc.category_name LIKE '".$category."') ";
				$sql .= "AND wnc.deletedby IS NULL AND wnc.deletedat IS NULL ";
				$sql .= "ORDER BY createdat DESC ";
				$newsFeedArray = Yii::$app->db->createCommand($sql)->queryAll();
				
				//update total viewed
				if(count($newsFeedArray)!=0 and strlen($news_feed_id))
				{
					$modelWhatsNew = WhatsNew::findOne($news_feed_id);
					$modelWhatsNew->total_viewed = $modelWhatsNew->total_viewed+1;
					$modelWhatsNew->save();
				}
			}
		}
		else
		{
			$sql = "(SELECT category_id, '' as category_name, id, title, description, ";
			$sql .= "'' as unit, '' as type, '' as address, '' as latitude, '' as longitude, '' as price, '' as building_size, '' as land_size, '' as total_floor, '' as bedroom, '' as bathroom, '' as others, '' as collaterals_link, ";
			$sql .= "images, embedded_video, createdat ";
			$sql .= "FROM whats_new WHERE status=3 AND createdby='".$memberLeads['leads_id']."' AND deletedby IS NULL AND deletedat IS NULL) ";
			$sql .= "UNION ALL ";
			$sql .= "(SELECT '1', '', id, title, others as description, ";
			$sql .= "unit, type, address, latitude, longitude, price, building_size, land_size, total_floor, bedroom, bathroom, others, collaterals_link,  ";
			$sql .= "images, '', createdat ";
			$sql .= "FROM product_listing WHERE status=3 AND createdby='".$memberLeads['leads_id']."' AND deletedby IS NULL AND deletedat IS NULL) ";
			$sql .= "ORDER BY createdat DESC ";
			$newsFeedArray = Yii::$app->db->createCommand($sql)->queryAll();
		}
		
		if(count($newsFeedArray)==0)
		{
			$this->errorMessage = "No news feed from your leads";
			return false;
		}
		else
		{
			foreach($newsFeedArray as $key=>$newsfeed)
			{
				//get category name
				$whatsNewCategory = WhatsNewCategories::find()->where(array('id'=>$newsfeed['category_id']))->asArray()->one();
				$newsFeedArray[$key]['category_name'] = $whatsNewCategory['category_name'];
				
				if($newsfeed['category_id']==1)
				{
					$newsFeedArray[$key]['price'] = Yii::$app->AccessMod->getPriceFormat($newsfeed['price']);
					$newsFeedArray[$key]['building_size'] = Yii::$app->AccessMod->getPointsFormat($newsfeed['building_size']);
					$newsFeedArray[$key]['land_size'] = Yii::$app->AccessMod->getPointsFormat($newsfeed['land_size']);
					
					$productImages = json_decode($newsfeed['images']);
					$imagesArray = array();
					foreach($productImages as $k=>$image)
					{
						$imagesArray[$k] = ((isset($_SERVER['HTTPS'])) ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'].$image;
					}
					$newsFeedArray[$key]['images'] = $imagesArray;
				}
			}
		
			return $newsFeedArray;
		}
	}
	*/
	
	public function getPropertyProducts($filter=array())
	{
		//initialize
		$result = array();
		$modelPropertyProducts = new PropertyProducts();
		$modelPropertyProductMedias = new PropertyProductMedias();
		$modelCollaterals = new Collaterals();
		$modelCollateralsMedias = new CollateralsMedias();
		
		//validate
		try
		{
			if(strlen($filter['filter_by_price_range']))
			{
				if(preg_match("/^([0-9]{0,20})\-([0-9]{0,20})$/",$filter['filter_by_price_range']) == 0)
				throw new ErrorException("Invalid filter price range format.");
			}
			
			if(strlen($filter['filter_by_building_size_range']))
			{
				if(preg_match("/^([0-9]{0,10})\-([0-9]{0,10})$/",$filter['filter_by_building_size_range']) == 0)
				throw new ErrorException("Invalid filter building size range format.");
			}
			
			if(strlen($filter['filter_by_land_size_range']))
			{
				if(preg_match("/^([0-9]{0,10})\-([0-9]{0,10})$/",$filter['filter_by_land_size_range']) == 0)
				throw new ErrorException("Invalid filter land size range format.");
			}
			
			if(strlen($filter['filter_by_bedroom_range']))
			{
				if(preg_match("/^([0-9]{0,10})\-([0-9]{0,10})$/",$filter['filter_by_bedroom_range']) == 0)
				throw new ErrorException("Invalid filter bedroom range format.");
			}
			
			if(strlen($filter['filter_by_bathroom_range']))
			{
				if(preg_match("/^([0-9]{0,10})\-([0-9]{0,10})$/",$filter['filter_by_bathroom_range']) == 0)
				throw new ErrorException("Invalid filter bathroom range format.");
			}
		}
		catch(ErrorException $e)
		{
			$this->errorMessage = $e->getMessage();
			return false;
		}
		
		$sql = "SELECT pp.id, pp.project_id, pp.project_product_id, pp.property_type_id, pp.title, pp.permalink, pp.summary, pp.description, pp.thumb_image, pp.product_type, pp.address, pp.latitude, pp.longitude, pp.price, pp.building_size, pp.land_size, pp.total_floor, pp.bedroom, pp.bathroom, pp.parking_lot, pp.collaterals_id, pp.createdby, pp.createdat, ";
		$sql .= "(SELECT projects.project_name FROM projects WHERE projects.id=pp.project_id) as project_name, ";
		$sql .= "(SELECT project_products.product_name FROM project_products WHERE project_products.id=pp.project_product_id) as project_product_name, ";
		$sql .= "(SELECT lookup_product_type.name FROM lookup_product_type WHERE lookup_product_type.id=pp.property_type_id) as property_type_name, ";
		$sql .= "(SELECT lookup_property_product_types.name FROM lookup_property_product_types WHERE lookup_property_product_types.id=pp.product_type) as product_type_name ";
		$sql .= "FROM property_products pp ";
		$sql .= "WHERE 0=0 ";
		$sql .= "AND pp.status=3 ";
		
		$sql .= "AND pp.project_id IN (SELECT projects.id FROM projects WHERE projects.status = 1 AND projects.deletedby IS NULL AND projects.deletedat IS NULL)";
		
		if(strlen($filter['project']))
		$sql .= "AND pp.project_id IN (SELECT projects.id FROM projects WHERE (projects.id='".$filter['project']."' OR LOWER(projects.project_name) = '".$filter['project']."')) ";
		if(strlen($filter['project_product']))
		$sql .= "AND pp.project_product_id IN (SELECT project_products.id FROM project_products WHERE (project_products.id='".$filter['project_product']."' OR LOWER(project_products.product_name) = '".$filter['project_product']."')) ";
		if(strlen($filter['property_type']))
		$sql .= "AND pp.property_type_id IN (SELECT lookup_product_type.id FROM lookup_product_type WHERE (lookup_product_type.id='".$filter['property_type']."' OR LOWER(lookup_product_type.name) = '".$filter['property_type']."')) ";
		if(strlen($filter['product_type']))
		$sql .= "AND pp.product_type IN (SELECT lookup_property_product_types.id FROM lookup_property_product_types WHERE (lookup_property_product_types.id='".$filter['product_type']."' OR LOWER(lookup_property_product_types.name) = '".$filter['product_type']."')) ";
		if(strlen($filter['product_id']))
		$sql .= "AND pp.id = '".$filter['product_id']."' ";
		if(strlen($filter['permalink']))
		$sql .= "AND LOWER(pp.permalink) = '".strtolower($filter['permalink'])."' ";
		if(strlen($filter['filter_by_price_range']))
		{
			list($start_price, $end_price) = explode('-', $filter['filter_by_price_range']);
			$sql .= "AND pp.price BETWEEN ".str_replace(',','',$start_price)." AND ".str_replace(',','',$end_price)." ";
		}
		if(strlen($filter['filter_by_building_size_range']))
		{
			list($start_size, $end_size) = explode('-', $filter['filter_by_building_size_range']);
			$sql .= "AND pp.building_size BETWEEN ".str_replace(',','',$start_size)." AND ".str_replace(',','',$end_size)." ";
		}
		if(strlen($filter['filter_by_land_size_range']))
		{
			list($start_size, $end_size) = explode('-', $filter['filter_by_land_size_range']);
			$sql .= "AND pp.land_size BETWEEN ".str_replace(',','',$start_size)." AND ".str_replace(',','',$end_size)." ";
		}
		if(strlen($filter['filter_by_bedroom_range']))
		{
			list($start_bedroom, $end_bedroom) = explode('-', $filter['filter_by_bedroom_range']);
			$sql .= "AND pp.bedroom BETWEEN ".str_replace(',','',$start_bedroom)." AND ".str_replace(',','',$end_bedroom)." ";
		}
		if(strlen($filter['filter_by_bathroom_range']))
		{
			list($start_bathroom, $end_bathroom) = explode('-', $filter['filter_by_bathroom_range']);
			$sql .= "AND pp.bathroom BETWEEN ".str_replace(',','',$start_bathroom)." AND ".str_replace(',','',$end_bathroom)." ";
		}
		if(strlen($filter['filter_by_parking_lot_range']))
		{
			list($start_parking, $end_parking) = explode('-', $filter['filter_by_parking_lot_range']);
			$sql .= "AND pp.parking_lot BETWEEN ".str_replace(',','',$start_parking)." AND ".str_replace(',','',$end_parking)." ";
		}
		if(strlen($filter['createdby_id']))
		{
			$sql .= "AND pp.createdby = '".$filter['createdby_id']."' ";
		}
		
		$sql .= "AND pp.published_date_start <= NOW() ";
		$sql .= "AND ( pp.published_date_end > NOW() OR pp.published_date_end IS NULL ) ";
		$sql .= "AND pp.deletedby IS NULL ";
		$sql .= "AND pp.deletedat IS NULL ";
		$sql .= "ORDER BY pp.createdat DESC ";
		$propertyProducts = Yii::$app->db->createCommand($sql)->queryAll();
		
		if($propertyProducts==NULL)
		{
			$this->errorMessage = 'No property products';
			return FALSE;
		}
		else
		{
			//update total viewed
			if(strlen($filter['product_id']) or strlen($filter['permalink']))
			{
				$modelPropertyProducts = PropertyProducts::find()->where("id = '".$filter['product_id']."' OR LOWER(permalink) = '".$filter['permalink']."'")->one();
				$modelPropertyProducts->total_viewed = $modelPropertyProducts->total_viewed+1;
				$modelPropertyProducts->save();
			}
			
			foreach($propertyProducts as $key=>$value)
			{
				$result[$key]['developer_id'] = Yii::$app->GeneralMod->getDeveloperID($value['project_id']);
				$result[$key]['developer_name'] = Yii::$app->GeneralMod->getDeveloperName(Yii::$app->GeneralMod->getDeveloperID($value['project_id']));
				$result[$key]['project_id'] = $value['project_id'];
				$result[$key]['project_name'] = $value['project_name'];
				$result[$key]['project_product_id'] = $value['project_product_id'];
				$result[$key]['project_product_name'] = $value['project_product_name'];
				$result[$key]['property_type_id'] = $value['property_type_id'];
				$result[$key]['property_type_name'] = $value['property_type_name'];
				$result[$key]['id'] = $value['id'];
				$result[$key]['title'] = $value['title'];
				$result[$key]['permalink'] = $value['permalink'];
				$result[$key]['summary'] = $value['summary'];
				$result[$key]['description'] = html_entity_decode($value['description']);
				$result[$key]['thumb_image'] = $value['thumb_image'];
				$result[$key]['product_type'] = $value['product_type'];
				$result[$key]['product_type_name'] = $value['product_type_name'];
				$result[$key]['address'] = $value['address'];
				$result[$key]['latitude'] = $value['latitude'];
				$result[$key]['longitude'] = $value['longitude'];
				$result[$key]['price'] = Yii::$app->AccessMod->getPriceFormat($value['price']);
				$result[$key]['building_size'] = Yii::$app->AccessMod->getPointsFormat($value['building_size']);
				$result[$key]['land_size'] = Yii::$app->AccessMod->getPointsFormat($value['land_size']);
				$result[$key]['total_floor'] = Yii::$app->AccessMod->getPointsFormat($value['total_floor']);
				$result[$key]['bedroom'] = $value['bedroom'];
				$result[$key]['bathroom'] = $value['bathroom'];
				$result[$key]['parking_lot'] = $value['parking_lot'];
				$result[$key]['collaterals_id'] = unserialize($value['collaterals_id']);
				
				if(count($result[$key]['collaterals_id'])!=0)
				{
					//get collaterals
					foreach($result[$key]['collaterals_id'] as $collateral_key=>$collateral_id)
					{
						$collateral = $modelCollaterals->getCollateralList('',$collateral_id,'');
						$collateralMedia = $modelCollateralsMedias->getCollateralsMedias($collateral_id);
						if($collateral and $collateralMedia)
						{
							$result[$key]['collaterals'][$collateral_key]['collateral_id'] = $collateral[0]['id'];
							$result[$key]['collaterals'][$collateral_key]['type_id'] = $collateralMedia[0]['collateral_media_type_id'];
							$result[$key]['collaterals'][$collateral_key]['type_name'] = $collateralMedia[0]['collateral_media_type_name'];
							$result[$key]['collaterals'][$collateral_key]['title'] = $collateralMedia[0]['media_title'];
							$result[$key]['collaterals'][$collateral_key]['thumb_image'] = $collateralMedia[0]['thumb_image'];
							$result[$key]['collaterals'][$collateral_key]['value'] = $collateralMedia[0]['media_value'];
						}
					}
				}
				
				$result[$key]['medias'] = array();
				$result[$key]['createdby_id'] = $value['createdby'];
				$userCreatedBy = Users::findOne($value['createdby']);
				$result[$key]['createdby_name'] = $userCreatedBy->name;
				$result[$key]['createdby_email'] = $userCreatedBy->email;
				$result[$key]['createdby_contact_no'] = $userCreatedBy->country_code.$userCreatedBy->contact_number;
				$result[$key]['createdby_profile_description'] = html_entity_decode($userCreatedBy->profile_description);
				$result[$key]['createdby_profile_photo'] = $userCreatedBy->avatar;
				$result[$key]['createdat'] = Yii::$app->formatter->asDatetime($value['createdat'], 'long');
				
				//get collateral medias
				$propertyProductMediasList = $modelPropertyProductMedias->getPropertyProductMedias($value['id']);
				if($propertyProductMediasList)
				$result[$key]['medias'] = $propertyProductMediasList;
			}
			
			if(strlen($filter['product_id']) or strlen($filter['permalink']))
			{
				$result[$key]['similar_products'] = array();
				$similarProducts = $this->getSimilarPropertyProducts($result[$key]['id'],$result[$key]['product_type'],$result[$key]['property_type_id'],$result[$key]['project_id']);
				if($similarProducts)
				$result[$key]['similar_products'] = $similarProducts;
			}
		}
				
		return $result;
	}
	
	public function getSimilarPropertyProducts($product_id,$product_type='',$property_type_id='',$project_id='')
	{
		//initialize
		$result = array();
		$modelPropertyProducts = new PropertyProducts();
		$modelPropertyProductMedias = new PropertyProductMedias();
		$modelCollaterals = new Collaterals();
		$modelCollateralsMedias = new CollateralsMedias();
			
				
		$sql = "SELECT pp.id, pp.project_id, pp.project_product_id, pp.property_type_id, pp.title, pp.permalink, pp.summary, pp.description, pp.thumb_image, pp.product_type, pp.address, pp.latitude, pp.longitude, pp.price, pp.building_size, pp.land_size, pp.total_floor, pp.bedroom, pp.bathroom, pp.parking_lot, pp.collaterals_id, pp.createdby, pp.createdat, ";
		$sql .= "(SELECT projects.project_name FROM projects WHERE projects.id=pp.project_id) as project_name, ";
		$sql .= "(SELECT project_products.product_name FROM project_products WHERE project_products.id=pp.project_product_id) as project_product_name, ";
		$sql .= "(SELECT lookup_product_type.name FROM lookup_product_type WHERE lookup_product_type.id=pp.property_type_id) as property_type_name, ";
		$sql .= "(SELECT lookup_property_product_types.name FROM lookup_property_product_types WHERE lookup_property_product_types.id=pp.product_type) as product_type_name ";
		$sql .= "FROM property_products pp ";
		$sql .= "WHERE 0=0 ";
		$sql .= "AND pp.status=3 ";
		$sql .= "AND pp.id<>".$product_id." ";
		
		$sql .= "AND pp.project_id IN (SELECT projects.id FROM projects WHERE projects.status = 1 AND projects.deletedby IS NULL AND projects.deletedat IS NULL)";
		
		$sql .= "AND ( ";
		if(strlen($product_type))
		$sql .= "pp.product_type = '".$product_type."' ";
		if(strlen($property_type_id))
		$sql .= "OR pp.property_type_id = '".$property_type_id."' ";
		if(strlen($project_id))
		$sql .= "OR pp.project_id = '".$project_id."' ";
		$sql .= ") ";
		
		$sql .= "AND pp.published_date_start <= NOW() ";
		$sql .= "AND ( pp.published_date_end > NOW() OR pp.published_date_end IS NULL ) ";
		$sql .= "AND pp.deletedby IS NULL ";
		$sql .= "AND pp.deletedat IS NULL ";
		$sql .= "ORDER BY pp.createdat DESC ";
		$propertyProducts = Yii::$app->db->createCommand($sql)->queryAll();
		
		if($propertyProducts==NULL)
		{
			$this->errorMessage = 'No property products';
			return FALSE;
		}
		else
		{
			foreach($propertyProducts as $key=>$value)
			{
				$result[$key]['developer_id'] = Yii::$app->GeneralMod->getDeveloperID($value['project_id']);
				$result[$key]['developer_name'] = Yii::$app->GeneralMod->getDeveloperName(Yii::$app->GeneralMod->getDeveloperID($value['project_id']));
				$result[$key]['project_id'] = $value['project_id'];
				$result[$key]['project_name'] = $value['project_name'];
				$result[$key]['project_product_id'] = $value['project_product_id'];
				$result[$key]['project_product_name'] = $value['project_product_name'];
				$result[$key]['property_type_id'] = $value['property_type_id'];
				$result[$key]['property_type_name'] = $value['property_type_name'];
				$result[$key]['id'] = $value['id'];
				$result[$key]['title'] = $value['title'];
				$result[$key]['permalink'] = $value['permalink'];
				$result[$key]['summary'] = $value['summary'];
				$result[$key]['description'] = html_entity_decode($value['description']);
				$result[$key]['thumb_image'] = $value['thumb_image'];
				$result[$key]['product_type'] = $value['product_type'];
				$result[$key]['product_type_name'] = $value['product_type_name'];
				$result[$key]['address'] = $value['address'];
				$result[$key]['latitude'] = $value['latitude'];
				$result[$key]['longitude'] = $value['longitude'];
				$result[$key]['price'] = Yii::$app->AccessMod->getPriceFormat($value['price']);
				$result[$key]['building_size'] = Yii::$app->AccessMod->getPointsFormat($value['building_size']);
				$result[$key]['land_size'] = Yii::$app->AccessMod->getPointsFormat($value['land_size']);
				$result[$key]['total_floor'] = Yii::$app->AccessMod->getPointsFormat($value['total_floor']);
				$result[$key]['bedroom'] = $value['bedroom'];
				$result[$key]['bathroom'] = $value['bathroom'];
				$result[$key]['parking_lot'] = $value['parking_lot'];
				$result[$key]['collaterals_id'] = unserialize($value['collaterals_id']);
				
				if(count($result[$key]['collaterals_id'])!=0)
				{
					//get collaterals
					foreach($result[$key]['collaterals_id'] as $collateral_key=>$collateral_id)
					{
						$collateral = $modelCollaterals->getCollateralList('',$collateral_id,'');
						$collateralMedia = $modelCollateralsMedias->getCollateralsMedias($collateral_id);
						if($collateral and $collateralMedia)
						{
							$result[$key]['collaterals'][$collateral_key]['collateral_id'] = $collateral[0]['id'];
							$result[$key]['collaterals'][$collateral_key]['type_id'] = $collateralMedia[0]['collateral_media_type_id'];
							$result[$key]['collaterals'][$collateral_key]['type_name'] = $collateralMedia[0]['collateral_media_type_name'];
							$result[$key]['collaterals'][$collateral_key]['title'] = $collateralMedia[0]['media_title'];
							$result[$key]['collaterals'][$collateral_key]['value'] = $collateralMedia[0]['media_value'];
						}
					}
				}
				
				$result[$key]['medias'] = array();
				$result[$key]['createdby_id'] = $value['createdby'];
				$userCreatedBy = Users::findOne($value['createdby']);
				$result[$key]['createdby_name'] = $userCreatedBy->name;
				$result[$key]['createdby_email'] = $userCreatedBy->email;
				$result[$key]['createdby_contact_no'] = $userCreatedBy->country_code.$userCreatedBy->contact_number;
				$result[$key]['createdby_profile_description'] = html_entity_decode($userCreatedBy->profile_description);
				$result[$key]['createdby_profile_photo'] = $userCreatedBy->avatar;
				$result[$key]['createdat'] = Yii::$app->formatter->asDatetime($value['createdat'], 'long');
				
				//get collateral medias
				$propertyProductMediasList = $modelPropertyProductMedias->getPropertyProductMedias($value['id']);
				if($propertyProductMediasList)
				$result[$key]['medias'] = $propertyProductMediasList;
			}
		}
				
		return $result;
	}
	
	public function getNewsFeeds($filter=array())
	{
		//initialize
		$result = array();
		$modelNewsFeeds = new NewsFeeds();
		$modelNewsFeedMedias = new NewsFeedMedias();
		
		$sql = "SELECT nf.category_id, lnfc.name as category_name, nf.project_id, p.project_name as project_name, ";
		$sql .= "nf.id, nf.title, nf.permalink, nf.summary, nf.description, nf.thumb_image, nf.product_id, nf.promotion_start_date, nf.promotion_end_date, nf.promotion_terms_conditions, nf.event_at, nf.event_location, nf.event_location_longitude, nf.event_location_latitude, nf.collaterals_id, nf.createdby, nf.createdat ";
		$sql .= "FROM news_feeds nf, projects p, lookup_news_feed_categories lnfc ";
		$sql .= "WHERE 0=0 ";
		$sql .= "AND nf.status=3 ";
		$sql .= "AND nf.category_id=lnfc.id ";
		$sql .= "AND nf.project_id=p.id ";
		
		$sql .= "AND nf.project_id IN (SELECT projects.id FROM projects WHERE projects.status = 1 AND projects.deletedby IS NULL AND projects.deletedat IS NULL)";
		
		if(strlen($filter['project']))
		$sql .= "AND (p.id='".$filter['project']."' OR LOWER(p.project_name) LIKE '".strtolower($filter['project'])."') ";
		if(strlen($filter['category']))
		$sql .= "AND (lnfc.id='".$filter['category']."' OR LOWER(lnfc.name) LIKE '".strtolower($filter['category'])."') ";
		if(strlen($filter['news_feed_id']))
		$sql .= "AND nf.id='".$filter['news_feed_id']."' ";
		if(strlen($filter['permalink']))
		$sql .= "AND LOWER(nf.permalink)='".strtolower($filter['permalink'])."' ";
		
		$sql .= "AND nf.published_date_start <= NOW() ";
		$sql .= "AND ( nf.published_date_end > NOW() OR nf.published_date_end IS NULL ) ";
		$sql .= "AND nf.deletedby IS NULL ";
		$sql .= "AND nf.deletedat IS NULL ";
		$sql .= "ORDER BY nf.createdat DESC ";
		$newsFeeds = Yii::$app->db->createCommand($sql)->queryAll();
				
		if($newsFeeds==NULL)
		{
			$this->errorMessage = 'No news feeds';
			return FALSE;
		}
		else
		{
			//update total viewed
			if(strlen($filter['news_feed_id']) or strlen($filter['permalink']))
			{
				$modelNewsFeeds = NewsFeeds::find()->where("id = '".$filter['news_feed_id']."' OR LOWER(permalink) = '".$filter['permalink']."'")->one();
				$modelNewsFeeds->total_viewed = $modelNewsFeeds->total_viewed+1;
				$modelNewsFeeds->save();
			}
			
			foreach($newsFeeds as $key=>$value)
			{
				$result[$key]['project_id'] = $value['project_id'];
				$result[$key]['project_name'] = $value['project_name'];
				$result[$key]['category_id'] = $value['category_id'];
				$result[$key]['category_name'] = $value['category_name'];
				$result[$key]['id'] = $value['id'];
				$result[$key]['title'] = $value['title'];
				$result[$key]['permalink'] = $value['permalink'];
				$result[$key]['summary'] = $value['summary'];
				$result[$key]['description'] = html_entity_decode($value['description']);
				$result[$key]['thumb_image'] = $value['thumb_image'];
				$result[$key]['product_id'] = $value['product_id'];
				$result[$key]['promotion_start_date'] = $value['promotion_start_date'];
				$result[$key]['promotion_end_date'] = $value['promotion_end_date'];
				$result[$key]['promotion_terms_conditions'] = html_entity_decode($value['promotion_terms_conditions']);
				$result[$key]['event_at'] = $value['event_at'];
				$result[$key]['event_date'] = strlen($value['event_at'])?date('Y M d',strtotime($value['event_at'])):'';
				$result[$key]['event_time'] = strlen($value['event_at'])?date('h:i A',strtotime($value['event_at'])):'';
				$result[$key]['event_location'] = $value['event_location'];
				$result[$key]['event_location_longitude'] = $value['event_location_longitude'];
				$result[$key]['event_location_latitude'] = $value['event_location_latitude'];
				$result[$key]['collaterals_id'] = unserialize($value['collaterals_id']);
				$result[$key]['medias'] = array();
				$result[$key]['createdby_id'] = $value['createdby'];
				$userCreatedBy = Users::findOne($value['createdby']);
				$result[$key]['createdby_name'] = $userCreatedBy->name;
				$result[$key]['createdby_email'] = $userCreatedBy->email;
				$result[$key]['createdby_contact_no'] = $userCreatedBy->country_code.$userCreatedBy->contact_number;
				$result[$key]['createdby_profile_description'] = html_entity_decode($userCreatedBy->profile_description);
				$result[$key]['createdby_profile_photo'] = $userCreatedBy->avatar;
				$result[$key]['createdat'] = Yii::$app->formatter->asDatetime($value['createdat'], 'long');
				
				//get collateral medias
				$newsFeedMediasList = $modelNewsFeedMedias->getNewsFeedMedias($value['id']);
				if($newsFeedMediasList)
				$result[$key]['medias'] = $newsFeedMediasList;
			}
		}
		
		return $result;
	}
	
	
	
	
	
	
}
?>