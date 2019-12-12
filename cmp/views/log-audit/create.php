<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\LogAudit */

$this->title = 'Create Log Audit';
$this->params['breadcrumbs'][] = ['label' => 'Log Audits', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-audit-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
