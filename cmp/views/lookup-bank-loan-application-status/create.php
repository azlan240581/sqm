<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\LookupBankLoanApplicationStatus */

$this->title = 'Create Bank Loan Application Status';
$this->params['breadcrumbs'][] = 'System Management';
$this->params['breadcrumbs'][] = ['label' => 'Manage Bank Loan Application Status', 'url' => ['/lookup-bank-loan-application-status']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lookup-bank-loan-application-status-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
