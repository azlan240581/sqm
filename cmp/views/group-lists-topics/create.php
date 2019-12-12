<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\GroupListsTopics */

$this->title = 'Create Topic';
$this->params['breadcrumbs'][] = 'Announcements Management';
$this->params['breadcrumbs'][] = 'Push Notifications';
$this->params['breadcrumbs'][] = ['label' => 'Group Lists / Topics', 'url' => ['/group-lists-topics']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="group-lists-topics-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
