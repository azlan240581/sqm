<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Commission */

$this->title = 'Create Commission Group Tier';
$this->params['breadcrumbs'][] = 'Commission Management';
$this->params['breadcrumbs'][] = ['label' => 'Commission Tiers Manager', 'url' => ['/commission-group-tiers']];
$this->params['breadcrumbs'][] = 'Create';
?>
<div class="commission-create">

    <?= $this->render('_form', [
		'model' => $model,
		'productTypeList' => $productTypeList,
		'commissionGroupList' => $commissionGroupList,
		'commissionTierList' => $commissionTierList,
		'commissionTypeList' => $commissionTypeList,
    ]) ?>

</div>
