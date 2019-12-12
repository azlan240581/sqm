<?php

namespace app\controllers;

use Yii;
use app\models\CommissionGroupTiers;
use app\models\CommissionGroupTiersSearch;
use app\models\LookupProductType;
use app\models\LookupCommissionGroup;
use app\models\LookupCommissionTier;
use app\models\LookupCommissionType;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\base\ErrorException;
use yii\filters\VerbFilter;
use yii\helpers\Html;

/**
 * CommissionController implements the CRUD actions for Commission model.
 */
class CommissionGroupTiersController extends Controller
{
	public function init()
	{
		$this->defaultAction = Yii::$app->AccessRule->get_default_action_by_controller($this->id);
	}

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new CommissionGroupTiersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

		//get product Type
		$productTypeList = LookupProductType::find()->where(array('deleted'=>0))->asArray()->all();
		//get commission group
		$commissionGroupList = LookupCommissionGroup::find()->where(array('deleted'=>0))->asArray()->all();
		//get commission group
		$commissionTierList = LookupCommissionTier::find()->where(array('deleted'=>0))->asArray()->all();
		//get commission group
		$commissionTypeList = LookupCommissionType::find()->where(array('deleted'=>0))->asArray()->all();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'productTypeList' => $productTypeList,
            'commissionGroupList' => $commissionGroupList,
            'commissionTierList' => $commissionTierList,
            'commissionTypeList' => $commissionTypeList,
        ]);
    }

	public function actionIndexAdmin()
	{
		$model = new CommissionGroupTiers();
		//get commission group tiers
		$commissionGroupTierArray = CommissionGroupTiers::find()->asArray()->all();
		foreach($commissionGroupTierArray as $key=>$value)
		{
			$commissionGroupTierList[$value['product_type_id']][$value['commission_group_id']][$value['commission_tier_id']]['minimum_transaction_value'] = $value['minimum_transaction_value'];
			$commissionGroupTierList[$value['product_type_id']][$value['commission_group_id']][$value['commission_tier_id']]['maximum_transaction_value'] = $value['maximum_transaction_value'];
			$commissionGroupTierList[$value['product_type_id']][$value['commission_group_id']][$value['commission_tier_id']]['commission_type'] = $value['commission_type'];
			$commissionGroupTierList[$value['product_type_id']][$value['commission_group_id']][$value['commission_tier_id']]['commission_value'] = $value['commission_value'];
			$commissionGroupTierList[$value['product_type_id']][$value['commission_group_id']][$value['commission_tier_id']]['expiration_period'] = $value['expiration_period'];
		}
		
		//get lookup data
		$productTypeList = LookupProductType::find()->where(array('deleted'=>0))->asArray()->all();
		$commissionGroupList = LookupCommissionGroup::find()->where(array('deleted'=>0))->asArray()->all();
		$commissionTierList = LookupCommissionTier::find()->where(array('deleted'=>0))->asArray()->all();
		$commissionTypeList = LookupCommissionType::find()->where(array('deleted'=>0))->asArray()->all();
		
		/*echo '<pre>';
		print_r($commissionGroupTierList);
		echo '</pre>';
		exit();*/
		
		if(count($_POST)!=0)
		{
			/*echo '<pre>';
			print_r($_POST);
			echo '</pre>';
			exit();*/
			
			//process
			$error = '';
			$connection = Yii::$app->db;
			$transaction = $connection->beginTransaction();
			try 
			{
				$commissionGroupTierList = array();
				$commissionGroupTierList = $_POST['CommissionGroupTiers'];
				
				foreach($_POST['CommissionGroupTiers'] as $product_type_id=>$array1)
				{
					foreach($array1 as $commission_group_id=>$array2)
					{
						foreach($array2 as $commission_tier_id=>$array3)
						{
							$modelCommissionGroupTiers = CommissionGroupTiers::find()->where(array('product_type_id'=>$product_type_id,'commission_group_id'=>$commission_group_id,'commission_tier_id'=>$commission_tier_id))->one();
							$modelCommissionGroupTiers->minimum_transaction_value = $array3['minimum_transaction_value'];
							$modelCommissionGroupTiers->maximum_transaction_value = $array3['maximum_transaction_value'];
							$modelCommissionGroupTiers->commission_type = $array3['commission_type'];
							$modelCommissionGroupTiers->commission_value = $array3['commission_value'];
							//$modelCommissionGroupTiers->expiration_period = $array3['expiration_period'];
							$modelCommissionGroupTiers->updatedby = $_SESSION['user']['id'];
							$modelCommissionGroupTiers->updatedat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
							$modelCommissionGroupTiers->save();
							if(count($modelCommissionGroupTiers->errors)!=0)
							{
								throw new ErrorException("Update commisison tiers failed.");
								break;
							}
						}
					}
				}

				$transaction->commit();
			}
			catch (ErrorException $e) 
			{
				$transaction->rollBack();
				$error = $e->getMessage();
				Yii::$app->session->set('errorMessage', $error);
			}
			
			if(!strlen($error))
			{
				$GLOBALS['successMessage'] = 'Update commission success!';
				//return $this->redirect(['index-admin']);
			}
		}
		
        return $this->render('index-admin', [
            'model' => $model,
            'commissionGroupTierList' => $commissionGroupTierList,
            'productTypeList' => $productTypeList,
            'commissionGroupList' => $commissionGroupList,
            'commissionTierList' => $commissionTierList,
            'commissionTypeList' => $commissionTypeList,
        ]);
	}

    public function actionView($id)
    {
		$model = $this->findModel($id);
		
		//get product type
		$productTypeList = LookupProductType::find()->where(array('deleted'=>0))->asArray()->all();
		//get commission group
		$commissionGroupList = LookupCommissionGroup::find()->where(array('deleted'=>0))->asArray()->all();
		//get commission group
		$commissionTierList = LookupCommissionTier::find()->where(array('deleted'=>0))->asArray()->all();
		//get commission group
		$commissionTypeList = LookupCommissionType::find()->where(array('deleted'=>0))->asArray()->all();
		foreach($commissionTypeList as $type)
		{
			$commissionType[$type['id']] = $type['name'];
		}
		
		$commissionArray = CommissionGroupTiers::find()->where(array('product_type_id'=>$model->product_type_id,'commission_group_id'=>$model->commission_group_id))->asArray()->all();
		foreach($commissionArray as $commission)
		{
			$commissionList[$commission['commission_tier_id']]['minimum_transaction_value'] = $commission['minimum_transaction_value'];
			$commissionList[$commission['commission_tier_id']]['maximum_transaction_value'] = $commission['maximum_transaction_value'];
			$commissionList[$commission['commission_tier_id']]['commission_type'] = $commission['commission_type'];
			$commissionList[$commission['commission_tier_id']]['commission_value'] = $commission['commission_value'];
			$commissionList[$commission['commission_tier_id']]['expiration_period'] = $commission['expiration_period'];
		}
		
        return $this->render('view', [
            'model' => $model,
            'productTypeList' => $productTypeList,
            'commissionTierList' => $commissionTierList,
            'commissionType' => $commissionType,
            'commissionList' => $commissionList,
        ]);
    }

    public function actionCreate()
    {
        $model = new CommissionGroupTiers();
		$modelLookupProductType = new LookupProductType();
		$modelLookupCommissionGroup = new LookupCommissionGroup();
		$modelLookupCommissionTier = new LookupCommissionTier();
		$modelLookupCommissionType = new LookupCommissionType();

		//get product type
		$productTypeList = LookupProductType::find()->where(array('deleted'=>0))->asArray()->all();
		//get commission group
		$commissionGroupList = LookupCommissionGroup::find()->where(array('deleted'=>0))->asArray()->all();
		//get commission tier
		$commissionTierList = LookupCommissionTier::find()->where(array('deleted'=>0))->asArray()->all();
		//get commission type
		$commissionTypeList = LookupCommissionType::find()->where(array('deleted'=>0))->asArray()->all();

        if(count($_POST)!=0)
		{
			$model->load(Yii::$app->request->post());
			
			//process
			$error = '';
			$connection = Yii::$app->db;
			$transaction = $connection->beginTransaction();
			try 
			{
				//check group exist
				$commissionGroupTiers = CommissionGroupTiers::find()->where(array('product_type_id'=>$_POST['CommissionGroupTiers']['product_type_id'],'commission_group_id'=>$_POST['CommissionGroupTiers']['commission_group_id']))->all();
				if($commissionGroupTiers!=NULL)
				throw new ErrorException("Commisison group already created.");
				
				foreach($commissionTierList as $tier)
				{
					$model = new CommissionGroupTiers();
					$model->product_type_id = $_POST['CommissionGroupTiers']['product_type_id'];
					$model->commission_group_id = $_POST['CommissionGroupTiers']['commission_group_id'];
					$model->commission_tier_id = $tier['id'];
					$model->minimum_transaction_value = $_POST['CommissionGroupTiers']['minimum_transaction_value'][$tier['id']];
					$model->maximum_transaction_value = $_POST['CommissionGroupTiers']['maximum_transaction_value'][$tier['id']];
					$model->commission_type = $_POST['CommissionGroupTiers']['commission_type'][$tier['id']];
					$model->commission_value = $_POST['CommissionGroupTiers']['commission_value'][$tier['id']];
					$model->expiration_period = $_POST['CommissionGroupTiers']['expiration_period'][$tier['id']];
					$model->createdby = $_SESSION['user']['id'];
					$model->createdat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
					$model->save();
					if(count($model->errors)!=0)
					{
						throw new ErrorException("Create commisison tier ".$tier['name']." failed.");
						break;
					}
				}
				
				$transaction->commit();
			}
			catch (ErrorException $e) 
			{
				$transaction->rollBack();
				$error = $e->getMessage();
				Yii::$app->session->set('errorMessage', $error);
			}
			
			if(!strlen($error))
			return $this->redirect(['view', 'id' => $model->id]);
        }
		
		return $this->render('create', [
			'model' => $model,
			'productTypeList' => $productTypeList,
			'commissionGroupList' => $commissionGroupList,
			'commissionTierList' => $commissionTierList,
			'commissionTypeList' => $commissionTypeList,
		]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
		$modelLookupCommissionGroup = new LookupCommissionGroup();
		$modelLookupCommissionTier = new LookupCommissionTier();
		$modelLookupCommissionType = new LookupCommissionType();
		$modelLookupCommissionType = new LookupCommissionType();

		//$model = new Commission();
		$commissionArray = CommissionGroupTiers::find()->where(array('product_type_id'=>$model->product_type_id,'commission_group_id'=>$model->commission_group_id))->asArray()->all();
		foreach($commissionArray as $commission)
		{
			$minimum_transaction_value[$commission['commission_tier_id']] = $commission['minimum_transaction_value'];
			$maximum_transaction_value[$commission['commission_tier_id']] = $commission['maximum_transaction_value'];
			$commission_type[$commission['commission_tier_id']] = $commission['commission_type'];
			$commission_value[$commission['commission_tier_id']] = $commission['commission_value'];
			$expiration_period[$commission['commission_tier_id']] = $commission['expiration_period'];
		}
		$model->minimum_transaction_value = $minimum_transaction_value;
		$model->maximum_transaction_value = $maximum_transaction_value;
		$model->commission_type = $commission_type;
		$model->commission_value = $commission_value;
		$model->expiration_period = $expiration_period;
			
		//get product type
		$productTypeList = LookupProductType::find()->where(array('deleted'=>0))->asArray()->all();
		//get commission group
		$commissionGroupList = LookupCommissionGroup::find()->where(array('deleted'=>0))->asArray()->all();
		//get commission group
		$commissionTierList = LookupCommissionTier::find()->where(array('deleted'=>0))->asArray()->all();
		//get commission group
		$commissionTypeList = LookupCommissionType::find()->where(array('deleted'=>0))->asArray()->all();
       
        if(count($_POST)!=0)
		{
			//$modelCommissionGroupTiers->load(Yii::$app->request->post());
			//process
			$error = '';
			$connection = Yii::$app->db;
			$transaction = $connection->beginTransaction();
			try 
			{
				foreach($commissionTierList as $tier)
				{
					$modelCommissionGroupTiers = CommissionGroupTiers::find()->where(array('product_type_id'=>$model->product_type_id,'commission_group_id'=>$model->commission_group_id,'commission_tier_id'=>$tier['id']))->one();
					$modelCommissionGroupTiers->minimum_transaction_value = $_POST['CommissionGroupTiers']['minimum_transaction_value'][$tier['id']];
					$modelCommissionGroupTiers->maximum_transaction_value = $_POST['CommissionGroupTiers']['maximum_transaction_value'][$tier['id']];
					$modelCommissionGroupTiers->commission_type = $_POST['CommissionGroupTiers']['commission_type'][$tier['id']];
					$modelCommissionGroupTiers->commission_value = $_POST['CommissionGroupTiers']['commission_value'][$tier['id']];
					$modelCommissionGroupTiers->expiration_period = $_POST['CommissionGroupTiers']['expiration_period'][$tier['id']];
					$modelCommissionGroupTiers->updatedby = $_SESSION['user']['id'];
					$modelCommissionGroupTiers->updatedat = Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i:s');
					$modelCommissionGroupTiers->save();
					if(count($modelCommissionGroupTiers->errors)!=0)
					{
						throw new ErrorException("Update commisison tier ".$tier['name']." failed.");
						break;
					}
				}
				
				$transaction->commit();
			}
			catch (ErrorException $e) 
			{
				$transaction->rollBack();
				$error = $e->getMessage();
				Yii::$app->session->set('errorMessage', $error);
			}
			
			if(!strlen($error))
			return $this->redirect(['view', 'id' => $model->id]);
        }
		
		return $this->render('update', [
			'model' => $model,
			'productTypeList' => $productTypeList,
			'commissionGroupList' => $commissionGroupList,
			'commissionTierList' => $commissionTierList,
			'commissionTypeList' => $commissionTypeList,
		]);
    }

    public function actionDelete($id)
    {
		$model = $this->findModel($id);
		$commission_group_id = $model->commission_group_id;
		CommissionGroupTiers::deleteAll(array('commission_group_id' => $commission_group_id));

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = CommissionGroupTiers::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
