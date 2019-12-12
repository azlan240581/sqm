<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\NewPotentialProspects */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="new-potential-prospects-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'associate_id')->textInput() ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'contactno')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'registered')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
