<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Commission */

$this->title = 'Commission Tiers Manager';
$this->params['breadcrumbs'][] = 'Commission Management';
$this->params['breadcrumbs'][] = ['label' => 'Commission Tiers Manager', 'url' => ['/commission-group-tiers']];
?>
<div class="commission-create">

    <?= $this->render('_formAdmin', [
		'model' => $model,
		'commissionGroupTierList' => $commissionGroupTierList,
		'productTypeList' => $productTypeList,
		'commissionGroupList' => $commissionGroupList,
		'commissionTierList' => $commissionTierList,
		'commissionTypeList' => $commissionTypeList,
    ]) ?>

</div>
