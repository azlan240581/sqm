<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LookupLoanApplicationStatus */

$this->title = 'Update Loan Application Status : ' . $model->name;
$this->params['breadcrumbs'][] = 'System Management';
$this->params['breadcrumbs'][] = ['label' => 'Manage Loan Application Status', 'url' => ['/lookup-loan-application-status']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="lookup-loan-application-status-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
