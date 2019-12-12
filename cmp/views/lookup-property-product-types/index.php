<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\LookupPropertyProductTypesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Manage Property Product Types';
$this->params['breadcrumbs'][] = 'System Management';
$this->params['breadcrumbs'][] = ['label' => 'Manage Property Product Types', 'url' => ['/lookup-property-product-types']];
?>
<div class="lookup-property-product-types-index">
    <p>
        <?= Html::a('Create Property Product Type', ['create'], ['class' => 'btn btn-success']) ?>
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
