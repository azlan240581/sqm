<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Banners */

$this->title = $model->banner_title;
$this->params['breadcrumbs'][] = 'Banners Management';
$this->params['breadcrumbs'][] = ['label' => 'List', 'url' => ['/banners']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="banners-view">

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
				'label'=>$model->getAttributeLabel('banner_category_id'),
				'value'=>$model->lookupBannerCategory->name,
			],
            'banner_title',
            'permalink',
            'banner_summary:ntext',
			[
				'label'=>$model->getAttributeLabel('banner_description'),
				'format'=>'raw',
				'value'=>html_entity_decode($model->banner_description),
			],
			[
				'label' => $model->getAttributeLabel('banner_img'),
				'format'=>'raw',
				'value'=> !strlen($model->banner_img)?NULL:Html::a(Html::img($model->banner_img, ['width'=>200]),$model->banner_img, ['data-fancybox'=>true]),
			],
            'banner_video',
            'link_url:url',
            //'published_date_start:datetime',
            //'published_date_end:datetime',
            'sort',
            'total_viewed',
			[
				'label'=>$model->getAttributeLabel('createdby'),
				'value'=>Yii::$app->AccessMod->getName($model->createdby),
			],
            'createdat:datetime',
			[
				'label'=>$model->getAttributeLabel('updatedby'),
				'value'=>Yii::$app->AccessMod->getName($model->updatedby),
			],
            'updatedat:datetime',
			
        ],
    ]) ?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.6/dist/jquery.fancybox.min.css" />
<script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.6/dist/jquery.fancybox.min.js"></script>
</div>
