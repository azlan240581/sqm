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
/* @var $model app\models\PropertyProductMedias */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="property-product-medias-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

	<?php
    echo $form->field($modelPropertyProductMedias, 'media_type_id')->dropDownList(
            ArrayHelper::map($lookupMediaTypeList, 'id', 'name'),['prompt' => 'Please select','disabled'=>($_SESSION['user']['action']=='create-media'?FALSE:TRUE)]
    )->label('Media Type');
    ?>
    <?php
	if($_SESSION['user']['action']!='create-media')
	echo $form->field($modelPropertyProductMedias, 'media_type_id')->hiddenInput(['value'=> $modelPropertyProductMedias->media_type_id])->label(false);
	?>

	<?php
	echo $form->field($modelPropertyProductMedias, 'file')->widget(FileInput::classname(), [
		'options' => [
				'accept' => 'image/*',
		],
		'pluginOptions' => [
				'browseClass' => 'btn btn-primary',
				'browseLabel' =>  'Browse Photo',
				'showUpload' => false,
				'showCaption' => false,
				'removeClass' => 'btn btn-danger',
				'previewFileType' => 'image',
				'initialPreview' => [
					(($modelPropertyProductMedias->thumb_image) ? Html::img($modelPropertyProductMedias->thumb_image, ['width'=>200]) : NULL), // checks the models to display the preview
				],
			],
	])->label('Thumb Image <span style="font-weight:normal;">(Max Size:10MB; File Format:png,jpg,jpeg; Width:'.$_SESSION['settings']['PRODUCT_MEDIA_THUMB_IMAGE_WIDTH'].'px * Height:'.$_SESSION['settings']['PRODUCTS_MEDIA_THUMB_IMAGE_HEIGHT'].'px)</span>');
	?>

    <?= $form->field($modelPropertyProductMedias, 'media_title')->textInput(['maxlength' => true]) ?>

	<?php
	echo $form->field($modelPropertyProductMedias, 'image')->widget(FileInput::classname(), [
		'options' => [
				'accept' => 'image/*',
		],
		'pluginOptions' => [
				'browseClass' => 'btn btn-primary',
				'browseLabel' =>  'Browse Photo',
				'showUpload' => false,
				'showCaption' => false,
				'removeClass' => 'btn btn-danger',
				'previewFileType' => 'image',
				'initialPreview' => [
					(($modelPropertyProductMedias->media_value) ? Html::img($modelPropertyProductMedias->media_value, ['width'=>200]) : NULL), // checks the models to display the preview
				],
			],
	])->label('Image <span style="font-weight:normal;">(Max Size:10MB; File Format:png,jpg,jpeg; Width:800px * Height:600px)</span>');
	?>
        
	<?php echo $form->field($modelPropertyProductMedias, 'youtube')->textInput(['maxlength' => true, 'value'=>$modelPropertyProductMedias->media_value]) ?>

    <?= $form->field($modelPropertyProductMedias, 'sort')->textInput(['type' => 'number', 'min'=>0]) ?>

    <?php echo $form->field($modelPropertyProductMedias, 'published')->radioList([1 => 'Yes', 0 => 'No'],['itemOptions' => ['labelOptions' => ['class' => 'col-md-1']]]) ?>    

    <div style="clear:both;"><br /></div>

    <div class="form-group">
        <?= Html::submitButton($modelPropertyProductMedias->isNewRecord ? 'Create' : 'Update', ['class' => $modelPropertyProductMedias->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script>
$(document).ready(function(e) {
	//image
	$(".field-propertyproductmedias-image").hide();
	$("#propertyproductmedias-image").prop('disabled',true);
	//youtube
	$(".field-propertyproductmedias-youtube").hide();
	$("#propertyproductmedias-youtube").prop('disabled',true);
	
	<?php
	if(strlen($modelPropertyProductMedias->media_type_id))
	{
		?>
		if(<?php echo $modelPropertyProductMedias->media_type_id ?>==1)
		{
			//image
			$("#propertyproductmedias-image").prop('disabled',false);
			$(".field-propertyproductmedias-image").show();
			//youtube
			$(".field-propertyproductmedias-youtube").hide();
			$("#propertyproductmedias-youtube").prop('disabled',true);
		}
		else if(<?php echo $modelPropertyProductMedias->media_type_id ?>==2)
		{
			//image
			$(".field-propertyproductmedias-image").hide();
			$("#propertyproductmedias-image").prop('disabled',true);
			//youtube
			$("#propertyproductmedias-youtube").prop('disabled',false);
			$(".field-propertyproductmedias-youtube").show();
		}
		<?php
	}
	?>
	
	$("#propertyproductmedias-media_type_id").on('change',function() {
		if(this.value==1)
		{
			//image
			$("#propertyproductmedias-image").prop('disabled',false);
			$(".field-propertyproductmedias-image").show();
			//youtube
			$(".field-propertyproductmedias-youtube").hide();
			$("#propertyproductmedias-youtube").prop('disabled',true);
		}
		else if(this.value==2)
		{
			//image
			$(".field-propertyproductmedias-image").hide();
			$("#propertyproductmedias-image").prop('disabled',true);
			//youtube
			$("#propertyproductmedias-youtube").prop('disabled',false);
			$(".field-propertyproductmedias-youtube").show();
		}
		else
		{
			//image
			$(".field-propertyproductmedias-image").hide();
			$("#propertyproductmedias-image").prop('disabled',true);
			//youtube
			$(".field-propertyproductmedias-youtube").hide();
			$("#propertyproductmedias-youtube").prop('disabled',true);
		}
	});
	
	
});
</script>





