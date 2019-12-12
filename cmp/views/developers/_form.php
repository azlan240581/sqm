<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Developers */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="developers-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'company_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'company_registration_no')->textInput(['maxlength' => true]) ?>

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

<script>
function checkName(attr)
{
	var response = true;
	
	if(attr.length == 0)
	return response;
	
	$.ajax({url: "/cmp/<?= Yii::$app->controller->id ?>/create?company_name="+attr<?php echo !empty($model->id)?'+"&id='.$model->id.'"':''; ?>, async: false, dataType: "json", success: function(result){
		//alert(JSON.stringify(result));
		if(result == false)
		{
			setTimeout(function() {
				$(".field-<?= str_replace('-','',Yii::$app->controller->id) ?>-company_name").removeClass("has-success");
				$(".field-<?= str_replace('-','',Yii::$app->controller->id) ?>-company_name").addClass("has-error");
				$(".field-<?= str_replace('-','',Yii::$app->controller->id) ?>-company_name .help-block").html("Company name is already exist.");
			},250);
			response = false;
		}
		else
		{
			response = true;
		}
	}});
	
	return response;
}

$(document).ready(function(e) {
	$("form").submit(function(e) {
		
		var error = '';

		if(error.length == 0 && $("#<?= str_replace('-','',Yii::$app->controller->id) ?>-company_name").val().length != 0)
		{
			if(!checkName($("#<?= str_replace('-','',Yii::$app->controller->id) ?>-company_name").val()))
			error = 1;
		}
		
		if(error.length != 0)
		e.preventDefault();
	});
	
    $("#<?= str_replace('-','',Yii::$app->controller->id) ?>-company_name").blur(function(e) {
		checkName(this.value);
    });
});
</script>

