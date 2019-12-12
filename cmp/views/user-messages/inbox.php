<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\daterange\DateRangePicker;


/* @var $this yii\web\View */
/* @var $searchModel app\models\UserMessagesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'My Inbox';
$this->params['breadcrumbs'][] = $this->title;
?>
<br />
<div class="user-messages-index">

	<div class="row">
        <?=Html::beginForm(['/user-messages/inbox'],'post');?>
        
        <div class="col-lg-2 col-xs-6" style="padding-right:0">
			<?=Html::dropDownList('action','',[''=>'Bulk action: ','delete'=>'Delete'],['class'=>'dropdown form-control form-control-sm'])?>
        </div>
        
        <div class="col-lg-2 col-xs-6" style="padding:0">
			<?=Html::submitButton('Apply', ['class' => 'btn btn-default', 'data' => ['confirm' => 'Are you sure you want to delete selected message(s)?','method' => 'post']]);?>
        </div>
        
	</div>
    <br />

	
	<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\CheckboxColumn'],
            ['class' => 'yii\grid\SerialColumn'],

            'subject',
            [
                'attribute' => 'mark_as_read',
                'filter' => array(0=>'Unread',1=>'Read'),
                'value' => function($model) {
                    if($model->mark_as_read==1)
                    return 'Read';
                    else
                    return 'Unread';
                },
            ],
            [
                'attribute' => 'priority',
                'filter' => array(1=>'Low',2=>'Normal',3=>'Important'),
                'value' => function($model) {
                    if($model->priority==3)
                    return 'Important';
                    if($model->priority==2)
                    return 'Normal';
                    else
                    return 'Low';
                },
            ],
            [
                'attribute' => 'createdby',
                'value' => function($model) {
                    return Yii::$app->AccessMod->getUsername($model->createdby);
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
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>&nbsp&nbsp', ['inbox-detail', 'id' => $model->id]);
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
        'rowOptions'=>function($model){
            if($model->mark_as_read==0){
            return ['class' => 'bold'];
        }
    },
    ]); 
    ?>
</div>
