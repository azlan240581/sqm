<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel app\models\GroupAccessSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Groups';
$this->params['breadcrumbs'][] = 'User Management';
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['/group-access']];
?>
<div class="group-access-index">
    <p>
    <?php
	if($_SESSION['user']['id'] == 1)
	{
		?>
        <?= Html::a('Create Group', ['create'], ['class' => 'btn btn-success']); ?>
        <!--<button onclick="printContent('divGroupAccessIndex')" class="btn btn-primary">Print this page</button>-->
        <button onclick="window.print()" class="btn btn-primary">Print this page</button>
        <?php
	}
	?>
    </p>
    
	<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
    
            [
                'attribute' => 'group_access_name',
                'label' => 'Group Name',
            ],
            [
                'attribute' => 'status',
                'label' => 'Status',
                'value' => function($model){ return (($model->status == 1) ? 'Yes' : 'No'); },
            ],
    
            [
                'class' => 'yii\grid\ActionColumn',
                'headerOptions' => ['class' => 'header-options'],
                'contentOptions' => ['class' => 'content-options'],
                'visible' => $_SESSION['user']['id'] == 1 ? true : false,
                'template' => '{assign-module}{view}{update}{delete}',
                'buttons' => [
                    'assign-module' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-plus-sign"></span>&nbsp&nbsp', ['assign-permission', 'id' => $model->id], ['class' => 'modal-button-01', 'data-pjax' => '0']);
                    },
                    'view' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>&nbsp&nbsp', ['view', 'id' => $model->id, 'ajaxView' => ''], ['class' => 'modal-button-02']);
                    },
                    'update' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>&nbsp&nbsp', ['update', 'id' => $model->id]);
                    },
                    'delete' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>&nbsp&nbsp', ['delete', 'id' => $model->id], ['data' => ['confirm' => 'Are you sure you want to delete this item?','method' => 'post']]);
                    },
                ],
            ],
        ],
    ]); ?>
    
   <?php
	Modal::begin([
		'header' => '<h4>Assign Permissions</h4>',
		'id' => 'modal-id-01',
		'size' => 'modal-lg',
		'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
		]);
	echo '<div id="modal-content-01"></div>';
	Modal::end();
	
	Modal::begin([
		'header' => '<h4>View Group</h4>',
		'id' => 'modal-id-02',
		'size' => 'modal-lg',
		'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
		]);
	echo '<div id="modal-content-02"></div>';
	Modal::end();
   ?>
</div>
