<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserAssociateBrokerDetailsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'User Associate Broker Details';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-associate-broker-details-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create User Associate Broker Details', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'user_id',
            'company_name',
            'brand_name',
            'akta_perusahaan',
            // 'nib',
            // 'sk_menkeh',
            // 'npwp',
            // 'ktp_direktur',
            // 'bank_account',
            // 'credits',
            // 'createdby',
            // 'createdat',
            // 'updatedby',
            // 'updatedat',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
