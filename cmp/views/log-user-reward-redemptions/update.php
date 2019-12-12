<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LogUserRewardRedemptions */

$this->title = 'Update Log User Reward Redemptions: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Log User Reward Redemptions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="log-user-reward-redemptions-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
