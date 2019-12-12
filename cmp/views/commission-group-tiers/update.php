<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Commission */

$this->title = 'Update Commission : ' . $model->lookupCommissionGroup->name;
$this->params['breadcrumbs'][] = 'Commission Management';
$this->params['breadcrumbs'][] = ['label' => 'Commission Tiers Manager', 'url' => ['/commission-group-tiers']];
$this->params['breadcrumbs'][] = ['label' => $model->lookupCommissionGroup->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="commission-update">

    <?= $this->render('_form', [
		'model' => $model,
		'productTypeList' => $productTypeList,
		'commissionGroupList' => $commissionGroupList,
		'commissionTierList' => $commissionTierList,
		'commissionTypeList' => $commissionTypeList,
    ]) ?>

</div>
