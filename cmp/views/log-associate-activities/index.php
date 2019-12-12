<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\LogAssociateActivitiesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Log Associate Activities';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-associate-activities-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Log Associate Activities', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'associate_id',
            'activity_id',
            'news_feed_id',
            'product_id',
            // 'banner_id',
            // 'createdby',
            // 'createdat',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
