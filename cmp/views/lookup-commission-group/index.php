<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\LookupCommissionGroupSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Manage Commission Group';
$this->params['breadcrumbs'][] = 'System Management';
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['/lookup-commission-group']];
?>
<div class="lookup-commission-group-index">
    <p>
        <?= Html::a('Create Commission Group', ['create'], ['class' => 'btn btn-success']) ?>
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
