<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\NewsFeedMedias */

$this->title = $modelNewsFeeds->title.' : '.$model->media_title;
$this->params['breadcrumbs'][] = 'Property Products Management';
$this->params['breadcrumbs'][] = ['label' => 'List', 'url' => ['/news-feeds']];
$this->params['breadcrumbs'][] = ['label' => $modelNewsFeeds->title, 'url' => ['view', 'id' => $modelNewsFeeds->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-feed-medias-view">

    <p>
        <?= Html::a('Update', ['update-media', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete-media', 'id' => $model->id], [
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
				'label'=>'Media Type',
				'value'=>$model->lookupMediaType->name,
			],
            'thumb_image:image',
            'media_title',
			[
				'label'=>$model->media_type_id==1?'Image':'Youtube ID',
				'format'=>$model->media_type_id==1?'image':'raw',
				'value'=>function($model){
					if($model->media_type_id==1)
					return $model->media_value;
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

</div>
