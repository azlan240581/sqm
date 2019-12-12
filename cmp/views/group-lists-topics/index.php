<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use kartik\daterange\DateRangePicker;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\GroupListsTopicsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Group Lists / Topics';
$this->params['breadcrumbs'][] = 'Announcements Management';
$this->params['breadcrumbs'][] = 'Push Notifications';
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['/group-lists-topics']];
?>
<div class="group-lists-topics-index">
    <p>
        <?= Html::a('Create Topic', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'topic_name',
			[
				'attribute' => 'status',
				'filter'=>ArrayHelper::map($statusArray, 'value', 'name'),
				'label' => 'Status',
				'format' => 'raw',
				'value' => function($model){
						return ($model->status == 0)?
						Html::a('<button type="button" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-off" style="color:white"></span>&nbsp;&nbsp;&nbsp;Inactive</button>', ['toggle-status', 'id' => $model->id], [
											'data' => [
												'confirm' => 'Are you sure you want to activate this category?',
												'method' => 'post',
												'pjax' => 0,
											],
										]):
						Html::a('<button type="button" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-off" style="color:white"></span>&nbsp;&nbsp;&nbsp;Active</button>', ['toggle-status', 'id' => $model->id], [
											'data' => [
												'confirm' => 'Are you sure you want to deactivate this category?',
												'method' => 'post',
												'pjax' => 0,
											],
										]);
					},
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

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
