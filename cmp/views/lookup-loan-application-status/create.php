<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\LookupLoanApplicationStatus */

$this->title = 'Create Loan Application Status';
$this->params['breadcrumbs'][] = 'System Management';
$this->params['breadcrumbs'][] = ['label' => 'Manage Loan Application Status', 'url' => ['/lookup-loan-application-status']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lookup-loan-application-status-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
