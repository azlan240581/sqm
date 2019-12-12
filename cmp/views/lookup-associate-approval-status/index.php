<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\LookupAssociateApprovalStatusSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Manage Associate Approval Status';
$this->params['breadcrumbs'][] = 'System Management';
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['/lookup-associate-approval-status']];
?>
<div class="lookup-associate-approval-status-index">
    <p>
        <?= Html::a('Create Associate Approval Status', ['create'], ['class' => 'btn btn-success']) ?>
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
