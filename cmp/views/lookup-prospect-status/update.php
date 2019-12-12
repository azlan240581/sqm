<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LookupProspectStatus */

$this->title = 'Update Prospect Status : ' . $model->name;
$this->params['breadcrumbs'][] = 'System Management';
$this->params['breadcrumbs'][] = ['label' => 'Manage Prospect Status', 'url' => ['/lookup-prospect-status']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="lookup-prospect-status-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
