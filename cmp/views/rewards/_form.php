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
/* @var $model app\models\Rewards */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="rewards-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

	<?php
	echo $form->field($model, 'category_id')->dropDownList(
			ArrayHelper::map(Yii::$app->AccessMod->getLookupData('lookup_reward_categories'), 'id', 'name'),['prompt' => 'Please select','disabled'=>($_SESSION['user']['action']=='create'?FALSE:TRUE)]
	)->label('Category');
    ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'summary')->textarea(['rows' => 6]) ?>

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

    <?= $form->field($model, 'quantity')->textInput(['type' => 'number', 'min'=>0]) ?>

    <?= $form->field($model, 'minimum_quantity')->textInput(['type' => 'number', 'min'=>0]) ?>

    <?= $form->field($model, 'points')->textInput(['type' => 'number', 'min'=>0, 'value'=>number_format($model->points,2,'.','')]) ?>

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
				'removeClass' => 'btn btn-danger',
				'previewFileType' => 'image',
				'initialPreview' => [
					(($model->images) ? Html::img($model->images, ['width'=>200]) : NULL), // checks the models to display the preview
				],
			],
	])->label('Image <span style="font-weight:normal;">(Max Size:10MB File Format:png,jpg,jpeg)</span>');
	?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

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

    <?php echo $form->field($model, 'status')->radioList([1 => 'Active', 0 => 'Inactive'],['itemOptions' => ['labelOptions' => ['class' => 'col-md-1']]]) ?>    

    <div style="clear:both;"><br /></div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
