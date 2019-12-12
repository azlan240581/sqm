<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\UserAssociateDetails */

$this->title = 'Associate Name : '.$modelUsers->name;
$this->params['breadcrumbs'][] = 'Associates Management';
$this->params['breadcrumbs'][] = ['label' => 'List', 'url' => ['/associates']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-associate-details-view">

    <p>
    <?php
	if($_SESSION['user']['id']==1 or (in_array('update',$_SESSION['user']['permission'])))
	{
		?>
        <?= Html::a('Update', ['update', 'id' => $modelUserAssociateDetails->id], ['class' => 'btn btn-primary']) ?>
		<?php
	}
	if($_SESSION['user']['id']==1 or (in_array('delete',$_SESSION['user']['permission'])))
	{
		?>
        <?= Html::a('Delete', ['delete', 'id' => $modelUserAssociateDetails->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this associate?',
                'method' => 'post',
            ],
        ]) ?>
		<?php
	}
    ?>
    </p>

    <div class="panel panel-default">
        <div class="panel-body">
            <div class="row bg-dark-grey">
                <div class="col-xs-12"><h4>Associate Account Details</h4></div>
            </div>
			<?= DetailView::widget([
                'model' => $modelUserAssociateDetails,
                'attributes' => [
        
                    [
						'label' => 'Profile Photo',
						'format'=>'raw',
						'value'=> !strlen($modelUsers->avatar)?NULL:Html::a(Html::img($modelUsers->avatar, ['width'=>200]),$modelUsers->avatar, ['data-fancybox'=>true]),
                    ],
                    [
                        'label'=>'Agent',
						'format' => 'raw',
						'value'  => call_user_func(function ($modelUserAssociateDetails) {
							return $modelUserAssociateDetails->agent->name.' ('.Yii::$app->AccessMod->getUserGroupName(Yii::$app->AccessMod->getUserGroupID($modelUserAssociateDetails->agent_id)).')';
						}, $modelUserAssociateDetails),
					],
                    [
                        'label'=>'Referrer',
						'format' => 'raw',
						'value'  => call_user_func(function ($modelUserAssociateDetails) {
							return $modelUserAssociateDetails->referrer_id==NULL?'None':(Yii::$app->AccessMod->getName($modelUserAssociateDetails->referrer_id));
						}, $modelUserAssociateDetails),
					],
                    [
                        'label'=>'Email',
						'format' => 'email',
						'value'  => $modelUsers->email,
					],
                    [
                        'label'=>'First Name',
						'value'  => $modelUsers->firstname,
					],
                    [
                        'label'=>'Last Name',
						'value'  => $modelUsers->lastname,
					],
                    [
                        'label'=>'Contact Number',
						'value'  => $modelUsers->country_code.$modelUsers->contact_number,
					],
                    [
                        'label'=>'Date of Birth',
						'format' => 'date',
						'value'  => $modelUsers->dob,
					],
                    [
                        'label'=>'Gender',
						'value'  => $modelUsers->gender,
					],
                    [
						'label' => 'Productivity Status',
						'value' => $modelUserAssociateDetails->lookupAssociateProductivityStatus->name,
                    ],
					[
						'label' => 'Account Status',
						'format' => 'raw',
						'value'  => call_user_func(function ($modelUsers) {
							if($_SESSION['user']['id']==1 or ($_SESSION['user']['groups']!=NULL and array_intersect(array(1,2),$_SESSION['user']['groups'])))
							return Html::a('<button type="button" class="btn btn-'.($modelUsers->status==1?'success':'danger').' btn-sm"><span class="glyphicon glyphicon-off" style="color:white"></span>&nbsp;&nbsp;&nbsp;'.($modelUsers->status==1?'Active':'Inactive').'</button>', ['toggle-status', 'id' => $modelUsers->id], ['data' => ['confirm' => 'Are you sure you want to '.($modelUsers->status==1?'deactivate':'activate').' this associate account?','method' => 'post','pjax' => 0,],]);
							else
							return '<button type="button" style="cursor:not-allowed;" class="btn btn-'.($modelUsers->status==1?'success':'danger').' btn-sm"><span class="glyphicon glyphicon-off" style="color:white"></span>&nbsp;&nbsp;&nbsp;'.($modelUsers->status==1?'Active':'Inactive').'</button>';
							}, $modelUsers),
					],
                    [
                        'label'=>'Last Login At',
                        'format'=>'datetime',
                        'value' => $modelUsers->lastloginat,
                    ],
                    [
                        'label'=>'Created by',
                        'value' => Yii::$app->AccessMod->getName($modelUsers->createdby),
                    ],
                    [
                        'label'=>'Created At',
                        'format'=>'datetime',
                        'value' => $modelUsers->createdat,
                    ],
                    [
						'label'=>'Updated by',
						'value' => Yii::$app->AccessMod->getUsername($modelUsers->updatedby),
                    ],
                    [
                        'label'=>'Updated At',
                        'format'=>'datetime',
                        'value' => $modelUsers->updatedat,
                    ],
                ],
            ]) ?>
            
            <?php
			if($modelUserAssociateDetails->approval_status==1)
			{
				$btn = 'btn-warning';
				$cursor = 'style="cursor:not-allowed;"';
				$icon = 'time';
				$statusName = 'Pending';
				$action = NULL;
				$name = 'Pending associate to complete verification details.';
			}
			elseif($modelUserAssociateDetails->approval_status==2)
			{
				$btn = 'btn-warning';
				$cursor = 'style="cursor:not-allowed;"';
				$icon = 'refresh';
				$statusName = 'Processing';
				$action = NULL;
				
				if($_SESSION['user']['id']==1)
				{
					$action = ['set-approval', 'id' => $modelUserAssociateDetails->id];
					$cursor = '';
				}
				elseif($_SESSION['user']['groups']!=NULL and array_intersect(array(1,2),$_SESSION['user']['groups'])and $modelUserAssociateDetails->agent_approval==1 and $modelUserAssociateDetails->admin_approval==0)
				{
					$action = ['set-approval', 'id' => $modelUserAssociateDetails->id];
					$cursor = '';
				}
				
				if($modelUserAssociateDetails->agent_approval==0)
				$name = 'Pending approval from agent';
				elseif($modelUserAssociateDetails->agent_approval==1 and $modelUserAssociateDetails->admin_approval==0)
				$name = 'Pending approval from admin';
			}
			elseif($modelUserAssociateDetails->approval_status==3)
			{
				$btn = 'btn-danger';
				$cursor = '';
				$icon = 'remove';
				$statusName = 'Rejected';
				$action = NULL;
				$name = '';
			}
			elseif($modelUserAssociateDetails->approval_status==4)
			{
				$btn = 'btn-success';
				$cursor = '';
				$icon = 'ok';
				$statusName = 'Approved';
				$action = NULL;
				$name = '';
			}
			
			$approval_status = Html::a('<button type="button" class="btn '.$btn.' btn-sm" '.$cursor.'><span class="glyphicon glyphicon-'.$icon.'" style="color:white"></span>&nbsp;&nbsp;&nbsp;'.$statusName.'</button>', $action);
			if(strlen($name))
			{
				$approval_status .= '<br>';
				$approval_status .= $name;
			}
            ?>
            <div class="row bg-dark-grey">
                <div class="col-xs-12"><h4>Associate Verification Data</h4></div>
            </div>
            <?= DetailView::widget([
                'model' => $modelUserAssociateDetails,
                'attributes' => [
                    [
						'label' => 'Approval Status',
						'format' => 'raw',
						'value' => $approval_status,
                    ],
					[
                        'label'=>'Address 1',
						'value'  => $modelUsers->address_1,
					],
                    [
                        'label'=>'Address 2',
						'value'  => $modelUsers->address_2,
					],
                    [
                        'label'=>'Address 3',
						'value'  => $modelUsers->address_3,
					],
                    [
                        'label'=>'City',
						'value'  => $modelUsers->city,
					],
                    [
                        'label'=>'Zipcode',
						'value'  => $modelUsers->postcode,
					],
                    [
                        'label'=>'State',
						'value'  => $modelUsers->state,
					],
                    [
                        'label'=>'Country',
						'value'  => $modelUsers->country==NULL?NULL:$modelUsers->lookupCountry->name,
					],
					[
						'label' => 'Bank',
						'value' => $modelUserAssociateDetails->bank_id==NULL?NULL:$modelUserAssociateDetails->lookupBank->name,
                    ],
					[
						'label' => 'Account Name',
						'value' => $modelUserAssociateDetails->account_name,
                    ],
					[
						'label' => 'Account Number',
						'value' => $modelUserAssociateDetails->account_number,
                    ],
					[
						'label' => 'Domicile',
						'value' => $modelUserAssociateDetails->domicile==NULL?NULL:$modelUserAssociateDetails->lookupDomicile->name,
                    ],
                    [
						'label' => 'Occupation',
						'value' => $modelUserAssociateDetails->occupation==NULL?NULL:$modelUserAssociateDetails->lookupOccupation->name,
                    ],
                    [
						'label' => 'Industry Background',
						'value' => $modelUserAssociateDetails->industry_background==NULL?NULL:$modelUserAssociateDetails->lookupIndustryBackground->name,
                    ],
                    [
						'attribute' => 'nricpass',
						'format'=>'raw',
						'value'=> !strlen($modelUserAssociateDetails->nricpass)?NULL:Html::a(Html::img($modelUserAssociateDetails->nricpass, ['width'=>200]),$modelUserAssociateDetails->nricpass, ['data-fancybox'=>true]),
                    ],
                    [
						'attribute' => 'tax_license',
						'format'=>'raw',
						'value'=> !strlen($modelUserAssociateDetails->tax_license)?NULL:Html::a(Html::img($modelUserAssociateDetails->tax_license, ['width'=>200]),$modelUserAssociateDetails->tax_license, ['data-fancybox'=>true]),
                    ],
                    [
						'attribute' => 'bank_account',
						'format'=>'raw',
						'value'=> !strlen($modelUserAssociateDetails->bank_account)?NULL:Html::a(Html::img($modelUserAssociateDetails->bank_account, ['width'=>200]),$modelUserAssociateDetails->bank_account, ['data-fancybox'=>true]),
                    ],
                    [
						'attribute' => 'udf1',
						'format'=>'raw',
						'value'=> !strlen($modelUserAssociateDetails->udf1)?NULL:Html::a(Html::img($modelUserAssociateDetails->udf1, ['width'=>200]),$modelUserAssociateDetails->udf1, ['data-fancybox'=>true]),
                    ],
                    //'udf2',
                    //'udf3',
                    //'udf4',
                    //'udf5',
                ],
            ]) ?>
        </div>
    </div>
    
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.6/dist/jquery.fancybox.min.css" />
<script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.6/dist/jquery.fancybox.min.js"></script>
</div>
