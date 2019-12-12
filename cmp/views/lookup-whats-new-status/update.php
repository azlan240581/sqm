<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LookupWhatsNewStatus */

$this->title = 'Update Whats New Status : ' . $model->name;
$this->params['breadcrumbs'][] = 'System Management';
$this->params['breadcrumbs'][] = ['label' => 'Manage Whats New Status', 'url' => ['/lookup-whats-new-status']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="lookup-whats-new-status-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
