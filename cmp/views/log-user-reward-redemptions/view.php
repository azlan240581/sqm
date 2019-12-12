<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\LogUserRewardRedemptions */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Log User Reward Redemptions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-user-reward-redemptions-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'user_id',
            'reward_id',
            'associate_reward_redemption_id',
            'points_value',
            'ticket_no',
            'status',
            'remarks:ntext',
            'createdby',
            'createdat',
        ],
    ]) ?>

</div>
