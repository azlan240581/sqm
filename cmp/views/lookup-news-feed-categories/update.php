<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LookupNewsFeedCategories */

$this->title = 'Update News Feed Category : ' . $model->name;
$this->params['breadcrumbs'][] = 'System Management';
$this->params['breadcrumbs'][] = ['label' => 'Manage News Feed Categories', 'url' => ['/lookup-news-feed-categories']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="lookup-news-feed-categories-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
