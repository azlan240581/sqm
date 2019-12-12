<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\LookupProductType */

$this->title = 'Create Product Type';
$this->params['breadcrumbs'][] = 'System Management';
$this->params['breadcrumbs'][] = ['label' => 'Manage Product Type', 'url' => ['/lookup-product-type']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lookup-product-type-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
