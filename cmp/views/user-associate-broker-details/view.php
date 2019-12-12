<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\UserAssociateBrokerDetails */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'User Associate Broker Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-associate-broker-details-view">

    <h1><?= Html::encode($this->title) ?></h1>

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
            'id',
            'user_id',
            'company_name',
            'brand_name',
            'akta_perusahaan',
            'nib',
            'sk_menkeh',
            'npwp',
            'ktp_direktur',
            'bank_account',
            'credits',
            'createdby',
            'createdat',
            'updatedby',
            'updatedat',
        ],
    ]) ?>

</div>
