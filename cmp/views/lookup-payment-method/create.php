<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\LookupPaymentMethod */

$this->title = 'Create Payment Method';
$this->params['breadcrumbs'][] = 'System Management';
$this->params['breadcrumbs'][] = ['label' => 'Manage Payment Method', 'url' => ['/lookup-payment-method']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lookup-payment-method-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
