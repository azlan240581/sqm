<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LogProductApproval */

$this->title = 'Update Log Product Approval: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Log Product Approvals', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="log-product-approval-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
