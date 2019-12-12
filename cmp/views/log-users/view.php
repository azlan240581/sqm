<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\LogUsers */

$this->title = $model->id;
$this->params['breadcrumbs'][] = 'Reports';
$this->params['breadcrumbs'][] = 'Log';
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['/log-users']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-users-view">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
			'user.name',
            'remarks:ntext',
			[
				'label'=>'Created by',
				'value' => YII::$app->AccessMod->getUsername($model->createdby),
			],
			[
				'attribute'=>'createdat',
				'label'=>'Last Login At',
				'format'=>'datetime',
			],
        ],
    ]) ?>

</div>
