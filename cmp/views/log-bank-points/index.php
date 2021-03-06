<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use kartik\daterange\DateRangePicker;

/* @var $this yii\web\View */
/* @var $searchModel app\models\LogBankPointsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Bank Points Transaction';
$this->params['breadcrumbs'][] = 'Reports Management';
$this->params['breadcrumbs'][] = 'Logs';
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['/bank-points']];
?>
<div class="log-bank-points-index">
    
	<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'points_value',
                'value' => function($model){
                        return Yii::$app->AccessMod->getPointsFormat($model->points_value);
                },
            ],
            'remarks:ntext',
            [
                'label'=>'Created By',
                'attribute'=>'user',
                'value'=>'user.name',
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

        ],
    ]); ?>
</div>
