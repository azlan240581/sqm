<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LookupPropertyProductTypes */

$this->title = 'Update Property Product Type : ' . $model->name;
$this->params['breadcrumbs'][] = 'System Management';
$this->params['breadcrumbs'][] = ['label' => 'Manage Property Product Types', 'url' => ['/lookup-property-product-types']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="lookup-property-product-types-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
