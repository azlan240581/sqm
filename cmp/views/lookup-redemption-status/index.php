<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\LookupRedemptionStatusSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Manage Redemption Status';
$this->params['breadcrumbs'][] = 'System Management';
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['/lookup-redemption-status']];
?>
<div class="lookup-redemption-status-index">
    <p>
        <?= Html::a('Create Redemption Status', ['create'], ['class' => 'btn btn-success']) ?>
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
