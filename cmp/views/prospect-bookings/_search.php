<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ProspectBookingsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="prospect-bookings-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'prospect_id') ?>

    <?= $form->field($model, 'agent_id') ?>

    <?= $form->field($model, 'member_id') ?>

    <?= $form->field($model, 'dedicated_agent_id') ?>

    <?php // echo $form->field($model, 'referrer_member_id') ?>

    <?php // echo $form->field($model, 'developer_id') ?>

    <?php // echo $form->field($model, 'project_id') ?>

    <?php // echo $form->field($model, 'product_id') ?>

    <?php // echo $form->field($model, 'product_unit') ?>

    <?php // echo $form->field($model, 'product_unit_type') ?>

    <?php // echo $form->field($model, 'product_unit_price') ?>

    <?php // echo $form->field($model, 'payment_method') ?>

    <?php // echo $form->field($model, 'express_downpayment') ?>

    <?php // echo $form->field($model, 'booking_eoi_amount') ?>

    <?php // echo $form->field($model, 'proof_of_payment_eoi') ?>

    <?php // echo $form->field($model, 'booking_amount') ?>

    <?php // echo $form->field($model, 'proof_of_payment') ?>

    <?php // echo $form->field($model, 'remarks') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'createdby') ?>

    <?php // echo $form->field($model, 'createdat') ?>

    <?php // echo $form->field($model, 'updatedby') ?>

    <?php // echo $form->field($model, 'updatedat') ?>

    <?php // echo $form->field($model, 'deletedby') ?>

    <?php // echo $form->field($model, 'deletedat') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
