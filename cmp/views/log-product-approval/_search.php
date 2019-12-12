<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\LogProductApprovalSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="log-product-approval-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'product_id') ?>

    <?= $form->field($model, 'status') ?>

    <?= $form->field($model, 'remarks') ?>

    <?= $form->field($model, 'createdby') ?>

    <?php // echo $form->field($model, 'createdat') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
