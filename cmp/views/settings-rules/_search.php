<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SettingsRulesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="settings-rules-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'settings_categories_id') ?>

    <?= $form->field($model, 'settings_rules_key') ?>

    <?= $form->field($model, 'settings_rules_value') ?>

    <?= $form->field($model, 'settings_rules_desc') ?>

    <?php // echo $form->field($model, 'settings_rules_config_type') ?>

    <?php // echo $form->field($model, 'settings_rules_config') ?>

    <?php // echo $form->field($model, 'settings_rules_sort') ?>

    <?php // echo $form->field($model, 'updatedat') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
