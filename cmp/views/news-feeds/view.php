<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\DetailView;
use yii\bootstrap\Modal;
use kartik\daterange\DateRangePicker;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\NewsFeeds */

$this->title = $model->title;
$this->params['breadcrumbs'][] = 'News Feed Management';
$this->params['breadcrumbs'][] = ['label' => 'List', 'url' => ['/news-feeds']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-feeds-view">

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [

			[
				'label'=>'Project',
				'value'=>$model->project->project_name,
			],
			[
				'label'=>'Category',
				'value'=>$model->lookupNewsFeedCategory->name,
			],
            'title',
            'permalink',
            'summary:ntext',
			[
				'label'=>'Description',
				'format'=>'raw',
				'value'=>html_entity_decode($model->description),
			],
			[
				'attribute' => 'thumb_image',
				'format'=>'raw',
				'value'=> !strlen($model->thumb_image)?NULL:Html::a(Html::img($model->thumb_image, ['width'=>200]),$model->thumb_image, ['data-fancybox'=>true]),
			],
			
			
			[
				'label'=>'Product',
				'visible'=>$model->category_id==2?TRUE:FALSE,
				'value'=>$model->product_id,
			],
			[
				'label'=>$model->getAttributeLabel('promotion_start_date'),
				'visible'=>$model->category_id==2?TRUE:FALSE,
				'format'=>'datetime',
				'value'=>$model->promotion_start_date,
			],
			[
				'label'=>$model->getAttributeLabel('promotion_end_date'),
				'visible'=>$model->category_id==2?TRUE:FALSE,
				'format'=>'datetime',
				'value'=>$model->promotion_end_date,
			],
			[
				'label'=>$model->getAttributeLabel('promotion_terms_conditions'),
				'visible'=>$model->category_id==2?TRUE:FALSE,
				'format'=>'raw',
				'value'=>html_entity_decode($model->promotion_terms_conditions),
			],
			
			
			[
				'label'=>$model->getAttributeLabel('event_at'),
				'visible'=>$model->category_id==3?TRUE:FALSE,
				'format'=>'datetime',
				'value'=>$model->event_at,
			],
			[
				'label'=>$model->getAttributeLabel('event_location'),
				'visible'=>$model->category_id==3?TRUE:FALSE,
				'value'=>$model->event_location,
			],
			[
				'label'=>$model->getAttributeLabel('event_location_longitude'),
				'visible'=>$model->category_id==3?TRUE:FALSE,
				'value'=>$model->event_location_longitude,
			],
			[
				'label'=>$model->getAttributeLabel('event_location_latitude'),
				'visible'=>$model->category_id==3?TRUE:FALSE,
				'value'=>$model->event_location_latitude,
			],
			
			
			[
				'label'=>'Collaterals',
				'format'=>'raw',
				'value'=>strlen($model->collaterals_id)?NULL:$model->getCollateralList($model->collaterals_id),
			],
            //'published_date_start:datetime',
            //'published_date_end:datetime',
            'total_viewed',
			[
				'label'=>'Status',
				'value'=>$model->lookupNewsFeedStatus->name,
			],
			[
				'label'=>'Created By',
				'value'=>Yii::$app->AccessMod->getName($model->createdby),
			],
            'createdat:datetime',
			[
				'label'=>'Updated By',
				'value'=>Yii::$app->AccessMod->getName($model->updatedby),
			],
            'updatedat:datetime',
			
        ],
    ]) ?>

</div>

<div class="news-feed-medias-index">
    <p>
        <?= Html::a('Create News Feed Media', ['create-media', 'id'=>$model->id], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProviderNewsFeedMedias,
        'filterModel' => $searchModelNewsFeedMedias,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

			[
				'attribute'=>'media_type_id',
				'filter'=>ArrayHelper::map($lookupMediaTypeList, 'id', 'name'),
				'label'=>'Media Type',
				'value'=>function($model){
							return $model->lookupMediaType->name;
						},
			],
			[
				'attribute'=>'thumb_image',
				'filter'=>false,
				'format'=>'image',
				'value'=>function($model){
							return $model->thumb_image;
						},
			],
            'media_title',
			[
				'attribute'=>'published',
				'filter'=>ArrayHelper::map(array(array('value'=>'1','name'=>'Yes'),array('value'=>'0','name'=>'No')), 'value', 'name'),
				'value'=>function($model){
							return $model->published==1?'Yes':'No';
						},
			],
			[
				'attribute' => 'createdat',
				'format' => 'datetime',
				'filter' => DateRangePicker::widget([
							'model'=>$searchModelNewsFeedMedias,
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

			[
				'class' => 'yii\grid\ActionColumn',
				'headerOptions' => ['class' => 'header-options'],
				'contentOptions' => ['class' => 'content-options'],
				'template' => '{view}{update}{delete}',
				'buttons' => [
					'view' => function ($url, $model) {
						return Html::a('<span class="glyphicon glyphicon-eye-open"></span>&nbsp&nbsp', ['view-media', 'id' => $model->id]);
					},
					'update' => function ($url, $model) {
						return Html::a('<span class="glyphicon glyphicon-pencil"></span>&nbsp&nbsp', ['update-media', 'id' => $model->id]);
					},
					'delete' => function ($url, $model) {
						return Html::a('<span class="glyphicon glyphicon-trash"></span>&nbsp&nbsp', ['delete-media', 'id' => $model->id], ['data' => ['confirm' => 'Are you sure you want to delete this media?','method' => 'post']]);
					},
				],
			],
        ],
    ]); ?>
    
    
    
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.6/dist/jquery.fancybox.min.css" />
<script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.6/dist/jquery.fancybox.min.js"></script>
</div>






