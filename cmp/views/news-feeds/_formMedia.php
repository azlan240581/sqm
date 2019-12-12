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
/* @var $model app\models\NewsFeedMedias */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="news-feed-medias-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

	<?php
    echo $form->field($modelNewsFeedMedias, 'media_type_id')->dropDownList(
            ArrayHelper::map($lookupMediaTypeList, 'id', 'name'),['prompt' => 'Please select','disabled'=>($_SESSION['user']['action']=='create-media'?FALSE:TRUE)]
    )->label('Media Type');
    ?>
    <?php
	if($_SESSION['user']['action']!='create-media')
	echo $form->field($modelNewsFeedMedias, 'media_type_id')->hiddenInput(['value'=> $modelNewsFeedMedias->media_type_id])->label(false);
	?>

	<?php
	echo $form->field($modelNewsFeedMedias, 'file')->widget(FileInput::classname(), [
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
					(($modelNewsFeedMedias->thumb_image) ? Html::img($modelNewsFeedMedias->thumb_image, ['width'=>200]) : NULL), // checks the models to display the preview
				],
			],
	])->label('Thumb Image <span style="font-weight:normal;">(Max Size:10MB; File Format:png,jpg,jpeg; Width:'.$_SESSION['settings']['NEWS_FEED_MEDIA_THUMB_IMAGE_WIDTH'].'px * Height:'.$_SESSION['settings']['NEWS_FEED_MEDIA_THUMB_IMAGE_HEIGHT'].'px)</span>');
	?>

    <?= $form->field($modelNewsFeedMedias, 'media_title')->textInput(['maxlength' => true]) ?>

	<?php
	echo $form->field($modelNewsFeedMedias, 'image')->widget(FileInput::classname(), [
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
					(($modelNewsFeedMedias->media_value) ? Html::img($modelNewsFeedMedias->media_value, ['width'=>200]) : NULL), // checks the models to display the preview
				],
			],
	])->label('Image <span style="font-weight:normal;">(Max Size:10MB; File Format:png,jpg,jpeg; Width:800px * Height:600px)</span>');
	?>
        
	<?php echo $form->field($modelNewsFeedMedias, 'youtube')->textInput(['maxlength' => true, 'value'=>$modelNewsFeedMedias->media_value]) ?>

    <?= $form->field($modelNewsFeedMedias, 'sort')->textInput(['type' => 'number', 'min'=>0]) ?>

    <?php echo $form->field($modelNewsFeedMedias, 'published')->radioList([1 => 'Yes', 0 => 'No'],['itemOptions' => ['labelOptions' => ['class' => 'col-md-1']]]) ?>    

    <div style="clear:both;"><br /></div>

    <div class="form-group">
        <?= Html::submitButton($modelNewsFeedMedias->isNewRecord ? 'Create' : 'Update', ['class' => $modelNewsFeedMedias->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script>
$(document).ready(function(e) {
	//image
	$(".field-newsfeedmedias-image").hide();
	$("#newsfeedmedias-image").prop('disabled',true);
	//youtube
	$(".field-newsfeedmedias-youtube").hide();
	$("#newsfeedmedias-youtube").prop('disabled',true);
	
	<?php
	if(strlen($modelNewsFeedMedias->media_type_id))
	{
		?>
		if(<?php echo $modelNewsFeedMedias->media_type_id ?>==1)
		{
			//image
			$("#newsfeedmedias-image").prop('disabled',false);
			$(".field-newsfeedmedias-image").show();
			//youtube
			$(".field-newsfeedmedias-youtube").hide();
			$("#newsfeedmedias-youtube").prop('disabled',true);
		}
		else if(<?php echo $modelNewsFeedMedias->media_type_id ?>==2)
		{
			//image
			$(".field-newsfeedmedias-image").hide();
			$("#newsfeedmedias-image").prop('disabled',true);
			//youtube
			$("#newsfeedmedias-youtube").prop('disabled',false);
			$(".field-newsfeedmedias-youtube").show();
		}
		<?php
	}
	?>
	
	$("#newsfeedmedias-media_type_id").on('change',function() {
		if(this.value==1)
		{
			//image
			$("#newsfeedmedias-image").prop('disabled',false);
			$(".field-newsfeedmedias-image").show();
			//youtube
			$(".field-newsfeedmedias-youtube").hide();
			$("#newsfeedmedias-youtube").prop('disabled',true);
		}
		else if(this.value==2)
		{
			//image
			$(".field-newsfeedmedias-image").hide();
			$("#newsfeedmedias-image").prop('disabled',true);
			//youtube
			$("#newsfeedmedias-youtube").prop('disabled',false);
			$(".field-newsfeedmedias-youtube").show();
		}
		else
		{
			//image
			$(".field-newsfeedmedias-image").hide();
			$("#newsfeedmedias-image").prop('disabled',true);
			//youtube
			$(".field-newsfeedmedias-youtube").hide();
			$("#newsfeedmedias-youtube").prop('disabled',true);
		}
	});
});
</script>




