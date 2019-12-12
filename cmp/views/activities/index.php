<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use kartik\daterange\DateRangePicker;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ActivitiesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Activities';
$this->params['breadcrumbs'][] = 'Points Management';
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['/activities']];
?>
<div class="activities-index">
    <p>
        <?php 
		if($_SESSION['user']['id']==1)
		echo Html::a('Create Activity', ['create'], ['class' => 'btn btn-success']);
		?>
    </p>
    
	<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'activity_code',
            'activity_name',
            [
                'attribute'=>'points_value',
                'value'=>function($model){
                        return Yii::$app->AccessMod->getPointsFormat($model->points_value);
                    },
            ],
            [
                'attribute'=>'status',
                'filter'=>ArrayHelper::map(array(array('value'=>'1','name'=>'Active'),array('value'=>'0','name'=>'Inactive')), 'id', 'name'),
                'value'=>function($model){
                        return $model->status==1?'Active':'Inactive';
                    },
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'headerOptions' => ['class' => 'header-options'],
                'contentOptions' => ['class' => 'content-options'],
                'template' => '{view}{update}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>&nbsp&nbsp', ['view', 'id' => $model->id]);
                    },
                    'update' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>&nbsp&nbsp', ['update', 'id' => $model->id]);
                    },
                ],
            ],
        ],
    ]); ?>
</div>
