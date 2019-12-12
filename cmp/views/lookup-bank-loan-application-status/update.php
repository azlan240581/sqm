<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LookupBankLoanApplicationStatus */

$this->title = 'Update Bank Loan Application Status : ' . $model->name;
$this->params['breadcrumbs'][] = 'System Management';
$this->params['breadcrumbs'][] = ['label' => 'Manage Bank Loan Application Status', 'url' => ['/lookup-bank-loan-application-status']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="lookup-bank-loan-application-status-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
