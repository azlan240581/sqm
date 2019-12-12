<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LookupOccupation */

$this->title = 'Update Occupation : ' . $model->name;
$this->params['breadcrumbs'][] = 'System Management';
$this->params['breadcrumbs'][] = ['label' => 'Manage Occupation List', 'url' => ['/lookup-occupation']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="lookup-occupation-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
