<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use kartik\daterange\DateRangePicker;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\LogApiSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Api Request';
$this->params['breadcrumbs'][] = 'Reports';
$this->params['breadcrumbs'][] = 'Logs';
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['/log-api']];

?>
<div class="log-api-index">
    <p>
    	<?php 
		$exportExcelLink = array();
		$exportExcelLink[] = 'export-excel';
		if(isset($_GET['LogApiSearch']))
		$exportExcelLink = array_merge($exportExcelLink,$_GET['LogApiSearch']);
		echo Html::a('Export Excels', $exportExcelLink, ['class' => 'btn btn-success']); 
		?>
        <!--<button onclick="printContent('divLogAPIIndex')" class="btn btn-primary">Print this page</button>-->
        <button onclick="window.print()" class="btn btn-primary">Print this page</button>
    </p>

	<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute'=>'user',
                'label'=>'Staff Name',
                'value'=>'user.name',
            ],
            'api_actions',
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
                'template' => '{view}',
                'headerOptions' => ['class' => 'header-options'],
                'contentOptions' => ['class' => 'content-options'],
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>&nbsp&nbsp', $url, ['class' => 'modal-button-01', 'data-pjax' => '0']);
                    },
                ],
                'urlCreator' => function ($action, $model) {
                    if ($action === 'view') {
                        $url = ['view', 'id'=>$model->id];
                        return $url;
                    }
                },
            ],
        ],
    ]); ?>
    
   <?php
	Modal::begin([
		'header' => '<h4>View API Request</h4>',
		'id' => 'modal-id-01',
		'size' => 'modal-lg',
		'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
		]);
	echo '<div id="modal-content-01"></div>';
	Modal::end();
   ?>
</div>
