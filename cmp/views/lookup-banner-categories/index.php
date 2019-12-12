<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\LookupBannerCategoriesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Manage Banner Categories';
$this->params['breadcrumbs'][] = 'System Management';
$this->params['breadcrumbs'][] = ['label' => 'Manage Banner Categories', 'url' => ['/lookup-banner-categories']];
?>
<div class="lookup-banner-categories-index">
    <p>
        <?= Html::a('Create Banner Category', ['create'], ['class' => 'btn btn-success']) ?>
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
