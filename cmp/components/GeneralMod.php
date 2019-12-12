<?php
namespace app\components;

use Yii;
use yii\helpers\Html;
use yii\base\ErrorException;

use app\models\Projects;
use app\models\Developers;
use app\models\UserAssociateDetails;
use app\models\ProjectProducts;
use app\models\ProjectProductUnitTypes;

use app\models\DashboardUser;

class GeneralMod extends \yii\base\Component{

	public $errorMessage;

    public function init() {
        parent::init();
    }
	
    public function getMemberAgentID($member_id)
    {
		$member = UserAssociateDetails::find()->where(array('user_id'=>$member_id))->one();
		if($member == NULL)
        {
			$this->errorMessage = 'Invalid member id';
			return false;
		}
		else
		return strlen($member->agent_id)?$member->agent_id:NULL;
    }

    public function getMemberReferrerID($member_id)
    {
		$member = UserAssociateDetails::find()->where(array('user_id'=>$member_id))->one();
		if($member == NULL)
        {
			$this->errorMessage = 'Invalid member id';
			return false;
		}
		else
		return strlen($member->referrer_id)?$member->referrer_id:NULL;
    }
	
    public function getDeveloperID($project_id)
    {
		$project = Projects::find()->where(array('id'=>$project_id))->one();
		if($project == NULL)
        {
			$this->errorMessage = 'Invalid project id';
			return false;
		}
		else
		return $project->developer_id;
    }
	
    public function getProjectProductsByProjectID($project_id=array())
    {
		$records = ProjectProducts::find()->where(array('project_id'=>$project_id))->asArray()->all();
		if($records == NULL)
		return array();
		else
		return $records;
    }
	
    public function getUnitTypesByProductID($product_id=array())
    {
		$records = ProjectProductUnitTypes::find()->where(array('project_product_id'=>$product_id))->asArray()->all();
		if($records == NULL)
		return array();
		else
		return $records;
    }

	public function getProjectName($project_id)
	{
		$project = Projects::find()->where(array('id'=>$project_id))->one();
		if($project == NULL)
        {
			$this->errorMessage = 'Invalid project id';
			return false;
		}
		else
		return $project->project_name;
	}
	
	public function getDeveloperName($developer_id)
	{
		$developer = Developers::find()->where(array('id'=>$developer_id))->one();
		if($developer == NULL)
        {
			$this->errorMessage = 'Invalid developer id';
			return false;
		}
		else
		return $developer->company_name;
	}
	
	public function calculateUserTotalPoints($user_id)
	{
		$sql = "SELECT SUM(lp.points_value) ";
		$sql .= "FROM log_points lp ";
		$sql .= "WHERE lp.user_id = '".$user_id."' ";
		$sql .= "AND lp.points_action_id IN (1,3,4,6,7,10,11,12) ";
		$sql .= "AND lp.user_id=u.id";
		$connection = Yii::$app->getDb();
		$query = $connection->createCommand($sql);
		$result = $query->queryAll();
		
		return $result;
	}

	public function getProjectList($id=array())
	{
		$sql = "SELECT p.id, p.project_name, p.project_description, p.developer_id FROM projects p ";
		$sql .= "WHERE p.status=1 ";
		if(!empty($id['project_id']))
		$sql .= "AND p.id IN (".implode(',',$id['project_id']).") ";
		if(!empty($id['developer_id']))
		$sql .= "AND p.developer_id IN (".implode(',',$id['developer_id']).") ";
		$sql .= "AND p.deletedby IS NULL AND p.deletedat IS NULL ";
		$sql .= "ORDER BY p.project_name ASC;";
		
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

	public function getProjectProducts($project_id)
	{
		$sql = "SELECT p.id, p.product_name, p.product_type_id, t.name as product_type_name  ";
		$sql .= "FROM project_products p, lookup_property_product_types t ";
		$sql .= "WHERE 0=0 ";
		$sql .= "AND p.product_type_id = t.id ";
		if(!empty($project_id))
		$sql .= "AND p.project_id = '".$project_id."' ";
		$sql .= "AND p.deletedby IS NULL AND p.deletedat IS NULL ";
		$sql .= "ORDER BY p.product_name ASC;";
		
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

	public function getProjectProductUnitTypes($product_id)
	{
		$sql = "SELECT p.id, p.type_name, p.building_size_sm, p.land_size_sm  ";
		$sql .= "FROM project_product_unit_types p ";
		$sql .= "WHERE 0=0 ";
		if(!empty($product_id))
		$sql .= "AND p.project_product_id = '".$product_id."' ";
		$sql .= "AND p.deletedby IS NULL AND p.deletedat IS NULL ";
		$sql .= "ORDER BY p.type_name ASC;";
		
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
	
	public function getTotalMemberStatus($user_id='')
	{
		$modelDashboardUser = new DashboardUser();
		
		if(!empty($user_id))
		{
			$modelDashboardUser = DashboardUser::find()->where(array('user_id'=>$user_id))->one();
			if($modelDashboardUser==NULL)
			{
				$modelDashboardUser = new DashboardUser();
				$modelDashboardUser->user_id = $user_id;
				$modelDashboardUser->save();
			}
		}
		
		$sql = "SELECT sum(total_normal) as normal, sum(total_active) as active, sum(total_productive) as productive ";
		$sql .= "FROM dashboard_user ";
		$sql .= "WHERE 0=0 ";
		if(!empty($user_id))
		$sql .= "AND user_id = '".$user_id."' ";
		$connection = Yii::$app->getDb();
		$query = $connection->createCommand($sql);
		$records = $query->queryOne();
		
		if(count($records)==0)
		{
			$this->errorMessage = 'Records not found.';
			return false;
		}
		else
		return $records;
	}
	
	public function getTotalProspectStatus($user_id='')
	{
		$modelDashboardUser = new DashboardUser();
		
		if(!empty($user_id))
		{
			$modelDashboardUser = DashboardUser::find()->where(array('user_id'=>$user_id))->one();
			if($modelDashboardUser==NULL)
			{
				$modelDashboardUser = new DashboardUser();
				$modelDashboardUser->user_id = $user_id;
				$modelDashboardUser->save();
			}
		}
		
		$sql = "SELECT sum(total_new_prospect_registered) as new_prospect_registered, sum(total_follow_up) as follow_up, sum(total_appointment_scheduled) as appointment_scheduled, sum(total_level_of_interest) as level_of_interest, sum(total_waiting_booking_eoi_approval) as waiting_booking_eoi_approval, ";
		$sql .= "sum(total_eoi_rejected) as eoi_rejected, sum(total_eoi_verified) as eoi_verified, sum(total_waiting_booking_approval) as waiting_booking_approval, sum(total_booking_rejected) as booking_rejected, sum(total_booking_approved) as booking_approved, ";
		$sql .= "sum(total_waiting_booking_contract_signed_approval) as waiting_booking_contract_signed_approval, sum(total_contract_signed_rejected) as contract_signed_rejected, sum(total_contract_signed_approved) as contract_signed_approved, sum(total_waiting_cancel_approved) as waiting_cancel_approved, sum(total_cancel_rejected) as cancel_rejected, ";
		$sql .= "sum(total_cancel_approved) as cancel_approved, sum(total_completed) as completed, sum(total_drop) as drop_interest ";
		$sql .= "FROM dashboard_user ";
		$sql .= "WHERE 0=0 ";
		if(!empty($user_id))
		$sql .= "AND user_id = '".$user_id."' ";
		$connection = Yii::$app->getDb();
		$query = $connection->createCommand($sql);
		$records = $query->queryOne();
		
		if(count($records)==0)
		{
			$this->errorMessage = 'Records not found.';
			return false;
		}
		else
		return $records;
	}
	
	
}
?>