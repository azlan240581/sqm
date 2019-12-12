<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LookupAssociateStatus */

$this->title = 'Update Associate Status : ' . $model->name;
$this->params['breadcrumbs'][] = 'System Management';
$this->params['breadcrumbs'][] = ['label' => 'Manage Associate Status', 'url' => ['/lookup-associate-status']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="lookup-associate-status-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
