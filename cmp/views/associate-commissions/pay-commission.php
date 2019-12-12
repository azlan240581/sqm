<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\UserCommissions */

$this->title = 'Create User Commissions';
$this->params['breadcrumbs'][] = ['label' => 'User Commissions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-commissions-create">

    <?= $this->render('_formPayCommission', [
            'modelUserCommissions' => $modelUserCommissions,
            'modelUserEligibleCommissions' => $modelUserEligibleCommissions,
            'modelProspectBookings' => $modelProspectBookings,
            'modelLogUserCommission' => $modelLogUserCommission,
    ]) ?>

</div>
