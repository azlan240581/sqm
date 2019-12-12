<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\daterange\DateRangePicker;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProspectsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'My Associate Prospects';
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

            //'id',
			[
				'attribute'=>'member_name',
				'value'=>function($model){
					return $model->member->name;
				},
			],
            'prospect_name',
            'prospect_email:email',
            'prospect_contact_number',
            // 'prospect_purpose_of_buying',
            // 'how_prospect_know_us',
            // 'prospect_age',
            // 'prospect_marital_status',
            // 'prospect_occupation',
            // 'prospect_identity_document',
            // 'tax_license',
            // 'remarks:ntext',
			[
				'attribute' => 'status',
				'filter'=>ArrayHelper::map($statusArray, 'id', 'name'),
				'format' => 'raw',
				'value' => function($model) use ($modelLogProspectHistory)
				{
					$button = '';
					
					if($model->status==1)
					$button .= '<span class="label label-warning">'.$model->lookupProspectStatus->name.'</span>';
					elseif($model->status==2)
					$button .= '<span class="label label-success">'.$model->lookupProspectStatus->name.'</span>';
					elseif($model->status==3)
					$button .= '<span class="label label-danger">'.$model->lookupProspectStatus->name.'</span>';
					elseif($model->status==4)
					$button .= '<span class="label label-default">'.$model->lookupProspectStatus->name.'</span>';

					if(($logHistory = $modelLogProspectHistory->lastLogProspectHistoryByProspectID($model->id)))
					$button .= '<small><i>'.'<br>- '.$logHistory['name'].'</i></small>';

					return $button;
				},
			],
            // 'createdby',
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
				'template' => '{view-my-associate-prospects}',
				'buttons' => [
					'view-my-associate-prospects' => function ($url, $model) {
						return Html::a('<span class="glyphicon glyphicon-eye-open"></span>&nbsp&nbsp', ['view-my-associate-prospects', 'id' => $model->id]);
					},
				],
			],
        ],
    ]); ?>
</div>
