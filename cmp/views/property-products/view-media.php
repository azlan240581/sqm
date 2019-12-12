<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\PropertyProductMedias */

$this->title = $modelPropertyProducts->title.' : '.$model->media_title;
$this->params['breadcrumbs'][] = 'Property Products Management';
$this->params['breadcrumbs'][] = ['label' => 'List', 'url' => ['/property-products']];
$this->params['breadcrumbs'][] = ['label' => $modelPropertyProducts->title, 'url' => ['view', 'id' => $modelPropertyProducts->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="property-product-medias-view">

    <p>
        <?= Html::a('Update', ['update-media', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete-media', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this media?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
		
			[
				'label'=>'Media Type',
				'value'=>$model->lookupMediaType->name,
			],
            'thumb_image:image',
            'media_title',
			[
				'label'=>$model->media_type_id==1?'Image':'Youtube ID',
				'format'=>'raw',
				'value'=>function($model){
					if($model->media_type_id==1)
					return Html::a(Html::img($model->media_value, ['width'=>200]),$model->media_value, ['data-fancybox'=>true]);
					elseif($model->media_type_id==2)
					return $model->media_value;
				},
			],
			[
				'label'=>'Publishes',
				'value'=>$model->published==1?'Yes':'No',
			],
            'sort',
			[
				'label'=>'Created By',
				'value'=>Yii::$app->AccessMod->getName($model->createdby),
			],
            'createdat:datetime',
			
        ],
    ]) ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.6/dist/jquery.fancybox.min.css" />
<script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.6/dist/jquery.fancybox.min.js"></script>
</div>
