<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LookupCommissionTier */

$this->title = 'Update Commission Tier : ' . $model->name;
$this->params['breadcrumbs'][] = 'System Management';
$this->params['breadcrumbs'][] = ['label' => 'Manage Commission Tier', 'url' => ['/lookup-commission-tier']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="lookup-commission-tier-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
