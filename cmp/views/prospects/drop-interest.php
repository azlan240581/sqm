<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Prospects */
/* @var $form yii\widgets\ActiveForm */
$model->remarks = '';
$reason['Prospect not interest to buy property'] = 'Prospect not interest to buy property';
$reason['Contact Information Wrong'] = 'Contact Information Wrong';
$reason['Cancel'] = 'Cancel';
$reason['Others'] = 'Others';

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

	<?php
	echo 	$form->field($modelPH, 'remarks')->dropDownList(
			$reason,['prompt' => 'Please select']
			)->label($modelPH->getAttributeLabel('remarks'));
    ?>
	
    <br />

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