<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use kartik\daterange\DateRangePicker;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserAssociateDetailsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = 'Assign Virtual Associate';
$this->params['breadcrumbs'][] = 'System Management';
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['/assign-virtual-associate']];
?>
<div class="user-associate-details-index">
    <p>
    </p>
    
	<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute'=>'agent',
                'visible'=>$_SESSION['user']['id']==1?TRUE:(($_SESSION['user']['groups']!=NULL and array_intersect(array(1,2),$_SESSION['user']['groups']))?TRUE:FALSE),
                'label'=>'Agent Name',
                'value'=>function($model){
                        return $model->agent->name.' ('.Yii::$app->AccessMod->getUserGroupName(Yii::$app->AccessMod->getUserGroupID($model->agent_id)).')';
                    },
            ],
            [
                'attribute'=>'associateFirstName',
                'label'=>'First Name',
                'value'=>function($model){
                        return $model->associateFirstName->firstname;
                    },
            ],
            [
                'attribute'=>'associateLastName',
                'label'=>'Last Name',
                'value'=>function($model){
                        return $model->associateLastName->lastname;
                    },
            ],
            [
                'attribute'=>'associateEmail',
                'label'=>'Email',
                'value'=>function($model){
                        return $model->associateEmail->email;
                    },
            ],
            [
                'attribute'=>'associateContactNo',
                'label'=>'Contact Number',
                'value'=>function($model){
                        return $model->associateContactNo->country_code.$model->associateContactNo->contact_number;
                    },
            ],
            [
                'attribute'=>'productivity_status',
                'filter'=>ArrayHelper::map($associateProductivityStatusList, 'id', 'name'),
                'label'=>'Productivity Status',
                'value'=>function($model){
                        return $model->lookupAssociateProductivityStatus->name;
                    },
            ],
            [
                'attribute' => 'associateCreatedAt',
                'value'=>function($model){
                        return $model->associateCreatedAt->createdat;
                    },
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
                'attribute' => 'associateLastLoginAt',
                'value'=>function($model){
                        return $model->associateLastLoginAt->lastloginat;
                    },
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
                //'template' => '{view}{update}{delete}',
                'template' => '{assign}',
                'buttons' => [
                    'assign' => function ($url, $model) {
                        if($model->associateFirstName->uuid!=$_SESSION['settings']['AUTO_ASSIGN_PROSPECT_TO_MEMBER'])
                        {
                            //return Html::a('<span class="glyphicon glyphicon-check"></span>&nbsp&nbsp', ['assign-virtual-associate', 'id' => $model->id]);
                            return Html::a('<button class="btn btn-sm btn-primary">Assign</button>', ['assign-virtual-associate','id'=>$model->id]);
                        }
                        else
                        {
                            return '<button class="btn btn-sm btn-success">Assigned</button>';
                            //return Html::a('<button class="btn btn-sm btn-danger">Unsign</button>', ['unsign-virtual-associate','id'=>$model->id]);
                        }
                    },
                ],
            ],
        ],
    ]); ?>
</div>
