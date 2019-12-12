<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model app\models\UserRewardRedemptions */

$this->title = $model->associateFirstName->firstname.' '.$model->associateFirstName->lastname.' : '.$model->reward->name;
$this->params['breadcrumbs'][] = 'Points Management';
$this->params['breadcrumbs'][] = ['label' => 'Associate Redemptions List', 'url' => ['/user-reward-redemptions']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-reward-redemptions-view">

    <p>
	<?php
	if($model->status==1)
	{
		?>
        <?= Html::a('Approve', ['approve', 'id' => $model->id, 'ajaxView' => ''], ['class' => 'btn btn-primary modal-button-01']) ?>
        <?= Html::a('Cancel', ['cancel', 'id' => $model->id, 'ajaxView' => ''], ['class' => 'btn btn-danger modal-button-02']) ?>
		<?php
    }
	if($model->status==2)
	{
		?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        <?php
	}
	?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
		
			[
				'label'=>'Reward Name',
				'value'=>$model->reward->name,
			],
            'receiver_name',
            'receiver_email:email',
            'receiver_country_code',
            'receiver_contact_no',
            'address_1',
            'address_2',
            'address_3',
            'city',
            'postcode',
            'state',
			[
				'label'=>$model->getAttributeLabel('country'),
				'value'=>$model->lookupCountry->name,
			],
            'courier_name',
            'tracking_number',
            'quantity',
			[
				'label'=>$model->getAttributeLabel('points_value'),
				'value'=>Yii::$app->AccessMod->getPointsFormat($model->points_value),
			],
			[
				'label'=>$model->getAttributeLabel('status'),
				'value'=>$model->lookupRedemptionStatus->name,
			],
			[
				'label'=>$model->getAttributeLabel('createdby'),
				'value'=>Yii::$app->AccessMod->getName($model->createdby),
			],
            'createdat:datetime',
			[
				'label'=>$model->getAttributeLabel('updatedby'),
				'value'=>Yii::$app->AccessMod->getName($model->updatedby),
			],
            'updatedat:datetime',
			
        ],
    ]) ?>

   <?php
	Modal::begin([
		'header' => '<h4>Approve Redemption</h4>',
		'id' => 'modal-id-01',
		'size' => 'modal-lg',
		'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
		]);
	echo '<div id="modal-content-01"></div>';
	Modal::end();
   ?>

   <?php
	Modal::begin([
		'header' => '<h4>Cancel Redemption</h4>',
		'id' => 'modal-id-02',
		'size' => 'modal-lg',
		'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
		]);
	echo '<div id="modal-content-02"></div>';
	Modal::end();
   ?>

</div>
