<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LookupDownpaymentPaidStatus */

$this->title = 'Update Downpayment Paid Status : ' . $model->name;
$this->params['breadcrumbs'][] = 'System Management';
$this->params['breadcrumbs'][] = ['label' => 'Manage Downpayment Paid Status', 'url' => ['/lookup-downpayment-paid-status']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="lookup-downpayment-paid-status-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
