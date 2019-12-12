<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\LookupIndustryBackgroundSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Manage Industry Background List';
$this->params['breadcrumbs'][] = 'System Management';
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['/lookup-industry-background']];
?>
<div class="lookup-industry-background-index">
    <p>
        <?= Html::a('Create Industry Background', ['create'], ['class' => 'btn btn-success']) ?>
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
