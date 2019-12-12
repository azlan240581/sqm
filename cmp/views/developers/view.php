<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Developers */

$this->title = $model->company_name;
$this->params['breadcrumbs'][] = 'Developer Management';
$this->params['breadcrumbs'][] = ['label' => 'List', 'url' => ['/developers']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="developers-view">
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

            'company_name',
            'company_registration_no',
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
			
        ],
    ]) ?>

</div>
