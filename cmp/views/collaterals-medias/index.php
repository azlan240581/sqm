<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CollateralsMediasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Collaterals Medias';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="collaterals-medias-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Collaterals Medias', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'collateral_id',
            'collateral_media_type_id',
            'thumb_image',
            'media_title',
            // 'media_value',
            // 'published',
            // 'sort',
            // 'createdby',
            // 'createdat',
            // 'deletedby',
            // 'deletedat',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
