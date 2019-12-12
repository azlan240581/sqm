<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use maksyutin\duallistbox\Widget;
use dosamigos\tinymce\TinyMce;
use kato\DropZone;
use kartik\file\FileInput;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Projects */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="projects-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

	<?php
    echo $form->field($model, 'developer_id')->dropDownList(
            ArrayHelper::map($developerList, 'id', 'company_name'),['prompt' => 'Please select']
    )->label('Developer');
    ?>

    <?= $form->field($model, 'project_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'project_description')->textarea(['rows' => 6]) ?>

	<?php
	echo $form->field($model, 'file')->widget(FileInput::classname(), [
		'options' => [
				'accept' => 'image/*',
		],
		'pluginOptions' => [
				'browseClass' => 'btn btn-primary',
				'browseLabel' =>  'Browse Photo',
				'showUpload' => false,
				'showCaption' => false,
				'showClose' => false,
				'removeClass' => 'btn btn-danger',
				'previewFileType' => 'image',
				'initialPreview' => [
					(($model->thumb_image) ? Html::img($model->thumb_image, ['width'=>200]) : NULL), // checks the models to display the preview
				],
				'layoutTemplates' => ['actionDrag'=> '','actionZoom'=> '','actionDelete'=> ''],
			],
	])->label($model->getAttributeLabel('thumb_image').' <span style="font-weight:normal;">(Max Size:10MB; File Format:png,jpg,jpeg; Width:800px * Height:600px)</span>');
	?>

    <?php echo $form->field($model, 'status')->radioList([1 => 'Active', 0 => 'Inactive'],['itemOptions' => ['labelOptions' => ['class' => 'col-md-1']]]) ?>    

    <div style="clear:both;"><br /></div>

    <label class="control-label">SQM Account Manager</label>
    <br />
    <div class="col-md-12">
    <?php
    echo Widget::widget([
        'model' => $modelProjectAgents,
        'attribute' => 'agent_id',
        'title' => 'SQM Account Manager',
        'data' => $sqmAccountManagerObj,
        'data_id'=> 'id',
        'data_value'=> 'name',
        'lngOptions' => [
            'warning_info' => 'Are you sure you want to move this many items?
        Doing so can cause your browser to become unresponsive.',
            'search_placeholder' => 'Search SQM Account Manager',
            'showing' => ' - total',
            'available' => 'Available',
            'selected' => 'Selected'
        ]
      ]);
    ?>
    </div>
        
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
	
	$.ajax({url: "/cmp/<?= Yii::$app->controller->id ?>/create?project_name="+attr<?php echo !empty($model->id)?'+"&id='.$model->id.'"':''; ?>, async: false, dataType: "json", success: function(result){
		//alert(JSON.stringify(result));
		if(result == false)
		{
			setTimeout(function() {
				$(".field-<?= str_replace('-','',Yii::$app->controller->id) ?>-project_name").removeClass("has-success");
				$(".field-<?= str_replace('-','',Yii::$app->controller->id) ?>-project_name").addClass("has-error");
				$(".field-<?= str_replace('-','',Yii::$app->controller->id) ?>-project_name .help-block").html("Project name is already exist.");
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

		if(error.length == 0 && $("#<?= str_replace('-','',Yii::$app->controller->id) ?>-project_name").val().length != 0)
		{
			if(!checkName($("#<?= str_replace('-','',Yii::$app->controller->id) ?>-project_name").val()))
			error = 1;
		}
		
		if(error.length != 0)
		e.preventDefault();
	});
	
    $("#<?= str_replace('-','',Yii::$app->controller->id) ?>-project_name").blur(function(e) {
		checkName(this.value);
    });
});
</script>



