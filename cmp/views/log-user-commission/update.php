<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LogUserCommission */

$this->title = 'Update Log User Commission: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Log User Commissions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="log-user-commission-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
