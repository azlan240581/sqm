<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LookupDomicile */

$this->title = 'Update Domicile : ' . $model->name;
$this->params['breadcrumbs'][] = 'System Management';
$this->params['breadcrumbs'][] = ['label' => 'Manage Domicile List', 'url' => ['/lookup-domicile']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="lookup-domicile-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
