<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\LogAssociateApprovalSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Log Associate Approvals';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-associate-approval-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Log Associate Approval', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'user_id',
            'status',
            'remarks:ntext',
            'createdby',
            // 'createdat',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
