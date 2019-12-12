<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\UserRewardRedemptions */

$this->title = 'Cancel Reward Redemptions: ' . $model->associateFirstName->firstname.' '.$model->associateFirstName->lastname.' : '.$model->reward->name;
$this->params['breadcrumbs'][] = 'Points Management';
$this->params['breadcrumbs'][] = ['label' => 'Associate Redemptions List', 'url' => ['/user-reward-redemptions']];
$this->params['breadcrumbs'][] = ['label' => $model->associateFirstName->firstname.' '.$model->associateFirstName->lastname.' : '.$model->reward->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="user-reward-redemptions-update">

    <?= $this->render('_formCancel', [
        'model' => $model,
		'modelLogUserRewardRedemptions' => $modelLogUserRewardRedemptions,
    ]) ?>

</div>
