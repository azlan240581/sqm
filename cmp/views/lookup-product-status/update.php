<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LookupProductStatus */

$this->title = 'Update Product Status : ' . $model->name;
$this->params['breadcrumbs'][] = 'System Management';
$this->params['breadcrumbs'][] = ['label' => 'Manage Product Status', 'url' => ['/lookup-product-status']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="lookup-product-status-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
