<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\datetime\DateTimePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Prospects */
/* @var $form yii\widgets\ActiveForm */

$agentProjects = Yii::$app->AccessMod->getAgentProjectID($_SESSION['user']['id']);
$prospectInterestedProjects = Yii::$app->ProspectMod->getProspectInterestedProjects($prospect_id,false);
$interProjects = array_values(array_intersect($agentProjects,$prospectInterestedProjects));
?>

<div class="prospects-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?php
	if(count($interProjects)==1)
	{
		$modelPH->project_id = $interProjects[0];
    	echo $form->field($modelPH, 'project_id')->hiddenInput()->label(false); 
	}
	else
	{
		$projects = Yii::$app->GeneralMod->getProjectList(array('project_id'=>$interProjects));
		echo 	$form->field($modelPH, 'project_id')->dropDownList(
				ArrayHelper::map($projects, 'id', 'project_name')
				)->label($modelPH->getAttributeLabel('project_id'));
	}
	?>

	<?=
	$form->field($modelPH, 'appointment_at')->widget(DateTimePicker::classname(), 
	[
		'options' => [
			'placeholder' => 'Select operating time ...',
			'class' => 'form-control',
			'readonly' => true,
		],
		'convertFormat' => true,
		'pluginOptions' => [
			'autoclose' => true,
			'format' => 'yyyy-MM-dd H:i',
			//'startDate' => Yii::$app->AccessRule->dateFormat(time(), 'Y-m-d H:i'),
			'todayHighlight' => true
		]
	]);
	?>


    <?= $form->field($modelPH, 'appointment_location')->textInput(['maxlength' => true]) ?>

    <?= $form->field($modelPH, 'remarks')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($modelPH->isNewRecord ? 'Create' : 'Update', ['class' => $modelPH->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script>
$(document).ready(function(e) 
{
	$("form").submit(function(e) {
		var error = '';

		//appointment date / time
		if($("#logprospecthistory-appointment_at").val()=='')
		{
			error = 'Appointment Date / Time cannot be blank.';
			$(".field-logprospecthistory-appointment_at").removeClass("has-success");
			$(".field-logprospecthistory-appointment_at").addClass("has-error");
			$(".field-logprospecthistory-appointment_at .help-block").html(error);
		}
		else
		{
			$(".field-logprospecthistory-appointment_at").removeClass("has-error");
			$(".field-logprospecthistory-appointment_at").addClass("has-success");
			$(".field-logprospecthistory-appointment_at .help-block").html('');
		}

		//appointment location
		if($("#logprospecthistory-appointment_location").val()=='')
		{
			error = 'Appointment Location cannot be blank.';
			$(".field-logprospecthistory-appointment_location").removeClass("has-success");
			$(".field-logprospecthistory-appointment_location").addClass("has-error");
			$(".field-logprospecthistory-appointment_location .help-block").html(error);
		}
		else
		{
			$(".field-logprospecthistory-appointment_location").removeClass("has-error");
			$(".field-logprospecthistory-appointment_location").addClass("has-success");
			$(".field-logprospecthistory-appointment_location .help-block").html('');
		}

		//remarks
		if($("#logprospecthistory-remarks").val()=='')
		{
			error = 'Remarks cannot be blank.';
			$(".field-logprospecthistory-remarks").removeClass("has-success");
			$(".field-logprospecthistory-remarks").addClass("has-error");
			$(".field-logprospecthistory-remarks .help-block").html(error);
		}
		else
		{
			$(".field-logprospecthistory-remarks").removeClass("has-error");
			$(".field-logprospecthistory-remarks").addClass("has-success");
			$(".field-logprospecthistory-remarks .help-block").html('');
		}

		//result
		if(error.length != 0)
		{
			e.preventDefault();
		}
		else
		{
			$('button[type="submit"]').attr("disabled", true);
		}
	});
});
</script>