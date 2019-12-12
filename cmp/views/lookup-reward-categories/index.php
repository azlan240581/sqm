<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\LookupRewardCategoriesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Manage Reward Categories';
$this->params['breadcrumbs'][] = 'System Management';
$this->params['breadcrumbs'][] = ['label' => 'Manage Reward Categories', 'url' => ['/lookup-reward-categories']];
?>
<div class="lookup-reward-categories-index">
    <p>
        <?= Html::a('Create Reward Category', ['create'], ['class' => 'btn btn-success']) ?>
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
