<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\LookupAssociateCommissionActivities */

$this->title = 'Create Associate Commission Activity';
$this->params['breadcrumbs'][] = 'System Management';
$this->params['breadcrumbs'][] = ['label' => 'Manage Associate Commission Activities', 'url' => ['/lookup-associate-commission-activities']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lookup-associate-commission-activities-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
