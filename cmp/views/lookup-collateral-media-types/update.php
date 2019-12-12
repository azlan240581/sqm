<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LookupCollateralMediaTypes */

$this->title = 'Update Collateral Media Type : ' . $model->name;
$this->params['breadcrumbs'][] = 'System Management';
$this->params['breadcrumbs'][] = ['label' => 'Manage Collateral Media Types', 'url' => ['/lookup-collateral-media-types']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="lookup-collateral-media-types-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
