<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\LookupNewsFeedCategories */

$this->title = 'Create News Feed Category';
$this->params['breadcrumbs'][] = 'System Management';
$this->params['breadcrumbs'][] = ['label' => 'Manage News Feed Categories', 'url' => ['/lookup-news-feed-categories']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lookup-news-feed-categories-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
