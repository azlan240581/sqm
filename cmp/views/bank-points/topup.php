<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\BankPoints */

$this->title = 'Topup Credits';
$this->params['breadcrumbs'][] = 'Points Management';
$this->params['breadcrumbs'][] = ['label' => 'Bank Points', 'url' => ['/bank-points']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bank-points-create">
    <?= $this->render('_form', [
        'model' => $model,
        'modelLogBankPoints' => $modelLogBankPoints,
    ]) ?>

</div>
