<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\LookupNewsFeedStatusSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Manage News Feed Status';
$this->params['breadcrumbs'][] = 'System Management';
$this->params['breadcrumbs'][] = ['label' => 'Manage News Feed Status', 'url' => ['/lookup-news-feed-status']];
?>
<div class="lookup-news-feed-status-index">
    <p>
        <?= Html::a('Create News Feed Status', ['create'], ['class' => 'btn btn-success']) ?>
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
