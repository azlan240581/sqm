<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LogProspectHistory */

$this->title = 'Update Log Prospect History: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Log Prospect Histories', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="log-prospect-history-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
