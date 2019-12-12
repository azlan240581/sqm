<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Rewards */

$this->title = $model->name;
$this->params['breadcrumbs'][] = 'Rewards Management';
$this->params['breadcrumbs'][] = ['label' => 'List', 'url' => ['/rewards']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rewards-view">

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
		
			[
				'label'=>'Category Name',
				'value'=>$model->lookupRewardCategory->name,
			],
            'name',
            'summary:ntext',
			[
				'label'=>'Category Name',
				'format'=>'raw',
				'value'=>html_entity_decode($model->description),
			],
            'quantity',
            'minimum_quantity',
			[
				'label'=>'Points',
				'value'=>Yii::$app->AccessMod->getPointsFormat($model->points),
			],
			[
				'attribute' => 'udf1',
				'format'=>'raw',
				'value'=> !strlen($model->images)?NULL:Html::a(Html::img($model->images, ['width'=>200]),$model->images, ['data-fancybox'=>true]),
			],
            'url:url',
            //'rule_expirary_in_days',
            'published_date_start:datetime',
            'published_date_end:datetime',
            'total_viewed',
			[
				'label'=>'Status',
				'value'=>$model->status==1?'Active':'Inactive',
			],
			[
				'label'=>'Created By',
				'value'=>Yii::$app->AccessMod->getName($model->createdby),
			],
            'createdat:datetime',
			[
				'label'=>'Updated By',
				'value'=>Yii::$app->AccessMod->getName($model->updatedby),
			],
            'updatedat:datetime',
			
        ],
    ]) ?>
    
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.6/dist/jquery.fancybox.min.css" />
<script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.6/dist/jquery.fancybox.min.js"></script>
</div>
