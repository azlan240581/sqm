<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\LookupDownpaymentApplicationStatus */

$this->title = 'Create Downpayment Application Status';
$this->params['breadcrumbs'][] = 'System Management';
$this->params['breadcrumbs'][] = ['label' => 'Manage Downpayment Application Status', 'url' => ['/lookup-downpayment-application-status']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lookup-downpayment-application-status-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
