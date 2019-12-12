<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\LookupDownpaymentPaidStatus */

$this->title = 'Create Downpayment Paid Status';
$this->params['breadcrumbs'][] = 'System Management';
$this->params['breadcrumbs'][] = ['label' => 'Manage Downpayment Paid Status', 'url' => ['/lookup-downpayment-paid-status']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lookup-downpayment-paid-status-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
