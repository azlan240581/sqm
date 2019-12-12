<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Banks */

$this->title = $model->bank_name;
$this->params['breadcrumbs'][] = 'Banks Management';
$this->params['breadcrumbs'][] = ['label' => 'List', 'url' => ['/banks']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="banks-view">

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
		
            'bank_name',
            'company_name',
            'company_registration_no',
            'company_description:ntext',
            'contact_person_name',
            'contact_person_email:email',
            'contact_person_contactno',
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
			[
				'label'=>$model->getAttributeLabel('deletedby'),
				'value'=>Yii::$app->AccessMod->getName($model->deletedby),
			],
            'deletedat:datetime',
			
        ],
    ]) ?>

</div>
