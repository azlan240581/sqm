<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use kartik\daterange\DateRangePicker;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserPointsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Associate Points';
$this->params['breadcrumbs'][] = 'Points Management';
$this->params['breadcrumbs'][] = ['label' => 'Associate Points', 'url' => ['/user-points']];
?>
<div class="user-points-index">
    <p>
    </p>
    
	<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute'=>'agentName',
                'label'=>'Agent Name',
                'value'=>function($model){
                            return $model->agentName->name;
                        },
            ],
            [
                'attribute'=>'associateName',
                'label'=>'Associate Name',
                'value'=>function($model){
                            return $model->associateName->name;
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
                'attribute'=>'total_points_value',
                'value'=>function($model){
                            return Yii::$app->AccessMod->getPointsFormat($model->total_points_value);
                        },
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
