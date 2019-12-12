<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UserAssociateDetailsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-associate-details-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'agent_id') ?>

    <?= $form->field($model, 'assistant_approval') ?>

    <?= $form->field($model, 'agent_approval') ?>

    <?php // echo $form->field($model, 'admin_approval') ?>

    <?php // echo $form->field($model, 'approval_status') ?>

    <?php // echo $form->field($model, 'productivity_status') ?>

    <?php // echo $form->field($model, 'domicile') ?>

    <?php // echo $form->field($model, 'occupation') ?>

    <?php // echo $form->field($model, 'industry_background') ?>

    <?php // echo $form->field($model, 'nricpass') ?>

    <?php // echo $form->field($model, 'tax_license') ?>

    <?php // echo $form->field($model, 'bank_account') ?>

    <?php // echo $form->field($model, 'udf1') ?>

    <?php // echo $form->field($model, 'udf2') ?>

    <?php // echo $form->field($model, 'udf3') ?>

    <?php // echo $form->field($model, 'udf4') ?>

    <?php // echo $form->field($model, 'udf5') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
