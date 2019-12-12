<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\LookupDeveloperCommissionPaidStatus */

$this->title = 'Create Developer Commission Paid Status';
$this->params['breadcrumbs'][] = 'System Management';
$this->params['breadcrumbs'][] = ['label' => 'Manage Developer Commission Paid Status', 'url' => ['/lookup-developer-commission-paid-status']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lookup-developer-commission-paid-status-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
