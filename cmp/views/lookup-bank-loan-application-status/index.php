<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\LookupBankLoanApplicationStatusSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Manage Bank Loan Application Status';
$this->params['breadcrumbs'][] = 'System Management';
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['/lookup-bank-loan-application-status']];
?>
<div class="lookup-bank-loan-application-status-index">
    <p>
        <?= Html::a('Create Bank Loan Application Status', ['create'], ['class' => 'btn btn-success']) ?>
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
