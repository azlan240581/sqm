<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LookupJobType */

$this->title = 'Update Job Type : ' . $model->name;
$this->params['breadcrumbs'][] = 'System Management';
$this->params['breadcrumbs'][] = ['label' => 'Manage Job Type', 'url' => ['/lookup-job-type']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="lookup-job-type-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
