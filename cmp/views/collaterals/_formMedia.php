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
/* @var $model app\models\CollateralsMedias */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="collaterals-medias-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

	<?php
    echo $form->field($modelCollateralsMedias, 'collateral_media_type_id')->dropDownList(
            ArrayHelper::map($collateralMediaTypeList, 'id', 'name'),['prompt' => 'Please select','disabled'=>($_SESSION['user']['action']=='create-media'?FALSE:TRUE)]
    )->label('Media Type');
    ?>

	<?php
	echo $form->field($modelCollateralsMedias, 'file')->widget(FileInput::classname(), [
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
					(($modelCollateralsMedias->thumb_image) ? Html::img($modelCollateralsMedias->thumb_image, ['width'=>200]) : NULL), // checks the models to display the preview
				],
				'layoutTemplates' => ['actionDrag'=> '','actionZoom'=> '','actionDelete'=> ''],
			],
	])->label('Thumb Image <span style="font-weight:normal;">(Max Size:10MB File Format:png,jpg,jpeg)</span>');
	?>

    <?= $form->field($modelCollateralsMedias, 'media_title')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($modelCollateralsMedias, 'media_value')->textInput(['maxlength' => true])->label('Media Link') ?>
    
    
    <?= $form->field($modelCollateralsMedias, 'sort')->textInput(['type' => 'number', 'min'=>0]) ?>

    <?php echo $form->field($modelCollateralsMedias, 'published')->radioList([1 => 'Yes', 0 => 'No'],['itemOptions' => ['labelOptions' => ['class' => 'col-md-1']]]) ?>    

    <div style="clear:both;"><br /></div>

    <div class="form-group">
        <?= Html::submitButton($modelCollateralsMedias->isNewRecord ? 'Create Media' : 'Update Media', ['class' => $modelCollateralsMedias->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


