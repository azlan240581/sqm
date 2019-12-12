<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\LogUserRewardRedemptions */

$this->title = 'Create Log User Reward Redemptions';
$this->params['breadcrumbs'][] = ['label' => 'Log User Reward Redemptions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-user-reward-redemptions-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
