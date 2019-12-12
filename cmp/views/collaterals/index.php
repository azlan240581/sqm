<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use kartik\daterange\DateRangePicker;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CollateralsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'List';
$this->params['breadcrumbs'][] = 'Collaterals Management';
$this->params['breadcrumbs'][] = ['label' => 'List', 'url' => ['/collaterals']];
?>
<div class="collaterals-index">
    <p>
    </p>

	<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute'=>'project',
                'label'=>'Project Name',
                'filter'=>ArrayHelper::map($projectList, 'project_name', 'project_name'),
                'value'=>function($model){
                            return $model->project->project_name;
                        },
            ],
            'title',
            [
                'attribute'=>'collateralType',
                'label'=>'Collateral Type',
                'filter'=>ArrayHelper::map($collateralMediaTypeList, 'id', 'name'),
                'value'=>function($model){
                            return $model->lookupCollateralMediaType->name;
                        },
            ],
            [
                'attribute'=>'collateralLink',
                'label'=>'Collateral Link',
                'format'=>'url',
                'value'=>function($model){
                            return $model->collateralLink->media_value;
                        },
            ],
            [
                'attribute'=>'status',
                'filter'=>ArrayHelper::map(array(array('value'=>'1','name'=>'Active'),array('value'=>'0','name'=>'Inactive')), 'value', 'name'),
                'value'=>function($model){
                            return $model->status==1?'Active':'Inactive';
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
