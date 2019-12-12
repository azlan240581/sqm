<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LookupRedemptionStatus */

$this->title = 'Update Redemption Status : ' . $model->name;
$this->params['breadcrumbs'][] = 'System Management';
$this->params['breadcrumbs'][] = ['label' => 'Manage Redemption Status', 'url' => ['/lookup-redemption-status']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="lookup-redemption-status-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
