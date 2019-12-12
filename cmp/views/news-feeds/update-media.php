<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\NewsFeedMedias */

$this->title = 'Update News Feed Media : ' . $modelNewsFeedMedias->media_title;
$this->params['breadcrumbs'][] = 'Property Products Management';
$this->params['breadcrumbs'][] = ['label' => 'List', 'url' => ['/news-feeds']];
$this->params['breadcrumbs'][] = ['label' => $modelNewsFeeds->title, 'url' => ['view', 'id' => $modelNewsFeeds->id]];
$this->params['breadcrumbs'][] = ['label' => $modelNewsFeedMedias->media_title, 'url' => ['view-media', 'id' => $modelNewsFeedMedias->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="news-feed-medias-update">

    <?= $this->render('_formMedia', [
			'modelNewsFeeds' => $modelNewsFeeds,
			'modelNewsFeedMedias' => $modelNewsFeedMedias,
			'lookupMediaTypeList' => $lookupMediaTypeList,
    ]) ?>

</div>
