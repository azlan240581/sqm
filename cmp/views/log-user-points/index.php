<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\LogUserPointsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Log User Points';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-user-points-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Log User Points', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'user_id',
            'points_value',
            'status',
            'remarks:ntext',
            // 'createdby',
            // 'createdat',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
