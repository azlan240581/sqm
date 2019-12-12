<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LookupPaymentMethod */

$this->title = 'Update Payment Method : ' . $model->name;
$this->params['breadcrumbs'][] = 'System Management';
$this->params['breadcrumbs'][] = ['label' => 'Manage Payment Method', 'url' => ['/lookup-payment-method']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="lookup-payment-method-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
