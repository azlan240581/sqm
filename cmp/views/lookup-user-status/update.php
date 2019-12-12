<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LookupUserStatus */

$this->title = 'Update User Status : ' . $model->name;
$this->params['breadcrumbs'][] = 'System Management';
$this->params['breadcrumbs'][] = ['label' => 'Manage User Status', 'url' => ['/lookup-user-status']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="lookup-user-status-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
