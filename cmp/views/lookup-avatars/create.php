<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\LookupAvatar */

$this->title = 'Create Avatar';
$this->params['breadcrumbs'][] = 'System Management';
$this->params['breadcrumbs'][] = ['label' => 'Manage Avatars', 'url' => ['/lookup-avatar']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lookup-avatar-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
