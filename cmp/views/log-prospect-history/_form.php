<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\LogProspectHistory */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="log-prospect-history-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'prospect_id')->textInput() ?>

    <?= $form->field($model, 'prospect_booking_id')->textInput() ?>

    <?= $form->field($model, 'history_id')->textInput() ?>

    <?= $form->field($model, 'udf1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'udf2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'udf3')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'remarks')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'createdby')->textInput() ?>

    <?= $form->field($model, 'createdat')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
