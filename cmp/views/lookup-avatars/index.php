<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\LookupAvatarSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Manage Avatars';
$this->params['breadcrumbs'][] = 'System Management';
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['/lookup-avatar']];
?>
<div class="lookup-avatar-index">
    <p>
        <?= Html::a('Create Avatar', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    
    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

			[
				'contentOptions' => ['style' => 'width:20%;'],
				'attribute'=>'image',
				'label'=>'Image',
				'format' => ['image',['width'=>'100%']],
				'filter' => false,
			],
            'name',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
