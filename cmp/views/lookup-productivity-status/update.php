<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LookupProductivityStatus */

$this->title = 'Update Productivity Status : ' . $model->name;
$this->params['breadcrumbs'][] = 'System Management';
$this->params['breadcrumbs'][] = ['label' => 'Manage Productivity Status', 'url' => ['/lookup-productivity-status']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="lookup-productivity-status-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
