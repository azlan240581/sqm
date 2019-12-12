<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use kartik\daterange\DateRangePicker;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserRewardRedemptionsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Associate Redemptions List';
$this->params['breadcrumbs'][] = 'Points Management';
$this->params['breadcrumbs'][] = ['label' => 'Associate Redemptions List', 'url' => ['/user-reward-redemptions']];
?>
<div class="user-reward-redemptions-index">
    <p>
    </p>
    
	<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute'=>'associateFirstName',
                'label'=>'Associate First Name',
                'value'=>function($model){
                        return $model->associateFirstName->firstname;
                    },
            ],
            [
                'attribute'=>'associateLastName',
                'label'=>'Associate Last Name',
                'value'=>function($model){
                        return $model->associateFirstName->lastname;
                    },
            ],
            [
                'attribute'=>'reward',
                'label'=>'Reward name',
                'value'=>function($model){
                        return $model->reward->name;
                    },
            ],
            'quantity',
            [
                'attribute'=>'points_value',
                'value'=>function($model){
                        return Yii::$app->AccessMod->getPointsFormat($model->points_value);
                    },
            ],
            [
                'attribute'=>'status',
                'filter'=>ArrayHelper::map($lookupRedemptionStatusList, 'id', 'name'),
                'value'=>function($model){
                        return $model->lookupRedemptionStatus->name;
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
                'template' => '{view}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>&nbsp&nbsp', ['view', 'id' => $model->id]);
                    },
                ],
            ],
        ],
    ]); ?>
</div>
