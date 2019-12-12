<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

use yii\grid\GridView;
use yii\bootstrap\Modal;
use kartik\daterange\DateRangePicker;

/* @var $this yii\web\View */
/* @var $model app\models\ProjectProducts */

$this->title = $model->product_name;
$this->params['breadcrumbs'][] = 'Projects Management';
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['/project-products']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-products-view">

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
				'label'=>'Developer Name',
				'value'=>Yii::$app->GeneralMod->getDeveloperName(Yii::$app->GeneralMod->getDeveloperID($model->project_id)),
			],
			[
				'label'=>'Project Name',
				'value'=>$model->project->project_name,
			],
            'product_name',
			[
				'label'=>'Product Tier',
				'value'=>$model->lookupProductType->name,
			],
			[
				'label'=>'Product Type',
				'value'=>$model->lookupPropertyProductType->name,
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

</div>

<div class="project-product-unit-types-index">
    <p>
        <?= Html::a('Create Unit Type', ['create-unit-type', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProviderProjectProductUnitTypesSearch,
        'filterModel' => $searchModelProjectProductUnitTypesSearch,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'type_name',
			[
				'attribute'=>'building_size_sm',
				'value'=>function($model){
							return number_format($model->building_size_sm,2,'.','');
						},
			],
			[
				'attribute'=>'land_size_sm',
				'value'=>function($model){
							return number_format($model->land_size_sm,2,'.','');
						},
			],
			[
				'attribute' => 'createdat',
				'format' => 'datetime',
				'filter' => DateRangePicker::widget([
							'model'=>$searchModelProjectProductUnitTypesSearch,
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
				'template' => '{delete}',
				'buttons' => [
					'delete' => function ($url, $model) {
						return Html::a('<span class="glyphicon glyphicon-trash"></span>&nbsp&nbsp', ['delete-unit-type', 'id' => $model->id], ['data' => ['confirm' => 'Are you sure you want to delete this unit type?','method' => 'post']]);
					},
				],
			],
        ],
    ]); ?>
</div>

