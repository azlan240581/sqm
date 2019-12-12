<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ProspectBookings */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="prospect-bookings-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'prospect_id')->textInput() ?>

    <?= $form->field($model, 'agent_id')->textInput() ?>

    <?= $form->field($model, 'member_id')->textInput() ?>

    <?= $form->field($model, 'dedicated_agent_id')->textInput() ?>

    <?= $form->field($model, 'referrer_member_id')->textInput() ?>

    <?= $form->field($model, 'developer_id')->textInput() ?>

    <?= $form->field($model, 'project_id')->textInput() ?>

    <?= $form->field($model, 'product_id')->textInput() ?>

    <?= $form->field($model, 'product_unit')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'product_unit_type')->textInput() ?>

    <?= $form->field($model, 'product_unit_price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'payment_method')->textInput() ?>

    <?= $form->field($model, 'express_downpayment')->textInput() ?>

    <?= $form->field($model, 'booking_eoi_amount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'proof_of_payment_eoi')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'booking_amount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'proof_of_payment')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'remarks')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'createdby')->textInput() ?>

    <?= $form->field($model, 'createdat')->textInput() ?>

    <?= $form->field($model, 'updatedby')->textInput() ?>

    <?= $form->field($model, 'updatedat')->textInput() ?>

    <?= $form->field($model, 'deletedby')->textInput() ?>

    <?= $form->field($model, 'deletedat')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
