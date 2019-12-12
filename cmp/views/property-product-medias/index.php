<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PropertyProductMediasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Property Product Medias';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="property-product-medias-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Property Product Medias', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'product_id',
            'media_type_id',
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
