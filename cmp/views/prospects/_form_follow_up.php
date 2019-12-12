<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model app\models\Prospects */
/* @var $form yii\widgets\ActiveForm */
$model->remarks = '';

$purposes = Yii::$app->AccessMod->getLookupData('lookup_purpose_of_buying');
$hows = Yii::$app->AccessMod->getLookupData('lookup_how_you_know_about_us');
$maritals = Yii::$app->AccessMod->getLookupData('lookup_marital_status');
$occupations = Yii::$app->AccessMod->getLookupData('lookup_occupation');
$domiciles = Yii::$app->AccessMod->getLookupData('lookup_domicile');
$agentProjects = Yii::$app->AccessMod->getAgentProjectID($_SESSION['user']['id']);
$prospectInterestedProjects = Yii::$app->ProspectMod->getProspectInterestedProjects($model->id,false);
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

    <?= $form->field($model, 'prospect_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'prospect_email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'prospect_contact_number')->textInput(['maxlength' => true]) ?>

	<?php
	echo 	$form->field($model, 'prospect_purpose_of_buying')->dropDownList(
			ArrayHelper::map($purposes, 'id', 'name'),['prompt' => 'Please select']
			)->label($model->getAttributeLabel('prospect_purpose_of_buying'));
    ?>

	<?php
	/*echo 	$form->field($model, 'how_prospect_know_us')->dropDownList(
			ArrayHelper::map($hows, 'id', 'name'),['prompt' => 'Please select']
			)->label($model->getAttributeLabel('how_prospect_know_us'));*/
    ?>

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

	<?php
	echo 	$form->field($model, 'prospect_marital_status')->dropDownList(
			ArrayHelper::map($maritals, 'id', 'name'),['prompt' => 'Please select']
			)->label($model->getAttributeLabel('prospect_marital_status'));
    ?>

	<?php
	echo 	$form->field($model, 'prospect_occupation')->dropDownList(
			ArrayHelper::map($occupations, 'id', 'name'),['prompt' => 'Please select']
			)->label($model->getAttributeLabel('prospect_occupation'));
    ?>

	<?php
	echo 	$form->field($model, 'prospect_domicile')->dropDownList(
			ArrayHelper::map($domiciles, 'id', 'name'),['prompt' => 'Please select']
			)->label($model->getAttributeLabel('prospect_domicile'));
    ?>

	<?php
	echo $form->field($model, 'prospect_identity_document')->widget(FileInput::classname(), [
        'model' => $model,
        'attribute' => 'prospect_identity_document',

		'options' => [
				'accept' => 'image/*',
				'multiple' => false,
		],
		'pluginOptions' => [
				'browseClass' => 'btn btn-primary',
				'browseLabel' =>  'Browse Photo',
				'showUpload' => false,
				'showCaption' => false,
				'removeClass' => 'btn btn-danger',
				'previewFileType' => 'any',
				'initialPreviewAsData'=>true,
				'initialPreview' => [
					$model->prospect_identity_document,
				],
				'initialPreviewConfig' => [
								[
									'caption'=>!empty($model->prospect_identity_document)?basename(explode('-', $model->prospect_identity_document, 2)[1]):'',
									'type'=>Yii::$app->AccessMod->is_image($model->prospect_identity_document)?"image":"pdf",
									'url' => "/cmp/prospects/file-identity-document-delete",
									'key' => $model->id,
								],
	
							],
			],
	]);
	?> 

	<?php
	echo $form->field($model, 'tax_license')->widget(FileInput::classname(), [
        'model' => $model,
        'attribute' => 'tax_license',

		'options' => [
				'accept' => 'image/*',
				'multiple' => false,
		],
		'pluginOptions' => [
				'browseClass' => 'btn btn-primary',
				'browseLabel' =>  'Browse Photo',
				'showUpload' => false,
				'showCaption' => false,
				'removeClass' => 'btn btn-danger',
				'previewFileType' => 'any',
				'initialPreviewAsData'=>true,
				'initialPreview' => [
					$model->tax_license,
				],
				'initialPreviewConfig' => [
								[
									'caption'=>!empty($model->tax_license)?basename(explode('-', $model->tax_license, 2)[1]):'',
									'type'=>Yii::$app->AccessMod->is_image($model->tax_license)?"image":"pdf",
									'url' => "/cmp/prospects/file-tax-license-delete",
									'key' => $model->id,
								],
	
							],
			],
	]);
	?> 

    <?= $form->field($modelPH, 'remarks')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script>
$(document).ready(function(e) 
{
	$("form").submit(function(e) {
		var error = '';
		var regex_email =  /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
		var regex_phone =  /^[0-9]{5,20}$/;
		
		if($("#prospects-prospect_name").val()=='')
		{
			error = 'Name cannot be blank.';
			$(".field-prospects-prospect_name").removeClass("has-success");
			$(".field-prospects-prospect_name").addClass("has-error");
			$(".field-prospects-prospect_name .help-block").html(error);
		}
		else
		{
			$(".field-prospects-prospect_name").removeClass("has-error");
			$(".field-prospects-prospect_name").addClass("has-success");
			$(".field-prospects-prospect_name .help-block").html('');
		}

		if($("#prospects-prospect_email").val()=='')
		{
			error = 'Email cannot be blank.';
			$(".field-prospects-prospect_email").removeClass("has-success");
			$(".field-prospects-prospect_email").addClass("has-error");
			$(".field-prospects-prospect_email .help-block").html(error);
		}
		else
		{
			if(!regex_email.test($("#prospects-prospect_email").val()))
			{
				error = 'Email is not a valid email address.';
				$(".field-prospects-prospect_email").removeClass("has-success");
				$(".field-prospects-prospect_email").addClass("has-error");
				$(".field-prospects-prospect_email .help-block").html(error);
			}
			else
			{
				$(".field-prospects-prospect_email").removeClass("has-error");
				$(".field-prospects-prospect_email").addClass("has-success");
				$(".field-prospects-prospect_email .help-block").html('');
			}
		}

		if($("#prospects-prospect_contact_number").val()=='')
		{
			error = 'Contact Number cannot be blank.';
			$(".field-prospects-prospect_contact_number").removeClass("has-success");
			$(".field-prospects-prospect_contact_number").addClass("has-error");
			$(".field-prospects-prospect_contact_number .help-block").html(error);
		}
		else
		{
			if(!regex_phone.test($("#prospects-prospect_contact_number").val()))
			{
				error = 'Contact Number must be an integer.';
				$(".field-prospects-prospect_contact_number").removeClass("has-success");
				$(".field-prospects-prospect_contact_number").addClass("has-error");
				$(".field-prospects-prospect_contact_number .help-block").html(error);
			}
			else
			{
				$(".field-prospects-prospect_contact_number").removeClass("has-error");
				$(".field-prospects-prospect_contact_number").addClass("has-success");
				$(".field-prospects-prospect_contact_number .help-block").html('');
			}
		}

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