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
            'modelUserEligibleCommissions' => $modelUserEligibleCommissions,
            'modelLogUserCommission' => $modelLogUserCommission,
            'modelProspectBookings' => $modelProspectBookings,
            'modelUserCommissions' => $modelUserCommissions,
            'logUserCommission' => $logUserCommission,
            'totalEligibleCommissionAmount' => $totalEligibleCommissionAmount,
            'totalCommissionPaid' => $totalCommissionPaid,
    ]) ?>

</div>
