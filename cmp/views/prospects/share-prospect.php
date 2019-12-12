<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use maksyutin\duallistbox\Widget;

/* @var $this yii\web\View */
/* @var $model app\models\Prospects */

$this->title = 'Share Prospect';
$this->params['breadcrumbs'][] = ['label' => 'Prospects', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$prospectInterestedProjects = Yii::$app->ProspectMod->getProspectInterestedProjects($model->id,false);
$modelPB->project_id = json_encode($prospectInterestedProjects);
$projects = Yii::$app->GeneralMod->getProjectList();
$projects = json_decode(json_encode($projects), FALSE);
?>
<div class="prospects-create">

    <?php $form = ActiveForm::begin(); ?>

    <div class="form-group">
    <?php
    echo Widget::widget([
        'model' => $modelPB,
        'attribute' => 'project_id',
        'title' => 'Projects',
        'data' => $projects,
        'data_id'=> 'id',
        'data_value'=> 'project_name',
        'lngOptions' => [
            'warning_info' => 'Are you sure you want to move this many items?
        Doing so can cause your browser to become unresponsive.',
            'search_placeholder' => 'Search Projects',
            'showing' => ' - total',
            'available' => 'Available',
            'selected' => 'Selected'
        ]
      ]);
    ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Share', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    
</div>

<script>
$(document).ready(function(e) 
{
	$("form").submit(function(e) {
		var error = '';

		if($("#prospectbookings-remarks").val()=='')
		{
			error = 'Remarks cannot be blank.';
			$(".field-prospectbookings-remarks").removeClass("has-success");
			$(".field-prospectbookings-remarks").addClass("has-error");
			$(".field-prospectbookings-remarks .help-block").html(error);
		}
		else
		{
			$(".field-prospectbookings-remarks").removeClass("has-error");
			$(".field-prospectbookings-remarks").addClass("has-success");
			$(".field-prospectbookings-remarks .help-block").html('');
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