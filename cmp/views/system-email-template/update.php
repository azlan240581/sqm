<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SystemEmailTemplate */

$this->title = 'Update Email Template: ' . $model->name;
$this->params['breadcrumbs'][] = 'System Management';
$this->params['breadcrumbs'][] = ['label' => 'Manage Email Template', 'url' => ['/system-email-template']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="system-email-template-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
