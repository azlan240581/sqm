<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use kartik\daterange\DateRangePicker;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CommissionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = 'Commission Tiers Manager';
$this->params['breadcrumbs'][] = 'Commission Management';
$this->params['breadcrumbs'][] = ['label' => 'Commission Tiers Manager', 'url' => ['/commission-group-tiers']];
?>
<div class="commission-index">
    <p>
        <?php 
		if($_SESSION['user']['id']==1)
		echo Html::a('Create Commission Group Tier', ['create'], ['class' => 'btn btn-success'])
		?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

			[
				'attribute' => 'lookupProductType',
				'filter'=>ArrayHelper::map($productTypeList, 'name', 'name'),
				'label' => 'Product Type',
				'value' => function($model){
						return $model->lookupProductType->name;
					},
			],
			[
				'attribute' => 'lookupCommissionGroup',
				'filter'=>ArrayHelper::map($commissionGroupList, 'name', 'name'),
				'label' => 'Group',
				'value' => function($model){
						return $model->lookupCommissionGroup->name;
					},
			],
			[
				'attribute' => 'lookupCommissionTier',
				'filter'=>ArrayHelper::map($commissionTierList, 'name', 'name'),
				'label' => 'Tier',
				'value' => function($model){
						return $model->lookupCommissionTier->name;
					},
			],
			[
				'attribute'=>'minimum_transaction_value',
				'value' => function($model){
						return Yii::$app->AccessMod->getPriceFormat($model->minimum_transaction_value);
					},
			],
			[
				'attribute'=>'maximum_transaction_value',
				'value' => function($model){
						return Yii::$app->AccessMod->getPriceFormat($model->maximum_transaction_value);
					},
			],
			[
				'attribute' => 'lookupCommissionType',
				'filter'=>ArrayHelper::map($commissionTypeList, 'name', 'name'),
				'label' => 'Type',
				'value' => function($model){
						return $model->lookupCommissionType->name;
					},
			],
			[
				'attribute'=>'commission_value',
				'value' => function($model){
						return $model->commission_type==1?number_format($model->commission_value,'2','.','').'%':Yii::$app->AccessMod->getPriceFormat($model->commission_value);
					},
			],
            'expiration_period',

			[
				'class' => 'yii\grid\ActionColumn',
				'headerOptions' => ['class' => 'header-options'],
				'contentOptions' => ['class' => 'content-options'],
				'template' => '{view}{update}',
				'buttons' => [
					'view' => function ($url, $model) {
						return Html::a('<span class="glyphicon glyphicon-eye-open"></span>&nbsp&nbsp', ['view', 'id' => $model->id]);
					},
					'update' => function ($url, $model) {
						return Html::a('<span class="glyphicon glyphicon-pencil"></span>&nbsp&nbsp', ['update', 'id' => $model->id]);
					},
				],
			],
        ],
    ]); ?>
</div>
