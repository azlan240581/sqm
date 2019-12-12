<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $modelPH app\models\Prospects */
/* @var $form yii\widgets\ActiveForm */
$levelInterests = Yii::$app->AccessMod->getLookupData('lookup_prospect_level_interest','','id');
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

	<?php
	echo 	$form->field($modelPH, 'level_of_interest')->radioList(
			ArrayHelper::map($levelInterests, 'id', 'name'),['itemOptions' => ['labelOptions' => ['class' => 'col-md-2']]]
			)->label($modelPH->getAttributeLabel('level_of_interest'));
    ?>
    <div style="clear:both;"><br /></div>

    <?php echo $form->field($modelPH, 'site_visit')->radioList([1 => 'Yes', 0 => 'No'],['itemOptions' => ['labelOptions' => ['class' => 'col-md-2']]]) ?>    
    <div style="clear:both;"><br /></div>

	<?php /*
	echo $form->field($modelPH, 'udf1')->widget(FileInput::classname(), [
        'model' => $modelPH,
        'attribute' => 'udf1',

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
					(($modelPH->udf1) ? Html::img($modelPH->udf1, ['width'=>200]) : NULL), // checks the models to display the preview
				],
				'initialPreviewConfig' => [
								[
									'type'=>Yii::$app->AccessMod->is_image($modelPB->sp_file)?"image":"pdf",
									'url' => "/cmp/prospect/file-udf1-delete",
									'key' => $modelPH->id,
								],
	
							],
			],
	]);*/
	?> 

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

		if($("#logprospecthistory-udf1").val()=='')
		{
			error = 'Udf1 cannot be blank.';
			$(".field-logprospecthistory-udf1").removeClass("has-success");
			$(".field-logprospecthistory-udf1").addClass("has-error");
			$(".field-logprospecthistory-udf1 .help-block").html(error);
		}
		else
		{
			$(".field-logprospecthistory-udf1").removeClass("has-error");
			$(".field-logprospecthistory-udf1").addClass("has-success");
			$(".field-logprospecthistory-udf1 .help-block").html('');
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