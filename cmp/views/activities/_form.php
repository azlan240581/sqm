<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Activities */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="activities-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'activity_code')->textInput(['maxlength' => true,'readonly'=>($_SESSION['user']['action']=='create'?FALSE:TRUE)]) ?>

    <?= $form->field($model, 'activity_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'activity_description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'points_value')->textInput(['type' => 'number', 'min' => 0, 'maxlength' => true]) ?>

    <?php echo $form->field($model, 'status')->radioList([1 => 'Active', 0 => 'Inactive'],['itemOptions' => ['labelOptions' => ['class' => 'col-md-1']]]) ?>    

    <div style="clear:both;"><br /></div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
