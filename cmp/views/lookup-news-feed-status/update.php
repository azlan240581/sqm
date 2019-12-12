<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LookupNewsFeedStatus */

$this->title = 'Update News Feed Status : ' . $model->name;
$this->params['breadcrumbs'][] = 'System Management';
$this->params['breadcrumbs'][] = ['label' => 'Manage News Feed Status', 'url' => ['/lookup-news-feed-status']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="lookup-news-feed-status-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
