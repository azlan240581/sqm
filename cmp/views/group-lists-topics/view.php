<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\GroupListsTopics */

$this->title = $model->topic_name;
$this->params['breadcrumbs'][] = 'Announcements Management';
$this->params['breadcrumbs'][] = 'Push Notifications';
$this->params['breadcrumbs'][] = ['label' => 'Group Lists / Topics', 'url' => ['/group-lists-topics']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="group-lists-topics-view">
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

            'topic_name',
			[
				'label'=>'Status',
				'value' => $model->status==1? 'Active':'Inactive',
			],
            'createdby',
            'createdat',
            'updatedby',
            'updatedat',
            'deletedby',
            'deletedat',
        ],
    ]) ?>

</div>
