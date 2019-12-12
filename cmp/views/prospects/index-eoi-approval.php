<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\daterange\DateRangePicker;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;


/* @var $this yii\web\View */
/* @var $searchModel app\models\ProspectsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pending EOI Approval';
$this->params['breadcrumbs'][] = 'Prospects Management';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="prospects-index">

    <?php /*?><h1><?= Html::encode($this->title) ?></h1><?php */?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

			[
				'attribute'=>'project_id',
				'value'=>function($model){
					return $model->project->project_name;
				},
			],
			[
				'attribute'=>'dedicated_agent_name',
				'value'=>function($model){
					return $model->dedicatedAgent->name;
				},
			],
			[
				'attribute'=>'prospect_name',
				'value'=>function($model){
					return $model->prospect->prospect_name;
				},
			],
            'eoi_ref_no',
            // 'createdby',*/

			[
				'attribute' => 'booking_date_eoi',
				'format' => 'date',
				'filter' => DateRangePicker::widget([
							'model'=>$searchModel,
							'attribute'=>'eoicreatedatrange',
							'convertFormat'=>true,
							'readonly'=>true,
							'presetDropdown'=>true,
							'pluginOptions'=>[
								'locale'=>[
									'format'=>'Y-m-d',
									'cancelLabel' => 'Clear',
								],
							],
							'options' => [
								'class' => 'form-control',
							],
							'pluginEvents' => [
										'apply.daterangepicker' => 'function(ev, picker) {
												if($(this).val() == "") {
													$(this).val(picker.startDate.format(picker.locale.format) + picker.locale.separator +
													picker.endDate.format(picker.locale.format)).trigger("change");
												}
											}',
											'show.daterangepicker' => 'function(ev, picker) {
												picker.container.find(".ranges").off("mouseenter.daterangepicker", "li");
													if($(this).val() == "") {
													picker.container.find(".ranges .active").removeClass("active");
												}
											}',
											'cancel.daterangepicker' => 'function(ev, picker) {
												if($(this).val() != "") {
													$(this).val("").trigger("change");
												}
											}'
							],
						]),
			],

			[
				'attribute' => 'createdat',
				'format' => 'datetime',
				'filter' => DateRangePicker::widget([
							'model'=>$searchModel,
							'attribute'=>'createdatrange',
							'convertFormat'=>true,
							'readonly'=>true,
							'presetDropdown'=>true,
							'pluginOptions'=>[
								'locale'=>[
									'format'=>'Y-m-d H:i:s',
									'cancelLabel' => 'Clear',
								],
							],
							'options' => [
								'class' => 'form-control',
							],
							'pluginEvents' => [
										'apply.daterangepicker' => 'function(ev, picker) {
												if($(this).val() == "") {
													$(this).val(picker.startDate.format(picker.locale.format) + picker.locale.separator +
													picker.endDate.format(picker.locale.format)).trigger("change");
												}
											}',
											'show.daterangepicker' => 'function(ev, picker) {
												picker.container.find(".ranges").off("mouseenter.daterangepicker", "li");
													if($(this).val() == "") {
													picker.container.find(".ranges .active").removeClass("active");
												}
											}',
											'cancel.daterangepicker' => 'function(ev, picker) {
												if($(this).val() != "") {
													$(this).val("").trigger("change");
												}
											}'
							],
						]),
			],
            // 'updatedby',
            // 'updatedat',
            // 'deletedby',
            // 'deletedat',

			[
				'class' => 'yii\grid\ActionColumn',
				'headerOptions' => ['class' => 'header-options'],
				'contentOptions' => ['class' => 'content-options'],
				'template' => Yii::$app->AccessRule->getTemplateActions(),
				'buttons' => [
					'view-eoi-approval' => function ($url, $model) {
						return Html::a('<span class="glyphicon glyphicon-eye-open"></span>&nbsp&nbsp', ['view-eoi-approval', 'prospect_booking_id' => $model->id, 'id'=> $model->prospect_id],['class'=>'modal-button-01']);
					},
					'update' => function ($url, $model) {
						return '';
					},
					'delete' => function ($url, $model) {
						return '';
					},
				],
			],
        ],
    ]); ?>
</div>
<?php
Modal::begin([
	'header' => '<h4 id="modal-header-id-01">View Prospect Booking EOI</h4>',
	'id' => 'modal-id-01',
	'size' => 'modal-lg',
	'clientOptions' => ['backdrop' => false, 'keyboard' => false],
	]);
	echo '<div id="modal-content-01"></div>';
Modal::end();
?>
