<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\GroupAccess */

$this->title = 'Create Group';
$this->params['breadcrumbs'][] = 'User Management';
$this->params['breadcrumbs'][] = ['label' => 'Groups', 'url' => ['/group-access']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="group-access-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
