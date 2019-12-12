<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\CollateralsMedias */

$this->title = $modelCollaterals->title.' : '.$modelCollateralsMedias->media_title;
$this->params['breadcrumbs'][] = 'Collaterals Management';
$this->params['breadcrumbs'][] = ['label' => 'List', 'url' => ['/collaterals']];
$this->params['breadcrumbs'][] = ['label' => $modelCollaterals->title, 'url' => ['view', 'id' => $modelCollaterals->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="collaterals-medias-view">

    <p>
        <?= Html::a('Update', ['update-media', 'id' => $modelCollateralsMedias->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete-media', 'id' => $modelCollateralsMedias->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $modelCollateralsMedias,
        'attributes' => [
		
			[
				'label'=>'Media Type',
				'value'=>$modelCollateralsMedias->lookupCollateralMediaType->name,
			],
            'thumb_image:image',
            'media_title',
			[
				'label'=>'Media Link',
				'value'=>$modelCollateralsMedias->media_value,
			],
			[
				'label'=>'Published',
				'value'=>$modelCollateralsMedias->published==1?'Yes':'No',
			],
            'sort',
			[
				'label'=>'Published',
				'value'=>Yii::$app->AccessMod->getName($modelCollateralsMedias->createdby),
			],
            'createdat:datetime',
            //'deletedby',
            //'deletedat',
			
        ],
    ]) ?>

</div>
