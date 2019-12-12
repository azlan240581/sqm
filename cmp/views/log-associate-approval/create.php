<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\LogAssociateApproval */

$this->title = 'Create Log Associate Approval';
$this->params['breadcrumbs'][] = ['label' => 'Log Associate Approvals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-associate-approval-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
