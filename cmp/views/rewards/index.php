<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use kartik\daterange\DateRangePicker;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RewardsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'List';
$this->params['breadcrumbs'][] = 'Rewards Management';
$this->params['breadcrumbs'][] = ['label' => 'List', 'url' => ['/rewards']];
?>
<div class="rewards-index">
    <p>
    </p>
    
	<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute'=>'lookupRewardCategory',
                'label'=>'Category Name',
                'filter'=>ArrayHelper::map(Yii::$app->AccessMod->getLookupData('lookup_reward_categories'), 'name', 'name'),
                'value'=>function($model){
                            return $model->lookupRewardCategory->name;
                        },
            ],
            'name',
            'quantity',
            [
                'attribute'=>'points',
                'value'=>function($model){
                            return Yii::$app->AccessMod->getPointsFormat($model->points);
                        },
            ],
            [
                'attribute' => 'published_date_start',
                'format' => 'datetime',
                'filter' => DateRangePicker::widget([
                            'model'=>$searchModel,
                            'attribute'=>'publishedDdateStartRange',
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
                'attribute' => 'published_date_end',
                'format' => 'datetime',
                'filter' => DateRangePicker::widget([
                            'model'=>$searchModel,
                            'attribute'=>'publishedDateEndRange',
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
