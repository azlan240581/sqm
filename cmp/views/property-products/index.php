<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use kartik\daterange\DateRangePicker;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PropertyProductsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'List';
$this->params['breadcrumbs'][] = 'Property Products Management';
$this->params['breadcrumbs'][] = ['label' => 'List', 'url' => ['/property-products']];
?>
<div class="property-products-index">
    <p>
    </p>

	<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'project',
                'filter'=>ArrayHelper::map($projectList, 'project_name', 'project_name'),
                'label' => 'Project Name',
                'value' => function($model){
                            return $model->project->project_name;
                        },
            ],
            [
                'attribute' => 'property_type_id',
                'filter'=>ArrayHelper::map(Yii::$app->AccessMod->getLookupData('lookup_product_type','','id'), 'id', 'name'),
                'label' => 'Property Type',
                'value' => function($model){
                            return $model->lookupProductType->name;
                        },
            ],
            'title',
            [
                'attribute' => 'product_type',
                'filter'=>ArrayHelper::map($lookupPropertyProductTypeList, 'id', 'name'),
                'value' => function($model){
                            return $model->lookupPropertyProductType->name;
                        },
            ],
            [
                'attribute' => 'price',
                'value' => function($model){
                            return Yii::$app->AccessMod->getPriceFormat($model->price);
                        },
            ],
            [
                'attribute' => 'status',
                'filter'=>ArrayHelper::map($lookupProductStatusList, 'id', 'name'),
                'value' => function($model){
                            return $model->lookupProductStatus->name;
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

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
