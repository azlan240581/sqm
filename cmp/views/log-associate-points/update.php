<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LogAssociatePoints */

$this->title = 'Update Log Associate Points: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Log Associate Points', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="log-associate-points-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
