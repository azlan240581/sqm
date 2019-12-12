<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LookupUserCommissionStatus */

$this->title = 'Update Commission Status : ' . $model->name;
$this->params['breadcrumbs'][] = 'System Management';
$this->params['breadcrumbs'][] = ['label' => 'Manage Commission Status', 'url' => ['/lookup-user-commission-status']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="lookup-user-commission-status-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
