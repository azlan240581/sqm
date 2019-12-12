<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LookupPointsActions */

$this->title = 'Update Point Action: ' . $model->name;
$this->params['breadcrumbs'][] = 'System Management';
$this->params['breadcrumbs'][] = ['label' => 'Manage Points Actions', 'url' => ['/lookup-points-actions']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="lookup-points-actions-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
