<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use kartik\daterange\DateRangePicker;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProjectsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'List';
$this->params['breadcrumbs'][] = 'Projects Management';
$this->params['breadcrumbs'][] = ['label' => 'List', 'url' => ['/projects']];
?>
<div class="projects-index">
    <p>
    </p>

	<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            
            [
                'attribute'=>'developer',
                'filter'=>ArrayHelper::map($developerList, 'company_name', 'company_name'),
                'label'=>'Developer Name',
                'value'=>function($model){
                            return $model->developer->company_name;
                        },
            ],
            'project_name',
            'project_description:ntext',
            [
                'attribute'=>'agent',
                'label'=>'Project Handler',
                'format'=>'raw',
                'value'=>function($model){
                            $agentIDs = $model->getProjectHandler($model->id);
                            if(count($agentIDs)!=0)
                            {
                                $tmp = '';
                                $i=1;
                                foreach($agentIDs as $value)
                                {
                                    $tmp .= Yii::$app->AccessMod->getName($value['agent_id']);
                                    $tmp .= '<br>';
                                    $i++;
                                }
                                $tmp .= '';
                                return $tmp;
                            }
                            else
                            return NULL;
                        },
            ],
            [
                'attribute'=>'status',
                'filter'=>ArrayHelper::map($statusList, 'value', 'name'),
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
