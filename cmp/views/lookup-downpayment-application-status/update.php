<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LookupDownpaymentApplicationStatus */

$this->title = 'Update Downpayment Application Status : ' . $model->name;
$this->params['breadcrumbs'][] = 'System Management';
$this->params['breadcrumbs'][] = ['label' => 'Manage Downpayment Application Status', 'url' => ['/lookup-downpayment-application-status']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="lookup-downpayment-application-status-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
