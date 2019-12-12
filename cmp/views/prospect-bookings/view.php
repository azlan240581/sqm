<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\ProspectBookings */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Prospect Bookings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="prospect-bookings-view">

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
            'prospect_id',
            'agent_id',
            'member_id',
            'dedicated_agent_id',
            'referrer_member_id',
            'developer_id',
            'project_id',
            'product_id',
            'product_unit',
            'product_unit_type',
            'product_unit_price',
            'payment_method',
            'express_downpayment',
            'booking_eoi_amount',
            'proof_of_payment_eoi',
            'booking_amount',
            'proof_of_payment',
            'remarks:ntext',
            'status',
            'createdby',
            'createdat',
            'updatedby',
            'updatedat',
            'deletedby',
            'deletedat',
        ],
    ]) ?>

</div>
