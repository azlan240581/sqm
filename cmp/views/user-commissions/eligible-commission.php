<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\UserCommissions */

$this->title = 'Create User Commissions';
$this->params['breadcrumbs'][] = ['label' => 'User Commissions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-commissions-create">

    <?= $this->render('_formEligibleCommission', [
		'modelUserCommissions' => $modelUserCommissions,
		'modelLogUserCommission' => $modelLogUserCommission,
		'totalCommissionPaid' => $totalCommissionPaid,
    ]) ?>

</div>
