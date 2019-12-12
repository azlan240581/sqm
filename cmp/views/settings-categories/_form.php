<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SettingsCategories */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="settings-categories-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'settings_category_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'settings_category_description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'updatedat')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
