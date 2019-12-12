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
/* @var $modelUser app\models\Users */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="users-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="panel panel-default">
        <div class="panel-heading"><strong>User Settings</strong></div>
        <div class="panel-body">
        
		<?= html_entity_decode($form->field($modelUser, 'avatar_id')->radioList($avatar,['itemOptions' => ['labelOptions' => ['class' => 'col-md-2']]])->label('Avatar')) ?>
        
        <div style="clear:both;"><br /></div>
        
		<?php
        $modelUser->photo = $modelUser->avatar;
        echo $form->field($modelUser, 'photo')->widget(FileInput::classname(), [
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
                    //'required' => strlen($model->banner_img)?false:true,
                    'initialPreview' => [
                        (($modelUser->avatar) ? Html::img($modelUser->avatar, ['width'=>200]) : NULL), // checks the models to display the preview
                    ],
					'layoutTemplates' => ['actionDrag'=> '','actionZoom'=> '','actionDelete'=> ''],
                ],
        ])->label('Photo <span style="font-weight:normal;">(Max Size:10MB File Format:png,jpg,jpeg)</span>');
        ?>
        
        </div>
    </div>

    <div style="clear:both;"><br /></div>
    <div class="panel panel-default">
        <div class="panel-heading"><strong>User Credentials</strong></div>
        <div class="panel-body">
        <?= $form->field($modelUser, 'username')->textInput(['maxlength' => true, 'readonly'=>true]) ?>
    
        <?= $form->field($modelUser, 'password')->passwordInput(['maxlength' => true]) ?>
    
        <?= $form->field($modelUser, 'password_repeat')->passwordInput(['maxlength' => true]) ?>
        
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading"><strong>User Details</strong></div>
        <div class="panel-body">

		<?= $form->field($modelUser, 'sqm_id')->textInput(['maxlength' => true, 'placeholder'=>'sqm-name']) ?>
		
		<?= $form->field($modelUser, 'email')->textInput(['maxlength' => true]) ?>
    
        <div class="row">
            <div class="col-md-4">
                <?= $form->field($modelUser, 'firstname')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-8">
                <?= $form->field($modelUser, 'lastname')->textInput(['maxlength' => true]) ?>
            </div>
        </div>
    
        <?php //echo $form->field($modelUser, 'name')->textInput(['maxlength' => true]) ?>
    
        <div class="row">
            <div class="col-md-4">
				<?php
                echo $form->field($modelUser, 'country_code')->dropDownList(
                        ArrayHelper::map($countryCodeList, 'value', 'name'),['prompt' => 'Please select']
                );
                ?>
            </div>
            <div class="col-md-8">
				<?= $form->field($modelUser, 'contact_number')->textInput(['maxlength' => true]) ?>
            </div>
        </div>
    
        <?= $form->field($modelUser, 'dob')->widget(\yii\jui\DatePicker::classname(), [
            //'language' => 'ru',
            'dateFormat' => 'yyyy-MM-dd',
            'options' => [
                    'class' => 'form-control',
                    'readonly' => true,
                ],
            'clientOptions' => [
                    'changeMonth' => true,
                    'yearRange' => (date('Y')-100).':'.date('Y'),
                    'changeYear' => true,
                ],			
                
            ])->label('Date of Birth') 
        ?>
    
		<?php
        $genderList = array(array('name'=>'Male','value'=>'Male'),array('name'=>'Female','value'=>'Female'));
        echo $form->field($modelUser, 'gender')->dropDownList(
                ArrayHelper::map($genderList, 'value', 'name'),['prompt' => 'Please select']
        );
        ?>
    
        <?= $form->field($modelUser, 'address_1')->textInput(['maxlength' => true]) ?>
    
        <?= $form->field($modelUser, 'address_2')->textInput(['maxlength' => true]) ?>
    
        <?= $form->field($modelUser, 'address_3')->textInput(['maxlength' => true]) ?>
    
        <?= $form->field($modelUser, 'city')->textInput(['maxlength' => true]) ?>
    
        <?= $form->field($modelUser, 'postcode')->textInput(['maxlength' => true]) ?>
    
        <?= $form->field($modelUser, 'state')->textInput(['maxlength' => true]) ?>
    
        <?php
        echo $form->field($modelUser, 'country')->dropDownList(
                ArrayHelper::map($countryList, 'id', 'name'),['prompt' => 'Please select']
        )->label('Country');
        ?>
        
		<?= $form->field($modelUser, 'profile_description')->widget(TinyMce::className(), [
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
        
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($modelUser->isNewRecord ? 'Create' : 'Update', ['class' => $modelUser->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script>
$(document).ready(function(e) {
	$(".field-users-photo").hide();
	$("#users-photo").prop('disabled',true);
	$("input[name='Users[avatar_id]']").on('change',function() {
		if(this.value==1)
		{
			$(".field-users-photo").show();
			$("#users-photo").prop('disabled',false);
		}
		else
		{
			$(".field-users-photo").hide();
			$("#users-photo").prop('disabled',true);
		}
	});
	
	<?php
	if($modelUser->avatar_id!=NULL)
	{
		if($modelUser->avatar_id==1)
		{
			?>
			$(".field-users-photo").show();
			$("#users-photo").prop('disabled',false);
			<?php
		}
		else
		{
			?>
			$(".field-users-photo").hide();
			$("#users-photo").prop('disabled',true);
			<?php
		}
	}
	?>
});
</script>


