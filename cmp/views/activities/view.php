<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Activities */

$this->title = $model->activity_code;
$this->params['breadcrumbs'][] = 'Points Management';
$this->params['breadcrumbs'][] = ['label' => 'Activities', 'url' => ['/activities']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="activities-view">
    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php /*echo Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ])*/ ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [

            'activity_code',
            'activity_name',
            'activity_description:ntext',
			[
				'label'=>$model->getAttributeLabel('points_value'),
				'value'=>Yii::$app->AccessMod->getPointsFormat($model->points_value),
			],
			[
				'label'=>$model->getAttributeLabel('status'),
				'value'=>$model->status==1?'Active':'Inactive',
			],
			[
				'label'=>$model->getAttributeLabel('createdby'),
				'value'=>Yii::$app->AccessMod->getName($model->createdby),
			],
            'createdat:datetime',
			[
				'label'=>$model->getAttributeLabel('updatedby'),
				'value'=>Yii::$app->AccessMod->getName($model->updatedby),
			],
            'updatedat:datetime',
			
        ],
    ]) ?>

</div>
