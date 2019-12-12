<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LookupAssociateProductivityStatus */

$this->title = 'Update Associate Productivity Status : ' . $model->name;
$this->params['breadcrumbs'][] = 'System Management';
$this->params['breadcrumbs'][] = ['label' => 'Manage Associate Productivity Status', 'url' => ['/lookup-associate-productivity-status']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="lookup-associate-productivity-status-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
