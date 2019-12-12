<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SettingsRules */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="settings-rules-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'employer_id')->textInput() ?>

    <?= $form->field($model, 'settings_categories_id')->textInput() ?>

    <?= $form->field($model, 'settings_rules_key')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'settings_rules_value')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'settings_rules_desc')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'settings_rules_config_type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'settings_rules_config')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'settings_rules_sort')->textInput() ?>

    <?= $form->field($model, 'updatedat')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
