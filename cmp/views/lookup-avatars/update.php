<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LookupAvatar */

$this->title = 'Update Avatar: ' . $model->name;
$this->params['breadcrumbs'][] = 'System Management';
$this->params['breadcrumbs'][] = ['label' => 'Manage Avatars', 'url' => ['/lookup-avatar']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="lookup-avatar-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
