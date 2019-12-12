<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LookupProductType */

$this->title = 'Update Product Type : ' . $model->name;
$this->params['breadcrumbs'][] = 'System Management';
$this->params['breadcrumbs'][] = ['label' => 'Manage Product Type', 'url' => ['/lookup-product-type']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="lookup-product-type-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
