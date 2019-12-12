<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserCommissionsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'User Commissions';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-commissions-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create User Commissions', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'user_id',
            'total_commission_amount',
            'remarks:ntext',
            'status',
            // 'createdby',
            // 'createdat',
            // 'updatedby',
            // 'updatedat',
            // 'deletedby',
            // 'deletedat',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
