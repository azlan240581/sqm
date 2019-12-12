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
/* @var $model app\models\Collaterals */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="collaterals-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

	<?php
	if(count($projectList)==1)
	{
		echo $form->field($model, 'project_id')->hiddenInput(['value'=> $projectList[0]['id']])->label(false);
	}
	else
	{
		echo $form->field($model, 'project_id')->dropDownList(
				ArrayHelper::map($projectList, 'id', 'project_name'),['prompt' => 'Please select','disabled'=>($_SESSION['user']['action']=='create'?FALSE:TRUE)]
		)->label('Project');
	}
    ?>

	<?php
    echo $form->field($modelCollateralsMedias, 'collateral_media_type_id')->dropDownList(
            ArrayHelper::map($collateralMediaTypeList, 'id', 'name'),['prompt' => 'Please select']
    )->label('Collateral Type');
    ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'permalink')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'summary')->textarea(['rows' => 6,'maxlength' => 80]) ?>

	<?= $form->field($model, 'description')->widget(TinyMce::className(), [
        'options' => ['rows' => 20],
        'language' => 'en',
        'clientOptions' => [
            'plugins' => [
                "advlist autolink lists link charmap print preview anchor",
                "searchreplace visualblocks code fullscreen",
                "insertdatetime media table contextmenu paste"
            ],
            'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
        ]
    ]);?>
    
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
	])->label($model->getAttributeLabel('file').' <span style="font-weight:normal;">(Max Size:10MB; File Format:png,jpg,jpeg; Width:'.$_SESSION['settings']['COLLATERAL_MEDIA_THUMB_IMAGE_WIDTH'].'px * Height:'.$_SESSION['settings']['COLLATERAL_MEDIA_THUMB_IMAGE_HEIGHT'].'px)</span>');
	?>
    
    <?php echo $form->field($modelCollateralsMedias, 'media_value')->textInput(['maxlength' => true])->label('Collateral Link') ?>
    
    <?php /*?>
	<?= $form->field($model, 'published_date_start')->widget(\yii\jui\DatePicker::classname(), [
        //'language' => 'ru',
        'dateFormat' => 'yyyy-MM-dd',
		'options' => ['class' => 'form-control','readonly' => true],
    	])->label('Publish Start Date') 
	?>

	<?= $form->field($model, 'published_date_end')->widget(\yii\jui\DatePicker::classname(), [
        //'language' => 'ru',
        'dateFormat' => 'yyyy-MM-dd',
		'options' => ['class' => 'form-control'],
    	])->label('Publish End Date') 
	?>
    <?php */?>

    <?= $form->field($model, 'sort')->textInput(['type' => 'number', 'min'=>0]) ?>

    <?php echo $form->field($model, 'status')->radioList([1 => 'Active', 0 => 'Inactive'],['itemOptions' => ['labelOptions' => ['class' => 'col-md-1']]]) ?>    

    <div style="clear:both;"><br /></div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script>
function getPermalink(attr)
{
	var response = true;
	
	if(attr.length == 0)
	return response;
	
	$.ajax({url: "/cmp/<?= Yii::$app->controller->id ?>/create?title="+attr<?php echo !empty($model->id)?'+"&id='.$model->id.'"':''; ?>, async: false, dataType: "json", success: function(result){
		//alert(result);
		$("#<?= str_replace('-','',Yii::$app->controller->id) ?>-permalink").val(result);
	}});
}

function checkPermalink(attr)
{
	var response = true;
	
	if(attr.length == 0)
	return response;
	
	$.ajax({url: "/cmp/<?= Yii::$app->controller->id ?>/create?permalink="+attr<?php echo !empty($model->id)?'+"&id='.$model->id.'"':''; ?>, async: false, dataType: "json", success: function(result){
		//alert(JSON.stringify(result));
		if(result == false)
		{
			setTimeout(function() {
				$(".field-<?= str_replace('-','',Yii::$app->controller->id) ?>-permalink").removeClass("has-success");
				$(".field-<?= str_replace('-','',Yii::$app->controller->id) ?>-permalink").addClass("has-error");
				$(".field-<?= str_replace('-','',Yii::$app->controller->id) ?>-permalink .help-block").html("Permalink is already exist.");
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
		if(error.length == 0 && $("#<?= str_replace('-','',Yii::$app->controller->id) ?>-permalink").val().length != 0)
		{
			if(!checkPermalink($("#<?= str_replace('-','',Yii::$app->controller->id) ?>-permalink").val()))
			error = 1;
		}
		if(error.length != 0)
		e.preventDefault();
	});
	
    $("#<?= str_replace('-','',Yii::$app->controller->id) ?>-title").blur(function(e)
	{
		if($("#<?= str_replace('-','',Yii::$app->controller->id) ?>-permalink").val()=='')
		getPermalink(this.value);
    });
	
    $("#<?= str_replace('-','',Yii::$app->controller->id) ?>-permalink").blur(function(e)
	{
		var permalink = this.value.toLowerCase();
		permalink = permalink.toLowerCase();
		permalink = permalink.replace(/[^a-z0-9\s]/gi, ' ');
		permalink = permalink.replace( /\s\s+/g, ' ' );
		permalink = permalink.trim();
		permalink = permalink.replace(/ /g,"-");
		$("#<?= str_replace('-','',Yii::$app->controller->id) ?>-permalink").val(permalink);
		checkPermalink(permalink);
    });
});
</script>

