<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProjectProductUnitTypesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Project Product Unit Types';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-product-unit-types-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Project Product Unit Types', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'project_id',
            'project_product_id',
            'type_name',
            'building_size_sm',
            // 'land_size_sm',
            // 'createdby',
            // 'createdat',
            // 'updatedby',
            // 'updatedat',
            // 'deletedby',
            // 'deletedat',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
