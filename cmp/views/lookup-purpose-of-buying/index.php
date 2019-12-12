<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\LookupPurposeOfBuyingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Manage Purpose Of Buying List';
$this->params['breadcrumbs'][] = 'System Management';
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['/lookup-purpose-of-buying']];
?>
<div class="lookup-purpose-of-buying-index">
    <p>
        <?= Html::a('Create Purpose Of Buying', ['create'], ['class' => 'btn btn-success']) ?>
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
