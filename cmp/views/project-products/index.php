<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use kartik\daterange\DateRangePicker;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProjectProductsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Products';
$this->params['breadcrumbs'][] = 'Projects Management';
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['/project-products']];

?>
<div class="project-products-index">
    <p>
    </p>

	<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute'=>'project',
                'filter'=>ArrayHelper::map($projectList, 'value', 'name'),
                'label'=>'Project Name (Developer Name)',
                'value'=>function($model){
                            return $model->project->project_name.' ('.Yii::$app->GeneralMod->getDeveloperName(Yii::$app->GeneralMod->getDeveloperID($model->project_id)).')';
                        },
            ],
            'product_name',
            [
                'attribute'=>'lookupProductType',
                'filter'=>ArrayHelper::map(Yii::$app->AccessMod->getLookupData('lookup_product_type'), 'name', 'name'),
                'label'=>'Product Tier',
                'value'=>function($model){
                            return $model->lookupProductType->name;
                        },
            ],
            [
                'attribute'=>'lookupPropertyProductType',
                'filter'=>ArrayHelper::map(Yii::$app->AccessMod->getLookupData('lookup_property_product_types'), 'name', 'name'),
                'label'=>'Product Type',
                'value'=>function($model){
                            return $model->lookupPropertyProductType->name;
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
            
            [
                'class' => 'yii\grid\ActionColumn',
                'headerOptions' => ['class' => 'header-options'],
                'contentOptions' => ['class' => 'content-options'],
                'template' => '{view}{update}{delete}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>&nbsp&nbsp', ['view', 'id' => $model->id]);
                    },
                    'update' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>&nbsp&nbsp', ['update', 'id' => $model->id]);
                    },
                    'delete' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>&nbsp&nbsp', ['delete', 'id' => $model->id], ['data' => ['confirm' => 'Are you sure you want to delete this product?','method' => 'post']]);
                    },
                ],
            ],
        ],
    ]); ?>
</div>
