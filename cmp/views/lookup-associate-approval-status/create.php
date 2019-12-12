<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\LookupAssociateApprovalStatus */

$this->title = 'Create Associate Approval Status';
$this->params['breadcrumbs'][] = 'System Management';
$this->params['breadcrumbs'][] = ['label' => 'Manage Associate Approval Status', 'url' => ['/lookup-associate-approval-status']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lookup-associate-approval-status-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
