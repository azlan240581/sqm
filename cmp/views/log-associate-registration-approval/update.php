<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LogAssociateRegistrationApproval */

$this->title = 'Update Log Associate Registration Approval: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Log Associate Registration Approvals', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="log-associate-registration-approval-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
