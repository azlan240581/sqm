<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LookupAssociateApprovalStatus */

$this->title = 'Update Associate Approval Status : ' . $model->name;
$this->params['breadcrumbs'][] = 'System Management';
$this->params['breadcrumbs'][] = ['label' => 'Manage Associate Approval Status', 'url' => ['/lookup-associate-approval-status']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="lookup-associate-approval-status-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
