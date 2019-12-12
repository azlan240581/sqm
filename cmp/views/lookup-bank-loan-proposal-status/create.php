<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\LookupBankLoanProposalStatus */

$this->title = 'Create Bank Loan Proposal Status';
$this->params['breadcrumbs'][] = 'System Management';
$this->params['breadcrumbs'][] = ['label' => 'Manage Bank Loan Proposal Status', 'url' => ['/lookup-bank-loan-proposal-status']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lookup-bank-loan-proposal-status-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
