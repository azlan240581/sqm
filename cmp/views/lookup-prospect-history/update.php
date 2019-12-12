<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LookupProspectHistory */

$this->title = 'Update Prospect History: ' . $model->name;
$this->params['breadcrumbs'][] = 'System Management';
$this->params['breadcrumbs'][] = ['label' => 'Manage Prospect History', 'url' => ['/lookup-prospect-history']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="lookup-prospect-history-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
