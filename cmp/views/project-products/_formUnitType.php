<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ProjectProductUnitTypes */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="project-product-unit-types-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($modelProjectProductUnitTypes, 'type_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($modelProjectProductUnitTypes, 'building_size_sm')->textInput(['type' => 'number', 'min'=>0, 'step'=>'0.01']) ?>

    <?= $form->field($modelProjectProductUnitTypes, 'land_size_sm')->textInput(['type' => 'number', 'min'=>0, 'step'=>'0.01']) ?>

    <div class="form-group">
        <?= Html::submitButton($modelProjectProductUnitTypes->isNewRecord ? 'Create' : 'Update', ['class' => $modelProjectProductUnitTypes->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
