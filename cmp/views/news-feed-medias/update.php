<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\NewsFeedMedias */

$this->title = 'Update News Feed Medias: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'News Feed Medias', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="news-feed-medias-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
