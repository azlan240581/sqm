<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\LoanApplications */

$this->title = $model->id;
$this->params['breadcrumbs'][] = 'Banks Management';
$this->params['breadcrumbs'][] = ['label' => 'Loan Applications', 'url' => ['/loan-applications']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="loan-applications-view">

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
		
            'bank_id',
            'prospect_id',
            'loan_amount',
            'status',
            'createdby',
            'createdat',
            'updatedby',
            'updatedat',
            'deletedby',
            'deletedat',
			
        ],
    ]) ?>

</div>
