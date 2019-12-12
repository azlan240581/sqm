<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use kartik\daterange\DateRangePicker;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserCommissionsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Account Manager Commission List';
$this->params['breadcrumbs'][] = 'Commission Management';
$this->params['breadcrumbs'][] = ['label' => 'Account Manager Commission List', 'url' => ['/account-manager-commissions']];
?>
<div class="user-commissions-index">
    <p>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

			[
				'attribute'=>'userFirstName',
				'label'=>'First Name',
				'value'=>function($model){
							return $model->userFirstName->firstname;
						},
			],
			[
				'attribute'=>'userLastName',
				'label'=>'Last Name',
				'value'=>function($model){
							return $model->userLastName->lastname;
						},
			],
			[
				'attribute'=>'userEmail',
				'label'=>'Email',
				'value'=>function($model){
							return $model->userEmail->email;
						},
			],
			[
				'attribute'=>'total_commission_amount',
				'value'=>function($model){
							return Yii::$app->AccessMod->getPriceFormat($model->total_commission_amount);
						},
			],
			[
				'attribute'=>'status',
				'filter'=>ArrayHelper::map($lookupUserCommissionStatus, 'id', 'name'),
				'value'=>function($model){
							return $model->lookupUserCommissionStatus->name;
						},
			],

			[
				'class' => 'yii\grid\ActionColumn',
				'headerOptions' => ['class' => 'header-options'],
				'contentOptions' => ['class' => 'content-options'],
				'template' => '{view}',
				'buttons' => [
					'view' => function ($url, $model) {
						return Html::a('<span class="glyphicon glyphicon-eye-open"></span>&nbsp&nbsp', ['view', 'id' => $model->id]);
					},
				],
			],
        ],
    ]); ?>
</div>
