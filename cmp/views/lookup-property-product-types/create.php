<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\LookupPropertyProductTypes */

$this->title = 'Create Property Product Type';
$this->params['breadcrumbs'][] = 'System Management';
$this->params['breadcrumbs'][] = ['label' => 'Manage Property Product Types', 'url' => ['/lookup-property-product-types']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lookup-property-product-types-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
