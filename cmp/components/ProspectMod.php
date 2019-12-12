<?php
namespace app\components;

use Yii;
use app\models\Prospects;
use app\models\ProspectBookings;
use app\models\ProspectBookingBuyers;
use app\models\ProspectInterestedProjects;
use app\models\LookupProspectStatus;
use app\models\LogProspectHistory;
use app\models\LookupProspectHistory;
use app\models\LogUserCommission;
use yii\helpers\Html;
use yii\base\ErrorException;

class ProspectMod extends \yii\base\Component{

	public $errorMessage;

    public function init() {
        parent::init();
    }
	
	
	public function LogProspectHistoryNotExist($prospect_id,$history_id)
	{
		$prospectHistory = LogProspectHistory::find()->where(array('prospect_id'=>$prospect_id,'history_id'=>$history_id))->one();
		
		if($prospectHistory==NULL)
		return true;
		else
		return false;
	}

	public function validateProspectID($prospect_id,$history_id='')
	{
		/*if(strlen($history_id))
		{
			if(!$this->LogProspectHistoryNotExist($prospect_id,$history_id))
			return false;
	
			$prospect = Prospects::find()->where(array('id'=>$prospect_id,'status'=>($history_id==1?1:2)))->one();
		}
		else*/
		$prospect = Prospects::find()->where(array('id'=>$prospect_id))->one();
		
		
		if($prospect==NULL)
		{
			$this->errorMessage = 'Invalid prospect access.';
			return false;
		}
		else
		return $prospect;
	}

	public function validateProspectOwner($prospect_id,$inputs=array())
	{
		$sql = "SELECT id ";
		$sql .= "FROM prospects ";
		$sql .= "WHERE 0=0 ";
		
		if(!empty($inputs['agent_id']))
		$sql .= "AND agent_id='".$inputs['agent_id']."' ";

		if(!empty($inputs['member_id']))
		$sql .= "AND member_id='".$inputs['member_id']."' ";
		
		$connection = Yii::$app->getDb();
		$query = $connection->createCommand($sql);
		$records = $query->queryAll();
					
		if(count($records)==0)
		{
			$this->errorMessage = 'Records not found.';
			return false;
		}
		else
		return $records;
	}

	public function validateProspectOwnedUnit($prospect_id,$product_id,$product_unit)
	{
		$record = ProspectBookings::find()->where(array('prospect_id'=>$prospect_id,'product_id'=>$product_id,'product_unit'=>$product_unit))->andWhere(['NOT IN','status', array(4,10,16,19)])->asArray()->all();
		
		if(count($record)!=0)
		return true;
		else
		{
			$this->errorMessage = 'Prospect is not booked this unit.';
			return false;
		}
	}

	public function validateEOIExist($eoi_ref_no,$prospect_booking_id='')
	{
		if(empty($prospect_booking_id))
		$record = ProspectBookings::find()->where(array('eoi_ref_no'=>$eoi_ref_no))->andWhere(['<>','status', 12])->asArray()->all();
		else
		$record = ProspectBookings::find()->where(array('eoi_ref_no'=>$eoi_ref_no))->andWhere(['<>','status', 12])->andWhere(['<>','id', $prospect_booking_id])->asArray()->all();
		
		if(count($record)==0)
		return true;
		else
		{
			$this->errorMessage = 'EOI Reference Number is already exist.';
			return false;
		}
	}

	public function validateBookingIDExist($product_id,$product_unit,$prospect_booking_id='')
	{
		if(empty($prospect_booking_id))
		$record = ProspectBookings::find()->where(array('product_id'=>$product_id,'product_unit'=>$product_unit))->andWhere(['<>','status', 12])->asArray()->all();
		else
		$record = ProspectBookings::find()->where(array('product_id'=>$product_id,'product_unit'=>$product_unit))->andWhere(['<>','status', 12])->andWhere(['<>','id', $prospect_booking_id])->asArray()->all();
		
		if(count($record)==0)
		return true;
		else
		{
			$this->errorMessage = 'Unit already been booked.';
			return false;
		}
	}

	public function getProspects($inputs=array())
	{
		$sql = "SELECT pr.id, pr.prospect_name, pr.prospect_email, pr.prospect_contact_number,  ";
		$sql .= "(SELECT pb.name FROM lookup_purpose_of_buying pb WHERE pb.id=pr.prospect_purpose_of_buying) as prospect_purpose_of_buying, ";
		$sql .= "(SELECT how.name FROM lookup_how_you_know_about_us how WHERE how.id=pr.how_prospect_know_us) as how_prospect_know_us, ";
		$sql .= "pr.prospect_age, ";
		$sql .= "(SELECT mr.name FROM lookup_marital_status mr WHERE mr.id=pr.prospect_marital_status) as prospect_marital_status, ";
		$sql .= "(SELECT o.name FROM lookup_occupation o WHERE o.id=pr.prospect_occupation) as prospect_occupation, ";
		$sql .= "(SELECT d.name FROM lookup_domicile d WHERE d.id=pr.prospect_domicile) as prospect_domicile, ";
		$sql .= "pr.prospect_identity_document, pr.tax_license, s.name as status, ";
		$sql .= "GROUP_CONCAT(p.id ORDER BY p.id ASC) as interested_project_ids, ";
		$sql .= "GROUP_CONCAT(p.project_name ORDER BY p.id ASC) as interested_projects, ";
		$sql .= "GROUP_CONCAT(pb.id ORDER BY pb.id ASC) as prospect_booking_ids, pr.createdat ";
		$sql .= "FROM prospects pr LEFT JOIN prospect_bookings pb ON pr.id=pb.prospect_id, prospect_interested_projects ip, projects p, lookup_prospect_status s ";
		$sql .= "WHERE 0=0 ";
		$sql .= "AND pr.id=ip.prospect_id ";
		$sql .= "AND p.id=ip.project_id ";
		$sql .= "AND s.id=pr.status ";
		$sql .= "AND pr.deletedby IS NULL ";
		$sql .= "AND pr.deletedat IS NULL ";
		
		if(!empty($inputs['member_id']))
		$sql .= "AND pr.member_id='".$inputs['member_id']."' ";

		if(!empty($inputs['agent_id']))
		$sql .= "AND pr.agent_id='".$inputs['agent_id']."' ";

		$sql .= "GROUP BY pr.id ";
		$sql .= "ORDER BY pr.createdat DESC ";

		$connection = Yii::$app->getDb();
		$query = $connection->createCommand($sql);
		$prospects = $query->queryAll();
					
		if(count($prospects)==0)
		{
			$this->errorMessage = 'Records not found.';
			return false;
		}
		else
		return $prospects;
	}


	public function getProspectsByDedicatedAgent($agent_id)
	{
		$sql = "SELECT pr.id, pr.prospect_name, pr.prospect_email, pr.prospect_contact_number,  ";
		$sql .= "(SELECT pb.name FROM lookup_purpose_of_buying pb WHERE pb.id=pr.prospect_purpose_of_buying) as prospect_purpose_of_buying, ";
		$sql .= "(SELECT how.name FROM lookup_how_you_know_about_us how WHERE how.id=pr.how_prospect_know_us) as how_prospect_know_us, ";
		$sql .= "pr.prospect_age, pr.createdat, ";
		$sql .= "(SELECT mr.name FROM lookup_marital_status mr WHERE mr.id=pr.prospect_marital_status) as prospect_marital_status, ";
		$sql .= "(SELECT o.name FROM lookup_occupation o WHERE o.id=pr.prospect_occupation) as prospect_occupation, ";
		$sql .= "(SELECT d.name FROM lookup_domicile d WHERE d.id=pr.prospect_domicile) as prospect_domicile, ";
		$sql .= "pr.prospect_identity_document, pr.tax_license, s.name as status, ";
		$sql .= "GROUP_CONCAT(p.id ORDER BY p.id ASC) as interested_project_ids, ";
		$sql .= "GROUP_CONCAT(p.project_name ORDER BY p.id ASC) as interested_projects, ";
		$sql .= "GROUP_CONCAT(pb.id ORDER BY pb.id ASC) as prospect_booking_ids ";
		$sql .= "FROM prospects pr LEFT JOIN prospect_bookings pb ON pr.id=pb.prospect_id, ";
		$sql .= "prospect_interested_projects ip, projects p, lookup_prospect_status s ";
		$sql .= "WHERE 0=0 ";
		$sql .= "AND p.id=ip.project_id ";
		$sql .= "AND ip.prospect_id = pr.id ";
		$sql .= "AND ip.project_id IN (SELECT pa.project_id FROM project_agents pa WHERE pa.agent_id='".$agent_id."') ";
		$sql .= "AND s.id=pr.status ";
		$sql .= "AND pr.deletedby IS NULL ";
		$sql .= "AND pr.deletedat IS NULL ";
		$sql .= "GROUP BY pr.id ";
		$sql .= "ORDER BY pr.createdat DESC ";

		$connection = Yii::$app->getDb();
		$query = $connection->createCommand($sql);
		$prospects = $query->queryAll();
					
		if(count($prospects)==0)
		{
			$this->errorMessage = 'Records not found.';
			return false;
		}
		else
		return $prospects;
	}


	public function getProspectInterestedProjects($prospectid,$asObject=true)
	{
		if($asObject)
		$prospectInterestedProjects = ProspectInterestedProjects::find()->select('project_id')->where(['prospect_id'=>$prospectid])->all();
		else
		$prospectInterestedProjects = ProspectInterestedProjects::find()->select('project_id')->where(['prospect_id'=>$prospectid])->asArray()->all();
		
		if(count($prospectInterestedProjects)==0)
		{
			$this->errorMessage = 'Records not found.';
			return false;
		}
		else
		return array_column($prospectInterestedProjects,'project_id');
	}


	public function getProspectBookings($prospect_id,$asObject=true,$inputs=array())
	{
		//initialize
		$where['prospect_id'] = $prospect_id;
		
		//capture
		if(!empty($inputs['status']))
		$where['status'] = $inputs['status'];
		
		if($asObject)
		$records = ProspectBookings::find()->where($where)->all();
		else
		$records = ProspectBookings::find()->where($where)->asArray()->all();
					
		if(count($records)==0)
		{
			$this->errorMessage = 'Records not found.';
			return false;
		}
		else
		return $records;
	}

	public function getProspectHistories($prospect_id)
	{
		$sql = "SELECT ph.id, p.project_name, ph.prospect_booking_id, ph.history_id, lph.name as prospect_history_name, ";
		$sql .= "ph.appointment_at, ph.appointment_location, ph.level_of_interest, li.name as level_of_interest_name, ph.site_visit, ";
		$sql .= "ph.remarks, ph.udf1, ph.udf2, ph.udf3, u.name as createdbyname, ph.createdat, bs.id as booking_status_id, bs.name as booking_status_name, pb.id as bookingid ";
		$sql .= "FROM log_prospect_history ph  ";
		$sql .= "LEFT JOIN projects p ON p.id = ph.project_id ";
		$sql .= "LEFT JOIN lookup_prospect_level_interest li ON li.id = ph.level_of_interest ";
		$sql .= "LEFT JOIN lookup_prospect_history lph ON lph.id = ph.history_id ";
		$sql .= "LEFT JOIN users u ON u.id=ph.createdby ";
		$sql .= "LEFT JOIN prospect_bookings pb ON pb.id=ph.prospect_booking_id ";
		$sql .= "LEFT JOIN lookup_booking_status bs ON bs.id=pb.status ";
		$sql .= "WHERE 0=0 ";
		if(!empty($prospect_id))
		$sql .= "AND ph.prospect_id='".$prospect_id."' ";
		$sql .= "ORDER BY ph.createdat ASC ";

		$connection = Yii::$app->getDb();
		$query = $connection->createCommand($sql);
		$histories = $query->queryAll();
					
		if(count($histories)==0)
		{
			$this->errorMessage = 'Records not found.';
			return false;
		}
		else
		return $histories;
	}


	public function getProspectBookingsTotal($id=array(), $commission_expiry_date = '', $past_period_month=12)
	{
		//validate
		if(empty($id['agent_id']) and empty($id['member_id']) and empty($id['prospect_id']))
		{
			$this->errorMessage = 'Invalid id.';
			return false;
		}

		if(!empty($past_period_month))
		{
			if(!preg_match('/^\d+$/',$past_period_month))
			{
				$this->errorMessage = 'Invalid past period month.';
				return false;
			}
		}
		
		$sql = "SELECT SUM(product_unit_price) as totalUnitPrices ";
		$sql .= "FROM prospect_bookings ";
		$sql .= "WHERE status IN (6,7,8,9) ";
		
		if(!empty($commission_expiry_date))
		{
			$sql .= "AND booking_date > '".date("Y-m-d", strtotime("-".$past_period_month." month",strtotime($commission_expiry_date)))."' ";
		}
		
		if(!empty($id['agent_id']))
		{
			$sql .= "AND agent_id = '".$id['agent_id']."' ";
			$sql .= "GROUP BY agent_id ASC ";
		}
		if(!empty($id['member_id']))
		{
			$sql .= "AND member_id = '".$id['member_id']."' ";
			$sql .= "GROUP BY member_id ASC ";
		}
		if(!empty($id['prospect_id']))
		{
			$sql .= "AND prospect_id = '".$id['prospect_id']."' ";
			$sql .= "GROUP BY prospect_id ASC ";
		}

		$connection = Yii::$app->getDb();
		$query = $connection->createCommand($sql);
		$records = $query->queryAll();
					
		if(count($records)==0)
		{
			return 0;
		}
		else
		return $records[0]['totalUnitPrices'];
	}

	
	public function addProspect($inputs,$memberid,$flags=array())
	{
		/*** INITIALIZE ***/
		//$response = array();
		
		/*** VALIDATE ***/
		try
		{
			if(!is_array($inputs))
			throw new ErrorException("Invalid inputs(1).");

			if(count($inputs)==0)
			throw new ErrorException("Invalid inputs(2).");
			
			if(!Yii::$app->AccessRule->validateUserID($memberid))
			throw new ErrorException("Invalid member access. Inactive member.");

			if(empty($inputs['interested_project_id']))
			throw new ErrorException("Prospect interested project is required.");

			if(empty($inputs['prospect_name']))
			throw new ErrorException("Prospect name is required.");
	
			if(!empty($inputs['prospect_email']))
			{
				if(preg_match("/^([\w\.-]{1,50}+[@]{1}+[\w-]{1,50})+?([\.\w]{1,50})?([\.][\w]{1,50})$/",$inputs['prospect_email']) == 0)
				throw new ErrorException("Incorrect email format.");
			}
			else
			$inputs['prospect_email'] = '';
	
			if(empty($inputs['prospect_contact_number']))
			throw new ErrorException("Prospect contact number is required.");
	
			if(preg_match("/^([0-9]{5,20})$/",$inputs['prospect_contact_number']) == 0)
			throw new ErrorException("Incorrect contact no format. Please remove all apecial characters including (+)sign and (-)sign.");
			
			$prospects = 	Prospects::find()
							->select('id')
							->where(['or',['prospect_name'=>$inputs['prospect_name'],'prospect_email'=>$inputs['prospect_email'],'prospect_contact_number'=>$inputs['prospect_contact_number']]])
							->andWhere(['status'=>[1,2]])
							->asArray()
							->all();
			
			if(count($prospects)!=0)
			throw new ErrorException("This prospect already been registered.");
		}
		catch(ErrorException $e)
		{
			$this->errorMessage = $e->getMessage();
			return false;
		}
		
		/*** PROCESS ***/
		//set prospect status pending (waiting for Leads Team approval)
		$model = new Prospects();
		$connection = \Yii::$app->db;
		$transaction = $connection->beginTransaction();
		try
		{
			//add prospect
			$model->prospect_name = $inputs['prospect_name'];
			$model->prospect_email = $inputs['prospect_email'];
			$model->prospect_contact_number = $inputs['prospect_contact_number'];
			
			if(!empty($inputs['remarks']))
			$model->remarks = $inputs['remarks'];
			
			$model->agent_id = Yii::$app->AccessMod->getUserUplineID($memberid);
			$model->member_id = $memberid;
			$model->status = 1;
			$model->createdby = $memberid;
			$model->createdat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
			$model->updatedby = $memberid;
			$model->updatedat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
			$model->save();

			if(count($model->errors)!=0)
			throw new ErrorException('Adding prospect failed.');

			//add interested project
			$modelInterestedProject = new ProspectInterestedProjects();
			$modelInterestedProject->prospect_id = $model->id;
			$modelInterestedProject->project_id = $inputs['interested_project_id'];
			$modelInterestedProject->save();

			if(count($modelInterestedProject->errors)!=0)
			throw new ErrorException('Adding prospect interested project failed.');

			//log prospect history
			$modelLog = new LogProspectHistory();
			$modelLog->project_id = $inputs['interested_project_id'];
			$modelLog->prospect_id = $model->id;
			$modelLog->history_id = 1;
			$modelLog->remarks = $model->remarks;
			$modelLog->createdby = $memberid;
			$modelLog->createdat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
			$modelLog->save();

			if(count($modelLog->errors)!=0)
			throw new ErrorException('Update prospect log failed.');

			//send message to member
			$sendMessage = Yii::$app->AccessMod;
			if(!$sendMessage->sendMessage($memberid,'Prospect Notification for a successfully registered new prospect ' . $model->prospect_name,'Prospect name ' . $model->prospect_name . ' is successfuly registered.'))
			throw new ErrorException($sendMessage->errorMessage);

			//send message to leads
			$sendMessage = Yii::$app->AccessMod;
			if(!$sendMessage->sendMessage($model->agent_id,'Prospect Notification for a successfully registered new prospect ' . $model->prospect_name,'New prospect ' . $model->prospect_name . ' is successfuly registered. Please click <a href="'.$_SESSION['settings']['SITE_URL'].'/prospects/">here</a> to take action.','',3))
			throw new ErrorException($sendMessage->errorMessage);

			$transaction->commit();
		}
		catch (ErrorException $e) 
		{
			$transaction->rollBack();
			$this->errorMessage = $e->getMessage();
			return false;
		}
		
				
		/*** FORMAT RETURN ***/
		
		return true;
	}


	public function updateProspect($prospectid,$userid,$inputs=array())
	{
		/*** VALIDATE ***/
		try
		{
			if(empty($prospectid))
			throw new ErrorException("Invalid prospect id.");

			if(!($prospect = $this->validateProspectID($prospectid)))
			return false;

			if(!is_array($inputs))
			throw new ErrorException("Invalid inputs(1).");

			if(count($inputs)==0)
			throw new ErrorException("Invalid inputs(2).");
			
			if(!empty($inputs['prospect_email']))
			{
				if(preg_match("/^([\w\.-]{1,50}+[@]{1}+[\w-]{1,50})+?([\.\w]{1,50})?([\.][\w]{1,50})$/",$inputs['prospect_email']) == 0)
				throw new ErrorException("Incorrect email format.");
			}
	
			if(preg_match("/^([0-9]{5,20})$/",$inputs['prospect_contact_number']) == 0)
			throw new ErrorException("Incorrect contact no format. Please remove all apecial characters including (+)sign and (-)sign.");
		}
		catch(ErrorException $e)
		{
			$this->errorMessage = $e->getMessage();
			return false;
		}
		
		/*** PROCESS ***/
		//set prospect status pending (waiting for Leads Team approval)
		$connection = \Yii::$app->db;
		$transaction = $connection->beginTransaction();
		try
		{
			//add prospect
			$model = Prospects::findOne($prospectid);

			if(!empty($inputs['prospect_name']))
			$model->prospect_name = $inputs['prospect_name'];

			if(!empty($inputs['prospect_email']))
			$model->prospect_email = $inputs['prospect_email'];

			if(!empty($inputs['prospect_contact_number']))
			$model->prospect_contact_number = $inputs['prospect_contact_number'];

			if(!empty($inputs['prospect_purpose_of_buying']))
			$model->prospect_purpose_of_buying = $inputs['prospect_purpose_of_buying'];

			if(!empty($inputs['how_prospect_know_us']))
			$model->how_prospect_know_us = $inputs['how_prospect_know_us'];

			if(!empty($inputs['prospect_age']))
			$model->prospect_age = $inputs['prospect_age'];

			if(!empty($inputs['prospect_marital_status']))
			$model->prospect_marital_status = $inputs['prospect_marital_status'];

			if(!empty($inputs['prospect_occupation']))
			$model->prospect_occupation = $inputs['prospect_occupation'];
			
			if(!empty($inputs['prospect_domicile']))
			$model->prospect_domicile = $inputs['prospect_domicile'];
			
			if(!empty($inputs['prospect_identity_document']))
			$model->prospect_identity_document = $inputs['prospect_identity_document'];

			if(!empty($inputs['tax_license']))
			$model->tax_license = $inputs['tax_license'];
			
			if(!empty($inputs['remarks']))
			$model->remarks = $inputs['remarks'];
			
			if($model->status==1)
			$model->status = 2;
			
			$model->updatedby = $userid;
			$model->updatedat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
			$model->save();

			if(count($model->errors)!=0)
			throw new ErrorException('Update prospect failed.');

			$transaction->commit();
		}
		catch (ErrorException $e) 
		{
			$transaction->rollBack();
			$this->errorMessage = $e->getMessage();
			return false;
		}
		
				
		/*** FORMAT RETURN ***/
		return $model;
	}
	
	
//	public function updateProspectHistoryNewRegisteredApproval($prospectid,$userid,$inputs=array())
//	{
//		/*** INITIALIZE ***/
//		$response = array();
//		$response['historyid'] = 1;
//		$model = '';
//		$modelLog = '';
//		
//		/*** VALIDATE ***/
//		//validate prospect id
//		if(!($prospect = $this->validateProspectID($prospectid,$response['historyid'])))
//		return false;
//		
//		//validate user updating history
//		if(!($user = Yii::$app->AccessRule->validateUserID($userid)))
//		{
//			$this->errorMessage = 'Invalid user access';
//			return false;
//		}
//		
//		//validate remarks
//		if(empty($inputs['remarks']))
//		{
//			$this->errorMessage = "Please insert remarks.";
//			return false;
//		}
//
//	
//		/*** PROCESS ***/
//		$connection = \Yii::$app->db;
//		$transaction = $connection->beginTransaction();
//		try
//		{
//			//set prospect status processing
//			$model = Prospects::findOne($prospectid);
//			$response['old_status'] = $model->status;
//			$model->status = 2;
//			$model->updatedby = $userid;
//			$model->updatedat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
//			$model->save();
//
//			if(count($model->errors)!=0)
//			throw new ErrorException('Update prospect failed.');
//
//			//give points for activity - New Prospect
//			$memberPointsActivities = Yii::$app->PointsMod;
//			if(!($memberPointsActivity = $memberPointsActivities->memberPointsActivities($modelLog->member_id,'PROSPECT_NEW',$userid)))
//			throw new ErrorException($memberPointsActivities->errorMessage);
//
//			//send message to member
//			$sendMessage = Yii::$app->AccessMod;
//			if(!$sendMessage->sendMessage($modelLog->member_id,'Prospect Notification',"Prospect(" . $model->prospect_name . ") is approved. ".($memberPointsActivity['activity_points']>0?"You've got " . Yii::$app->AccessMod->getPointsFormat($memberPointsActivity['activity_points']) . " points.":"")))
//			throw new ErrorException($sendMessage->errorMessage);
//
//
//			$sendMessage = Yii::$app->AccessMod;
//			if(!$sendMessage->sendMessage(Yii::$app->AccessMod->getUserUplineID($userid),'Prospect Notification',"Prospect(" . $model->prospect_name . ") is approved. Now you're able to access and add prospect log.",'',2))
//			throw new ErrorException($sendMessage->errorMessage);
//
//			$transaction->commit();
//		}
//		catch (ErrorException $e) 
//		{
//			$transaction->rollBack();
//			$this->errorMessage = $e->getMessage();
//			echo $this->errorMessage;
//			exit();
//			return false;
//		}
//
//		/*** FORMAT RETURN ***/
//		
//		return $response;
//	}
	
	
	public function createProspectHistoryFollowUp($projectid,$prospectid,$userid,$inputs=array())
	{
		/*** INITIALIZE ***/
		$response = array();
		$response['historyid'] = 2;
		
		/*** VALIDATE ***/
		//validate prospect id
		if(!($prospect = $this->validateProspectID($prospectid,$response['historyid'])))
		return false;
		
		//validate user updating history
		if(!($user = Yii::$app->AccessRule->validateUserID($userid)))
		{
			$this->errorMessage = 'Invalid user access';
			return false;
		}
		
		//validate remarks
		if(empty($inputs['remarks']))
		{
			$this->errorMessage = "Please insert remarks.";
			return false;
		}
		
		/*** PROCESS ***/
		//log prospect history
		$connection = \Yii::$app->db;
		$transaction = $connection->beginTransaction();
		try
		{
			//update prospect
			if(!($prospect = $this->updateProspect($prospectid,$userid,$inputs)))
			throw new ErrorException($this->errorMessage);

			//give points for activity - follow up
			$memberPointsActivities = Yii::$app->PointsMod;
			if(!($memberPointsActivity = $memberPointsActivities->memberPointsActivities($prospect->member_id,'PROSPECT_FOLLOW_UP',$userid,array('action_name'=>'PROSPECT_HISTORY','prospect_id'=>$prospectid,'history_id'=>$response['historyid']))))
			throw new ErrorException($memberPointsActivities->errorMessage);
						
			//log prospect history
			$modelLog = new LogProspectHistory();
			$modelLog->project_id = $projectid;
			$modelLog->prospect_id = $prospectid;
			$modelLog->history_id = $response['historyid'];
			$modelLog->remarks = $prospect->remarks;
			$modelLog->createdby = $userid;
			$modelLog->createdat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
			$modelLog->save();

			if(count($modelLog->errors)!=0)
			throw new ErrorException('Update prospect log failed.');

			//send message to member
			$sendMessage = Yii::$app->AccessMod;
			if(!$sendMessage->sendMessage($prospect->member_id,'Prospect Notification for following up prospect ' . $prospect->prospect_name,"Follow up prospect(" . $prospect->prospect_name . "). ".($memberPointsActivity['activity_points']>0?"You've got " . Yii::$app->AccessMod->getPointsFormat($memberPointsActivity['activity_points']) . " points.":"")))
			throw new ErrorException($sendMessage->errorMessage);

			$transaction->commit();
		}
		catch (ErrorException $e) 
		{
			$transaction->rollBack();
			$this->errorMessage = $e->getMessage();
			return false;
		}

		/*** FORMAT RETURN ***/
		
		return $response;
	}
	
	
	public function createProspectHistoryAppointmentSchedule($projectid,$prospectid,$userid,$inputs=array())
	{
		/*** INITIALIZE ***/
		$response = array();
		$response['historyid'] = 3;
		
		/*** VALIDATE ***/
		//validate prospect id
		if(!($prospect = $this->validateProspectID($prospectid,$response['historyid'])))
		return false;
		
		//validate user updating history
		if(!($user = Yii::$app->AccessRule->validateUserID($userid)))
		{
			$this->errorMessage = 'Invalid user access';
			return false;
		}
		
		//validate remarks
		if(empty($inputs['remarks']))
		{
			$this->errorMessage = "Please insert remarks.";
			return false;
		}
		
		/*** PROCESS ***/
		$connection = \Yii::$app->db;
		$transaction = $connection->beginTransaction();
		try
		{
			//update prospect
			$model = Prospects::findOne($prospectid);
			
			if($model->status==1)
			$model->status = 2;
			$model->updatedby = $userid;
			$model->updatedat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
			$model->save();
	
			if(count($model->errors)!=0)
			throw new ErrorException('Update prospect failed.');

			//give points for activity - set appointment
			$memberPointsActivities = Yii::$app->PointsMod;
			if(!($memberPointsActivity = $memberPointsActivities->memberPointsActivities($prospect->member_id,'PROSPECT_SET_APPOINTMENT',$userid,array('action_name'=>'PROSPECT_HISTORY','prospect_id'=>$prospectid,'history_id'=>$response['historyid']))))
			throw new ErrorException($memberPointsActivities->errorMessage);

			//log prospect history
			$modelLog = new LogProspectHistory();
			$modelLog->project_id = $projectid;
			$modelLog->prospect_id = $prospectid;
			$modelLog->history_id = $response['historyid'];
			if(!empty($inputs['appointment_at']))
			$modelLog->appointment_at = $inputs['appointment_at'];
			if(!empty($inputs['appointment_location']))
			$modelLog->appointment_location = $inputs['appointment_location'];
			$modelLog->remarks = $inputs['remarks'];
			$modelLog->createdby = $userid;
			$modelLog->createdat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
			$modelLog->save();

			if(count($modelLog->errors)!=0)
			throw new ErrorException('Update prospect log failed.');

			//send message to member
			$sendMessage = Yii::$app->AccessMod;
			if(!$sendMessage->sendMessage($prospect->member_id,'Prospect Notification for appointment scheduled with a prospect '.$prospect->prospect_name,"Set appointment with prospect(" . $prospect->prospect_name . "). ".($memberPointsActivity['activity_points']>0?"You've got " . Yii::$app->AccessMod->getPointsFormat($memberPointsActivity['activity_points']) . " points.":"")))
			throw new ErrorException($sendMessage->errorMessage);

			$transaction->commit();
		}
		catch (ErrorException $e) 
		{
			$transaction->rollBack();
			$this->errorMessage = $e->getMessage();
			return false;
		}

		/*** FORMAT RETURN ***/
		
		return $response;
	}

	
	public function createProspectHistoryLevelInterest($projectid,$prospectid,$userid,$inputs=array())
	{
		/*** INITIALIZE ***/
		$response = array();
		$response['historyid'] = 4;
		
		/*** VALIDATE ***/
		//validate prospect id
		if(!($prospect = $this->validateProspectID($prospectid,$response['historyid'])))
		return false;
		
		//validate user updating history
		if(!($user = Yii::$app->AccessRule->validateUserID($userid)))
		{
			$this->errorMessage = 'Invalid user access';
			return false;
		}
		
		//validate remarks
		if(empty($inputs['remarks']))
		{
			$this->errorMessage = "Please insert remarks.";
			return false;
		}
				
		/*** PROCESS ***/
		//log prospect history
		$connection = \Yii::$app->db;
		$transaction = $connection->beginTransaction();
		try
		{
			//update prospect
			$model = Prospects::findOne($prospectid);
			
			if($model->status==1)
			$model->status = 2;
			$model->updatedby = $userid;
			$model->updatedat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
			$model->save();

			if(count($model->errors)!=0)
			throw new ErrorException('Update prospect failed.');

			/* check visit gallery */
			if($inputs['site_visit']==1)
			{
				//give points for activity - Visit Gallery
				$memberPointsActivities = Yii::$app->PointsMod;
				if(!($memberPointsActivity = $memberPointsActivities->memberPointsActivities($prospect->member_id,'PROSPECT_VISIT_MARKETING_GALLERY',$userid,array('action_name'=>'PROSPECT_HISTORY','prospect_id'=>$prospectid,'history_id'=>$response['historyid']))))
				throw new ErrorException($memberPointsActivities->errorMessage);
	
				//send message to member
				$sendMessage = Yii::$app->AccessMod;
				if(!$sendMessage->sendMessage($prospect->member_id,'Prospect Notification for visit marketing gallery for prospect '.$prospect->prospect_name,"Prospect(" . $prospect->prospect_name . ") is visited the marketing gallery. ".($memberPointsActivity['activity_points']>0?"You've got " . Yii::$app->AccessMod->getPointsFormat($memberPointsActivity['activity_points']) . " points.":"")))
				throw new ErrorException($sendMessage->errorMessage);
			}
			
			//log prospect history
			$modelLog = new LogProspectHistory();
			$modelLog->project_id = $projectid;
			$modelLog->prospect_id = $prospectid;
			$modelLog->history_id = $response['historyid'];
			if(!empty($inputs['level_of_interest']))
			$modelLog->level_of_interest = $inputs['level_of_interest'];
			if(!empty($inputs['site_visit']))
			$modelLog->site_visit = $inputs['site_visit'];
			$modelLog->remarks = $inputs['remarks'];
			$modelLog->createdby = $userid;
			$modelLog->createdat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
			$modelLog->save();

			if(count($modelLog->errors)!=0)
			throw new ErrorException('Update prospect log failed.');

			$transaction->commit();
		}
		catch (ErrorException $e) 
		{
			$transaction->rollBack();
			$this->errorMessage = $e->getMessage();
			return false;
		}

		
		/*** FORMAT RETURN ***/
		
		return $response;
	}


	public function createProspectEOI($projectid,$prospectid,$userid,$inputs=array())
	{
		/*** INITIALIZE ***/
		$response = array();
		$response['historyid'] = 5;

	
		/*** VALIDATE ***/
		//validate prospect id
		if(!($prospect = $this->validateProspectID($prospectid,$response['historyid'])))
		return false;

		//validate user updating history
		if(!($user = Yii::$app->AccessRule->validateUserID($userid)))
		{
			$this->errorMessage = 'Invalid user access';
			return false;
		}

		//validate buyer
		if(empty($inputs['buyers']))
		{
			$this->errorMessage = "Invalid buyer details (1)";
			return false;
		}
		else
		{
			if(!is_array($inputs['buyers']))
			{
				$this->errorMessage = "Invalid buyer details (2)";
				return false;
			}

			if(count($inputs['buyers']) == 0)
			{
				$this->errorMessage = "Invalid buyer details (3)";
				return false;
			}
			
			foreach($inputs['buyers'] as $buyer)
			{
				if(empty($buyer['buyer_firstname']) or empty($buyer['buyer_lastname']))
				{
					$this->errorMessage = "Invalid buyer details (4)";
					break;
				}
			}
		}

		/*//validate eoi reference no
		if(empty($inputs['eoi_ref_no']))
		{
			$this->errorMessage = "Invalid EOI Reference Number";
			return false;
		}

		//validate EOI
		if(!($prospectEOI = $this->validateEOIExist($inputs['eoi_ref_no'])))
		return false;*/
		
		//validate payment method
		if(empty($inputs['payment_method_eoi']))
		{
			$this->errorMessage = "Invalid payment method";
			return false;
		}
		
		//validate eoi amount
		if(empty($inputs['booking_eoi_amount']))
		{
			$this->errorMessage = "Invalid booking's EOI amount";
			return false;
		}
		else
		{
			if(preg_match("/^([\d]+)(\.[\d]+)?$/",$inputs['booking_eoi_amount']) == 0)
			{
				$this->errorMessage = "Invalid booking's EOI amount";
				return false;
			}
		}

		//validate proof of payment eoi
		if(empty($inputs['proof_of_payment_eoi']))
		{
			$this->errorMessage = "Invalid proof of payment for booking's EOI";
			return false;
		}
		
		//validate remarks
		if(empty($inputs['remarks']))
		{
			$this->errorMessage = "Please insert remarks.";
			return false;
		}
		
		/*** PROCESS ***/
		$connection = \Yii::$app->db;
		$transaction = $connection->beginTransaction();
		try
		{
			//update prospect
			$model = Prospects::findOne($prospectid);
			if($model->status==1)
			$model->status = 2;
			if(!empty($inputs['prospect_identity_document']))
			$model->prospect_identity_document = $inputs['prospect_identity_document'];
			if(!empty($inputs['tax_license']))
			$model->tax_license = $inputs['tax_license'];
			$model->updatedby = $userid;
			$model->updatedat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
			$model->save();

			if(count($model->errors)!=0)
			throw new ErrorException('Update prospect failed.');

			//prospect booking
			$modelPB = new ProspectBookings();
			$modelPB->prospect_id = $prospectid;
			$modelPB->agent_id = $model->agent_id;
			$modelPB->member_id = $model->createdby;
			$modelPB->dedicated_agent_id = $userid;
			$modelPB->referrer_member_id = Yii::$app->GeneralMod->getMemberReferrerID($model->member_id);
			$modelPB->developer_id = Yii::$app->GeneralMod->getDeveloperID($projectid);;
			$modelPB->project_id = $projectid;
			$modelPB->payment_method_eoi = $inputs['payment_method_eoi'];
			$modelPB->booking_eoi_amount = $inputs['booking_eoi_amount'];
			$modelPB->proof_of_payment_eoi = $inputs['proof_of_payment_eoi'];
			$modelPB->booking_date_eoi = $inputs['booking_date_eoi'];
			$modelPB->status = 1;
			$modelPB->remarks = $inputs['remarks'];
			$modelPB->createdby = $userid;
			$modelPB->createdat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
			$modelPB->save();

			if(count($modelPB->errors)!=0)
			throw new ErrorException('Create EOI Booking failed.');

			//update ref no
			$modelPB->ref_no = Yii::$app->AccessMod->generate_simple_unique_id(Yii::$app->AccessRule->dateFormat(time(), 'md'),$modelPB->id).'88108';
			$modelPB->eoi_ref_no = 'EO'.$modelPB->ref_no;
			$modelPB->save();

			//update eoi ref no
			$modelPB->save();

			if(count($modelPB->errors)!=0)
			throw new ErrorException('Update EOI Reference No Failed');

			//prospect booking buyer
			foreach($inputs['buyers'] as $buyer)
			{
				$modelPBB = new ProspectBookingBuyers();
				$modelPBB->prospect_id = $prospectid;
				$modelPBB->prospect_booking_id = $modelPB->id;
				$modelPBB->buyer_firstname = $buyer['buyer_firstname'];
				$modelPBB->buyer_lastname = $buyer['buyer_lastname'];
				$modelPBB->save();
	
				if(count($modelPBB->errors)!=0)
				throw new ErrorException('Create buyer(s) failed.');
			}
			
			//log prospect history
			$modelLog = new LogProspectHistory();
			$modelLog->project_id = $projectid;
			$modelLog->prospect_id = $prospectid;
			$modelLog->prospect_booking_id = $modelPB->id;
			$modelLog->history_id = $response['historyid'];
			$modelLog->remarks = $inputs['remarks'];
			$modelLog->createdby = $userid;
			$modelLog->createdat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
			$modelLog->save();

			if(count($modelLog->errors)!=0)
			throw new ErrorException('create prospect log failed.');

			//send message to admin
			$mod = Yii::$app->AccessMod;
			if(!$mod->sendMessage($mod->getAdminsIDs(),"Prospect Notification for Booking EOI (#".$modelPB->eoi_ref_no.") for prospect ".$model->prospect_name." and waiting for your approval.","Prospect name " . $model->prospect_name . " has made a booking(EOI). Waiting for your approval. Please click <a href=\"".$_SESSION['settings']['SITE_URL']."/prospects/pending-eoi-approval\">here</a> and click Approve button to approved.",'',3))
			throw new ErrorException($mod->errorMessage);
			
			//send message to prospect
			$replaceItems = array();
			$replaceItems['buyer_name'] = $inputs['buyers'][0]['buyer_firstname'].' '.$inputs['buyers'][0]['buyer_lastname'];
			$replaceItems['project_name'] = $model->projects['project_name'];
			$replaceItems['eoi_ref_no'] = $modelPB->eoi_ref_no;
			$replaceItems['booking_eoi_amount'] = $mod->getPriceFormat($modelPB->booking_eoi_amount);
			$emailTemplate = $mod->getMailTemplate('PROSPECT_BOOKING_EOI');
			$emailTemplate['subject'] = $mod->multipleReplace($emailTemplate['subject'],$replaceItems);
			$emailTemplate['template'] = $mod->multipleReplace($emailTemplate['template'],$replaceItems);
			if(!$mod->sendEmail(array($_SESSION['settings']['SITE_EMAIL_USERNAME'],$_SESSION['settings']['SITE_NAME']), array($model->prospect_email), $emailTemplate['subject'], $emailTemplate['template']))
			throw new ErrorException($mod->errorMessage);

			$transaction->commit();
		}
		catch (ErrorException $e) 
		{
			$transaction->rollBack();
			$this->errorMessage = $e->getMessage();
			return false;
		}


		/*** FORMAT RETURN ***/
		
		return $response;
	}


	public function updateProspectEOI($projectid,$prospectid,$prospect_booking_id,$userid,$inputs=array())
	{
		/*** INITIALIZE ***/
		$response = array();
		$response['historyid'] = 5;
	
		/*** VALIDATE ***/
		//validate user updating history
		if(!($user = Yii::$app->AccessRule->validateUserID($userid)))
		{
			$this->errorMessage = 'Invalid user access';
			return false;
		}

		//validate buyer
		if(empty($inputs['buyers']))
		{
			$this->errorMessage = "Invalid buyer details (1)";
			return false;
		}
		else
		{
			if(!is_array($inputs['buyers']))
			{
				$this->errorMessage = "Invalid buyer details (2)";
				return false;
			}

			if(count($inputs['buyers']) == 0)
			{
				$this->errorMessage = "Invalid buyer details (3)";
				return false;
			}
			
			foreach($inputs['buyers'] as $buyer)
			{
				if(empty($buyer['buyer_firstname']) or empty($buyer['buyer_lastname']))
				{
					$this->errorMessage = "Invalid buyer details (4)";
					break;
				}
			}
		}

		/*//validate eoi reference no
		if(empty($inputs['eoi_ref_no']))
		{
			$this->errorMessage = "Invalid EOI Reference Number";
			return false;
		}

		//validate EOI
		if(!($prospectEOI = $this->validateEOIExist($inputs['eoi_ref_no'],$prospect_booking_id)))
		return false;*/

		//validate eoi amount
		if(!empty($inputs['booking_eoi_amount']))
		{
			if(preg_match("/^([\d]+)(\.[\d]+)?$/",$inputs['booking_eoi_amount']) == 0)
			{
				$this->errorMessage = "Invalid booking's EOI amount";
				return false;
			}
		}
		
		/*** PROCESS ***/
		$connection = \Yii::$app->db;
		$transaction = $connection->beginTransaction();
		try
		{
			//update prospect
			$model = Prospects::findOne($prospectid);
			if(!empty($inputs['prospect_identity_document']))
			$model->prospect_identity_document = $inputs['prospect_identity_document'];
			if(!empty($inputs['tax_license']))
			$model->tax_license = $inputs['tax_license'];
			$model->updatedby = $userid;
			$model->updatedat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
			$model->save();
			
			if(count($model->errors)!=0)
			throw new ErrorException('Update prospect failed.');

			$modelPB = ProspectBookings::findOne($prospect_booking_id);
			if(!empty($inputs['project_id']))
			$modelPB->project_id = $inputs['project_id'];
			if(!empty($inputs['payment_method_eoi']))
			$modelPB->payment_method_eoi = $inputs['payment_method_eoi'];
			if(!empty($inputs['booking_eoi_amount']))
			$modelPB->booking_eoi_amount = $inputs['booking_eoi_amount'];
			if(!empty($inputs['proof_of_payment_eoi']))
			$modelPB->proof_of_payment_eoi = $inputs['proof_of_payment_eoi'];
			if(!empty($inputs['booking_date_eoi']))
			$modelPB->booking_date_eoi = $inputs['booking_date_eoi'];
			if(!empty($inputs['remarks']))
			$modelPB->status = 1;
			$modelPB->remarks = $inputs['remarks'];
			$modelPB->updatedby = $userid;
			$modelPB->updatedat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
			$modelPB->save();

			if(count($modelPB->errors)!=0)
			throw new ErrorException('Create booking(EOI) failed.');

			//prospect booking buyer
			ProspectBookingBuyers::deleteAll(array('prospect_booking_id' => $modelPB->id));
			foreach($inputs['buyers'] as $buyer)
			{
				$modelPBB = new ProspectBookingBuyers();
				$modelPBB->prospect_id = $prospectid;
				$modelPBB->prospect_booking_id = $modelPB->id;
				$modelPBB->buyer_firstname = $buyer['buyer_firstname'];
				$modelPBB->buyer_lastname = $buyer['buyer_lastname'];
				$modelPBB->save();
	
				if(count($modelPBB->errors)!=0)
				throw new ErrorException('Create buyer(s) failed.');
			}

			//log prospect history
			if(!empty($inputs['remarks']))
			{
				$modelLog = LogProspectHistory::find()->where(['prospect_booking_id'=>$prospect_booking_id, 'history_id'=>$response['historyid']])->one();
				$modelLog->remarks = $inputs['remarks'];
				$modelLog->save();
	
				if(count($modelLog->errors)!=0)
				throw new ErrorException('Update prospect log failed.');
			}

			//send message to admin
			$mod = Yii::$app->AccessMod;
			if(!$mod->sendMessage($mod->getAdminsIDs(),"Prospect Notification for changes to Booking EOI (#".$modelPB->eoi_ref_no.") for prospect ".$model->prospect_name." and waiting for your approval.","Prospect name " . $model->prospect_name . " has made a changes to booking(EOI). Waiting for your approval. Please click <a href=\"".$_SESSION['settings']['SITE_URL']."/prospects/pending-eoi-approval\">here</a> and click Approve button to approved.",'',3))
			throw new ErrorException($mod->errorMessage);

			$transaction->commit();
		}
		catch (ErrorException $e) 
		{
			$transaction->rollBack();
			$this->errorMessage = $e->getMessage();
			return false;
		}


		/*** FORMAT RETURN ***/
		
		return $response;
	}


	public function approvalProspectEOI($bookingid,$userid,$approve,$remarks='')
	{
		/*** INITIALIZE ***/
		$response = array();
	
	
		/*** VALIDATE ***/
		//validate user updating history
		if(!($user = Yii::$app->AccessRule->validateUserID($userid)))
		{
			$this->errorMessage = 'Invalid user access (1)';
			return false;
		}
		else
		{
			if(count(array_intersect(explode(',',$user['groups']),array(1,2)))==0)
			{
				$this->errorMessage = 'Invalid user access (2)';
				return false;
			}
		}

		//validate booking id
		if(empty($bookingid))
		{
			$this->errorMessage = "Invalid booking's id";
			return false;
		}

		//validate action
		if(!in_array($approve,array('0','1')))
		{
			$this->errorMessage = "Invalid action";
			return false;
		}
		else
		{
			if($approve==1)
			$response['historyid'] = 7;
			else
			{
				if(empty($remarks))
				{
					$this->errorMessage = "Invalid remarks for reject.";
					return false;
				}
				else
				$response['historyid'] = 6;
			}
		}

		/*** PROCESS ***/
		$connection = \Yii::$app->db;
		$transaction = $connection->beginTransaction();
		try
		{
			//update booking status
			$modelPB = ProspectBookings::findOne($bookingid);

			//get prospect
			$prospect = Prospects::findOne($modelPB->prospect_id);

			if($approve==1)
			$modelPB->status = 3;
			else
			$modelPB->status = 2;
			$modelPB->updatedby = $userid;
			$modelPB->updatedat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
			$modelPB->save();

			if(count($modelPB->errors)!=0)
			throw new ErrorException('Update booking(EOI) status failed.');
				
			//log prospect history
			$modelLog = new LogProspectHistory();
			$modelLog->project_id = $modelPB->project_id;
			$modelLog->prospect_id = $modelPB->prospect_id;
			$modelLog->prospect_booking_id = $modelPB->id;
			$modelLog->history_id = $response['historyid'];
			$modelLog->remarks = $remarks;
			$modelLog->createdby = $userid;
			$modelLog->createdat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
			$modelLog->save();

			if(count($modelLog->errors)!=0)
			throw new ErrorException('create prospect log failed.');

			//send message to agent
			$mod = Yii::$app->AccessMod;
			if(!$mod->sendMessage($modelPB->dedicated_agent_id,'Prospect Notification for Booking EOI Approval (#'.$modelPB->eoi_ref_no.') for prospect '.$prospect->prospect_name,"Prospect(" . $prospect->prospect_name . ") Booking EOI has been ".($approve==1?'approved':'rejected').". ".$remarks."."))
			throw new ErrorException($mod->errorMessage);

			//send message to prospect
			if($approve==1)
			{
				$replaceItems = array();
				$modelPBB = ProspectBookingBuyers::find()->where(['prospect_booking_id'=>$modelPB->id])->all();
				$replaceItems['buyer_name'] = $modelPBB[0]->buyer_firstname.' '.$modelPBB[0]->buyer_lastname;
				$replaceItems['project_name'] = $prospect->projects['project_name'];
				$replaceItems['eoi_ref_no'] = $modelPB->eoi_ref_no;
				$replaceItems['booking_eoi_amount'] = $mod->getPriceFormat($modelPB->booking_eoi_amount);
				$emailTemplate = $mod->getMailTemplate('PROSPECT_BOOKING_EOI_APPROVAL');
				$emailTemplate['subject'] = $mod->multipleReplace($emailTemplate['subject'],$replaceItems);
				$emailTemplate['template'] = $mod->multipleReplace($emailTemplate['template'],$replaceItems);
				if(!$mod->sendEmail(array($_SESSION['settings']['SITE_EMAIL_USERNAME'],$_SESSION['settings']['SITE_NAME']), array($prospect->prospect_email), $emailTemplate['subject'], $emailTemplate['template']))
				throw new ErrorException($mod->errorMessage);
			}

			$transaction->commit();
		}
		catch (ErrorException $e) 
		{
			$transaction->rollBack();
			$this->errorMessage = $e->getMessage();
			return false;
		}

		/*** FORMAT RETURN ***/
		return $response;
	}


	public function prospectEOIBooking($projectid,$prospectid,$prospect_booking_id,$userid,$inputs=array())
	{
		/*** INITIALIZE ***/
		$response = array();
		$response['historyid'] = 8;

	
		/*** VALIDATE ***/
		//validate prospect id
		if(!($prospect = $this->validateProspectID($prospectid,$response['historyid'])))
		return false;
		
		//validate user updating history
		if(!($user = Yii::$app->AccessRule->validateUserID($userid)))
		{
			$this->errorMessage = 'Invalid user access (1)';
			return false;
		}
		else
		{
			if(count(array_intersect(explode(',',$user['groups']),array(7)))==0)
			{
				$this->errorMessage = 'Invalid user access (2)';
				return false;
			}
		}

		//validate buyer
		if(empty($inputs['buyers']))
		{
			$this->errorMessage = "Invalid buyer details (1)";
			return false;
		}
		else
		{
			if(!is_array($inputs['buyers']))
			{
				$this->errorMessage = "Invalid buyer details (2)";
				return false;
			}

			if(count($inputs['buyers']) == 0)
			{
				$this->errorMessage = "Invalid buyer details (3)";
				return false;
			}
			
			foreach($inputs['buyers'] as $buyer)
			{
				if(empty($buyer['buyer_firstname']) or empty($buyer['buyer_lastname']))
				{
					$this->errorMessage = "Invalid buyer details (4)";
					break;
				}
			}
		}

		//validate product info
		if(empty($inputs['product_id']))
		{
			$this->errorMessage = "Invalid product's id";
			return false;
		}

		//validate unit info
		if(empty($inputs['product_unit']))
		{
			$this->errorMessage = "Invalid product's unit no";
			return false;
		}

		//validate booking
		if(!($prospectBooking = $this->validateBookingIDExist($inputs['product_id'],$inputs['product_unit'],$prospect_booking_id)))
		return false;
		
		//validate unit type
		if(empty($inputs['product_unit_type']))
		{
			$this->errorMessage = "Invalid product's type";
			return false;
		}
		
		//validate building size sm
		if(empty($inputs['building_size_sm']))
		{
			$this->errorMessage = "Invalid product's building size m2";
			return false;
		}
		else
		{
			if(preg_match("/^([\d]+)(\.[\d]+)?$/",$inputs['building_size_sm']) == 0)
			{
				$this->errorMessage = "Invalid product's building size m2";
				return false;
			}
		}
		
		//validate land size sm
		if(empty($inputs['land_size_sm']))
		{
			$this->errorMessage = "Invalid product's land size m2";
			return false;
		}
		else
		{
			if(preg_match("/^([\d]+)(\.[\d]+)?$/",$inputs['land_size_sm']) == 0)
			{
				$this->errorMessage = "Invalid product's land size m2";
				return false;
			}
		}
		
		//validate unit price
		if(empty($inputs['product_unit_price']))
		{
			$this->errorMessage = "Invalid product's price";
			return false;
		}
		else
		{
			if(preg_match("/^([\d]+)(\.[\d]+)?$/",$inputs['product_unit_price']) == 0)
			{
				$this->errorMessage = "Invalid product's price";
				return false;
			}
		}
		
		//validate unit price vat
		if(empty($inputs['product_unit_vat_price']))
		{
			$this->errorMessage = "Invalid product's price vat";
			return false;
		}
		else
		{
			if(preg_match("/^([\d]+)(\.[\d]+)?$/",$inputs['product_unit_vat_price']) == 0)
			{
				$this->errorMessage = "Invalid product's price vat";
				return false;
			}
		}
		
		//validate payment method
		if(empty($inputs['payment_method']))
		{
			$this->errorMessage = "Invalid payment method";
			return false;
		}
		
		//validate amount
		if(empty($inputs['booking_amount']))
		{
			$this->errorMessage = "Invalid booking's amount";
			return false;
		}
		else
		{
			if(preg_match("/^([\d]+)(\.[\d]+)?$/",$inputs['booking_amount']) == 0)
			{
				$this->errorMessage = "Invalid booking's amount";
				return false;
			}
		}

		//validate proof of payment
		if(empty($inputs['proof_of_payment']))
		{
			$this->errorMessage = "Invalid proof of payment for booking.";
			return false;
		}

		//validate booking date
		if(empty($inputs['booking_date']))
		{
			$this->errorMessage = "Invalid booking date";
			return false;
		}

		//validate sp file
		if(empty($inputs['sp_file']))
		{
			$this->errorMessage = "Invalid SP File.";
			return false;
		}
		
		//validate remarks
		if(empty($inputs['remarks']))
		{
			$this->errorMessage = "Please insert remarks.";
			return false;
		}

		/*** PROCESS ***/
		$connection = \Yii::$app->db;
		$transaction = $connection->beginTransaction();
		try
		{
			//update prospect
			$model = Prospects::findOne($prospectid);
			if(!empty($inputs['prospect_identity_document']))
			$model->prospect_identity_document = $inputs['prospect_identity_document'];
			if(!empty($inputs['tax_license']))
			$model->tax_license = $inputs['tax_license'];
			$model->updatedby = $userid;
			$model->updatedat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
			$model->save();
			
			if(count($model->errors)!=0)
			throw new ErrorException('Update prospect failed.');

			$modelPB = ProspectBookings::findOne($prospect_booking_id);
			if(!empty($inputs['product_id']))
			$modelPB->product_id = $inputs['product_id'];
			if(!empty($inputs['product_unit']))
			$modelPB->product_unit = $inputs['product_unit'];
			if(!empty($inputs['product_unit_type']))
			$modelPB->product_unit_type = $inputs['product_unit_type'];
			if(!empty($inputs['building_size_sm']))
			$modelPB->building_size_sm = $inputs['building_size_sm'];
			if(!empty($inputs['land_size_sm']))
			$modelPB->land_size_sm = $inputs['land_size_sm'];
			if(!empty($inputs['product_unit_price']))
			$modelPB->product_unit_price = $inputs['product_unit_price'];
			if(!empty($inputs['product_unit_vat_price']))
			$modelPB->product_unit_vat_price = $inputs['product_unit_vat_price'];
			if(!empty($inputs['payment_method']))
			$modelPB->payment_method = $inputs['payment_method'];
			if(!empty($inputs['booking_amount']))
			$modelPB->booking_amount = $inputs['booking_amount'];
			if(!empty($inputs['proof_of_payment']))
			$modelPB->proof_of_payment = $inputs['proof_of_payment'];
			if(!empty($inputs['sp_file']))
			$modelPB->sp_file = $inputs['sp_file'];
			if(!empty($inputs['booking_date']))
			$modelPB->booking_date = $inputs['booking_date'];
			if(!empty($inputs['remarks']))
			$modelPB->remarks = $inputs['remarks'];
			$modelPB->status = 4;
			$modelPB->updatedby = $userid;
			$modelPB->updatedat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
			$modelPB->save();

			if(count($modelPB->errors)!=0)
			throw new ErrorException('Create booking failed.');

			//update booking ref no
			$modelPB->booking_ref_no = 'FB'.$modelPB->ref_no;
			$modelPB->save();

			if(count($modelPB->errors)!=0)
			throw new ErrorException('Update Booking Reference No Failed');

			//prospect booking buyer
			ProspectBookingBuyers::deleteAll(array('prospect_booking_id' => $modelPB->id));
			foreach($inputs['buyers'] as $buyer)
			{
				$modelPBB = new ProspectBookingBuyers();
				$modelPBB->prospect_id = $prospectid;
				$modelPBB->prospect_booking_id = $modelPB->id;
				$modelPBB->buyer_firstname = $buyer['buyer_firstname'];
				$modelPBB->buyer_lastname = $buyer['buyer_lastname'];
				$modelPBB->save();
	
				if(count($modelPBB->errors)!=0)
				throw new ErrorException('Create buyer(s) failed.');
			}

			//log prospect history
			$modelLog = new LogProspectHistory();
			$modelLog->project_id = $modelPB->project_id;
			$modelLog->prospect_id = $prospectid;
			$modelLog->prospect_booking_id = $modelPB->id;
			$modelLog->history_id = $response['historyid'];
			$modelLog->remarks = $inputs['remarks'];
			$modelLog->createdby = $userid;
			$modelLog->createdat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
			$modelLog->save();

			if(count($modelLog->errors)!=0)
			throw new ErrorException('create prospect log failed.');

			//send message to admin
			$mod = Yii::$app->AccessMod;
			if(!$mod->sendMessage(Yii::$app->AccessMod->getAdminsIDs(),"Prospect Notication for a new booking (#".$modelPB->booking_ref_no.") for prospect ".$model->prospect_name." and waiting for your approval.","Prospect name " . $model->prospect_name . " has made a booking. Waiting for your approval. Please click <a href=\"".$_SESSION['settings']['SITE_URL']."/prospects/pending-booking-approval\">here</a> and click Approve button to approved.",'',3))
			throw new ErrorException($mod->errorMessage);

			//send message to prospect
			$replaceItems = array();
			$replaceItems['buyer_name'] = $inputs['buyers'][0]['buyer_firstname'].' '.$inputs['buyers'][0]['buyer_lastname'];
			$replaceItems['developer_name'] = $modelPB->developer['company_name'];
			$replaceItems['project_name'] = $model->projects['project_name'];
			$replaceItems['project_product_name'] = $modelPB->projectProducts['product_name'];
			$replaceItems['product_unit'] = $modelPB->product_unit;
			$replaceItems['project_product_unit_type'] = $modelPB->projectProductUnitTypes['type_name'];
			$replaceItems['building_size_sm'] = $modelPB->building_size_sm;
			$replaceItems['land_size_sm'] = $modelPB->land_size_sm;
			$replaceItems['total_product_unit_price'] = number_format(($modelPB->product_unit_price+$modelPB->product_unit_vat_price),2,'.',',');
			$replaceItems['booking_ref_no'] = $modelPB->booking_ref_no;
			$replaceItems['booking_amount'] = number_format($modelPB->booking_amount,2,'.',',');
			$emailTemplate = $mod->getMailTemplate('PROSPECT_BOOKING');
			$emailTemplate['subject'] = $mod->multipleReplace($emailTemplate['subject'],$replaceItems);
			$emailTemplate['template'] = $mod->multipleReplace($emailTemplate['template'],$replaceItems);
			if(!$mod->sendEmail(array($_SESSION['settings']['SITE_EMAIL_USERNAME'],$_SESSION['settings']['SITE_NAME']), array($model->prospect_email), $emailTemplate['subject'], $emailTemplate['template']))
			throw new ErrorException($mod->errorMessage);

			$transaction->commit();
		}
		catch (ErrorException $e) 
		{
			$transaction->rollBack();
			$this->errorMessage = $e->getMessage();
			return false;
		}

		/*** FORMAT RETURN ***/
		return $response;
	}
	
	public function createProspectBooking($projectid,$prospectid,$userid,$inputs=array())
	{
		/*** INITIALIZE ***/
		$response = array();
		$response['historyid'] = 8;

	
		/*** VALIDATE ***/
		//validate prospect id
		if(!($prospect = $this->validateProspectID($prospectid,$response['historyid'])))
		return false;
		
		//validate user updating history
		if(!($user = Yii::$app->AccessRule->validateUserID($userid)))
		{
			$this->errorMessage = 'Invalid user access (1)';
			return false;
		}
		else
		{
			if(count(array_intersect(explode(',',$user['groups']),array(7)))==0)
			{
				$this->errorMessage = 'Invalid user access (2)';
				return false;
			}
		}

		//validate product info
		if(empty($inputs['product_id']))
		{
			$this->errorMessage = "Invalid product's id";
			return false;
		}

		//validate unit info
		if(empty($inputs['product_unit']))
		{
			$this->errorMessage = "Invalid product's unit no";
			return false;
		}

		//validate booking
		if(!($prospectBooking = $this->validateBookingIDExist($inputs['product_id'],$inputs['product_unit'])))
		return false;
		
		//validate unit type
		if(empty($inputs['product_unit_type']))
		{
			$this->errorMessage = "Invalid product's type";
			return false;
		}

		//validate building size sm
		if(empty($inputs['building_size_sm']))
		{
			$this->errorMessage = "Invalid product's building size m2";
			return false;
		}
		else
		{
			if(preg_match("/^([\d]+)(\.[\d]+)?$/",$inputs['building_size_sm']) == 0)
			{
				$this->errorMessage = "Invalid product's building size m2";
				return false;
			}
		}
		
		//validate land size sm
		if(empty($inputs['land_size_sm']))
		{
			$this->errorMessage = "Invalid product's land size m2";
			return false;
		}
		else
		{
			if(preg_match("/^([\d]+)(\.[\d]+)?$/",$inputs['land_size_sm']) == 0)
			{
				$this->errorMessage = "Invalid product's land size m2";
				return false;
			}
		}
		
		//validate unit price
		if(empty($inputs['product_unit_price']))
		{
			$this->errorMessage = "Invalid product's price";
			return false;
		}
		else
		{
			if(preg_match("/^([\d]+)(\.[\d]+)?$/",$inputs['product_unit_price']) == 0)
			{
				$this->errorMessage = "Invalid product's price";
				return false;
			}
		}
		
		//validate unit price vat
		if(empty($inputs['product_unit_vat_price']))
		{
			$this->errorMessage = "Invalid product's price vat";
			return false;
		}
		else
		{
			if(preg_match("/^([\d]+)(\.[\d]+)?$/",$inputs['product_unit_vat_price']) == 0)
			{
				$this->errorMessage = "Invalid product's price vat";
				return false;
			}
		}

		//validate payment method
		if(empty($inputs['payment_method']))
		{
			$this->errorMessage = "Invalid payment method";
			return false;
		}
		
		//validate amount
		if(empty($inputs['booking_amount']))
		{
			$this->errorMessage = "Invalid booking's amount";
			return false;
		}
		else
		{
			if(preg_match("/^([\d]+)(\.[\d]+)?$/",$inputs['booking_amount']) == 0)
			{
				$this->errorMessage = "Invalid booking's amount";
				return false;
			}
		}

		//validate proof of payment
		if(empty($inputs['proof_of_payment']))
		{
			$this->errorMessage = "Invalid proof of payment for booking.";
			return false;
		}
		
		//validate sp file
		if(empty($inputs['sp_file']))
		{
			$this->errorMessage = "Invalid SP File.";
			return false;
		}
		
		//validate remarks
		if(empty($inputs['remarks']))
		{
			$this->errorMessage = "Please insert remarks.";
			return false;
		}

		/*** PROCESS ***/
		$connection = \Yii::$app->db;
		$transaction = $connection->beginTransaction();
		try
		{
			//update prospect
			$model = Prospects::findOne($prospectid);
			if($model->status==1)
			$model->status = 2;
			if(!empty($inputs['prospect_identity_document']))
			$model->prospect_identity_document = $inputs['prospect_identity_document'];
			if(!empty($inputs['tax_license']))
			$model->tax_license = $inputs['tax_license'];
			$model->updatedby = $userid;
			$model->updatedat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
			$model->save();
			
			if(count($model->errors)!=0)
			throw new ErrorException('Update prospect failed.');

			$modelPB = new ProspectBookings();
			$modelPB->prospect_id = $prospectid;
			$modelPB->agent_id = $model->agent_id;
			$modelPB->member_id = $model->createdby;
			$modelPB->dedicated_agent_id = $userid;
			$modelPB->referrer_member_id = Yii::$app->GeneralMod->getMemberReferrerID($model->member_id);
			$modelPB->developer_id = Yii::$app->GeneralMod->getDeveloperID($inputs['project_id']);;
			$modelPB->project_id = $inputs['project_id'];
			$modelPB->product_id = $inputs['product_id'];
			$modelPB->product_unit = $inputs['product_unit'];
			$modelPB->product_unit_type = $inputs['product_unit_type'];
			$modelPB->building_size_sm = $inputs['building_size_sm'];
			$modelPB->land_size_sm = $inputs['land_size_sm'];
			$modelPB->product_unit_price = $inputs['product_unit_price'];
			$modelPB->product_unit_vat_price = $inputs['product_unit_vat_price'];
			$modelPB->payment_method = $inputs['payment_method'];
			$modelPB->booking_amount = $inputs['booking_amount'];
			$modelPB->proof_of_payment = $inputs['proof_of_payment'];
			$modelPB->sp_file = $inputs['sp_file'];
			$modelPB->booking_date = $inputs['booking_date'];
			$modelPB->remarks = $inputs['remarks'];
			$modelPB->status = 4;
			$modelPB->createdby = $userid;
			$modelPB->createdat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
			$modelPB->save();

			if(count($modelPB->errors)!=0)
			throw new ErrorException('Create booking failed.');

			//update ref no
			$modelPB->ref_no = Yii::$app->AccessMod->generate_simple_unique_id(Yii::$app->AccessRule->dateFormat(time(), 'md'),$modelPB->id).'88108';
			$modelPB->booking_ref_no = 'FB'.$modelPB->ref_no;
			$modelPB->save();
			
			if(count($modelPB->errors)!=0)
			throw new ErrorException('Update Booking Reference No Failed');

			//prospect booking buyer
			foreach($inputs['buyers'] as $buyer)
			{
				$modelPBB = new ProspectBookingBuyers();
				$modelPBB->prospect_id = $prospectid;
				$modelPBB->prospect_booking_id = $modelPB->id;
				$modelPBB->buyer_firstname = $buyer['buyer_firstname'];
				$modelPBB->buyer_lastname = $buyer['buyer_lastname'];
				$modelPBB->save();
	
				if(count($modelPBB->errors)!=0)
				throw new ErrorException('Create buyer failed.');
			}

			//log prospect history
			$modelLog = new LogProspectHistory();
			$modelLog->project_id = $projectid;
			$modelLog->prospect_id = $prospectid;
			$modelLog->prospect_booking_id = $modelPB->id;
			$modelLog->history_id = $response['historyid'];
			$modelLog->remarks = $inputs['remarks'];
			$modelLog->createdby = $userid;
			$modelLog->createdat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
			$modelLog->save();

			if(count($modelLog->errors)!=0)
			throw new ErrorException('Create prospect log failed.');

			//send message to admin
			$mod = Yii::$app->AccessMod;
			if(!$mod->sendMessage(Yii::$app->AccessMod->getAdminsIDs(),"Prospect Notication for a new booking (#".$modelPB->booking_ref_no.") for prospect ".$model->prospect_name." and waiting for your approval.","Prospect name " . $model->prospect_name . " has made a booking. Waiting for your approval. Please click <a href=\"".$_SESSION['settings']['SITE_URL']."/prospects/pending-booking-approval\">here</a> and click Approve button to approved.",'',3))
			throw new ErrorException($mod->errorMessage);

			//send message to prospect
			$replaceItems = array();
			$replaceItems['buyer_name'] = $inputs['buyers'][0]['buyer_firstname'].' '.$inputs['buyers'][0]['buyer_lastname'];
			$replaceItems['developer_name'] = $modelPB->developer['company_name'];
			$replaceItems['project_name'] = $model->projects['project_name'];
			$replaceItems['project_product_name'] = $modelPB->projectProducts['product_name'];
			$replaceItems['product_unit'] = $modelPB->product_unit;
			$replaceItems['project_product_unit_type'] = $modelPB->projectProductUnitTypes['type_name'];
			$replaceItems['building_size_sm'] = $modelPB->building_size_sm;
			$replaceItems['land_size_sm'] = $modelPB->land_size_sm;
			$replaceItems['total_product_unit_price'] = number_format(($modelPB->product_unit_price+$modelPB->product_unit_vat_price),2,'.',',');
			$replaceItems['booking_ref_no'] = $modelPB->booking_ref_no;
			$replaceItems['booking_amount'] = number_format($modelPB->booking_amount,2,'.',',');
			$emailTemplate = $mod->getMailTemplate('PROSPECT_BOOKING');
			$emailTemplate['subject'] = $mod->multipleReplace($emailTemplate['subject'],$replaceItems);
			$emailTemplate['template'] = $mod->multipleReplace($emailTemplate['template'],$replaceItems);
			if(!$mod->sendEmail(array($_SESSION['settings']['SITE_EMAIL_USERNAME'],$_SESSION['settings']['SITE_NAME']), array($model->prospect_email), $emailTemplate['subject'], $emailTemplate['template']))
			throw new ErrorException($mod->errorMessage);

			$transaction->commit();
		}
		catch (ErrorException $e) 
		{
			$transaction->rollBack();
			$this->errorMessage = $e->getMessage();
			return false;
		}

		/*** FORMAT RETURN ***/
		return $response;
	}


	public function updateProspectBooking($projectid,$prospectid,$prospect_booking_id,$userid,$inputs=array())
	{
		/*** INITIALIZE ***/
		$response = array();
		$response['historyid'] = 5;
	
		/*** VALIDATE ***/
		//validate user updating history
		if(!($user = Yii::$app->AccessRule->validateUserID($userid)))
		{
			$this->errorMessage = 'Invalid user access';
			return false;
		}

		//validate product info
		if(empty($inputs['product_id']))
		{
			$this->errorMessage = "Invalid product's id";
			return false;
		}

		//validate unit info
		if(empty($inputs['product_unit']))
		{
			$this->errorMessage = "Invalid product's unit no";
			return false;
		}

		if($_SESSION['settings']['PROSPECT_CHANGE_BOOKING_UNIT_NO_PERMISSION'] == 0 and !$this->validateProspectOwnedUnit($prospectid,$inputs['product_id'],$inputs['product_unit']))
		return false;

		//validate booking
		if(!($prospectBooking = $this->validateBookingIDExist($inputs['product_id'],$inputs['product_unit'],$prospect_booking_id)))
		return false;
		
		//validate unit type
		if(empty($inputs['product_unit_type']))
		{
			$this->errorMessage = "Invalid product's type";
			return false;
		}
		
		//validate building size sm
		if(empty($inputs['building_size_sm']))
		{
			$this->errorMessage = "Invalid product's building size m2";
			return false;
		}
		else
		{
			if(preg_match("/^([\d]+)(\.[\d]+)?$/",$inputs['building_size_sm']) == 0)
			{
				$this->errorMessage = "Invalid product's building size m2";
				return false;
			}
		}
		
		//validate land size sm
		if(empty($inputs['land_size_sm']))
		{
			$this->errorMessage = "Invalid product's land size m2";
			return false;
		}
		else
		{
			if(preg_match("/^([\d]+)(\.[\d]+)?$/",$inputs['land_size_sm']) == 0)
			{
				$this->errorMessage = "Invalid product's land size m2";
				return false;
			}
		}
		
		//validate unit price
		if(!empty($inputs['product_unit_price']))
		{
			if(preg_match("/^([\d]+)(\.[\d]+)?$/",$inputs['product_unit_price']) == 0)
			{
				$this->errorMessage = "Invalid product's price";
				return false;
			}
		}

		//validate unit price vat
		if(!empty($inputs['product_unit_vat_price']))
		{
			if(preg_match("/^([\d]+)(\.[\d]+)?$/",$inputs['product_unit_vat_price']) == 0)
			{
				$this->errorMessage = "Invalid product's price vat";
				return false;
			}
		}
		
		//validate amount
		if(!empty($inputs['booking_amount']))
		{
			if(preg_match("/^([\d]+)(\.[\d]+)?$/",$inputs['booking_amount']) == 0)
			{
				$this->errorMessage = "Invalid booking's amount";
				return false;
			}
		}

		/*** PROCESS ***/
		$connection = \Yii::$app->db;
		$transaction = $connection->beginTransaction();
		try
		{
			//update prospect
			$model = Prospects::findOne($prospectid);
			if(!empty($inputs['prospect_identity_document']))
			$model->prospect_identity_document = $inputs['prospect_identity_document'];
			if(!empty($inputs['tax_license']))
			$model->tax_license = $inputs['tax_license'];
			$model->updatedby = $userid;
			$model->updatedat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
			$model->save();
			
			if(count($model->errors)!=0)
			throw new ErrorException('Update prospect failed.');

			$modelPB = ProspectBookings::findOne($prospect_booking_id);
			if(!empty($inputs['project_id']))
			$modelPB->project_id = $inputs['project_id'];
			if(!empty($inputs['product_id']))
			$modelPB->product_id = $inputs['product_id'];
			if(!empty($inputs['product_unit']))
			$modelPB->product_unit = $inputs['product_unit'];
			if(!empty($inputs['product_unit_type']))
			$modelPB->product_unit_type = $inputs['product_unit_type'];
			if(!empty($inputs['building_size_sm']))
			$modelPB->building_size_sm = $inputs['building_size_sm'];
			if(!empty($inputs['land_size_sm']))
			$modelPB->land_size_sm = $inputs['land_size_sm'];
			if(!empty($inputs['product_unit_price']))
			$modelPB->product_unit_price = $inputs['product_unit_price'];
			if(!empty($inputs['product_unit_vat_price']))
			$modelPB->product_unit_vat_price = $inputs['product_unit_vat_price'];
			if(!empty($inputs['payment_method']))
			$modelPB->payment_method = $inputs['payment_method'];
			if(!empty($inputs['booking_amount']))
			$modelPB->booking_amount = $inputs['booking_amount'];
			if(!empty($inputs['proof_of_payment']))
			$modelPB->proof_of_payment = $inputs['proof_of_payment'];
			if(!empty($inputs['sp_file']))
			$modelPB->sp_file = $inputs['sp_file'];
			if(!empty($inputs['booking_date']))
			$modelPB->booking_date = $inputs['booking_date'];
			if(!empty($inputs['remarks']))
			$modelPB->remarks = $inputs['remarks'];
			$modelPB->status = 4;
			$modelPB->updatedby = $userid;
			$modelPB->updatedat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
			$modelPB->save();

			if(count($modelPB->errors)!=0)
			throw new ErrorException('Update booking failed.');

			//prospect booking buyer
			ProspectBookingBuyers::deleteAll(array('prospect_booking_id' => $modelPB->id));
			foreach($inputs['buyers'] as $buyer)
			{
				$modelPBB = new ProspectBookingBuyers();
				$modelPBB->prospect_id = $prospectid;
				$modelPBB->prospect_booking_id = $modelPB->id;
				$modelPBB->buyer_firstname = $buyer['buyer_firstname'];
				$modelPBB->buyer_lastname = $buyer['buyer_lastname'];
				$modelPBB->save();
	
				if(count($modelPBB->errors)!=0)
				throw new ErrorException('Update buyer(s) failed.');
			}

			//send message to admin
			$mod = Yii::$app->AccessMod;
			if(!$mod->sendMessage($mod->getAdminsIDs(),"Prospect Notication for the changes to booking (#".$modelPB->booking_ref_no.") for prospect ".$model->prospect_name." and waiting for your approval.","Prospect name " . $model->prospect_name . " has made a changes to booking. Waiting for your approval. Please click <a href=\"".$_SESSION['settings']['SITE_URL']."/prospects/pending-booking-approval\">here</a> and click Approve button to approved.",'',3))
			throw new ErrorException($mod->errorMessage);

			$transaction->commit();
		}
		catch (ErrorException $e) 
		{
			$transaction->rollBack();
			$this->errorMessage = $e->getMessage();
			return false;
		}


		/*** FORMAT RETURN ***/
		
		return $response;
	}


	public function updateProspectFullBooking($projectid,$prospectid,$prospect_booking_id,$userid,$inputs=array())
	{
		/*** INITIALIZE ***/
		$response = array();
		$response['historyid'] = 5;
	
		/*** VALIDATE ***/
		//validate user updating history
		if(!($user = Yii::$app->AccessRule->validateUserID($userid)))
		{
			$this->errorMessage = 'Invalid user access';
			return false;
		}

		//validate user updating history
		if(!($user = Yii::$app->AccessRule->validateUserID($userid)))
		{
			$this->errorMessage = 'Invalid user access (1)';
			return false;
		}
		else
		{
			if(count(array_intersect(explode(',',$user['groups']),array(1,2)))==0)
			{
				$this->errorMessage = 'Invalid user access (2)';
				return false;
			}
		}

		//validate product info
		if(empty($inputs['product_id']))
		{
			$this->errorMessage = "Invalid product's id";
			return false;
		}

		//validate unit info
		if(empty($inputs['product_unit']))
		{
			$this->errorMessage = "Invalid product's unit no";
			return false;
		}

		if(!$this->validateProspectOwnedUnit($prospectid,$inputs['product_id'],$inputs['product_unit']))
		return false;

		//validate booking
		if(!($prospectBooking = $this->validateBookingIDExist($inputs['product_id'],$inputs['product_unit'],$prospect_booking_id)))
		return false;
		
		//validate building size sm
		if(!empty($inputs['building_size_sm']))
		{
			if(preg_match("/^([\d]+)(\.[\d]+)?$/",$inputs['building_size_sm']) == 0)
			{
				$this->errorMessage = "Invalid product's building size m2";
				return false;
			}
		}
		
		//validate land size sm
		if(!empty($inputs['land_size_sm']))
		{
			if(preg_match("/^([\d]+)(\.[\d]+)?$/",$inputs['land_size_sm']) == 0)
			{
				$this->errorMessage = "Invalid product's land size m2";
				return false;
			}
		}
		
		//validate unit price
		if(!empty($inputs['product_unit_price']))
		{
			if(preg_match("/^([\d]+)(\.[\d]+)?$/",$inputs['product_unit_price']) == 0)
			{
				$this->errorMessage = "Invalid product's price";
				return false;
			}
		}

		//validate unit price vat
		if(!empty($inputs['product_unit_vat_price']))
		{
			if(preg_match("/^([\d]+)(\.[\d]+)?$/",$inputs['product_unit_vat_price']) == 0)
			{
				$this->errorMessage = "Invalid product's price vat";
				return false;
			}
		}
		
		//validate amount
		if(!empty($inputs['booking_amount']))
		{
			if(preg_match("/^([\d]+)(\.[\d]+)?$/",$inputs['booking_amount']) == 0)
			{
				$this->errorMessage = "Invalid booking's amount";
				return false;
			}
		}

		/*** PROCESS ***/
		$connection = \Yii::$app->db;
		$transaction = $connection->beginTransaction();
		try
		{
			//update prospect
			$model = Prospects::findOne($prospectid);
			if(!empty($inputs['prospect_identity_document']))
			$model->prospect_identity_document = $inputs['prospect_identity_document'];
			if(!empty($inputs['tax_license']))
			$model->tax_license = $inputs['tax_license'];
			$model->updatedby = $userid;
			$model->updatedat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
			$model->save();
			
			if(count($model->errors)!=0)
			throw new ErrorException('Update prospect failed.');

			$modelPB = ProspectBookings::findOne($prospect_booking_id);
			if(!empty($inputs['project_id']))
			$modelPB->project_id = $inputs['project_id'];
			if(!empty($inputs['product_id']))
			$modelPB->product_id = $inputs['product_id'];
			if(!empty($inputs['product_unit']))
			$modelPB->product_unit = $inputs['product_unit'];
			if(!empty($inputs['product_unit_type']))
			$modelPB->product_unit_type = $inputs['product_unit_type'];
			if(!empty($inputs['building_size_sm']))
			$modelPB->building_size_sm = $inputs['building_size_sm'];
			if(!empty($inputs['land_size_sm']))
			$modelPB->land_size_sm = $inputs['land_size_sm'];
			if(!empty($inputs['product_unit_price']))
			$modelPB->product_unit_price = $inputs['product_unit_price'];
			if(!empty($inputs['product_unit_vat_price']))
			$modelPB->product_unit_vat_price = $inputs['product_unit_vat_price'];
			if(!empty($inputs['payment_method_eoi']))
			$modelPB->payment_method_eoi = $inputs['payment_method_eoi'];
			if(!empty($inputs['booking_eoi_amount']))
			$modelPB->booking_eoi_amount = $inputs['booking_eoi_amount'];
			if(!empty($inputs['proof_of_payment_eoi']))
			$modelPB->proof_of_payment_eoi = $inputs['proof_of_payment_eoi'];
			if(!empty($inputs['booking_date_eoi']))
			$modelPB->booking_date_eoi = $inputs['booking_date_eoi'];
			if(!empty($inputs['payment_method']))
			$modelPB->payment_method = $inputs['payment_method'];
			if(!empty($inputs['booking_amount']))
			$modelPB->booking_amount = $inputs['booking_amount'];
			if(!empty($inputs['proof_of_payment']))
			$modelPB->proof_of_payment = $inputs['proof_of_payment'];
			if(!empty($inputs['sp_file']))
			$modelPB->sp_file = $inputs['sp_file'];
			if(!empty($inputs['ppjb_file']))
			$modelPB->ppjb_file = $inputs['ppjb_file'];
			if(!empty($inputs['booking_date']))
			$modelPB->booking_date = $inputs['booking_date'];
			if(!empty($inputs['remarks']))
			$modelPB->remarks = $inputs['remarks'];
			$modelPB->updatedby = $userid;
			$modelPB->updatedat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
			$modelPB->save();

			if(count($modelPB->errors)!=0)
			throw new ErrorException('Create booking(EOI) failed.');

			//prospect booking buyer
			ProspectBookingBuyers::deleteAll(array('prospect_booking_id' => $modelPB->id));
			foreach($inputs['buyers'] as $buyer)
			{
				$modelPBB = new ProspectBookingBuyers();
				$modelPBB->prospect_id = $prospectid;
				$modelPBB->prospect_booking_id = $modelPB->id;
				$modelPBB->buyer_firstname = $buyer['buyer_firstname'];
				$modelPBB->buyer_lastname = $buyer['buyer_lastname'];
				$modelPBB->save();
	
				if(count($modelPBB->errors)!=0)
				throw new ErrorException('Create buyer(s) failed.');
			}

			/*//log prospect history
			if(!empty($inputs['remarks']))
			{
				$modelLog = LogProspectHistory::find()->where(['prospect_booking_id'=>$prospect_booking_id, 'history_id'=>$response['historyid']])->one();
				$modelLog->remarks = $inputs['remarks'];
				$modelLog->save();
	
				if(count($modelLog->errors)!=0)
				throw new ErrorException('Update prospect log failed.');
			}*/

			$transaction->commit();
		}
		catch (ErrorException $e) 
		{
			$transaction->rollBack();
			$this->errorMessage = $e->getMessage();
			return false;
		}


		/*** FORMAT RETURN ***/
		
		return $response;
	}


	public function approvalProspectBooking($bookingid,$userid,$approve,$remarks='')
	{
		/*** INITIALIZE ***/
		$response = array();
	
	
		/*** VALIDATE ***/
		//validate user updating history
		if(!($user = Yii::$app->AccessRule->validateUserID($userid)))
		{
			$this->errorMessage = 'Invalid user access (1)';
			return false;
		}
		else
		{
			if(count(array_intersect(explode(',',$user['groups']),array(1,2)))==0)
			{
				$this->errorMessage = 'Invalid user access (2)';
				return false;
			}
		}

		//validate booking id
		if(empty($bookingid))
		{
			$this->errorMessage = "Invalid booking's id";
			return false;
		}

		//validate action
		if(!in_array($approve,array('0','1')))
		{
			$this->errorMessage = "Invalid action";
			return false;
		}
		else
		{
			if($approve==1)
			$response['historyid'] = 10;
			else
			{
				if(empty($remarks))
				{
					$this->errorMessage = "Invalid remarks for reject.";
					return false;
				}
				else
				$response['historyid'] = 9;
			}
		}

		/*** PROCESS ***/
		$connection = \Yii::$app->db;
		$transaction = $connection->beginTransaction();
		try
		{

			//update booking status
			$modelPB = ProspectBookings::findOne($bookingid);

			//get prospect
			$prospect = Prospects::findOne($modelPB->prospect_id);

			if($approve==1)
			$modelPB->status = 6;
			else
			$modelPB->status = 5;
			
			$modelPB->updatedby = $userid;
			$modelPB->updatedat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
			$modelPB->save();

			if(count($modelPB->errors)!=0)
			throw new ErrorException('Update booking status failed.');

			//give points for activity - booking
			if($approve==1)
			{
				$memberPointsActivities = Yii::$app->PointsMod;
				if(!($memberPointsActivity = $memberPointsActivities->memberPointsActivities($prospect->member_id,'PROSPECT_FULL_BOOK',$userid,array('action_name'=>'PROSPECT_HISTORY','prospect_id'=>$prospect->id,'history_id'=>$response['historyid']))))
				throw new ErrorException($memberPointsActivities->errorMessage);
			}
			
			//log prospect history
			$modelLog = new LogProspectHistory();
			$modelLog->project_id = $modelPB->project_id;
			$modelLog->prospect_id = $modelPB->prospect_id;
			$modelLog->prospect_booking_id = $modelPB->id;
			$modelLog->history_id = $response['historyid'];
			$modelLog->remarks = $remarks;
			$modelLog->createdby = $userid;
			$modelLog->createdat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
			$modelLog->save();

			if(count($modelLog->errors)!=0)
			throw new ErrorException('create prospect log failed.');

			//send message to agent
			$mod = Yii::$app->AccessMod;
			if(!$mod->sendMessage($modelPB->dedicated_agent_id,'Prospect Notification for Booking Approval (#'.$modelPB->booking_ref_no.') for prospect '.$prospect->prospect_name,"Prospect(" . $prospect->prospect_name . ") Booking has been ".($approve==1?'approved':'rejected').". ".$remarks."."))
			throw new ErrorException($mod->errorMessage);

			//send message to member
			if($approve==1)
			{
				if(!$mod->sendMessage($modelPB->member_id,'Prospect Notification for Booking Approval (#'.$modelPB->booking_ref_no.') for prospect '.$prospect->prospect_name,"Prospect(" . $prospect->prospect_name . ") has been Full Booked. ".($memberPointsActivity['activity_points']>0?"You've got " . Yii::$app->AccessMod->getPointsFormat($memberPointsActivity['activity_points']) . " points.":"")))
				throw new ErrorException($mod->errorMessage);
			}

			//send message to prospect
			if($approve==1)
			{
				$replaceItems = array();
				$modelPBB = ProspectBookingBuyers::find()->where(['prospect_booking_id'=>$modelPB->id])->all();
				$replaceItems['buyer_name'] = $modelPBB[0]->buyer_firstname.' '.$modelPBB[0]->buyer_lastname;
				$replaceItems['project_name'] = $prospect->projects['project_name'];
				$replaceItems['product_unit'] = $modelPB->product_unit;
				$replaceItems['dedicated_agent_name'] = $modelPB->dedicatedAgent['name'];
				$replaceItems['booking_ref_no'] = $modelPB->booking_ref_no;
				$replaceItems['booking_amount'] = $mod->getPriceFormat($modelPB->booking_amount);
				$emailTemplate = $mod->getMailTemplate('PROSPECT_BOOKING_APPROVAL');
				$emailTemplate['subject'] = $mod->multipleReplace($emailTemplate['subject'],$replaceItems);
				$emailTemplate['template'] = $mod->multipleReplace($emailTemplate['template'],$replaceItems);
				if(!$mod->sendEmail(array($_SESSION['settings']['SITE_EMAIL_USERNAME'],$_SESSION['settings']['SITE_NAME']), array($prospect->prospect_email), $emailTemplate['subject'], $emailTemplate['template']))
				throw new ErrorException($mod->errorMessage);
			}

			//generate commission
			if($approve==1)
			{
				$commissionGenerator = Yii::$app->CommissionMod;
				if(!$commissionGenerator->generateUserCommissionsByProspectBooking($modelPB->id))
				throw new ErrorException($commissionGenerator->errorMessage);
			}

			$transaction->commit();
		}
		catch (ErrorException $e) 
		{
			$transaction->rollBack();
			$this->errorMessage = $e->getMessage();
			return false;
		}

		/*** FORMAT RETURN ***/
		return $response;
	}

	public function prospectContractSigned($prospectid,$prospect_booking_id,$userid,$inputs=array())
	{
		/*** INITIALIZE ***/
		$response = array();
		$response['historyid'] = 11;

	
		/*** VALIDATE ***/
		//validate prospect id
		if(!($prospect = $this->validateProspectID($prospectid,$response['historyid'])))
		return false;
		
		//validate user updating history
		if(!($user = Yii::$app->AccessRule->validateUserID($userid)))
		{
			$this->errorMessage = 'Invalid user access (1)';
			return false;
		}
		else
		{
			if(count(array_intersect(explode(',',$user['groups']),array(7)))==0)
			{
				$this->errorMessage = 'Invalid user access (2)';
				return false;
			}
		}

		//validate ppjb file
		if(empty($inputs['ppjb_file']))
		{
			$this->errorMessage = "Invalid ppjb File";
			return false;
		}
		
		//validate remarks
		if(empty($inputs['remarks']))
		{
			$this->errorMessage = "Please insert remarks.";
			return false;
		}

		/*** PROCESS ***/
		$connection = \Yii::$app->db;
		$transaction = $connection->beginTransaction();
		try
		{
			//update prospect product info
			$model = Prospects::findOne($prospectid);
			$model->updatedby = $userid;
			$model->updatedat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
			$model->save();
			
			if(count($model->errors)!=0)
			throw new ErrorException('Update prospect failed.');

			$modelPB = ProspectBookings::findOne($prospect_booking_id);
			if(!empty($inputs['ppjb_file']))
			$modelPB->ppjb_file = $inputs['ppjb_file'];
			$modelPB->status = 7;
			$modelPB->updatedby = $userid;
			$modelPB->updatedat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
			$modelPB->save();

			if(count($modelPB->errors)!=0)
			throw new ErrorException('Update booking contract signed failed.');

			//log prospect history
			$modelLog = new LogProspectHistory();
			$modelLog->project_id = $modelPB->project_id;
			$modelLog->prospect_id = $prospectid;
			$modelLog->prospect_booking_id = $modelPB->id;
			$modelLog->history_id = $response['historyid'];
			$modelLog->remarks = $inputs['remarks'];
			$modelLog->createdby = $userid;
			$modelLog->createdat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
			$modelLog->save();

			if(count($modelLog->errors)!=0)
			throw new ErrorException('create prospect log failed.');

			//send message to admin
			$sendMessage = Yii::$app->AccessMod;
			if(!$sendMessage->sendMessage(Yii::$app->AccessMod->getAdminsIDs(),"Prospect Notification for Booking Contract Signed Approval (#".$modelPB->booking_ref_no.") for prospect ".$model->prospect_name,"Booking contract signed has been created for prospect name " . $model->prospect_name . ". Waiting for your approval. Please click <a href=\"".$_SESSION['settings']['SITE_URL']."/prospects/pending-contract-signed-approval\">here</a> and click Approve button to approved.",'',3))
			throw new ErrorException($sendMessage->errorMessage);

			$transaction->commit();
		}
		catch (ErrorException $e) 
		{
			$transaction->rollBack();
			$this->errorMessage = $e->getMessage();
			return false;
		}

		/*** FORMAT RETURN ***/
		return $response;
	}

	public function updateProspectContractSigned($prospectid,$prospect_booking_id,$userid,$inputs=array())
	{
		/*** INITIALIZE ***/
		$response = array();
		$response['historyid'] = 11;
	
		/*** VALIDATE ***/
		//validate user updating history
		if(!($user = Yii::$app->AccessRule->validateUserID($userid)))
		{
			$this->errorMessage = 'Invalid user access';
			return false;
		}

		//validate prospect id
		if(!($prospect = $this->validateProspectID($prospectid,$response['historyid'])))
		return false;
		
		//validate user updating history
		if(!($user = Yii::$app->AccessRule->validateUserID($userid)))
		{
			$this->errorMessage = 'Invalid user access (1)';
			return false;
		}
		else
		{
			if(count(array_intersect(explode(',',$user['groups']),array(7)))==0)
			{
				$this->errorMessage = 'Invalid user access (2)';
				return false;
			}
		}
		
		//validate remarks
		if(empty($inputs['remarks']))
		{
			$this->errorMessage = "Please insert remarks.";
			return false;
		}

		/*** PROCESS ***/
		$connection = \Yii::$app->db;
		$transaction = $connection->beginTransaction();
		try
		{
			//update prospect
			$model = Prospects::findOne($prospectid);
			$model->updatedby = $userid;
			$model->updatedat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
			$model->save();
			
			if(count($model->errors)!=0)
			throw new ErrorException('Update prospect failed.');

			$modelPB = ProspectBookings::findOne($prospect_booking_id);
			if(!empty($inputs['ppjb_file']))
			$modelPB->ppjb_file = $inputs['ppjb_file'];
			$modelPB->status = 7;
			$modelPB->updatedby = $userid;
			$modelPB->updatedat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
			$modelPB->save();

			if(count($modelPB->errors)!=0)
			throw new ErrorException('Update PPJB file failed.');

			//log prospect history
			if(!empty($inputs['remarks']))
			{
				$modelLog = LogProspectHistory::find()->where(['prospect_booking_id'=>$prospect_booking_id, 'history_id'=>$response['historyid']])->one();
				$modelLog->remarks = $inputs['remarks'];
				$modelLog->save();
	
				if(count($modelLog->errors)!=0)
				throw new ErrorException('Update prospect log failed.');
			}

			//send message to admin
			$sendMessage = Yii::$app->AccessMod;
			if(!$sendMessage->sendMessage(Yii::$app->AccessMod->getAdminsIDs(),"Prospect Notification for changes of Booking Contract Signed Approval (#".$modelPB->booking_ref_no.") for prospect ".$model->prospect_name,"Changes has been made to a booking contract signed for prospect name " . $model->prospect_name . ". Waiting for your approval. Please click <a href=\"".$_SESSION['settings']['SITE_URL']."/prospects/pending-contract-signed-approval\">here</a> and click Approve button to approved.",'',3))
			throw new ErrorException($sendMessage->errorMessage);

			$transaction->commit();
		}
		catch (ErrorException $e) 
		{
			$transaction->rollBack();
			$this->errorMessage = $e->getMessage();
			return false;
		}

		/*** FORMAT RETURN ***/
		return $response;
	}


	public function approvalProspectContractSigned($bookingid,$userid,$approve,$remarks='')
	{
		/*** INITIALIZE ***/
		$response = array();
		$response['historyid'] = 11;
	
	
		/*** VALIDATE ***/
		//validate user updating history
		if(!($user = Yii::$app->AccessRule->validateUserID($userid)))
		{
			$this->errorMessage = 'Invalid user access (1)';
			return false;
		}
		else
		{
			if(count(array_intersect(explode(',',$user['groups']),array(1,2)))==0)
			{
				$this->errorMessage = 'Invalid user access (2)';
				return false;
			}
		}

		//validate booking id
		if(empty($bookingid))
		{
			$this->errorMessage = "Invalid booking's id";
			return false;
		}

		//validate action
		if(!in_array($approve,array('0','1')))
		{
			$this->errorMessage = "Invalid action";
			return false;
		}
		else
		{
			if($approve==1)
			$response['historyid'] = 13;
			else
			{
				if(empty($remarks))
				{
					$this->errorMessage = "Invalid remarks for reject.";
					return false;
				}
				else
				$response['historyid'] = 12;
			}
		}

		/*** PROCESS ***/
		$connection = \Yii::$app->db;
		$transaction = $connection->beginTransaction();
		try
		{

			//update booking status
			$modelPB = ProspectBookings::findOne($bookingid);

			//get prospect
			$prospect = Prospects::findOne($modelPB->prospect_id);

			if($approve==1)
			$modelPB->status = 9;
			else
			$modelPB->status = 8;
			$modelPB->updatedby = $userid;
			$modelPB->updatedat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
			$modelPB->save();

			if(count($modelPB->errors)!=0)
			throw new ErrorException('Update contract signed status failed.');

			//log prospect history
			$modelLog = new LogProspectHistory();
			$modelLog->project_id = $modelPB->project_id;
			$modelLog->prospect_id = $modelPB->prospect_id;
			$modelLog->prospect_booking_id = $modelPB->id;
			$modelLog->history_id = $response['historyid'];
			$modelLog->remarks = $remarks;
			$modelLog->createdby = $userid;
			$modelLog->createdat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
			$modelLog->save();

			if(count($modelLog->errors)!=0)
			throw new ErrorException('create prospect log failed.');

			//send message to agent
			$sendMessage = Yii::$app->AccessMod;
			if(!$sendMessage->sendMessage($modelPB->dedicated_agent_id,'Prospect Notification for Booking Contract Signed Approval (#'.$modelPB->booking_ref_no.') for prospect '.$prospect->prospect_name,"Prospect(" . $prospect->prospect_name . ") Booking has been ".($approve==1?'approved':'rejected').". ".$remarks."."))
			throw new ErrorException($sendMessage->errorMessage);

			$transaction->commit();
		}
		catch (ErrorException $e) 
		{
			$transaction->rollBack();
			$this->errorMessage = $e->getMessage();
			return false;
		}

		/*** FORMAT RETURN ***/
		return $response;
	}


	public function shareProspect($prospectid,$userid,$projects)
	{
		/*** INITIALIZE ***/
		$response = true;
	
	
		/*** VALIDATE ***/
		//validate user updating history
		if(!($user = Yii::$app->AccessRule->validateUserID($userid)))
		{
			$this->errorMessage = 'Invalid user access (1)';
			return false;
		}
		else
		{
			if(count(array_intersect(explode(',',$user['groups']),array(7)))==0)
			{
				$this->errorMessage = 'Invalid user access (2)';
				return false;
			}
		}

		//validate booking id
		if(empty($prospectid))
		{
			$this->errorMessage = "Invalid prospect's id";
			return false;
		}

		//validate project
		if(!is_array($projects))
		{
			$this->errorMessage = "Invalid projects";
			return false;
		}

		/*** PROCESS ***/
		$connection = \Yii::$app->db;
		$transaction = $connection->beginTransaction();
		try
		{
			//delete prospect interested projects
			ProspectInterestedProjects::deleteAll(array('prospect_id' => $prospectid));

			foreach($projects as $project)
			{
				$modelProspectInterestedProjects = new ProspectInterestedProjects();
				$modelProspectInterestedProjects->project_id = $project;
				$modelProspectInterestedProjects->prospect_id = $prospectid;
				$modelProspectInterestedProjects->save();
				if(count($modelProspectInterestedProjects->errors)!=0)
				{
					throw new ErrorException("Create prospect interested project failed.");
					break;
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

		/*** FORMAT RETURN ***/
		return $response;
	}


	public function cancelBooking($prospectid,$prospect_booking_id,$userid,$inputs=array())
	{
		/*** INITIALIZE ***/
		$response = array();
		$response['historyid'] = 14;

	
		/*** VALIDATE ***/
		//validate prospect id
		if(!($prospect = $this->validateProspectID($prospectid,$response['historyid'])))
		return false;
		
		//validate user updating history
		if(!($user = Yii::$app->AccessRule->validateUserID($userid)))
		{
			$this->errorMessage = 'Invalid user access (1)';
			return false;
		}
		else
		{
			if(count(array_intersect(explode(',',$user['groups']),array(7)))==0)
			{
				$this->errorMessage = 'Invalid user access (2)';
				return false;
			}
		}

		//validate cancellation attachment
		/*if(empty($inputs['cancellation_attachment']))
		{
			$this->errorMessage = "Invalid Cancellation Attachment File";
			return false;
		}*/

		//validate remarks
		if(empty($inputs['remarks']))
		{
			$this->errorMessage = "Please insert remarks.";
			return false;
		}

		/*** PROCESS ***/
		$connection = \Yii::$app->db;
		$transaction = $connection->beginTransaction();
		try
		{
			//update prospect product info
			$model = Prospects::findOne($prospectid);
			$model->updatedby = $userid;
			$model->updatedat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
			$model->save();
			
			if(count($model->errors)!=0)
			throw new ErrorException('Update prospect failed.');

			$modelPB = ProspectBookings::findOne($prospect_booking_id);
			$modelPB->cancel_ref_no = 'CC'.$modelPB->ref_no;
			if(!empty($inputs['cancellation_attachment']))
			$modelPB->cancellation_attachment = $inputs['cancellation_attachment'];
			$modelPB->status = 10;
			$modelPB->updatedby = $userid;
			$modelPB->updatedat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
			$modelPB->save();

			if(count($modelPB->errors)!=0)
			throw new ErrorException('Update booking cancellation failed.');

			//log prospect history
			$modelLog = new LogProspectHistory();
			$modelLog->project_id = $modelPB->project_id;
			$modelLog->prospect_id = $prospectid;
			$modelLog->prospect_booking_id = $modelPB->id;
			$modelLog->history_id = $response['historyid'];
			$modelLog->remarks = $inputs['remarks'];
			$modelLog->createdby = $userid;
			$modelLog->createdat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
			$modelLog->save();

			if(count($modelLog->errors)!=0)
			throw new ErrorException('create prospect log failed.');

			//send message to admin
			$sendMessage = Yii::$app->AccessMod;
			if(!$sendMessage->sendMessage(Yii::$app->AccessMod->getAdminsIDs(),"Prospect Notification for Booking Cancellation Approval (#".$modelPB->cancel_ref_no.") for prospect ".$model->prospect_name,"Booking Cancellation has been created for prospect name " . $model->prospect_name . ". Waiting for your approval. Please click <a href=\"".$_SESSION['settings']['SITE_URL']."/prospects/pending-booking-approval\">here</a> and click Approve button to approved.",'',3))
			throw new ErrorException($sendMessage->errorMessage);

			$transaction->commit();
		}
		catch (ErrorException $e) 
		{
			$transaction->rollBack();
			$this->errorMessage = $e->getMessage();
			return false;
		}

		/*** FORMAT RETURN ***/
		return $response;
	}


	public function cancelBookingFull($prospectid,$prospect_booking_id,$userid,$inputs=array())
	{
		/*** INITIALIZE ***/
		$response = array();
		$response['historyid'] = 16;

	
		/*** VALIDATE ***/
		//validate prospect id
		if(!($prospect = $this->validateProspectID($prospectid,$response['historyid'])))
		return false;
		
		//validate user updating history
		if(!($user = Yii::$app->AccessRule->validateUserID($userid)))
		{
			$this->errorMessage = 'Invalid user access (1)';
			return false;
		}
		else
		{
			if(count(array_intersect(explode(',',$user['groups']),array(1,2)))==0)
			{
				$this->errorMessage = 'Invalid user access (2)';
				return false;
			}
		}

		//validate cancellation attachment
		/*if(empty($inputs['cancellation_attachment']))
		{
			$this->errorMessage = "Invalid Cancellation Attachment File";
			return false;
		}*/

		//validate remarks
		if(empty($inputs['remarks']))
		{
			$this->errorMessage = "Please insert remarks.";
			return false;
		}

		/*** PROCESS ***/
		$connection = \Yii::$app->db;
		$transaction = $connection->beginTransaction();
		try
		{
			//update prospect product info
			$model = Prospects::findOne($prospectid);
			$model->updatedby = $userid;
			$model->updatedat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
			$model->save();
			
			if(count($model->errors)!=0)
			throw new ErrorException('Update prospect failed.');

			$modelPB = ProspectBookings::findOne($prospect_booking_id);
			$modelPB->cancel_ref_no = 'CC'.$modelPB->ref_no;
			if(!empty($inputs['cancellation_attachment']))
			$modelPB->cancellation_attachment = $inputs['cancellation_attachment'];
			$modelPB->status = 12;
			$modelPB->updatedby = $userid;
			$modelPB->updatedat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
			$modelPB->save();

			if(count($modelPB->errors)!=0)
			throw new ErrorException('Update booking contract signed failed.');

			//log prospect history
			$modelLog = new LogProspectHistory();
			$modelLog->project_id = $modelPB->project_id;
			$modelLog->prospect_id = $prospectid;
			$modelLog->prospect_booking_id = $modelPB->id;
			$modelLog->history_id = $response['historyid'];
			$modelLog->remarks = $inputs['remarks'];
			$modelLog->createdby = $userid;
			$modelLog->createdat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
			$modelLog->save();

			if(count($modelLog->errors)!=0)
			throw new ErrorException('create prospect log failed.');

			//send message to prospect
			$mod = Yii::$app->AccessMod;
			$replaceItems = array();
			$modelPBB = ProspectBookingBuyers::find()->where(['prospect_booking_id'=>$modelPB->id])->all();
			$replaceItems['buyer_name'] = $modelPBB[0]->buyer_firstname.' '.$modelPBB[0]->buyer_lastname;
			$replaceItems['project_name'] = $prospect->projects['project_name'];
			$replaceItems['product_unit'] = $modelPB->product_unit;
			$replaceItems['cancel_ref_no'] = $modelPB->cancel_ref_no;
			$emailTemplate = $mod->getMailTemplate('PROSPECT_CANCELLATION_BOOKING');
			
			if(empty($replaceItems['product_unit']))
			$emailTemplate['subject'] = str_replace('[product_unit], ','',$emailTemplate['subject']);
			
			$emailTemplate['subject'] = $mod->multipleReplace($emailTemplate['subject'],$replaceItems);
			$emailTemplate['template'] = $mod->multipleReplace($emailTemplate['template'],$replaceItems);
			if(!$mod->sendEmail(array($_SESSION['settings']['SITE_EMAIL_USERNAME'],$_SESSION['settings']['SITE_NAME']), array($prospect->prospect_email), $emailTemplate['subject'], $emailTemplate['template']))
			throw new ErrorException($mod->errorMessage);

			//commission cancellation
			$commissionMod = Yii::$app->CommissionMod;
			if(!$commissionMod->cancelUserCommissionsByProspectBookingID($modelPB->id))
			throw new ErrorException($commissionMod->errorMessage);

			$transaction->commit();
		}
		catch (ErrorException $e) 
		{
			$transaction->rollBack();
			$this->errorMessage = $e->getMessage();
			return false;
		}

		/*** FORMAT RETURN ***/
		return $response;
	}


	public function approvalCancelBooking($bookingid,$userid,$approve,$remarks='')
	{
		/*** INITIALIZE ***/
		$response = array();
		$response['historyid'] = 14;
	
	
		/*** VALIDATE ***/
		//validate user updating history
		if(!($user = Yii::$app->AccessRule->validateUserID($userid)))
		{
			$this->errorMessage = 'Invalid user access (1)';
			return false;
		}
		else
		{
			if(count(array_intersect(explode(',',$user['groups']),array(1,2)))==0)
			{
				$this->errorMessage = 'Invalid user access (2)';
				return false;
			}
		}

		//validate booking id
		if(empty($bookingid))
		{
			$this->errorMessage = "Invalid booking's id";
			return false;
		}

		//validate action
		if(!in_array($approve,array('0','1')))
		{
			$this->errorMessage = "Invalid action";
			return false;
		}
		else
		{
			if($approve==1)
			$response['historyid'] = 16;
			else
			{
				if(empty($remarks))
				{
					$this->errorMessage = "Invalid remarks for reject.";
					return false;
				}
				else
				$response['historyid'] = 15;
			}
		}

		/*** PROCESS ***/
		$connection = \Yii::$app->db;
		$transaction = $connection->beginTransaction();
		try
		{

			//update booking status
			$modelPB = ProspectBookings::findOne($bookingid);

			//get prospect
			$prospect = Prospects::findOne($modelPB->prospect_id);

			if($approve==1)
			$modelPB->status = 12;
			else
			$modelPB->status = 11;
			$modelPB->updatedby = $userid;
			$modelPB->updatedat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
			$modelPB->save();

			if(count($modelPB->errors)!=0)
			throw new ErrorException('Update cancellation status failed.');

			//log prospect history
			$modelLog = new LogProspectHistory();
			$modelLog->project_id = $modelPB->project_id;
			$modelLog->prospect_id = $modelPB->prospect_id;
			$modelLog->prospect_booking_id = $modelPB->id;
			$modelLog->history_id = $response['historyid'];
			$modelLog->remarks = $remarks;
			$modelLog->createdby = $userid;
			$modelLog->createdat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
			$modelLog->save();

			if(count($modelLog->errors)!=0)
			throw new ErrorException('create prospect log failed.');

			//send message to agent
			$mod = Yii::$app->AccessMod;
			if(!$mod->sendMessage($modelPB->dedicated_agent_id,'Prospect Notification for Booking Cancellation Approval (#'.$modelPB->cancel_ref_no.') for prospect '.$prospect->prospect_name,"Prospect(" . $prospect->prospect_name . ") Booking has been ".($approve==1?'approved':'rejected').".".$remarks."."))
			throw new ErrorException($mod->errorMessage);

			//send message to prospect
			if($approve==1)
			{
				$replaceItems = array();
				$modelPBB = ProspectBookingBuyers::find()->where(['prospect_booking_id'=>$modelPB->id])->all();
				$replaceItems['buyer_name'] = $modelPBB[0]->buyer_firstname.' '.$modelPBB[0]->buyer_lastname;
				$replaceItems['project_name'] = $prospect->projects['project_name'];
				$replaceItems['product_unit'] = $modelPB->product_unit;
				$replaceItems['cancel_ref_no'] = $modelPB->cancel_ref_no;
				$emailTemplate = $mod->getMailTemplate('PROSPECT_CANCELLATION_BOOKING');
				
				if(empty($replaceItems['product_unit']))
				$emailTemplate['subject'] = str_replace('[product_unit], ','',$emailTemplate['subject']);
				
				$emailTemplate['subject'] = $mod->multipleReplace($emailTemplate['subject'],$replaceItems);
				$emailTemplate['template'] = $mod->multipleReplace($emailTemplate['template'],$replaceItems);
				if(!$mod->sendEmail(array($_SESSION['settings']['SITE_EMAIL_USERNAME'],$_SESSION['settings']['SITE_NAME']), array($prospect->prospect_email), $emailTemplate['subject'], $emailTemplate['template']))
				throw new ErrorException($mod->errorMessage);
			}

			//commission cancellation
			if($approve==1)
			{
				$commissionMod = Yii::$app->CommissionMod;
				if(!$commissionMod->cancelUserCommissionsByProspectBookingID($modelPB->id))
				throw new ErrorException($commissionMod->errorMessage);
			}
			
			$transaction->commit();
		}
		catch (ErrorException $e) 
		{
			$transaction->rollBack();
			$this->errorMessage = $e->getMessage();
			return false;
		}

		/*** FORMAT RETURN ***/
		return $response;
	}


	public function prospectDropInterest($projectid,$prospectid,$userid,$inputs=array())
	{
		/*** INITIALIZE ***/
		$response = array();
		$response['historyid'] = 18;
		
		/*** VALIDATE ***/
		//validate prospect id
		if(!($prospect = $this->validateProspectID($prospectid,$response['historyid'])))
		return false;
		
		//validate user updating history
		if(!($user = Yii::$app->AccessRule->validateUserID($userid)))
		{
			$this->errorMessage = 'Invalid user access';
			return false;
		}
		
		//validate remarks
		if(empty($inputs['remarks']))
		{
			$this->errorMessage = "Please insert remarks.";
			return false;
		}
		
		/*** PROCESS ***/
		//log prospect history
		$connection = \Yii::$app->db;
		$transaction = $connection->beginTransaction();
		try
		{
			//update prospect
			$model = Prospects::findOne($prospectid);
			$model->status = 3;
			$model->updatedby = $userid;
			$model->updatedat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
			$model->save();

			if(count($model->errors)!=0)
			throw new ErrorException('Update prospect failed.');
						
			//log prospect history
			$modelLog = new LogProspectHistory();
			$modelLog->project_id = $projectid;
			$modelLog->prospect_id = $prospectid;
			$modelLog->history_id = $response['historyid'];
			$modelLog->remarks = $prospect->remarks;
			$modelLog->createdby = $userid;
			$modelLog->createdat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
			$modelLog->save();

			if(count($modelLog->errors)!=0)
			throw new ErrorException('Update prospect log failed.');

			//send message to member
			$sendMessage = Yii::$app->AccessMod;
			if(!$sendMessage->sendMessage($prospect->member_id,'Prospect ' . $prospect->prospect_name .' has drop interest',"Prospect(" . $prospect->prospect_name . ") has drop interest."))
			throw new ErrorException($sendMessage->errorMessage);

			//send message to admin
			$sendMessage = Yii::$app->AccessMod;
			if(!$sendMessage->sendMessage(Yii::$app->AccessMod->getAdminsIDs(),'Prospect ' . $prospect->prospect_name .' has drop interest','Prospect ' . $prospect->prospect_name .' has drop interest','',3))
			throw new ErrorException($sendMessage->errorMessage);

			$transaction->commit();
		}
		catch (ErrorException $e) 
		{
			$transaction->rollBack();
			$this->errorMessage = $e->getMessage();
			return false;
		}

		/*** FORMAT RETURN ***/
		
		return $response;
	}
}
?>