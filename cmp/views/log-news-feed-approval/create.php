<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\LogNewsFeedApproval */

$this->title = 'Create Log News Feed Approval';
$this->params['breadcrumbs'][] = ['label' => 'Log News Feed Approvals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-news-feed-approval-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
