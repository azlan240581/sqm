<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Prospects */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="prospects-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'agent_id')->textInput() ?>

    <?= $form->field($model, 'member_id')->textInput() ?>

    <?= $form->field($model, 'prospect_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'prospect_email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'prospect_contact_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'prospect_purpose_of_buying')->textInput() ?>

    <?php // $form->field($model, 'how_prospect_know_us')->textInput() ?>

    <?php // $form->field($model, 'prospect_age')->textInput(['maxlength' => true]) ?>

	<?= $form->field($model, 'prospect_dob')->widget(\yii\jui\DatePicker::classname(), [
        //'language' => 'ru',
        'dateFormat' => 'yyyy-MM-dd',
        'options' => [
                'class' => 'form-control',
                'readonly' => true,
            ],
        'clientOptions' => [
                'changeMonth' => true,
                'yearRange' => (date('Y')-100).':'.date('Y'),
                'changeYear' => true,
            ],			
            
        ]) 
    ?>

    <?= $form->field($model, 'prospect_marital_status')->textInput() ?>

    <?= $form->field($model, 'prospect_occupation')->textInput() ?>

    <?= $form->field($model, 'prospect_identity_document')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tax_license')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'remarks')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'status')->textInput() ?>

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
