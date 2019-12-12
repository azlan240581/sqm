<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\LogProspectHistorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Log Prospect Histories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-prospect-history-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Log Prospect History', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'prospect_id',
            'prospect_booking_id',
            'history_id',
            'udf1',
            // 'udf2',
            // 'udf3',
            // 'remarks',
            // 'createdby',
            // 'createdat',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
