<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use kartik\daterange\DateRangePicker;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserAssociateDetailsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = 'List';
$this->params['breadcrumbs'][] = 'Associates Management';
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['/associates']];
?>
<div class="user-associate-details-index">
    <p>
    </p>
    
    <?php
	if($_SESSION['user']['id']==1 or ($_SESSION['user']['groups']!=NULL and array_intersect(array(1,2),$_SESSION['user']['groups'])))
	{
	?>
    <div class="row">
		<?=Html::beginForm(['/associates/index'],'post');?>
        <div class="col-md-4 action">
            <select class="form-control dropdown col-md-4" name="action" id="action">
                <option value="" selected="">Bulk action: </option>
                <option value="change-agent">Change Agent</option>
                <option value="delete-member">Delete Associate</option>
            </select>
        </div>
        <div class="col-md-4 agent_id">
            <select class="form-control dropdown col-md-4" name="agent_id" id="agent_id">
                <option value="" selected="">Select New Agent: </option>
                <?php
                foreach($agentList as $agent)
                {
                    echo '<option value="'.$agent['id'].'">'.$agent['name'].'</option>';
                }
                ?>
            </select>
        </div>
        <div class="col-md-4">
            <button type="submit" class="btn btn-primary" data-confirm="Are you sure you want to change selected associate(s)?" data-method="post">Apply</button>
        </div>
    </div>    
	<script>
    $(document).ready(function(e) {
        //hide bank dropdown
        $(".agent_id").hide();
        $(".agent_id").prop('disabled',true);
        
        $("#action").on('change',function() {
            if(this.value=='change-agent')
            {
                $(".agent_id").show();
                $(".agent_id").prop('disabled',false);
            }
            else
            {
                $(".agent_id").hide();
                $(".agent_id").prop('disabled',true);
            }
        });
    });
    </script>
    <br />
    <?php
	}
	?>
    
	<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
				'class' => 'yii\grid\CheckboxColumn'
			],
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
                'template' => Yii::$app->AccessRule->getTemplateActions(),
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>&nbsp&nbsp', ['view', 'id' => $model->id]);
                    },
                    'update' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>&nbsp&nbsp', ['update', 'id' => $model->id]);
                    },
                    'delete' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>&nbsp&nbsp', ['delete', 'id' => $model->id], ['data' => ['confirm' => 'Are you sure you want to delete this associate?','method' => 'post']]);
                    },
                ],
            ],
        ],
    ]); ?>
</div>
