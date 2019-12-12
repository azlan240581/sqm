<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Rewards */

$this->title = 'Update Reward : ' . $model->name;
$this->params['breadcrumbs'][] = 'Rewards Management';
$this->params['breadcrumbs'][] = ['label' => 'List', 'url' => ['/rewards']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="rewards-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
