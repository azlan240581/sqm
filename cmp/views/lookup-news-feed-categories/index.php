<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\LookupNewsFeedCategoriesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Manage News Feed Categories';
$this->params['breadcrumbs'][] = 'System Management';
$this->params['breadcrumbs'][] = ['label' => 'Manage News Feed Categories', 'url' => ['/lookup-news-feed-categories']];
?>
<div class="lookup-news-feed-categories-index">
    <p>
        <?= Html::a('Create News Feed Category', ['create'], ['class' => 'btn btn-success']) ?>
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
