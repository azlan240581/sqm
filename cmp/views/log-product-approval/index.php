<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\LogProductApprovalSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Log Product Approvals';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-product-approval-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Log Product Approval', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'product_id',
            'status',
            'remarks',
            'createdby',
            // 'createdat',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
