<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProspectBookingsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Prospect Bookings';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="prospect-bookings-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Prospect Bookings', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'prospect_id',
            'agent_id',
            'member_id',
            'dedicated_agent_id',
            // 'referrer_member_id',
            // 'developer_id',
            // 'project_id',
            // 'product_id',
            // 'product_unit',
            // 'product_unit_type',
            // 'product_unit_price',
            // 'payment_method',
            // 'express_downpayment',
            // 'booking_eoi_amount',
            // 'proof_of_payment_eoi',
            // 'booking_amount',
            // 'proof_of_payment',
            // 'remarks:ntext',
            // 'status',
            // 'createdby',
            // 'createdat',
            // 'updatedby',
            // 'updatedat',
            // 'deletedby',
            // 'deletedat',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
