<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\DetailView;
use yii\bootstrap\Modal;
use kartik\daterange\DateRangePicker;
use yii\helpers\ArrayHelper;


/* @var $this yii\web\View */
/* @var $model app\models\Collaterals */

$this->title = $model->title;
$this->params['breadcrumbs'][] = 'Collaterals Management';
$this->params['breadcrumbs'][] = ['label' => 'List', 'url' => ['/collaterals']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="collaterals-view">

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [

			[
				'label'=>'Project Name',
				'value'=>$model->project->project_name,
			],
			[
				'label'=>'Collateral Type',
				'value'=>$modelCollateralsMedias->lookupCollateralMediaType->name,
			],
            'title',
            'permalink',
            'summary:ntext',
			[
				'label'=>'Status',
				'format'=>'raw',
				'value'  => call_user_func(function ($model) {
						return html_entity_decode($model->description);
					}, $model),
			],
			[
				'attribute' => 'thumb_image',
				'format'=>'raw',
				'value'=> !strlen($model->thumb_image)?NULL:Html::a(Html::img($model->thumb_image, ['width'=>200]),$model->thumb_image, ['data-fancybox'=>true]),
			],
			[
				'label'=>'Collateral Link',
				'format'=>'url',
				'value'=>$modelCollateralsMedias->media_value,
			],
		    //'published_date_start:datetime',
            //'published_date_end:datetime',
            'sort',
			[
				'label'=>'Status',
				'value'=>$model->status==1?'Active':'Inactive',
			],
			[
				'label'=>'Created By',
				'value'=>Yii::$app->AccessMod->getName($model->createdby),
			],
            'createdat:datetime',
			[
				'label'=>'Updated By',
				'value'=>Yii::$app->AccessMod->getName($model->updatedby),
			],
            'updatedat:datetime',
			/*[
				'label'=>'Deleted By',
				'value'=>Yii::$app->AccessMod->getName($model->deletedby),
			],*/
            //'deletedat:datetime',
			
        ],
    ]) ?>

</div>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.6/dist/jquery.fancybox.min.css" />
<script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.6/dist/jquery.fancybox.min.js"></script>


