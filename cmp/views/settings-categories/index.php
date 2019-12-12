<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SettingsCategoriesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Settings Categories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="settings-categories-index">
    <p>
        <?= Html::a('Create Settings Categories', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    
    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'settings_category_name',
            'settings_category_description',
            'updatedat',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
