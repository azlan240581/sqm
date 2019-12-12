<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Users */

$this->title = $model->name;
$this->params['breadcrumbs'][] = 'User Management';
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['/users']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-view">
    <p>
        <?= Html::a('Edit', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        
        <?php echo $_GET['id']!=1?Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
				],
			]):'';
		?>
    </p>


    <div class="row bg-dark-grey">
        <div class="col-xs-12"><h4>User Account Details</h4></div>
    </div>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
			/*[
				'label'=>'System Avatar',
				'format'=>'raw',
				'value'=> !strlen($model->avatar_id)?NULL:Html::a(Html::img($model->getUserAvatarImage($model->avatar_id), ['width'=>200]),$model->getUserAvatarImage($model->avatar_id), ['data-fancybox'=>true]),
			],*/
			[
				'label' => 'Avatar',
				'format'=>'raw',
				'value'=> !strlen($model->avatar)?Html::a(Html::img($model->getUserAvatarImage($model->avatar_id), ['width'=>200]),$model->getUserAvatarImage($model->avatar_id), ['data-fancybox'=>true]):Html::a(Html::img($model->avatar, ['width'=>200]),$model->avatar, ['data-fancybox'=>true]),
			],
			[
				'label'=>'System Group',
				'attribute' => 'groupAccess.group_access_name',
			],
			/*[
				'label'=>'QRCode(UUID)',
				'value' => Yii::$app->AccessMod->showQRcode('user',$model->uuid).'<br>'.$model->uuid,
				'format'=>'html',
			],*/
            'username',
            'email:email',
			'firstname',
			'lastname',
            'country_code',
            'contact_number',
			[
				'label'=>'Project Handled',
				'visible'=>count($modelProjectAgents)!=0?true:false,
				'format' => 'raw',
				'value'  => call_user_func(function ($modelProjectAgents) {
					if(count($modelProjectAgents)!=0)
					{
						$tmp = '';
						$i=1;
						foreach($modelProjectAgents as $value)
						{
							$tmp .= Yii::$app->GeneralMod->getProjectName($value['project_id']);
							$tmp .= '<br>';
							$i++;
						}
						$tmp .= '';
						return $tmp;
					}
					else
					return NULL;
				}, $modelProjectAgents),
			],
            'address_1',
            'address_2',
            'address_3',
            'city',
            'postcode',
            'state',
			[
				'label'=>'Country',
				'attribute' => 'lookupCountry.name',
			],
			[
				'label'=>'Profile Description',
				'format'=>'raw',
				'value' => html_entity_decode($model->profile_description),
			],
			/*[
				'label'=>'Position',
				'attribute' => 'lookupPosition.name',
			],*/
			[
				'label'=>'Status',
				'value' => $model->status==1? 'Active':'Inactive',
			],
            'lastloginat:datetime',
			[
				'label'=>'Created by',
				'value' => $model->getUsername($model->createdby),
			],
            'createdat:datetime',
			[
				'label'=>'Updated by',
				'value' => $model->getUsername($model->updatedby),
			],
            'updatedat:datetime',
        ],
    ]) ?>
    
    <?php
	if($modelUserAssociateBrokerDetails!=NULL)
	{
		?>
		<div class="row bg-dark-grey">
			<div class="col-xs-12"><h4>User Account Details</h4></div>
		</div>

		<?= DetailView::widget([
            'model' => $modelUserAssociateBrokerDetails,
            'attributes' => [
			
				'company_name',
				'brand_name',
				[
					'label'=>$modelUserAssociateBrokerDetails->getAttributeLabel('credits'),
					'value'=> Yii::$app->AccessMod->getPointsFormat($modelUserAssociateBrokerDetails->credits),
				],
				[
					'label'=>$modelUserAssociateBrokerDetails->getAttributeLabel('akta_perusahaan'),
					'format'=>'raw',
					'value'=> !strlen($modelUserAssociateBrokerDetails->akta_perusahaan)?NULL:Html::a(Html::img($modelUserAssociateBrokerDetails->akta_perusahaan, ['width'=>200]),$modelUserAssociateBrokerDetails->akta_perusahaan, ['data-fancybox'=>true]),
				],
				[
					'label'=>$modelUserAssociateBrokerDetails->getAttributeLabel('nib'),
					'format'=>'raw',
					'value'=> !strlen($modelUserAssociateBrokerDetails->nib)?NULL:Html::a(Html::img($modelUserAssociateBrokerDetails->nib, ['width'=>200]),$modelUserAssociateBrokerDetails->nib, ['data-fancybox'=>true]),
				],
				[
					'label'=>$modelUserAssociateBrokerDetails->getAttributeLabel('sk_menkeh'),
					'format'=>'raw',
					'value'=> !strlen($modelUserAssociateBrokerDetails->sk_menkeh)?NULL:Html::a(Html::img($modelUserAssociateBrokerDetails->sk_menkeh, ['width'=>200]),$modelUserAssociateBrokerDetails->sk_menkeh, ['data-fancybox'=>true]),
				],
				[
					'label'=>$modelUserAssociateBrokerDetails->getAttributeLabel('npwp'),
					'format'=>'raw',
					'value'=> !strlen($modelUserAssociateBrokerDetails->npwp)?NULL:Html::a(Html::img($modelUserAssociateBrokerDetails->npwp, ['width'=>200]),$modelUserAssociateBrokerDetails->npwp, ['data-fancybox'=>true]),
				],
				[
					'label'=>$modelUserAssociateBrokerDetails->getAttributeLabel('ktp_direktur'),
					'format'=>'raw',
					'value'=> !strlen($modelUserAssociateBrokerDetails->ktp_direktur)?NULL:Html::a(Html::img($modelUserAssociateBrokerDetails->ktp_direktur, ['width'=>200]),$modelUserAssociateBrokerDetails->ktp_direktur, ['data-fancybox'=>true]),
				],
				[
					'label'=>$modelUserAssociateBrokerDetails->getAttributeLabel('bank_account'),
					'format'=>'raw',
					'value'=> !strlen($modelUserAssociateBrokerDetails->bank_account)?NULL:Html::a(Html::img($modelUserAssociateBrokerDetails->bank_account, ['width'=>200]),$modelUserAssociateBrokerDetails->bank_account, ['data-fancybox'=>true]),
				],
			
            ],
        ]) ?>


		<?php
	}
	?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.6/dist/jquery.fancybox.min.css" />
<script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.6/dist/jquery.fancybox.min.js"></script>
</div>
