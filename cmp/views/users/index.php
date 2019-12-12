<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use kartik\daterange\DateRangePicker;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UsersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = 'User Management';
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['/users']];
?>
<div class="users-index">
    <p>
        <?= Html::a('Create User', ['create'], ['class' => 'btn btn-success']) ?>
		<?php /*?><?php 
        $exportExcelLink = array();
        $exportExcelLink[] = 'export-excel';
        $exportExcelLink = array_merge($exportExcelLink,$_GET);
        echo Html::a('Export Excels', $exportExcelLink, ['class' => 'btn btn-warning']); 
        ?>
        <!--<button onclick="printContent('divUsersIndex')" class="btn btn-primary">Print</button>-->
        <button onclick="window.print()" class="btn btn-primary">Print this page</button><?php */?>
    </p>
    
	<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            
            'username',
            'firstname',
            'lastname',
            [
                'attribute' => 'groupAccess',
                'filter'=>ArrayHelper::map($systemGroupArray, 'group_access_name', 'group_access_name'),
                'label' => 'System Group',
                'value' => 'groupAccess.group_access_name',
            ],
            [
                'attribute' => 'status',
                'filter'=>ArrayHelper::map($statusArray, 'value', 'name'),
                'label' => 'Status',
                'format' => 'raw',
                'value' => function($model){
                        return ($model->status == 0)?
                        Html::a('<button type="button" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-off" style="color:white"></span>&nbsp;&nbsp;&nbsp;Inactive</button>', ['toggle-status', 'id' => $model->id], [
                                            'data' => [
                                                'confirm' => 'Are you sure you want to activate this user?',
                                                'method' => 'post',
                                                'pjax' => 0,
                                            ],
                                        ]):
                        Html::a('<button type="button" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-off" style="color:white"></span>&nbsp;&nbsp;&nbsp;Active</button>', ['toggle-status', 'id' => $model->id], [
                                            'data' => [
                                                'confirm' => 'Are you sure you want to deactivate this user?',
                                                'method' => 'post',
                                                'pjax' => 0,
                                            ],
                                        ]);
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
                'attribute' => 'lastloginat',
                'format' => 'datetime',
                'filter' => DateRangePicker::widget([
                            'model'=>$searchModel,
                            'attribute'=>'lastloginatrange',
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
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>&nbsp&nbsp', ['view', 'id' => $model->id, 'ajaxView' => ''], ['class' => 'modal-button-01']);
                    },
                    'update' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>&nbsp&nbsp', ['update', 'id' => $model->id]);
                    },
                    'delete' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>&nbsp&nbsp', ['delete', 'id' => $model->id], ['data' => ['confirm' => 'Are you sure you want to delete this user?','method' => 'post']]);
                    },
                ],
            ],
        ],
    ]); ?>
    
   <?php
	Modal::begin([
		'header' => '<h4>View Users</h4>',
		'id' => 'modal-id-01',
		'size' => 'modal-lg',
		'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
		]);
	echo '<div id="modal-content-01"></div>';
	Modal::end();
   ?>
</div>
