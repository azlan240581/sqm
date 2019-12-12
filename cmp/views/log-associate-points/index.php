<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\LogAssociatePointsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Log Associate Points';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-associate-points-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Log Associate Points', ['create'], ['class' => 'btn btn-success']) ?>
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
