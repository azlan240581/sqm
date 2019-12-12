<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\UserMessages */

$this->title = 'Subject : '.$modelLogUserMessages->subject;
$this->params['breadcrumbs'][] = 'Announcements Management';
$this->params['breadcrumbs'][] = 'Push Notifications';
$this->params['breadcrumbs'][] = ['label' => 'Send Notification', 'url' => ['/send-notification']];
?>
<div class="user-messages-view">

	<p></p>
    <?= DetailView::widget([
        'model' => $modelLogUserMessages,
        'attributes' => [
            'recepients_list:ntext',
            'subject:ntext',
            'message:ntext',
			[
				'attribute' => 'long_message',
				'value' => html_entity_decode($modelLogUserMessages->long_message),
				'format' => 'raw',
			],
			[
				'label' => 'Created By',
				'value' => Yii::$app->AccessMod->getName($modelLogUserMessages->createdby),
			],
			[
				'label' => 'Created At',
				'attribute' => 'createdat',
				'format' => 'datetime',
			],
        ],
    ]) ?>

</div>
