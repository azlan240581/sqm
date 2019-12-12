<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use kartik\daterange\DateRangePicker;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserAssociateDetailsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pending Approval';
$this->params['breadcrumbs'][] = 'Associates Management';
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['/associates/pending-approval']];
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
                'label'=>'Associate Email',
                'value'=>function($model){
                        return $model->associateEmail->email;
                    },
            ],
            [
                'attribute'=>'associateContactNo',
                'label'=>'Associate Contact Number',
                'value'=>function($model){
                        return $model->associateContactNo->country_code.$model->associateContactNo->contact_number;
                    },
            ],
            [
                'attribute'=>'approval_status',
                'label'=>'Approval Status',
                'filter'=>false,
                'format'=>'raw',
                'value'=>function($model){
                        $button = '';
                        if($model->approval_status==2)
                        {
                            if($_SESSION['user']['id']==1)
                            $button .= Html::a('<button type="button" class="btn btn-warning btn-sm"><span class="glyphicon glyphicon-refresh" style="color:white"></span>&nbsp;&nbsp;&nbsp;'.$model->lookupAssociateApprovalStatus->name.'</button>', ['set-approval', 'id' => $model->id]);					
                            elseif($_SESSION['user']['groups']!=NULL and array_intersect(array(1,2),$_SESSION['user']['groups']) and $model->agent_approval==1 and $model->admin_approval==0)
                            $button .= Html::a('<button type="button" class="btn btn-warning btn-sm"><span class="glyphicon glyphicon-refresh" style="color:white"></span>&nbsp;&nbsp;&nbsp;'.$model->lookupAssociateApprovalStatus->name.'</button>', ['set-approval', 'id' => $model->id]);					
                            else
                            $button .= Html::a('<button type="button" class="btn btn-warning btn-sm" style="cursor:not-allowed;"><span class="glyphicon glyphicon-refresh" style="color:white"></span>&nbsp;&nbsp;&nbsp;'.$model->lookupAssociateApprovalStatus->name.'</button>');
                        
                            $button .= '<br>';
                            
                            if($model->agent_approval==0)
                            $button .= 'Pending approval from agent.';
                            elseif($model->agent_approval==1 and $model->admin_approval==0)
                            $button .= 'Pending approval from admin.';
                        }
                        return $button;
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
