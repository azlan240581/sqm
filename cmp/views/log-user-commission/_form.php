<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\LogUserCommission */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="log-user-commission-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'commission_group_tier_id')->textInput() ?>

    <?= $form->field($model, 'prospect_id')->textInput() ?>

    <?= $form->field($model, 'prospect_booking_id')->textInput() ?>

    <?= $form->field($model, 'user_commission_id')->textInput() ?>

    <?= $form->field($model, 'user_eligible_commission_id')->textInput() ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'commission_amount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'remarks')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'createdby')->textInput() ?>

    <?= $form->field($model, 'createdat')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
