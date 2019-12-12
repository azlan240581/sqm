<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Fintech */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="fintech-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'company_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'company_registration_no')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'company_description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'contact_person_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'contact_person_email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'contact_person_contactno')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'status')->radioList([1 => 'Active', 0 => 'Inactive'],['itemOptions' => ['labelOptions' => ['class' => 'col-md-1']]]) ?>    

    <div style="clear:both;"><br /></div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
