<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\LookupDownpaymentPaidStatusSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Manage Downpayment Paid Status';
$this->params['breadcrumbs'][] = 'System Management';
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['/lookup-downpayment-paid-status']];
?>
<div class="lookup-downpayment-paid-status-index">
    <p>
        <?= Html::a('Create Downpayment Paid Status', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
            'deleted',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
