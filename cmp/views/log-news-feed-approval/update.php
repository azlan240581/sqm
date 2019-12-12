<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LogNewsFeedApproval */

$this->title = 'Update Log News Feed Approval: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Log News Feed Approvals', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="log-news-feed-approval-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
