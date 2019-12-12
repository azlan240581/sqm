<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\LookupLoanApplicationStatusSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Manage Loan Application Status';
$this->params['breadcrumbs'][] = 'System Management';
$this->params['breadcrumbs'][] = ['label' => 'Manage Loan Application Status', 'url' => ['/lookup-loan-application-status']];
?>
<div class="lookup-loan-application-status-index">
    <p>
        <?= Html::a('Create Loan Application Status', ['create'], ['class' => 'btn btn-success']) ?>
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
