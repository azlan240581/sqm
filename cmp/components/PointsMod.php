<?php
namespace app\components;

use Yii;
use yii\helpers\Html;
use yii\base\ErrorException;

use app\models\Users;
use app\models\UserAssociateDetails;

use app\models\Activities;
use app\models\BankPoints;
use app\models\UserPoints;
use app\models\LogBankPoints;
use app\models\LogUserPoints;
use app\models\LogAssociateActivities;
use app\models\LogProspectHistory;

use app\models\DashboardUser;

use yii\helpers\Json;

class PointsMod extends \yii\base\Component
{
	public $errorMessage;


    public function init() {
        parent::init();
    }
	
	
    public function getActivity($uniqueid)
    {
		$activity = new Activities;

		if($activity == null)
		{
			$this->errorMessage = 'No records for the activity.';
        	return false;
		}

		return $activity->getActivityInfo($uniqueid);
    }
	
	
    public function getActivityPointsValue($uniqueid)
    {
		$activity = $this->getActivity($uniqueid);

		if($activity)
		return $activity['points_value'];
		else
		{
 			$this->errorMessage = 'Failed to get activity points value.';
      		return false;
		}
    }
	
	public function topupBankPoints($points_value='',$remarks='',$user_id='')
	{
		//initialize
		$result = '';
		$errors = '';
		
		//validate
		try
		{
			if(!strlen($points_value))
			throw new ErrorException("Invalid points value");
			
			if(!strlen($user_id))
			throw new ErrorException("Invalid user id");
		}
		catch(ErrorException $e)
		{
			$this->errorMessage = $e->getMessage();
			return false;
		}
		
		//process
		$connection = \Yii::$app->db;
		$transaction = $connection->beginTransaction();
		try
		{
			$modelBankPoints = BankPoints::find()->where(array('id'=>1))->one();
			$modelBankPoints->credits = $modelBankPoints->credits+$points_value;
			$modelBankPoints->updatedby = $user_id;
			$modelBankPoints->updatedat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
			$modelBankPoints->save();
			if(count($modelBankPoints->errors)!=0)
			throw new ErrorException("Failed to topup bank points credits.");
			
			$modelLogBankPoints = new LogBankPoints();
			$modelLogBankPoints->points_value = $points_value;
			$modelLogBankPoints->remarks = 'Topup credits. '.$remarks;
			$modelLogBankPoints->createdby = $user_id;
			$modelLogBankPoints->createdat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
			$modelLogBankPoints->save();
			if(count($modelLogBankPoints->errors)!=0)
			throw new ErrorException("Failed to create log bank points.");

			$transaction->commit();
		}
		catch (ErrorException $e) 
		{
			$transaction->rollBack();
			$this->errorMessage = $e->getMessage();
			return false;
		}
		
		return true;
	}
	
	public function memberPointsActivities($member_id,$activity_uniqueid,$user_id,$action=array(),$remarks='',$eligiblePointsError=true)
	{
		//initialize
		$addPoints = true;
		$result = array();
		$errors = '';
		
		//validate
		try
		{
			if(!strlen($member_id))
			throw new ErrorException("Invalid associate id.");
			
			if(!strlen($activity_uniqueid))
			throw new ErrorException("Invalid activity uniqueid.");
			
			if(!strlen($user_id))
			throw new ErrorException("Invalid user id.");
							
			if(!($activity = $this->getActivity($activity_uniqueid)))
			throw new ErrorException($this->errorMessage);
						
			if(!($activityPoints = $this->getActivityPointsValue($activity_uniqueid)))
			throw new ErrorException($this->errorMessage);
			
			$modelBankPoints = BankPoints::find()->where(array('id'=>1))->one();
			if($modelBankPoints->credits<$activityPoints)
			throw new ErrorException("Insufficient bank points credits.");
						
			if(!in_array($activity['id'],array(6,7,10,11)))
			{			
				if(!is_array($action))
				throw new ErrorException("Invalid action.");
				else
				{			
					if(empty($action['action_name'])) 
					throw new ErrorException("Invalid action name (1).");
					else
					{
						switch (strtoupper(trim($action['action_name'])))
						{
							case "PROSPECT_HISTORY":
														
								if(empty($action['prospect_id']))
								throw new ErrorException("Invalid prospect ID.");
								
								if(empty($action['history_id']))
								throw new ErrorException("Invalid history ID.");
								
								break;
								
							case "SHARE_NEWS_FEED":
							
								if(empty($action['news_feed_id']))
								throw new ErrorException("Invalid news feed ID.");
								break;
								
							case "SHARE_PRODUCT":
							
								if(empty($action['product_id']))
								throw new ErrorException("Invalid product ID.");
								break;
								
							case "SHARE_BANNER":
							
								if(empty($action['banner_id']))
								throw new ErrorException("Invalid banner ID.");
								break;
								
							default:
								throw new ErrorException("Invalid action name (2).");
						}	
					}
				}
			}
		}
		catch(ErrorException $e)
		{
			$this->errorMessage = $e->getMessage();
			return false;
		}
				
		//process
		$connection = \Yii::$app->db;
		$transaction = $connection->beginTransaction();
		try
		{
			if($activityPoints>0)
			{
				
				if(!empty($action['action_name']))
				{
					if($action['action_name']=='SHARE_NEWS_FEED')
					{
						//$logMemberActivity = LogAssociateActivities::find()->where(array('associate_id'=>$member_id,'activity_id'=>8,'news_feed_id'=>$action['news_feed_id']))->asArray()->one();
						$logMemberActivity = LogAssociateActivities::find()->where(array('associate_id'=>$member_id,'activity_id'=>8,'news_feed_id'=>$action['news_feed_id']))->one();
						if($logMemberActivity!=NULL)
						{
							$activityPoints=0;
							$addPoints = false;
						}
					}
					
					if($action['action_name']=='SHARE_PRODUCT')
					{
						//$logMemberActivity = LogAssociateActivities::find()->where(array('associate_id'=>$member_id,'activity_id'=>8,'product_id'=>$action['product_id']))->asArray()->one();
						$logMemberActivity = LogAssociateActivities::find()->where(array('associate_id'=>$member_id,'activity_id'=>8,'product_id'=>$action['product_id']))->one();
						if($logMemberActivity!=NULL)
						{
							$activityPoints=0;
							$addPoints = false;
						}
					}
									
					if($action['action_name']=='SHARE_BANNER')
					{
						//$logMemberActivity = LogAssociateActivities::find()->where(array('associate_id'=>$member_id,'activity_id'=>9,'banner_id'=>$action['banner_id']))->asArray()->one();
						$logMemberActivity = LogAssociateActivities::find()->where(array('associate_id'=>$member_id,'activity_id'=>9,'banner_id'=>$action['banner_id']))->one();
						if($logMemberActivity!=NULL)
						{
							$activityPoints=0;
							$addPoints = false;
						}
					}
						
					if($action['action_name']=='PROSPECT_HISTORY')
					{
						if($activity['id']==2)
						{
							//$logProspectHistory = LogProspectHistory::find()->where(array('prospect_id'=>$action['prospect_id'],'history_id'=>$action['history_id'],'site_visit'=>1))->asArray()->all();
							$logProspectHistory = LogProspectHistory::find()->where(array('prospect_id'=>$action['prospect_id'],'history_id'=>$action['history_id'],'site_visit'=>1))->all();
							if($logProspectHistory=NULL)
							{
								$activityPoints=0;
								$addPoints = false;
							}
						}
						elseif(in_array($activity['id'],array(3,4,5)))
						{
							//$logProspectHistory = LogProspectHistory::find()->where(array('prospect_id'=>$action['prospect_id'],'history_id'=>$action['history_id']))->asArray()->all();
							$logProspectHistory = LogProspectHistory::find()->where(array('prospect_id'=>$action['prospect_id'],'history_id'=>$action['history_id']))->all();
							if($logProspectHistory=NULL)
							{
								$activityPoints=0;
								$addPoints = false;
							}
						}
					}
				}
																						
				if($addPoints)
				{
					//get bank points
					$modelBankPoints = BankPoints::find()->where(array('id'=>1))->one();
					$modelBankPoints->credits = $modelBankPoints->credits-$activityPoints;
					$modelBankPoints->updatedby = $user_id;
					$modelBankPoints->updatedat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
					$modelBankPoints->save();
					if(count($modelBankPoints->errors)!=0)
					throw new ErrorException("Update bank points credits failed.");
					
					$modelLogBankPoints = new LogBankPoints();
					$modelLogBankPoints->points_value = -$activityPoints;
					$modelLogBankPoints->remarks = 'Transfered points to '.Yii::$app->AccessMod->getName($member_id).'.';
					$modelLogBankPoints->createdby = $user_id;
					$modelLogBankPoints->createdat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
					$modelLogBankPoints->save();
					if(count($modelLogBankPoints->errors)!=0)
					throw new ErrorException("Failed to create log bank points.");
								
					$modelUserPoints = UserPoints::find()->where(array('user_id'=>$member_id))->one();
					if($modelUserPoints==NULL)
					{
						$modelUserPoints = new UserPoints();
						$modelUserPoints->user_id = $member_id;
						$modelUserPoints->total_points_value = $activityPoints;
						$modelUserPoints->createdby = $user_id;
						$modelUserPoints->createdat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
						$modelUserPoints->save();
						if(count($modelUserPoints->errors)!=0)
						throw new ErrorException("Create user points failed.");
					}
					else
					{
						$modelUserPoints->total_points_value = $modelUserPoints->total_points_value+$activityPoints;
						$modelUserPoints->updatedby = $user_id;
						$modelUserPoints->updatedat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
						$modelUserPoints->save();
						if(count($modelUserPoints->errors)!=0)
						throw new ErrorException("Update user points failed.");
					}
															
					//save log associate points
					$modelLogUserPoints = new LogUserPoints();
					$modelLogUserPoints->user_id = $member_id;
					$modelLogUserPoints->points_value = $activityPoints;
					$modelLogUserPoints->status = '2';
					$modelLogUserPoints->remarks = strlen($remarks)?$remarks:$activity['activity_name'];
					$modelLogUserPoints->createdby = $user_id;
					$modelLogUserPoints->createdat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
					$modelLogUserPoints->save();
					if(count($modelLogUserPoints->errors)!=0)
					throw new ErrorException("Create log user points failed.");
										
					//send message
					$subject = 'Points Received';
					if($activity['id']==6)
					$message = 'Congratulations! You have received '.Yii::$app->AccessMod->getPointsFormat($activityPoints).' points for Joining SQM Property.';
					else
					$message = 'Congratulations! You have received '.Yii::$app->AccessMod->getPointsFormat($activityPoints).' points from activity '.$activity['activity_name'];
					$sendMessage = Yii::$app->AccessMod;
					if(!$sendMessage->sendMessage($member_id,$subject,$message,1,1))
					throw new ErrorException($sendMessage->errorMessage);
				}
				else
				$modelUserPoints = UserPoints::find()->where(array('user_id'=>$member_id))->one();
			}
			else
			$modelUserPoints = UserPoints::find()->where(array('user_id'=>$member_id))->one();
									
			//save log member activities
			$modelLogAssociateActivities = new LogAssociateActivities();
			$modelLogAssociateActivities->associate_id = $member_id;
			$modelLogAssociateActivities->activity_id = $activity['id'];
			$modelLogAssociateActivities->points_value = $activityPoints;
			if(!empty($action['action_name']))
			{
				if($action['action_name']=='SHARE_NEWS_FEED')
				$modelLogAssociateActivities->news_feed_id = $action['news_feed_id'];
				if($action['action_name']=='SHARE_PRODUCT')
				$modelLogAssociateActivities->product_id = $action['product_id'];
				if($action['action_name']=='SHARE_BANNER')
				$modelLogAssociateActivities->banner_id = $action['banner_id'];
			}
			$modelLogAssociateActivities->createdby = $user_id;
			$modelLogAssociateActivities->createdat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
			$modelLogAssociateActivities->save();
			if(count($modelLogAssociateActivities->errors)!=0)
			throw new ErrorException("Create log member activities failed.");
			
			if(in_array($activity['id'],array(1,3,4)))
			{
				$modelUserAssociateDetails = UserAssociateDetails::find()->where(array('user_id'=>$member_id))->one();
				if($modelUserAssociateDetails!=NULL)
				{
					$associateOldProductivityStatus = $modelUserAssociateDetails->productivity_status;
					
					if($modelUserAssociateDetails->productivity_status == 1)
					{
						if($activity['id']==1)
						$modelUserAssociateDetails->productivity_status = 3;
						elseif($activity['id']==3 or $activity['id']==4)
						$modelUserAssociateDetails->productivity_status = 2;
						$modelUserAssociateDetails->save();
						if(count($modelUserAssociateDetails->errors)!=0)
						throw new ErrorException("Update member productivity status failed.");
					}
					elseif(in_array($modelUserAssociateDetails->productivity_status, array(1,2)) and $activity['id']==1)
					{
						$modelUserAssociateDetails->productivity_status = 3;
						$modelUserAssociateDetails->save();
						if(count($modelUserAssociateDetails->errors)!=0)
						throw new ErrorException("Update member productivity status failed.");
					}
					
					$associateNewProductivityStatus = $modelUserAssociateDetails->productivity_status;
					
					//update dashboard user
					$modelDashboardUser = DashboardUser::find()->where(array('user_id'=>$modelUserAssociateDetails->agent_id))->one();
					if($modelDashboardUser!=NULL)
					{
						if($associateOldProductivityStatus==1)
						$modelDashboardUser->total_normal = $modelDashboardUser->total_normal-1;
						elseif($associateOldProductivityStatus==2)
						$modelDashboardUser->total_active = $modelDashboardUser->total_active-1;
						
						if($associateNewProductivityStatus==2)
						$modelDashboardUser->total_active = $modelDashboardUser->total_active+1;
						elseif($associateNewProductivityStatus==3)
						$modelDashboardUser->total_productive = $modelDashboardUser->total_productive+1;
						
						$modelDashboardUser->save();
						if(count($modelDashboardUser->errors)!=0)
						throw new ErrorException("Update dashboard user failed.");
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
		
		//format return
		if(!strlen($this->errorMessage))
		{
			$result['associate_id'] = $member_id;
			$result['activity_id'] = $activity['id'];
			$result['activity_code'] = $activity['activity_code'];
			$result['activity_points'] = $activityPoints;
			$result['total_points_value'] = $modelUserPoints->total_points_value;
		}
		
		if(strlen($this->errorMessage))
		return false;
		else
		return $result;
	}
	
	
	public function memberPoints($member_id='',$points_action='',$points_value='',$remarks='',$user_id='')
	{
		//initialize
		$result = '';
		$errors = '';
		
		//validate
		try
		{
			if(!strlen($member_id))
			throw new ErrorException("Invalid member id.");
			
			if(!strlen($points_action))
			throw new ErrorException("Invalid points action.");
			
			if(!strlen($points_value))
			throw new ErrorException("Invalid points value.");
			
			if(!strlen($user_id))
			throw new ErrorException("Invalid user id.");
			
			if($points_action==2)
			{
				$modelBankPoints = BankPoints::find()->where(array('id'=>1))->one();
				if($modelBankPoints->credits<$points_value)
				throw new ErrorException("Insufficient bank points credits.");
			}
			elseif($points_action==4)
			{
				$modelUserPoints = UserPoints::find()->where(array('user_id'=>$member_id))->one();
				if($modelUserPoints->total_points_value<$points_value)
				throw new ErrorException("Insufficient associate points value to deduct.");
			}
		}
		catch(ErrorException $e)
		{
			$this->errorMessage = $e->getMessage();
			return false;
		}
		
		//process
		if($points_value>0)
		{
			$connection = \Yii::$app->db;
			$transaction = $connection->beginTransaction();
			try
			{
				$modelUserPoints = UserPoints::find()->where(array('user_id'=>$member_id))->one();
				$modelUserPoints->total_points_value = $points_action==2?($modelUserPoints->total_points_value+$points_value):($modelUserPoints->total_points_value-$points_value);;
				$modelUserPoints->updatedby = $user_id;
				$modelUserPoints->updatedat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
				$modelUserPoints->save();
				if(count($modelUserPoints->errors)!=0)
				throw new ErrorException("Update associate points failed.");
				
				//create log member points
				$modelLogUserPoints = new LogUserPoints();
				$modelLogUserPoints->user_id = $member_id;
				$modelLogUserPoints->points_value = $points_action==2?($points_value):(-$points_value);
				$modelLogUserPoints->status = $points_action;
				$modelLogUserPoints->remarks = $remarks;
				$modelLogUserPoints->createdby = $user_id;
				$modelLogUserPoints->createdat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
				$modelLogUserPoints->save();
				if(count($modelLogUserPoints->errors)!=0)
				throw new ErrorException("Create log user points failed.");
				
				if(in_array($points_action,array(2,4)))
				{
					//update bank points credits
					$modelBankPoints = BankPoints::find()->where(array('id'=>1))->one();
					$modelBankPoints->credits = $points_action==2?($modelBankPoints->credits-$points_value):($modelBankPoints->credits+$points_value);
					$modelBankPoints->updatedby = $user_id;
					$modelBankPoints->updatedat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
					$modelBankPoints->save();
					if(count($modelBankPoints->errors)!=0)
					throw new ErrorException("Update bank points credits failed.");
					
					//create log bank points
					$modelLogBankPoints = new LogBankPoints();
					$modelLogBankPoints->points_value = $points_action==2?(-$points_value):($points_value);
					$modelLogBankPoints->remarks = $remarks;
					$modelLogBankPoints->createdby = $user_id;
					$modelLogBankPoints->createdat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
					$modelLogBankPoints->save();
					if(count($modelLogBankPoints->errors)!=0)
					throw new ErrorException("Create log bank points failed.");
				}
				
				//send message
				if($points_action==2)
				{
					$subject = 'Points Received';
					$message = 'You have received '.$points_value.' points. '.$remarks;
				}
				elseif($points_action==4)
				{
					$subject = 'Points Deducted';
					$message = $points_value.' points have beed deducted. '.$remarks;
				}
				$sendMessage = Yii::$app->AccessMod;
				if(!$sendMessage->sendMessage($member_id,$subject,$message,1,1))
				throw new ErrorException($sendMessage->errorMessage);
				
				$transaction->commit();
			}
			catch (ErrorException $e) 
			{
				$transaction->rollBack();
				$this->errorMessage = $e->getMessage();
				return false;
			}
		}
		
		if(!strlen($this->errorMessage))
		$result = UserPoints::find()->where(array('user_id'=>$member_id))->asArray()->one();
		
		if(strlen($this->errorMessage))
		return false;
		else
		return $result;
	}
	
	public function getMemberPoints($member_id='')
	{
		//initialize
		$result = '';
		$errors = '';
		
		//validate member id
		if(!strlen($member_id))
		$this->errorMessage = 'Invalid member id';
		
		if(!strlen($this->errorMessage))
		$result = MemberPoints::find()->where(array('user_id'=>$member_id))->asArray()->one();
		
		if(strlen($this->errorMessage))
		return false;
		else
		return $result;
	}
}
?>