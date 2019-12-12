<?php
namespace app\components;

use Yii;
use yii\helpers\Html;
use yii\base\ErrorException;

use app\models\Users;
use app\models\CommissionGroupTiers;
use app\models\Prospects;
use app\models\ProspectBookings;
use app\models\PropertyProducts;
use app\models\ProjectProducts;
use app\models\UserCommissions;
use app\models\UserEligibleCommissions;

use app\models\LookupCommissionTier;

use app\models\LogProspectHistory;
use app\models\LogMemberActivities;
use app\models\LogUserCommission;

use yii\helpers\Json;

class CommissionMod extends \yii\base\Component
{
	public $errorMessage;

    public function init() {
        parent::init();
    }
		
	public function getCommissionGroupTier($prospect_booking_id,$product_type_id)
	{
		//initialize
		$result = array();
		$result['agent']['user_id'] = '';
		$result['agent']['commission_group_tier_id'] = '';
		$result['agent']['commission_group_id'] = '';
		$result['agent']['commission_tier_id'] = '';
		$result['agent']['commission_type_id'] = '';
		$result['agent']['commission_value'] = '';
		$result['agent']['commission_amount'] = '';
		$result['dedicated_agent']['user_id'] = '';
		$result['dedicated_agent']['commission_group_tier_id'] = '';
		$result['dedicated_agent']['commission_group_id'] = '';
		$result['dedicated_agent']['commission_tier_id'] = '';
		$result['dedicated_agent']['commission_type_id'] = '';
		$result['dedicated_agent']['commission_value'] = '';
		$result['dedicated_agent']['commission_amount'] = '';
		$result['member']['user_id'] = '';
		$result['member']['commission_group_tier_id'] = '';
		$result['member']['commission_group_id'] = '';
		$result['member']['commission_tier_id'] = '';
		$result['member']['commission_type_id'] = '';
		$result['member']['commission_value'] = '';
		$result['member']['commission_amount'] = '';
		$result['referrer']['user_id'] = '';
		$result['referrer']['commission_group_tier_id'] = '';
		$result['referrer']['commission_group_id'] = '';
		$result['referrer']['commission_tier_id'] = '';
		$result['referrer']['commission_type_id'] = '';
		$result['referrer']['commission_value'] = '';
		$result['referrer']['commission_amount'] = '';
		$modelCommissionGroupTiers = new CommissionGroupTiers();
		$modelProspectBookings = new ProspectBookings();
		
		//validate
		try
		{
			if(empty($prospect_booking_id))
			throw new ErrorException("Invalid prospect booking id (1)");
			
			$prospectBookings = ProspectBookings::find()->where(array('id'=>$prospect_booking_id))->asArray()->one();
			if($prospectBookings==NULL)
			throw new ErrorException("Invalid prospect booking id (2)");
			
			if(empty($product_type_id))
			throw new ErrorException("Invalid product type id (1)");
			
			if(!in_array($product_type_id,array_column(Yii::$app->AccessMod->getLookupData('lookup_product_type'),'id')))
			throw new ErrorException("Invalid product type id (2)");
		}
		catch(ErrorException $e)
		{
			$this->errorMessage = $e->getMessage();
			return false;
		}
		
		//get agent details
		$agent = Users::find()->where(array('id'=>$prospectBookings['agent_id']))->asArray()->one();
		//get agent group ID
		$agentGroupID = Yii::$app->AccessMod->getUserGroupID($prospectBookings['agent_id']);
		//check commisison expiry date - user table
		//if commission expired, update new date, reset commission ranking/tier
		if(!empty($agent['commission_tier_expiry_date']))
		{
			if(strtotime(date('Y-m-d',time())) <= strtotime($agent['commission_tier_expiry_date']))
			$commission_tier_expiry_date = $agent['commission_tier_expiry_date'];
			else
			$commission_tier_expiry_date = date("Y-m-d", strtotime("+12 month",strtotime(date('Y-m-d',time()))));
		}
		else
		$commission_tier_expiry_date = date("Y-m-d", strtotime("+12 month",strtotime(date('Y-m-d',time()))));
		
		//get agent total transaction value
		$agentTotalTransactionValue = Yii::$app->ProspectMod->getProspectBookingsTotal(array('agent_id'=>$prospectBookings['agent_id']),$commission_tier_expiry_date,12);		
		$agentTotalTransactionValue = $agentTotalTransactionValue+$prospectBookings['product_unit_price'];
		
		//get agent commission tier		
		if(in_array($agentGroupID,array(7,9)))
		$agentCommissionGroupTier = $modelCommissionGroupTiers->getCommissionGroupTierByTotalTransactionValue($product_type_id,1,'',$agentTotalTransactionValue);
		elseif(in_array($agentGroupID,array(8,10)))
		$agentCommissionGroupTier = $modelCommissionGroupTiers->getCommissionGroupTierByTotalTransactionValue($product_type_id,2,'',$agentTotalTransactionValue);		
		
		//check commission ranking/tier - user table
		//if not platinum, check ranking promotion (total booking unit price + new booking unit price), reset commisison ranking 
		if(!empty($agent['commission_tier_id']) and !empty($agent['commission_tier_expiry_date']))
		{
			if($agent['commission_tier_id']==3 or $agent['commission_tier_id']>$agentCommissionGroupTier['commission_tier_id'])
			{
				if(strtotime(date('Y-m-d',time())) <= strtotime($agent['commission_tier_expiry_date']))
				{
					if(in_array($agentGroupID,array(7,9)))
					$agentCommissionGroupTier = $modelCommissionGroupTiers->getCommissionGroupTierByTotalTransactionValue($product_type_id,1,$agent['commission_tier_id'],'');
					elseif(in_array($agentGroupID,array(8,10)))
					$agentCommissionGroupTier = $modelCommissionGroupTiers->getCommissionGroupTierByTotalTransactionValue($product_type_id,2,$agent['commission_tier_id'],'');		
				}
			}
		}
		
		//capture agent
		$result['agent']['user_id'] = $prospectBookings['agent_id'];
		$result['agent']['commission_group_tier_id'] = $agentCommissionGroupTier['id'];
		$result['agent']['commission_group_id'] = $agentCommissionGroupTier['commission_group_id'];
		$result['agent']['commission_group_id'] = $agentCommissionGroupTier['commission_group_id'];
		$result['agent']['commission_tier_id'] = $agentCommissionGroupTier['commission_tier_id'];
		$result['agent']['commission_type_id'] = $agentCommissionGroupTier['commission_type_id'];
		$result['agent']['commission_value'] = $agentCommissionGroupTier['commission_value'];
		//calculate commission amount
		if($result['agent']['commission_type_id']==1)
		$agent_commission_amount = ($result['agent']['commission_value']/100)*$prospectBookings['product_unit_price'];
		else
		$agent_commission_amount = $result['agent']['commission_value'];
		$result['agent']['commission_amount'] = $agent_commission_amount;
				
		//get dedicated agent commission tier
		if(strlen($prospectBookings['dedicated_agent_id']) and $prospectBookings['dedicated_agent_id']!=$prospectBookings['agent_id'] and $prospectBookings['dedicated_agent_id']!=0)
		{
			if(in_array($agentGroupID,array(7,9)))
			$dedicatedAgentCommissionGroupTier = $modelCommissionGroupTiers->getCommissionGroupTierByTotalTransactionValue($product_type_id,5,$agentCommissionGroupTier['commission_tier_id'],'');
			elseif(in_array($agentGroupID,array(8,10)))
			$dedicatedAgentCommissionGroupTier = $modelCommissionGroupTiers->getCommissionGroupTierByTotalTransactionValue($product_type_id,6,$agentCommissionGroupTier['commission_tier_id'],'');
			
			//capture dedicated agent
			$result['dedicated_agent']['user_id'] = $prospectBookings['dedicated_agent_id'];
			$result['dedicated_agent']['commission_group_tier_id'] = $dedicatedAgentCommissionGroupTier['id'];
			$result['dedicated_agent']['commission_group_id'] = $dedicatedAgentCommissionGroupTier['commission_group_id'];
			$result['dedicated_agent']['commission_tier_id'] = $dedicatedAgentCommissionGroupTier['commission_tier_id'];
			$result['dedicated_agent']['commission_type_id'] = $dedicatedAgentCommissionGroupTier['commission_type_id'];
			$result['dedicated_agent']['commission_value'] = $dedicatedAgentCommissionGroupTier['commission_value'];
			//calculate commission amount
			if($result['dedicated_agent']['commission_type_id']==1)
			$dedicated_agent_commission_amount = ($result['dedicated_agent']['commission_value'])*$agent_commission_amount;
			else
			$dedicated_agent_commission_amount = $result['dedicated_agent']['commission_value'];
			$result['dedicated_agent']['commission_amount'] = $dedicated_agent_commission_amount;
			$result['agent']['commission_amount'] = $agent_commission_amount-$dedicated_agent_commission_amount;
		}
		
		//get agent details
		$member = Users::find()->where(array('id'=>$prospectBookings['member_id']))->asArray()->one();
		if($member['uuid']==$_SESSION['settings']['AUTO_ASSIGN_PROSPECT_TO_MEMBER'])
		{
			$memberCommissionGroupTier = $modelCommissionGroupTiers->getCommissionGroupTierByTotalTransactionValue($product_type_id,3,3,'');
		}
		else
		{
			//get member group ID
			$memberGroupID = Yii::$app->AccessMod->getUserGroupID($prospectBookings['member_id']);
			//check commisison expiry date - user table
			//if commission expired, update new date, reset commission ranking/tier
			if(!empty($member['commission_tier_expiry_date']))
			{
				if(strtotime(date('Y-m-d',time())) <= strtotime($member['commission_tier_expiry_date']))
				$commission_tier_expiry_date = $member['commission_tier_expiry_date'];
				else
				$commission_tier_expiry_date = date("Y-m-d", strtotime("+12 month",strtotime(date('Y-m-d',time()))));
			}
			else
			$commission_tier_expiry_date = date("Y-m-d", strtotime("+12 month",strtotime(date('Y-m-d',time()))));
			
			//get member total transaction value
			$memberTotalTransactionValue = Yii::$app->ProspectMod->getProspectBookingsTotal(array('member_id'=>$prospectBookings['member_id']),$commission_tier_expiry_date,12);
			$memberTotalTransactionValue = $memberTotalTransactionValue+$prospectBookings['product_unit_price'];
			
			//get member commission tier
			if($memberGroupID==11)
			$memberCommissionGroupTier = $modelCommissionGroupTiers->getCommissionGroupTierByTotalTransactionValue($product_type_id,3,'',$memberTotalTransactionValue);
			if($memberGroupID==12)
			$memberCommissionGroupTier = $modelCommissionGroupTiers->getCommissionGroupTierByTotalTransactionValue($product_type_id,4,'',$memberTotalTransactionValue);
			
			//check commission ranking/tier - user table
			//if not platinum, check ranking promotion (total booking unit price + new booking unit price), reset commisison ranking 
			if(!empty($member['commission_tier_id']) and !empty($member['commission_tier_expiry_date']))
			{
				if($member['commission_tier_id']==3 or $member['commission_tier_id']>$memberCommissionGroupTier['commission_tier_id'])
				{
					if(strtotime(date('Y-m-d',time())) <= strtotime($member['commission_tier_expiry_date']))
					{
						if($memberGroupID==11)
						$memberCommissionGroupTier = $modelCommissionGroupTiers->getCommissionGroupTierByTotalTransactionValue($product_type_id,3,$agent['commission_tier_id'],'');
						if($memberGroupID==12)
						$memberCommissionGroupTier = $modelCommissionGroupTiers->getCommissionGroupTierByTotalTransactionValue($product_type_id,4,$agent['commission_tier_id'],'');
					}
				}
			}
		}
		
		//capture member
		$result['member']['user_id'] = $prospectBookings['member_id'];
		$result['member']['commission_group_tier_id'] = $memberCommissionGroupTier['id'];
		$result['member']['commission_group_id'] = $memberCommissionGroupTier['commission_group_id'];
		$result['member']['commission_tier_id'] = $memberCommissionGroupTier['commission_tier_id'];
		$result['member']['commission_type_id'] = $memberCommissionGroupTier['commission_type_id'];
		$result['member']['commission_value'] = $memberCommissionGroupTier['commission_value'];
		//calculate commission amount
		if($result['member']['commission_type_id']==1)
		$member_commission_amount = ($result['member']['commission_value']/100)*$prospectBookings['product_unit_price'];
		else
		$member_commission_amount = $result['member']['commission_value'];
		$result['member']['commission_amount'] = $member_commission_amount;

		//get member referrer commission tier
		if(strlen($prospectBookings['referrer_member_id']) and $prospectBookings['member_id']!=$prospectBookings['referrer_member_id'] and $prospectBookings['referrer_member_id']!=0 and $prospectBookings['product_unit_price'] >= 1000000000)
		{
			$referrerCommissionLimit = $this->getMemberGetMemberCommissionLimit($prospectBookings['member_id']);
			if($referrerCommissionLimit)
			{
				$referrerMemberCommissionGroupTier = $modelCommissionGroupTiers->getCommissionGroupTierByTotalTransactionValue($product_type_id,7,$memberCommissionGroupTier['commission_tier_id'],'');
				//capture member referrer
				$result['referrer']['user_id'] = $prospectBookings['referrer_member_id'];
				$result['referrer']['commission_group_tier_id'] = $referrerMemberCommissionGroupTier['id'];
				$result['referrer']['commission_group_id'] = $referrerMemberCommissionGroupTier['commission_group_id'];
				$result['referrer']['commission_tier_id'] = $referrerMemberCommissionGroupTier['commission_tier_id'];
				$result['referrer']['commission_type_id'] = $referrerMemberCommissionGroupTier['commission_type_id'];
				$result['referrer']['commission_value'] = $referrerMemberCommissionGroupTier['commission_value'];
				//calculate commission amount
				if($result['referrer']['commission_type_id']==1)
				{
					$referrer_commission_amount = ($result['referrer']['commission_value'])*$member_commission_amount;
					$result['member']['commission_amount'] = $member_commission_amount-$referrer_commission_amount;
				}
				else
				{
					$referrer_commission_amount = $result['referrer']['commission_value'];
					$result['referrer']['commission_amount'] = $referrer_commission_amount;
				}				
			}
		}
				
		return $result;
	}
	
	public function getProjectProductTierByProductID($product_id)
	{
		//validate
		try
		{
			if(empty($product_id))
			throw new ErrorException("Invalid product id (1)");
			
			$projectProducts = ProjectProducts::find()->where(array('id'=>$product_id))->asArray()->one();
			if($projectProducts==NULL)
			throw new ErrorException("Invalid product id (2)");
		}
		catch(ErrorException $e)
		{
			$this->errorMessage = $e->getMessage();
			return false;
		}
		
		return $projectProducts['product_tier'];
	}
	
	public function generateUserCommissionsByProspectBooking($prospect_booking_id)
	{
		//validate
		try
		{
			if(empty($prospect_booking_id))
			throw new ErrorException("Invalid prospect booking id (1)");
			
			$prospectBookings = ProspectBookings::find()->where(array('id'=>$prospect_booking_id))->asArray()->one();
			if($prospectBookings==NULL)
			throw new ErrorException("Invalid prospect booking id (2)");
						
			$projectProductTier = $this->getProjectProductTierByProductID($prospectBookings['product_id']);
			if(!$projectProductTier)
			throw new ErrorException($this->errorMessage);
						
			$userCommissionGroupTiers = $this->getCommissionGroupTier($prospect_booking_id,$projectProductTier);
			if(!$userCommissionGroupTiers)
			throw new ErrorException($this->errorMessage);
			
			$prospect = Prospects::find()->where(array('id'=>$prospectBookings['prospect_id']))->asArray()->one();
		
			//check commission exist
			$logUserCommission = LogUserCommission::find()->where(array('prospect_id'=>$prospectBookings['prospect_id'],'prospect_booking_id'=>$prospect_booking_id,'status'=>1))->one();
			if($logUserCommission!=NULL)
			throw new ErrorException("Commission already been generated.");
		}
		catch(ErrorException $e)
		{
			$this->errorMessage = $e->getMessage();
			return false;
		}
					
		//process
		$connection = Yii::$app->db;
		$transaction = $connection->beginTransaction();
		try 
		{
			foreach($userCommissionGroupTiers as $key=>$value)
			{
				if(strlen($value['user_id']) and strlen($value['commission_group_tier_id']) and strlen($value['commission_group_id']) and strlen($value['commission_tier_id']) and strlen($value['commission_type_id']) and strlen($value['commission_value']) and strlen($value['commission_amount']))
				{
					//save user commissions
					$modelUserCommissions = UserCommissions::find()->where(array('user_id'=>$value['user_id']))->one();
					if($modelUserCommissions!=NULL)
					{
						$modelUserCommissions->total_commission_amount = $modelUserCommissions->total_commission_amount+$value['commission_amount'];
						if(in_array($modelUserCommissions->status,array(2,4)))
						$modelUserCommissions->status = 1;
						$modelUserCommissions->updatedby = $_SESSION['user']['id'];
						$modelUserCommissions->updatedat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
					}
					else
					{
						$modelUserCommissions = new UserCommissions();
						$modelUserCommissions->user_id = $value['user_id'];
						$modelUserCommissions->total_commission_amount = $value['commission_amount'];
						$modelUserCommissions->status = 1;
						$modelUserCommissions->createdby = $_SESSION['user']['id'];
						$modelUserCommissions->createdat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
					}
					
					$modelUserCommissions->save();
					if(count($modelUserCommissions->errors)!=0)
					throw new ErrorException("Generate user commission failed.");
					
					
					//create log user commissions
					$modelLogUserCommission = new LogUserCommission();
					$modelLogUserCommission->commission_group_tier_id = $value['commission_group_tier_id'];
					$modelLogUserCommission->prospect_id = $prospect['id'];
					$modelLogUserCommission->prospect_booking_id = $prospectBookings['id'];
					$modelLogUserCommission->user_commission_id = $modelUserCommissions->id;
					$modelLogUserCommission->user_id = $value['user_id'];
					$modelLogUserCommission->commission_amount = $value['commission_amount'];
					$modelLogUserCommission->status = 1;
					$modelLogUserCommission->createdby = $_SESSION['user']['id'];
					$modelLogUserCommission->createdat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
					$modelLogUserCommission->save();
					if(count($modelLogUserCommission->errors)!=0)
					throw new ErrorException("Create log user commission failed.");
				
					if(in_array($key, array('agent','member')))
					{
						$modelUsers = Users::find()->where(array('id'=>$value['user_id']))->one();
						unset($modelUsers->password);
						
						if(!empty($member['commission_tier_expiry_date']))
						{
							if(strtotime(date('Y-m-d',time())) > strtotime($modelUsers->commission_tier_expiry_date))
							$modelUsers->commission_tier_expiry_date = date("Y-m-d", strtotime("+12 month",strtotime(date('Y-m-d',time()))));
						}
						else
						$modelUsers->commission_tier_expiry_date = date("Y-m-d", strtotime("+12 month",strtotime(date('Y-m-d',time()))));
						
						$modelUsers->commission_tier_id = $value['commission_tier_id'];
						
						$modelUsers->save();
						if(count($modelUsers->errors)!=0)
						throw new ErrorException("Create update user commission ranking failed.");
					}
				}
			}
									
			$transaction->commit();
		}
		catch (ErrorException $e) 
		{
			$transaction->rollBack();
			$this->errorMessage = $e->getMessage();
			return false;
		}
		
		if(!strlen($this->errorMessage))
		return $userCommissionGroupTiers;
	}
	
	public function getMemberGetMemberCommissionLimit($member_id)
	{
		//validate
		try
		{
			if(empty($member_id))
			throw new ErrorException("Invalid member id");
		}
		catch(ErrorException $e)
		{
			$this->errorMessage = $e->getMessage();
			return false;
		}
		
		//count member prospect full book
		$sql = "SELECT count(id) as totalProspectBook ";
		$sql .= "FROM prospect_bookings ";
		$sql .= "WHERE status IN (6,7,8,9) ";
		if(!empty($member_id))
		$sql .= "AND member_id = '".$member_id."' ";
		$sql .= "AND prospect_bookings.product_unit_price >= 1000000000 ";
		$connection = Yii::$app->getDb();
		$query = $connection->createCommand($sql);
		$records = $query->queryOne();
		
		if($records['totalProspectBook']<$_SESSION['settings']['MEMBER_GET_MEMBER_COMMISSION_LIMIT'])
		return true;
		else
		return false;
	}
	
	public function cancelUserCommissionsByProspectBookingID($prospect_booking_id)
	{
		$modelUserCommissions = new UserCommissions();
		$modelUserEligibleCommissions = new UserEligibleCommissions();
		$modelLogUserCommission = new LogUserCommission();
		
		//validate
		try
		{
			if(empty($prospect_booking_id))
			throw new ErrorException("Invalid prospect booking id (1).");
			
			$prospectBookings = ProspectBookings::find()->where(array('id'=>$prospect_booking_id))->asArray()->one();
			if($prospectBookings==NULL)
			throw new ErrorException("Invalid prospect booking id (2).");
			
			$prospect = Prospects::find()->where(array('id'=>$prospectBookings['prospect_id']))->asArray()->one();
			if($prospect==NULL)
			throw new ErrorException("Invalid prospect id.");
			
			$logUserCommissionCancel = LogUserCommission::find()->where(array('prospect_id'=>$prospect['id'],'prospect_booking_id'=>$prospectBookings['id'],'status'=>3))->asArray()->all();
			if(count($logUserCommissionCancel)!=0)
			throw new ErrorException("Commission already beed cancelled.");
			
			$logUserCommissions = LogUserCommission::find()->where(array('prospect_id'=>$prospect['id'],'prospect_booking_id'=>$prospectBookings['id'],'status'=>1))->asArray()->all();
		}
		catch(ErrorException $e)
		{
			$this->errorMessage = $e->getMessage();
			return false;
		}
						
		//process
		$connection = Yii::$app->db;
		$transaction = $connection->beginTransaction();
		try 
		{
			if(count($logUserCommissions)!=0)
			{
				foreach($logUserCommissions as $key=>$log_user_commission)
				{
					//get user commission
					$modelUserCommissions = UserCommissions::find()->where(array('user_id'=>$log_user_commission['user_id']))->one();
					//get eligible commission
					$totalEligibleCommissionGiven = $modelLogUserCommission->getTotalEligibleCommissionGiven($log_user_commission['user_id'],$log_user_commission['prospect_booking_id']);				
					
					if($totalEligibleCommissionGiven != 0)
					{
						//get commission paid
						$totalCommissionPaid = $modelLogUserCommission->getTotalCommissionPaid($log_user_commission['user_id'],$log_user_commission['prospect_booking_id']);
						if(($totalEligibleCommissionGiven-$totalCommissionPaid)!=0)
						{
							//soft delete user eligible commission
							$modelUserEligibleCommissions = UserEligibleCommissions::find()->where(array('user_id'=>$log_user_commission['user_id'],'status'=>0,'deletedby'=>NULL,'deletedat'=>NULL))->one();
							$modelUserEligibleCommissions->deletedby = $_SESSION['user']['id'];
							$modelUserEligibleCommissions->deletedat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
							$modelUserEligibleCommissions->save();
							if(count($modelUserEligibleCommissions->errors)!=0)
							throw new ErrorException("Cancel user eligible commission failed.");
						}
							
						//update user commission
						$modelUserCommissions->total_commission_amount = $modelUserCommissions->total_commission_amount-($log_user_commission['commission_amount']-$totalCommissionPaid);
	
						$tmpTotalUserCommissionPaid = $modelLogUserCommission->getTotalCommissionPaid($log_user_commission['user_id'],'');
						if($modelUserCommissions->total_commission_amount==$tmpTotalUserCommissionPaid)
						$modelUserCommissions->status = 4;
	
						$modelUserCommissions->updatedby = $_SESSION['user']['id'];
						$modelUserCommissions->updatedat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
						$modelUserCommissions->save();
						if(count($modelUserCommissions->errors)!=0)
						throw new ErrorException("Update user commission failed.");
						
						
						//create log user commission status cancel
						$modelLogUserCommission = new LogUserCommission();
						$modelLogUserCommission->prospect_id = $log_user_commission['prospect_id'];
						$modelLogUserCommission->prospect_booking_id = $log_user_commission['prospect_booking_id'];
						$modelLogUserCommission->user_commission_id = $modelUserCommissions->id;
						$modelLogUserCommission->user_id = $log_user_commission['user_id'];
						$modelLogUserCommission->commission_amount = $log_user_commission['commission_amount']-$totalCommissionPaid;
						$modelLogUserCommission->status = 3;
						$modelLogUserCommission->createdby = $_SESSION['user']['id'];
						$modelLogUserCommission->createdat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
						$modelLogUserCommission->save();
						if(count($modelLogUserCommission->errors)!=0)
						throw new ErrorException("Create log user commission failed.");
					}
					else
					{
						//update user commission
						$modelUserCommissions->total_commission_amount = $modelUserCommissions->total_commission_amount-$log_user_commission['commission_amount'];
						
						if($modelUserCommissions->total_commission_amount==0)
						$modelUserCommissions->status = 2;
						else
						{
							$totalUserCommissionPaid = $modelLogUserCommission->getTotalCommissionPaid($log_user_commission['user_id'],'');
							if($modelUserCommissions->total_commission_amount==$totalUserCommissionPaid)
							$modelUserCommissions->status = 4;
						}
						
						$modelUserCommissions->updatedby = $_SESSION['user']['id'];
						$modelUserCommissions->updatedat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
						$modelUserCommissions->save();
						if(count($modelUserCommissions->errors)!=0)
						throw new ErrorException("Update user commission failed.");
						
						//create log user commission status cancel
						$modelLogUserCommission = new LogUserCommission();
						$modelLogUserCommission->prospect_id = $log_user_commission['prospect_id'];
						$modelLogUserCommission->prospect_booking_id = $log_user_commission['prospect_booking_id'];
						$modelLogUserCommission->user_commission_id = $modelUserCommissions->id;
						$modelLogUserCommission->user_id = $log_user_commission['user_id'];
						$modelLogUserCommission->commission_amount = $log_user_commission['commission_amount'];
						$modelLogUserCommission->status = 3;
						$modelLogUserCommission->createdby = $_SESSION['user']['id'];
						$modelLogUserCommission->createdat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
						$modelLogUserCommission->save();
						if(count($modelLogUserCommission->errors)!=0)
						throw new ErrorException("Create log user commission failed.");
					}
				}
			}
				
			$transaction->commit();
		}
		catch (ErrorException $e)
		{
			$transaction->rollBack();
			$this->errorMessage = $e->getMessage();
			return false;
		}
		
		if(!strlen($this->errorMessage))
		return true;
	}
	
	public function getUserCommissions($user_id)
	{
		$result = array();
		$modelUserCommissions = new UserCommissions();
		$modelUserEligibleCommissions = new UserEligibleCommissions();
		$modelLogUserCommission = new LogUserCommission();
		
		$users = Users::find()->where(array('id'=>$user_id))->asArray()->one();
		$commission_tier_id = 1;
		if(!empty($users['commission_tier_id']))
		$commission_tier_id = $users['commission_tier_id'];
		$commissionTier = LookupCommissionTier::find()->where(array('id'=>$commission_tier_id))->one();
		$modelUserCommissions = UserCommissions::find()->where(array('user_id'=>$user_id))->one();
		$modelUserEligibleCommissions = UserEligibleCommissions::find()->where(array('user_id'=>$user_id,'status'=>0,'deletedby'=>NULL,'deletedat'=>NULL))->asArray()->all();		
		$totalCommissionClaimed = $modelLogUserCommission->getTotalCommissionPaid($user_id,'');
		
		$result['commission_tier'] = $commissionTier->name;
		
		$total_estimated_commission_amount=0;
		if($modelUserCommissions!=NULL)
		$total_estimated_commission_amount=$modelUserCommissions->total_commission_amount;
		
		$total_eligible_commission_amount=0;
		if(count($modelUserEligibleCommissions)!=0)
		{
			foreach($modelUserEligibleCommissions as $value)
			$total_eligible_commission_amount=$total_eligible_commission_amount+$value['commission_eligible_amount'];
		}
		
		$result['total_estimated_commission_amount'] = Yii::$app->AccessMod->getPriceFormat($total_estimated_commission_amount-($total_eligible_commission_amount+$totalCommissionClaimed));
		$result['total_eligible_commission_amount'] = Yii::$app->AccessMod->getPriceFormat($total_eligible_commission_amount);
		$result['total_commission_claimed'] = Yii::$app->AccessMod->getPriceFormat($totalCommissionClaimed);
		
		return $result;
	}
	
	public function getUserCommissionsTransaction($user_id)
	{
		$modelLogUserCommission = new LogUserCommission();
		
		$result = array();
		$logUserCommissions = $modelLogUserCommission->getLogUserCommissions($user_id,'',1);
		if($logUserCommissions)
		{
			foreach($logUserCommissions as $key=>$value)
			{
				//check eligible commission
				$tmpUserEligibleCommissionGiven = 0;
				$tmpUserEligibleCommissions = UserEligibleCommissions::find()->where(array('user_commission_id'=>$value['user_commission_id'],'prospect_booking_id'=>$value['prospect_booking_id'],'user_id'=>$value['user_id'],'status'=>0,'deletedby'=>NULL,'deletedat'=>NULL))->asArray()->all();
				if(count($tmpUserEligibleCommissions)!=0)
				{
					foreach($tmpUserEligibleCommissions as $tmpUserEligibleCommission)
					{
						$tmpUserEligibleCommissionGiven = $tmpUserEligibleCommissionGiven+$tmpUserEligibleCommission['commission_eligible_amount'];
					}
				}
				
				//check commission paid
				$tmpTotalCommissionPaid = $modelLogUserCommission->getTotalCommissionPaid($value['user_id'],$value['prospect_booking_id']);
							
				$logUserCommissions[$key]['commission_amount'] = $value['commission_amount']-($tmpUserEligibleCommissionGiven+$tmpTotalCommissionPaid);
				$logUserCommissions[$key]['eligible_commission_amount'] = $tmpUserEligibleCommissionGiven;
				$logUserCommissions[$key]['paid_commission_amount'] = $tmpTotalCommissionPaid;
				
				$logUserCommissions[$key]['status_text'] = 'Pending';
				if($tmpUserEligibleCommissionGiven!=0 and $value['commission_amount']!=$tmpTotalCommissionPaid)
				{
					$logUserCommissions[$key]['status'] = 2;
					$logUserCommissions[$key]['status_text'] = 'Processing';
				}
				if($value['commission_amount']==$tmpTotalCommissionPaid)
				{
					$logUserCommissions[$key]['status'] = 4;
					$logUserCommissions[$key]['status_text'] = 'Completed';
				}
				//check cancel commission
				$logUserCommissionCancel = LogUserCommission::find()->where(array('prospect_id'=>$value['prospect_id'],'prospect_booking_id'=>$value['prospect_booking_id'],'user_commission_id'=>$value['user_commission_id'],'status'=>3))->asArray()->all();
				if(count($logUserCommissionCancel)!=0)
				{
					$logUserCommissions[$key]['status'] = 3;
					$logUserCommissions[$key]['status_text'] = 'Cancelled';
				}
			}
			
			if(count($logUserCommissions)!=0)
			{
				foreach($logUserCommissions as $key=>$value)
				{
					$modelProspectBookings = ProspectBookings::findOne($value['prospect_booking_id']);
					
					$result[$key]['prospect_id'] = $value['prospect_id'];
					$result[$key]['prospect_booking_id'] = $value['prospect_booking_id'];
					$result[$key]['developer_name'] = $value['developer_name'];
					$result[$key]['project_name'] = $value['project_name'];
					$result[$key]['product_name'] = $value['product_name'];
					$result[$key]['product_unit'] = $value['product_unit'];
					$result[$key]['product_price'] = Yii::$app->AccessMod->getPriceFormat($modelProspectBookings->product_unit_price);
					$result[$key]['prospect_name'] = $value['prospect_name'];
					$modelCommissionGroupTiers = CommissionGroupTiers::find()->where(array('id'=>$value['commission_group_tier_id']))->one();
					$result[$key]['commission_tier'] = $modelCommissionGroupTiers->lookupCommissionTier->name;
					$result[$key]['estimated_commission_amount'] = Yii::$app->AccessMod->getPriceFormat($value['commission_amount']);
					$result[$key]['eligible_commission_amount'] = Yii::$app->AccessMod->getPriceFormat($value['eligible_commission_amount']);
					$result[$key]['paid_commission_amount'] = Yii::$app->AccessMod->getPriceFormat($value['paid_commission_amount']);
					$result[$key]['status'] = $value['status'];
					$result[$key]['status_text'] = $value['status_text'];
					$result[$key]['createdbyName'] = $value['createdbyName'];
					$result[$key]['createdat'] = $value['createdat'];
				}
			}
		}
		
		return $result;
	}
	
	public function getLogUserCommissionTransaction($user_id,$prospect_booking_id)
	{
		//initialize
		$result = array();
		$modelUserCommissions = UserCommissions::find()->where(array('user_id'=>$user_id))->one();
		$modelProspectBookings = ProspectBookings::findOne($prospect_booking_id);
		$modelLogUserCommission =  new LogUserCommission();
		
		$estimateCommission = LogUserCommission::find()
									->where(array(
										'user_commission_id'=>$modelUserCommissions->id,
										'user_id'=>$modelUserCommissions->user_id,
										'prospect_booking_id'=>$prospect_booking_id,
										'status'=>1
										)
									)
									->asArray()
									->one();
		
		if($estimateCommission==NULL)
		{
			$this->errorMessage = 'Invalid prospect booking id.';
			return false;
		}
		
		//get user eligible commission
		$userEligibleCommissionAmount = 0;
		$userEligibleCommissions = UserEligibleCommissions::find()->where(array('user_commission_id'=>$modelUserCommissions->id,'prospect_booking_id'=>$modelProspectBookings->id,'user_id'=>$modelUserCommissions->user_id,'status'=>0,'deletedby'=>NULL,'deletedat'=>NULL))->asArray()->all();
		if(count($userEligibleCommissions)!=0)
		{
			foreach($userEligibleCommissions as $userEligibleCommission)
			{
				$userEligibleCommissionAmount = $userEligibleCommissionAmount+$userEligibleCommission['commission_eligible_amount'];
			}
		}
		
		//get user eligible commission
		$totalCommissionPaid = $modelLogUserCommission->getTotalCommissionPaid($modelUserCommissions->user_id,$prospect_booking_id);
		
		
		$result['commission_transation']['developer'] = $modelProspectBookings->developer->company_name;
		$result['commission_transation']['project'] = $modelProspectBookings->project->project_name;
		$result['commission_transation']['product'] = $modelProspectBookings->projectProducts->product_name;
		$result['commission_transation']['unit'] = $modelProspectBookings->product_unit;
		$result['commission_transation']['product_price'] = Yii::$app->AccessMod->getPriceFormat($modelProspectBookings->product_unit_price);
		$result['commission_transation']['prospect'] = $modelProspectBookings->prospect->prospect_name;
		$modelCommissionGroupTiers = CommissionGroupTiers::find()->where(array('id'=>$estimateCommission['commission_group_tier_id']))->one();
		$result['commission_transation']['commission_tier'] = $modelCommissionGroupTiers->lookupCommissionTier->name;
		$result['commission_transation']['estimated_commission_amount'] = Yii::$app->AccessMod->getPriceFormat($estimateCommission['commission_amount']-($userEligibleCommissionAmount+$totalCommissionPaid));
		$result['commission_transation']['eligible_commission_amount'] = Yii::$app->AccessMod->getPriceFormat($userEligibleCommissionAmount);
		$result['commission_transation']['paid_commission_amount'] = Yii::$app->AccessMod->getPriceFormat($totalCommissionPaid);
		
		$result['log_commission_transactions'] = array();
		$logUserCommissions = $modelLogUserCommission->getLogUserCommissions($modelUserCommissions->user_id,$modelProspectBookings->id);
		if(!$logUserCommissions)
		{
			$result['log_commission_transactions'] = array();
		}
		else
		{
			foreach($logUserCommissions as $key=>$value)
			{
				if($value['status']!=1)
				{
					$result['log_commission_transactions'][$key]['commission_amount'] = $value['commission_amount'];
					$result['log_commission_transactions'][$key]['remarks'] = $value['remarks'];
					if($value['status']==2)
					$status = 'Eligible';
					if($value['status']==3)
					$status = 'Cancelled';
					if($value['status']==4)
					$status = 'Claimed';
					$result['log_commission_transactions'][$key]['status'] = $status;
					$result['log_commission_transactions'][$key]['createdby'] = $value['createdbyName'];
					$result['log_commission_transactions'][$key]['createdat'] = Yii::$app->formatter->asDatetime($value['createdat'], 'long');
				}
			}
		}
		
		return $result;
	}
}
?>