<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LookupCountry */

$this->title = 'Update Country: ' . $model->name;
$this->params['breadcrumbs'][] = 'System Management';
$this->params['breadcrumbs'][] = ['label' => 'Manage Countries', 'url' => ['/lookup-country']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="lookup-country-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
