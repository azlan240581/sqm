<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\UserMessages */

$this->title = 'Send Notification';
$this->params['breadcrumbs'][] = 'Announcements Management';
$this->params['breadcrumbs'][] = 'Push Notifications';
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['/send-notification']];
?>
<div class="user-messages-create">

    <?= $this->render('_form', [
        'modelUserMessages' => $modelUserMessages,
        'memberListBox' => $memberListBox,
    ]) ?>

</div>
