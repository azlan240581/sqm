<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\NewsFeedMedias */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'News Feed Medias', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-feed-medias-view">

    <h1><?= Html::encode($this->title) ?></h1>

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
            'id',
            'news_feed_id',
            'media_type_id',
            'thumb_image',
            'media_title',
            'media_value',
            'published',
            'sort',
            'createdby',
            'createdat',
            'deletedby',
            'deletedat',
        ],
    ]) ?>

</div>
