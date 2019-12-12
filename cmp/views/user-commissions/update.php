<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\UserCommissions */

$this->title = 'Update User Commissions: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'User Commissions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="user-commissions-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
