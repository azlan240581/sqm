<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\LoanApplications */

$this->title = '+ Add New Loan Application';
$this->params['breadcrumbs'][] = 'Banks Management';
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['/loan-applications/create']];
?>
<div class="loan-applications-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
