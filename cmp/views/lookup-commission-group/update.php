<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LookupCommissionGroup */

$this->title = 'Update Commission Group : ' . $model->name;
$this->params['breadcrumbs'][] = 'System Management';
$this->params['breadcrumbs'][] = ['label' => 'Manage Commission Group', 'url' => ['/lookup-commission-group']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="lookup-commission-group-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
