<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\LookupNewsFeedStatus */

$this->title = 'Create News Feed Status';
$this->params['breadcrumbs'][] = 'System Management';
$this->params['breadcrumbs'][] = ['label' => 'Manage News Feed Status', 'url' => ['/lookup-news-feed-status']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lookup-news-feed-status-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
