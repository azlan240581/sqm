<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AssociatePoints */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="associate-points-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'total_points_value')->textInput(['maxlength' => true]) ?>

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
