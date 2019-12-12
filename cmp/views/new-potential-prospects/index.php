<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\NewPotentialProspectsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'New Potential Prospects';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="new-potential-prospects-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create New Potential Prospects', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'associate_id',
            'name',
            'email:email',
            'contactno',
            // 'registered',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
