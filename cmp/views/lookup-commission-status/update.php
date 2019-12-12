<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LookupCommissionStatus */

$this->title = 'Update Commission Status : ' . $model->name;
$this->params['breadcrumbs'][] = 'System Management';
$this->params['breadcrumbs'][] = ['label' => 'Manage Commission Status', 'url' => ['/lookup-commission-status']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="lookup-commission-status-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
