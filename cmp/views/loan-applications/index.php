<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\LoanApplicationsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Loan Applications';
$this->params['breadcrumbs'][] = 'Banks Management';
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['/loan-applications']];
?>
<div class="loan-applications-index">
    <p>
        <?php //echo Html::a('Create Loan Applications', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'bank_id',
            'prospect_id',
            'loan_amount',
            'status',
            'createdby',
            'createdat',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
