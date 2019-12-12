<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\GroupAccess */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="group-access-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'group_access_name')->textInput(['maxlength' => true])->label('Group Access Name*') ?>

    <?= $form->field($model, 'sort')->textInput(['type' => 'number', 'min' => 0, 'value'=>0]) ?>

    <?= $form->field($model, 'status')->radioList([1 => 'Active', 0 => 'Inactive'],['itemOptions' => ['labelOptions' => ['class' => 'col-md-1']]])->label('Status*') ?>
    <div style="clear:both;"><br /></div>

    <div class="form-group">
        <?= Html::submitButton((($model->isNewRecord) ? 'Create' : 'Update'), ['class' => (($model->isNewRecord) ? 'btn btn-success' : 'btn btn-primary')]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
