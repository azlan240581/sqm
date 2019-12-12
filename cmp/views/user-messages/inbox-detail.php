<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\UserMessages */

$this->title = 'Full Message';
$this->params['breadcrumbs'][] = ['label' => 'User Messages', 'url' => ['inbox']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-messages-view">

    <p>
        <?= Html::a('Delete', ['inbox-delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this message?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'subject',
            'message:raw',
			[
				'attribute' => 'createdby',
				'value' => Yii::$app->AccessMod->getUsername($model->createdby),
			],
			[
				'attribute' => 'priority',
				'value' => ($model->priority==3?'Important':($model->priority==2?'Normal':'Low')),
			],
			[
				'attribute' => 'mark_as_read',
				'value' => ($model->mark_as_read==1?'Read':'Unread'),
			],
            'createdat:datetime',
        ],
    ]) ?>

	<p>
    	<button class="btn btn-primary" type="button" onclick="window.history.back();">Back</button>
    </p>
</div>
