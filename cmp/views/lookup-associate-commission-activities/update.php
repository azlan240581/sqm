<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LookupAssociateCommissionActivities */

$this->title = 'Update Associate Commission Activity : ' . $model->name;
$this->params['breadcrumbs'][] = 'System Management';
$this->params['breadcrumbs'][] = ['label' => 'Manage Associate Commission Activities', 'url' => ['/lookup-associate-commission-activities']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="lookup-associate-commission-activities-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
