<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\GroupListsTopics */

$this->title = 'Update Topic: ' . $model->topic_name;
$this->params['breadcrumbs'][] = 'Announcements';
$this->params['breadcrumbs'][] = 'Push Notifications';
$this->params['breadcrumbs'][] = ['label' => 'Group Lists / Topics', 'url' => ['/group-lists-topics']];
$this->params['breadcrumbs'][] = ['label' => $model->topic_name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="group-lists-topics-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
