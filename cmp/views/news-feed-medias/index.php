<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\NewsFeedMediasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'News Feed Medias';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-feed-medias-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create News Feed Medias', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'news_feed_id',
            'media_type_id',
            'thumb_image',
            'media_title',
            // 'media_value',
            // 'published',
            // 'sort',
            // 'createdby',
            // 'createdat',
            // 'deletedby',
            // 'deletedat',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
