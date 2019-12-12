<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LogAssociateApproval */

$this->title = 'Update Log Associate Approval: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Log Associate Approvals', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="log-associate-approval-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
