<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\SystemEmailTemplate */

$this->title = 'Create Email Template';
$this->params['breadcrumbs'][] = 'System Management';
$this->params['breadcrumbs'][] = ['label' => 'Manage Email Template', 'url' => ['/system-email-template']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="system-email-template-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
