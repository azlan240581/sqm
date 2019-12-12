<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LookupDeveloperCommissionPaidStatus */

$this->title = 'Update Developer Commission Paid Status : ' . $model->name;
$this->params['breadcrumbs'][] = 'System Management';
$this->params['breadcrumbs'][] = ['label' => 'Manage Developer Commission Paid Status', 'url' => ['/lookup-developer-commission-paid-status']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="lookup-developer-commission-paid-status-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
