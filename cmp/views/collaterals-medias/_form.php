<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CollateralsMedias */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="collaterals-medias-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'collateral_id')->textInput() ?>

    <?= $form->field($model, 'collateral_media_type_id')->textInput() ?>

    <?= $form->field($model, 'thumb_image')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'media_title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'media_value')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'published')->textInput() ?>

    <?= $form->field($model, 'sort')->textInput() ?>

    <?= $form->field($model, 'createdby')->textInput() ?>

    <?= $form->field($model, 'createdat')->textInput() ?>

    <?= $form->field($model, 'deletedby')->textInput() ?>

    <?= $form->field($model, 'deletedat')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
