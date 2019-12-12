<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\NewsFeedMedias */

$this->title = 'Create News Feed Media';
$this->params['breadcrumbs'][] = 'News Feed Management';
$this->params['breadcrumbs'][] = ['label' => 'List', 'url' => ['/news-feeds']];
$this->params['breadcrumbs'][] = ['label' => $modelNewsFeeds->title, 'url' => ['view', 'id' => $modelNewsFeeds->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-feed-medias-create">

    <?= $this->render('_formMedia', [
			'modelNewsFeeds' => $modelNewsFeeds,
			'modelNewsFeedMedias' => $modelNewsFeedMedias,
			'lookupMediaTypeList' => $lookupMediaTypeList,
    ]) ?>

</div>
