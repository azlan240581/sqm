<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LookupBankLoanProposalStatus */

$this->title = 'Update Bank Loan Proposal Status : ' . $model->name;
$this->params['breadcrumbs'][] = 'System Management';
$this->params['breadcrumbs'][] = ['label' => 'Manage Bank Loan Proposal Status', 'url' => ['/lookup-bank-loan-proposal-status']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="lookup-bank-loan-proposal-status-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
