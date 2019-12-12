<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\LookupCollateralMediaTypes */

$this->title = 'Create Collateral Media Type';
$this->params['breadcrumbs'][] = 'System Management';
$this->params['breadcrumbs'][] = ['label' => 'Manage Collateral Media Types', 'url' => ['/lookup-collateral-media-types']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lookup-collateral-media-types-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
