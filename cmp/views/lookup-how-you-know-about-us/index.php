<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\LookupHowYouKnowAboutUsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Manage How You Know About Us List';
$this->params['breadcrumbs'][] = 'System Management';
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['/lookup-how-you-know-about-us']];
?>
<div class="lookup-how-you-know-about-us-index">
    <p>
        <?= Html::a('Create How You Know About Us', ['create'], ['class' => 'btn btn-success']) ?>
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
