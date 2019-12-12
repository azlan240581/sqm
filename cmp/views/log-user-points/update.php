<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LogUserPoints */

$this->title = 'Update Log User Points: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Log User Points', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="log-user-points-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
