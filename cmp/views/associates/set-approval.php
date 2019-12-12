<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\UserAssociateDetails */

$this->title = 'Set Approval Associate : '.$modelUsers->name;
$this->params['breadcrumbs'][] = 'Associates Management';
$this->params['breadcrumbs'][] = ['label' => 'List', 'url' => ['/associates']];
$this->params['breadcrumbs'][] = ['label' => $modelUsers->name, 'url' => ['view', 'id' => $modelUserAssociateDetails->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-associate-details-create">

    <?= $this->render('_formSetApproval', [
			'modelUserAssociateDetails' => $modelUserAssociateDetails,
			'modelUsers' => $modelUsers,
			'modelLogAssociateApproval' => $modelLogAssociateApproval,
			'lookupAssociateApprovalStatusList' => $lookupAssociateApprovalStatusList,
    ]) ?>

</div>
