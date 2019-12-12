<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\LookupCommissionTier */

$this->title = 'Create Commission Tier';
$this->params['breadcrumbs'][] = 'System Management';
$this->params['breadcrumbs'][] = ['label' => 'Manage Commission Tier', 'url' => ['/lookup-commission-tier']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lookup-commission-tier-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
