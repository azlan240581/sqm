<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LookupMaritalStatus */

$this->title = 'Update Marital Status : ' . $model->name;
$this->params['breadcrumbs'][] = 'System Management';
$this->params['breadcrumbs'][] = ['label' => 'Manage Marital Status', 'url' => ['/lookup-marital-status']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="lookup-marital-status-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
