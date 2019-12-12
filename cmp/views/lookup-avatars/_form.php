<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model app\models\LookupAvatar */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="lookup-avatar-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?php //echo $form->field($model, 'image')->textInput(['maxlength' => true]) ?>
	<?php
	if($_SESSION['user']['action'] == 'update')
	{
		echo '<img src="'.$model->image.'" height="32px">';
		echo $form->field($model, 'file')->widget(FileInput::classname(), [
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
				],
		]);
	}
	else
	{
		echo $form->field($model, 'file')->widget(FileInput::classname(), [
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
				],
		]);
	}
	?>
    <?php //echo $form->field($model, 'deleted')->dropDownList([1 => 'Yes', 0 => 'No']) ?>
    <?php echo $form->field($model, 'deleted')->radioList([1 => 'Yes', 0 => 'No'],['itemOptions' => ['labelOptions' => ['class' => 'col-md-1']]]) ?>    

    <div style="clear:both;"><br /></div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
