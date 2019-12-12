<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\SystemEmailTemplate */

$this->title = $model->name;
$this->params['breadcrumbs'][] = 'System Management';
$this->params['breadcrumbs'][] = ['label' => 'Manage Email Template', 'url' => ['/system-email-template']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="system-email-template-view">
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

            'code',
            'name',
            'description',
            'subject',
			[
				'label' => 'Template',
				'format' => 'raw',
				'value' => $model->getTemplate($model->template),
			],
			
        ],
    ]) ?>

</div>
