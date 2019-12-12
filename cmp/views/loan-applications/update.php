<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LoanApplications */

$this->title = 'Update Loan Application : ' . $model->id;
$this->params['breadcrumbs'][] = 'Banks Management';
$this->params['breadcrumbs'][] = ['label' => 'Loan Applications', 'url' => ['/loan-applications']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="loan-applications-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
