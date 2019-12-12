<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\LookupCollateralMediaTypesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Manage Collateral Media Types';
$this->params['breadcrumbs'][] = 'System Management';
$this->params['breadcrumbs'][] = ['label' => 'Manage Collateral Media Types', 'url' => ['/lookup-collateral-media-types']];
?>
<div class="lookup-collateral-media-types-index">
    <p>
        <?= Html::a('Create Collateral Media Type', ['create'], ['class' => 'btn btn-success']) ?>
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
