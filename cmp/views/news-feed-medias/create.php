<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\NewsFeedMedias */

$this->title = 'Create News Feed Medias';
$this->params['breadcrumbs'][] = ['label' => 'News Feed Medias', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-feed-medias-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
