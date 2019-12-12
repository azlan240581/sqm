<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\LogAssociateRegistrationApproval */

$this->title = 'Create Log Associate Registration Approval';
$this->params['breadcrumbs'][] = ['label' => 'Log Associate Registration Approvals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-associate-registration-approval-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
