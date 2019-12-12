<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LogAudit */

$this->title = 'Update Log Audit: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Log Audits', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="log-audit-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
