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

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    
    <div style="clear:both;"><br /></div>
    <div class="panel panel-default">
        <div class="panel-heading"><strong>User Settings</strong></div>
        <div class="panel-body">
        
		<?= html_entity_decode($form->field($modelUser, 'avatar_id')->radioList($avatar ,['itemOptions' => ['labelOptions' => ['class' => 'col-md-2']]])->label('Avatar')) ?>
        
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
       
        <?php 
        if($_SESSION['settings']['SITE_ALLOW_MULTIPLE_GROUPS']==1)
        echo $form->field($modelUserGroups, 'groupaccess_id')->checkboxList($groupAccess,['itemOptions' => ['labelOptions' => ['class' => 'col-md-2']]])->label('System Groups'); 
        else
        echo $form->field($modelUserGroups, 'groupaccess_id')->radioList($groupAccess,['itemOptions' => ['labelOptions' => ['class' => 'col-md-2']]])->label('System Groups');
        ?>
        
        <div style="clear:both;"><br /></div>
        
        <?php
        /*echo $form->field($modelUserPosition, 'position_id')->dropDownList(
                ArrayHelper::map($positionList, 'id', 'name'),['prompt' => 'Please select']
        )->label('Position');*/
        ?>
                
        <?php
        echo $form->field($modelUserBank, 'bank_id')->dropDownList(
                ArrayHelper::map($bankList, 'id', 'bank_name'),['prompt' => 'Please select']
        )->label('Bank');
        ?>
        
        <?php
        echo $form->field($modelUserDeveloper, 'developer_id')->dropDownList(
                ArrayHelper::map($developerList, 'id', 'company_name'),['prompt' => 'Please select']
        )->label('Developer');
        ?>
        
        <?php
        echo $form->field($modelUserFintech, 'fintech_id')->dropDownList(
                ArrayHelper::map($fintechList, 'id', 'company_name'),['prompt' => 'Please select']
        )->label('Fintech');
        ?>
        
        <?php
       /* echo $form->field($modelProjectAgents, 'project_id')->dropDownList(
                ArrayHelper::map($projectList, 'id', 'project_name'),['prompt' => 'Please select']
        )->label('Project');*/
        ?>
        
        <div class="field-projectagents-project_id">
        <label class="control-label">Projects</label>
        <br />
        <div class="col-md-12">
        <?php
        echo Widget::widget([
            'model' => $modelProjectAgents,
            'attribute' => 'project_id',
            'title' => 'Project',
            'data' => $projectObj,
            'data_id'=> 'id',
            'data_value'=> 'project_name',
            'lngOptions' => [
                'warning_info' => 'Are you sure you want to move this many items?
            Doing so can cause your browser to become unresponsive.',
                'search_placeholder' => 'Search Project',
                'showing' => ' - total',
                'available' => 'Available',
                'selected' => 'Selected'
            ]
          ]);
        ?>
        </div>
        <div style="clear:both;"><br /></div>
        </div>
        
        <?php
        echo $form->field($modelAssistantUpline, 'upline_id')->dropDownList(
                ArrayHelper::map($uplineList, 'id', 'name'),['prompt' => 'Please select']
        )->label('Upline');
        ?>
        
        <?= $form->field($modelUser, 'status')->radioList([1 => 'Active', 0 => 'Inactive'],['itemOptions' => ['labelOptions' => ['class' => 'col-md-1']]]) ?>

        </div>
    </div>    
        
    <div class="panel panel-default">
        <div class="panel-heading"><strong>User Credential</strong></div>
        <div class="panel-body">
        
		<?= $form->field($modelUser, 'username')->textInput(['maxlength' => true, 'readonly' => ($_SESSION['user']['action']=='update'?true:false) ]) ?>
    
        <?= $form->field($modelUser, 'password')->passwordInput(['maxlength' => true]) ?>
    
        <?= $form->field($modelUser, 'password_repeat')->passwordInput(['maxlength' => true]) ?>
    
        <?php if($_SESSION['user']['action'] == 'update') { ?>
            <script type="text/javascript">
            function generatePassword() {
                var length = 6,
                    charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789",
                    retVal = "";
                for (var i = 0, n = charset.length; i < length; ++i) {
                    retVal += charset.charAt(Math.floor(Math.random() * n));
                }
                
                document.getElementById('users-generate_password').value = retVal;
                document.getElementById('users-password').value = '';
                document.getElementById('users-password').readOnly = true;
                document.getElementById('users-password_repeat').value = '';
                document.getElementById('users-password_repeat').readOnly = true;
                document.getElementById('users-generate_password_button_hide').style.display = '';
                document.getElementById('users-generate_password_button_cancel').style.display = '';
            }
        
            function generatePasswordCancel() {
                document.getElementById('users-generate_password').value = '';
                document.getElementById('users-generate_password_button_hide').style.display = 'none';
                document.getElementById('users-generate_password_button_cancel').style.display = 'none';
                document.getElementById('users-password').readOnly = false;
                document.getElementById('users-password_repeat').readOnly = false;
            }
            
            function hidePasswordToggle() {
                if(document.getElementById('users-generate_password').type=='password')
                {
                    document.getElementById("users-generate_password").type="text";
                    document.getElementById("users-generate_password_button_hide").value="Hide Password";
                }
                else
                {
                    document.getElementById("users-generate_password").type="password";
                    document.getElementById("users-generate_password_button_hide").value="Show Password";
                }
            }
            
        
            </script>
            
            <div class="form-group field-users-generate_password">
            <div><label class="control-label" for="users-generate_password">Generate Password</label></div>
            <div class="row">
            <div class="col-sm-4"><input type="text" id="users-generate_password" class="form-control input-sm" name="Users[generate_password]"></div>
            <div class="col-sm-2"><input type="button" id="users-generate_password_button" class="form-control input-sm btn btn-success btn-sm" name="generate_password" value="Generate Password" onclick="generatePassword();"></div>
            <div class="col-sm-2"><input type="button" id="users-generate_password_button_hide" class="form-control input-sm btn btn-warning btn-sm" name="hide_password" value="Hide Password" onclick="hidePasswordToggle();" style="display:none"></div>
            <div class="col-sm-2"><input type="button" id="users-generate_password_button_cancel" class="form-control input-sm btn btn-danger btn-sm" name="cancel_password" value="Cancel" onclick="generatePasswordCancel();" style="display:none"></div>
            </div>
            </div>
            
        <?php } ?>
        
        
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
    
    <div id="user-associate-broker-details" class="panel panel-default">
        <div class="panel-heading"><strong>Assocaite Broker Details</strong></div>
        <div class="panel-body">
        
        <?= $form->field($modelUserAssociateBrokerDetails, 'company_name')->textInput(['maxlength' => true]) ?>

        <?= $form->field($modelUserAssociateBrokerDetails, 'brand_name')->textInput(['maxlength' => true]) ?>
        
		<?php
        echo $form->field($modelUserAssociateBrokerDetails, 'akta_perusahaan')->widget(FileInput::classname(), [
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
                        (($modelUserAssociateBrokerDetails->akta_perusahaan) ? Html::img($modelUserAssociateBrokerDetails->akta_perusahaan, ['width'=>200]) : NULL), // checks the models to display the preview
                    ],
					'layoutTemplates' => ['actionDrag'=> '','actionZoom'=> '','actionDelete'=> ''],
                ],
        ])->label($modelUserAssociateBrokerDetails->getAttributeLabel('akta_perusahaan').' <span style="font-weight:normal;">(Max Size:10MB File Format:png,jpg,jpeg)</span>');
        ?>
    
		<?php
        echo $form->field($modelUserAssociateBrokerDetails, 'nib')->widget(FileInput::classname(), [
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
                        (($modelUserAssociateBrokerDetails->nib) ? Html::img($modelUserAssociateBrokerDetails->nib, ['width'=>200]) : NULL), // checks the models to display the preview
                    ],
					'layoutTemplates' => ['actionDrag'=> '','actionZoom'=> '','actionDelete'=> ''],
                ],
        ])->label($modelUserAssociateBrokerDetails->getAttributeLabel('nib').' <span style="font-weight:normal;">(Max Size:10MB File Format:png,jpg,jpeg)</span>');
        ?>
    
		<?php
        echo $form->field($modelUserAssociateBrokerDetails, 'sk_menkeh')->widget(FileInput::classname(), [
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
                        (($modelUserAssociateBrokerDetails->sk_menkeh) ? Html::img($modelUserAssociateBrokerDetails->sk_menkeh, ['width'=>200]) : NULL), // checks the models to display the preview
                    ],
					'layoutTemplates' => ['actionDrag'=> '','actionZoom'=> '','actionDelete'=> ''],
                ],
        ])->label($modelUserAssociateBrokerDetails->getAttributeLabel('sk_menkeh').' <span style="font-weight:normal;">(Max Size:10MB File Format:png,jpg,jpeg)</span>');
        ?>
    
		<?php
        echo $form->field($modelUserAssociateBrokerDetails, 'npwp')->widget(FileInput::classname(), [
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
                        (($modelUserAssociateBrokerDetails->npwp) ? Html::img($modelUserAssociateBrokerDetails->npwp, ['width'=>200]) : NULL), // checks the models to display the preview
                    ],
					'layoutTemplates' => ['actionDrag'=> '','actionZoom'=> '','actionDelete'=> ''],
                ],
        ])->label($modelUserAssociateBrokerDetails->getAttributeLabel('npwp').' <span style="font-weight:normal;">(Max Size:10MB File Format:png,jpg,jpeg)</span>');
        ?>
    
		<?php
        echo $form->field($modelUserAssociateBrokerDetails, 'ktp_direktur')->widget(FileInput::classname(), [
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
                        (($modelUserAssociateBrokerDetails->ktp_direktur) ? Html::img($modelUserAssociateBrokerDetails->ktp_direktur, ['width'=>200]) : NULL), // checks the models to display the preview
                    ],
					'layoutTemplates' => ['actionDrag'=> '','actionZoom'=> '','actionDelete'=> ''],
                ],
        ])->label($modelUserAssociateBrokerDetails->getAttributeLabel('ktp_direktur').' <span style="font-weight:normal;">(Max Size:10MB File Format:png,jpg,jpeg)</span>');
        ?>
    
		<?php
        echo $form->field($modelUserAssociateBrokerDetails, 'bank_account')->widget(FileInput::classname(), [
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
                        (($modelUserAssociateBrokerDetails->bank_account) ? Html::img($modelUserAssociateBrokerDetails->bank_account, ['width'=>200]) : NULL), // checks the models to display the preview
                    ],
					'layoutTemplates' => ['actionDrag'=> '','actionZoom'=> '','actionDelete'=> ''],
                ],
        ])->label($modelUserAssociateBrokerDetails->getAttributeLabel('bank_account').' <span style="font-weight:normal;">(Max Size:10MB File Format:png,jpg,jpeg)</span>');
        ?>
    
        </div>
    </div>  
     
    <?php
	if(!$modelUser->isNewRecord)
	{
	?>
    <div class="panel panel-default">
        <div class="panel-heading"><strong>Actions</strong></div>
        <div class="panel-body">
        
        <input id="send_user_notification" name="send_user_notification" value="1" type="checkbox" />
        <label>Send an email to user about reset password.</label>
        
        </div>
    </div> 
    <?php
	}
	?>
                   
    <div class="form-group">
        <?= Html::submitButton($modelUser->isNewRecord ? 'Create' : 'Update', ['class' => $modelUser->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


<script>
$(document).ready(function(e) {
	//hide bank dropdown
	$(".field-userbank-bank_id").hide();
	$("#userbank-bank_id").prop('disabled',true);
	//hide developer dropdown
	$(".field-userdeveloper-developer_id").hide();
	$("#userdeveloper-developer_id").prop('disabled',true);
	//hide fintech dropdown
	$(".field-userfintech-fintech_id").hide();
	$("#userfintech-fintech_id").prop('disabled',true);
	//hide project dropdown
	$(".field-projectagents-project_id").hide();
	$("#projectagents-project_id").prop('disabled',true);
	//hide upline dropdown
	$(".field-assistantupline-upline_id").hide();
	$("#assistantupline-upline_id").prop('disabled',true);
	
	//user-associate-broker-details
	$("#user-associate-broker-details").hide();
	$(".field-userassociatebrokerdetails-company_name").hide();
	$("#userassociatebrokerdetails-company_name").prop('disabled',true);
	$(".field-userassociatebrokerdetails-brand_name").hide();
	$("#userassociatebrokerdetails-brand_name").prop('disabled',true);
	$(".field-userassociatebrokerdetails-akta_perusahaan").hide();
	$("#userassociatebrokerdetails-akta_perusahaan").prop('disabled',true);
	$(".field-userassociatebrokerdetails-nib").hide();
	$("#userassociatebrokerdetails-nib").prop('disabled',true);
	$(".field-userassociatebrokerdetails-sk_menkeh").hide();
	$("#userassociatebrokerdetails-sk_menkeh").prop('disabled',true);
	$(".field-userassociatebrokerdetails-npwp").hide();
	$("#userassociatebrokerdetails-npwp").prop('disabled',true);
	$(".field-userassociatebrokerdetails-ktp_direktur").hide();
	$("#userassociatebrokerdetails-ktp_direktur").prop('disabled',true);
	$(".field-userassociatebrokerdetails-bank_account").hide();
	$("#userassociatebrokerdetails-bank_account").prop('disabled',true);
	
	<?php
	if($modelUserGroups->groupaccess_id != NULL)
	{
		if(!is_array($modelUserGroups->groupaccess_id))
		$modelUserGroups->groupaccess_id = (array)$modelUserGroups->groupaccess_id;
		if(in_array(4,$modelUserGroups->groupaccess_id))
		{
			?>
			$(".field-userbank-bank_id").show();
			$("#userbank-bank_id").prop('disabled',false);
			$(".field-userdeveloper-developer_id").hide();
			$("#userdeveloper-developer_id").prop('disabled',true);
			$(".field-userfintech-fintech_id").hide();
			$("#userfintech-fintech_id").prop('disabled',true);
			$(".field-projectagents-project_id").hide();
			$("#projectagents-project_id").prop('disabled',true);
			$(".field-assistantupline-upline_id").hide();
			$("#assistantupline-upline_id").prop('disabled',true);
			
			//user-associate-broker-details
			$("#user-associate-broker-details").hide();
			$(".field-userassociatebrokerdetails-company_name").hide();
			$("#userassociatebrokerdetails-company_name").prop('disabled',true);
			$(".field-userassociatebrokerdetails-brand_name").hide();
			$("#userassociatebrokerdetails-brand_name").prop('disabled',true);
			$(".field-userassociatebrokerdetails-akta_perusahaan").hide();
			$("#userassociatebrokerdetails-akta_perusahaan").prop('disabled',true);
			$(".field-userassociatebrokerdetails-nib").hide();
			$("#userassociatebrokerdetails-nib").prop('disabled',true);
			$(".field-userassociatebrokerdetails-sk_menkeh").hide();
			$("#userassociatebrokerdetails-sk_menkeh").prop('disabled',true);
			$(".field-userassociatebrokerdetails-npwp").hide();
			$("#userassociatebrokerdetails-npwp").prop('disabled',true);
			$(".field-userassociatebrokerdetails-ktp_direktur").hide();
			$("#userassociatebrokerdetails-ktp_direktur").prop('disabled',true);
			$(".field-userassociatebrokerdetails-bank_account").hide();
			$("#userassociatebrokerdetails-bank_account").prop('disabled',true);
			<?php
		}
		elseif(in_array(5,$modelUserGroups->groupaccess_id))
		{
			?>
			$(".field-userbank-bank_id").hide();
			$("#userbank-bank_id").prop('disabled',true);
			$(".field-userdeveloper-developer_id").show();
			$("#userdeveloper-developer_id").prop('disabled',false);
			$(".field-userfintech-fintech_id").hide();
			$("#userfintech-fintech_id").prop('disabled',true);
			$(".field-projectagents-project_id").hide();
			$("#projectagents-project_id").prop('disabled',true);
			$(".field-assistantupline-upline_id").hide();
			$("#assistantupline-upline_id").prop('disabled',true);
			
			//user-associate-broker-details
			$("#user-associate-broker-details").hide();
			$(".field-userassociatebrokerdetails-company_name").hide();
			$("#userassociatebrokerdetails-company_name").prop('disabled',true);
			$(".field-userassociatebrokerdetails-brand_name").hide();
			$("#userassociatebrokerdetails-brand_name").prop('disabled',true);
			$(".field-userassociatebrokerdetails-akta_perusahaan").hide();
			$("#userassociatebrokerdetails-akta_perusahaan").prop('disabled',true);
			$(".field-userassociatebrokerdetails-nib").hide();
			$("#userassociatebrokerdetails-nib").prop('disabled',true);
			$(".field-userassociatebrokerdetails-sk_menkeh").hide();
			$("#userassociatebrokerdetails-sk_menkeh").prop('disabled',true);
			$(".field-userassociatebrokerdetails-npwp").hide();
			$("#userassociatebrokerdetails-npwp").prop('disabled',true);
			$(".field-userassociatebrokerdetails-ktp_direktur").hide();
			$("#userassociatebrokerdetails-ktp_direktur").prop('disabled',true);
			$(".field-userassociatebrokerdetails-bank_account").hide();
			$("#userassociatebrokerdetails-bank_account").prop('disabled',true);
			<?php
		}
		elseif(in_array(6,$modelUserGroups->groupaccess_id))
		{
			?>
			$(".field-userbank-bank_id").hide();
			$("#userbank-bank_id").prop('disabled',true);
			$(".field-userdeveloper-developer_id").hide();
			$("#userdeveloper-developer_id").prop('disabled',true);
			$(".field-userfintech-fintech_id").show();
			$("#userfintech-fintech_id").prop('disabled',false);
			$(".field-projectagents-project_id").hide();
			$("#projectagents-project_id").prop('disabled',true);
			$(".field-assistantupline-upline_id").hide();
			$("#assistantupline-upline_id").prop('disabled',true);
			
			//user-associate-broker-details
			$("#user-associate-broker-details").hide();
			$(".field-userassociatebrokerdetails-company_name").hide();
			$("#userassociatebrokerdetails-company_name").prop('disabled',true);
			$(".field-userassociatebrokerdetails-brand_name").hide();
			$("#userassociatebrokerdetails-brand_name").prop('disabled',true);
			$(".field-userassociatebrokerdetails-akta_perusahaan").hide();
			$("#userassociatebrokerdetails-akta_perusahaan").prop('disabled',true);
			$(".field-userassociatebrokerdetails-nib").hide();
			$("#userassociatebrokerdetails-nib").prop('disabled',true);
			$(".field-userassociatebrokerdetails-sk_menkeh").hide();
			$("#userassociatebrokerdetails-sk_menkeh").prop('disabled',true);
			$(".field-userassociatebrokerdetails-npwp").hide();
			$("#userassociatebrokerdetails-npwp").prop('disabled',true);
			$(".field-userassociatebrokerdetails-ktp_direktur").hide();
			$("#userassociatebrokerdetails-ktp_direktur").prop('disabled',true);
			$(".field-userassociatebrokerdetails-bank_account").hide();
			$("#userassociatebrokerdetails-bank_account").prop('disabled',true);
			<?php
		}
		elseif(in_array(7,$modelUserGroups->groupaccess_id))
		{
			?>
			$(".field-userbank-bank_id").hide();
			$("#userbank-bank_id").prop('disabled',true);
			$(".field-userdeveloper-developer_id").hide();
			$("#userdeveloper-developer_id").prop('disabled',true);
			$(".field-userfintech-fintech_id").hide();
			$("#userfintech-fintech_id").prop('disabled',true);
			$(".field-projectagents-project_id").show();
			$("#projectagents-project_id").prop('disabled',false);
			$(".field-assistantupline-upline_id").hide();
			$("#assistantupline-upline_id").prop('disabled',true);
			
			//user-associate-broker-details
			$("#user-associate-broker-details").hide();
			$(".field-userassociatebrokerdetails-company_name").hide();
			$("#userassociatebrokerdetails-company_name").prop('disabled',true);
			$(".field-userassociatebrokerdetails-brand_name").hide();
			$("#userassociatebrokerdetails-brand_name").prop('disabled',true);
			$(".field-userassociatebrokerdetails-akta_perusahaan").hide();
			$("#userassociatebrokerdetails-akta_perusahaan").prop('disabled',true);
			$(".field-userassociatebrokerdetails-nib").hide();
			$("#userassociatebrokerdetails-nib").prop('disabled',true);
			$(".field-userassociatebrokerdetails-sk_menkeh").hide();
			$("#userassociatebrokerdetails-sk_menkeh").prop('disabled',true);
			$(".field-userassociatebrokerdetails-npwp").hide();
			$("#userassociatebrokerdetails-npwp").prop('disabled',true);
			$(".field-userassociatebrokerdetails-ktp_direktur").hide();
			$("#userassociatebrokerdetails-ktp_direktur").prop('disabled',true);
			$(".field-userassociatebrokerdetails-bank_account").hide();
			$("#userassociatebrokerdetails-bank_account").prop('disabled',true);
			<?php
		}
		elseif(in_array(8,$modelUserGroups->groupaccess_id))
		{
			?>
			$(".field-userbank-bank_id").hide();
			$("#userbank-bank_id").prop('disabled',true);
			$(".field-userdeveloper-developer_id").hide();
			$("#userdeveloper-developer_id").prop('disabled',true);
			$(".field-userfintech-fintech_id").hide();
			$("#userfintech-fintech_id").prop('disabled',true);
			$(".field-projectagents-project_id").hide();
			$("#projectagents-project_id").prop('disabled',true);
			$(".field-assistantupline-upline_id").hide();
			$("#assistantupline-upline_id").prop('disabled',true);
			
			//user-associate-broker-details
			$("#user-associate-broker-details").show();
			$(".field-userassociatebrokerdetails-company_name").show();
			$("#userassociatebrokerdetails-company_name").prop('disabled',false);
			$(".field-userassociatebrokerdetails-brand_name").show();
			$("#userassociatebrokerdetails-brand_name").prop('disabled',false);
			$(".field-userassociatebrokerdetails-akta_perusahaan").show();
			$("#userassociatebrokerdetails-akta_perusahaan").prop('disabled',false);
			$(".field-userassociatebrokerdetails-nib").show();
			$("#userassociatebrokerdetails-nib").prop('disabled',false);
			$(".field-userassociatebrokerdetails-sk_menkeh").show();
			$("#userassociatebrokerdetails-sk_menkeh").prop('disabled',false);
			$(".field-userassociatebrokerdetails-npwp").show();
			$("#userassociatebrokerdetails-npwp").prop('disabled',false);
			$(".field-userassociatebrokerdetails-ktp_direktur").show();
			$("#userassociatebrokerdetails-ktp_direktur").prop('disabled',false);
			$(".field-userassociatebrokerdetails-bank_account").show();
			$("#userassociatebrokerdetails-bank_account").prop('disabled',false);
			<?php
		}
		elseif(array_intersect(array(9,10),$modelUserGroups->groupaccess_id))
		{
			?>
			$(".field-userbank-bank_id").hide();
			$("#userbank-bank_id").prop('disabled',true);
			$(".field-userdeveloper-developer_id").hide();
			$("#userdeveloper-developer_id").prop('disabled',true);
			$(".field-userfintech-fintech_id").hide();
			$("#userfintech-fintech_id").prop('disabled',true);
			$(".field-projectagents-project_id").hide();
			$("#projectagents-project_id").prop('disabled',true);
			$(".field-assistantupline-upline_id").show();
			$("#assistantupline-upline_id").prop('disabled',false);
			
			//user-associate-broker-details
			$("#user-associate-broker-details").hide();
			$(".field-userassociatebrokerdetails-company_name").hide();
			$("#userassociatebrokerdetails-company_name").prop('disabled',true);
			$(".field-userassociatebrokerdetails-brand_name").hide();
			$("#userassociatebrokerdetails-brand_name").prop('disabled',true);
			$(".field-userassociatebrokerdetails-akta_perusahaan").hide();
			$("#userassociatebrokerdetails-akta_perusahaan").prop('disabled',true);
			$(".field-userassociatebrokerdetails-nib").hide();
			$("#userassociatebrokerdetails-nib").prop('disabled',true);
			$(".field-userassociatebrokerdetails-sk_menkeh").hide();
			$("#userassociatebrokerdetails-sk_menkeh").prop('disabled',true);
			$(".field-userassociatebrokerdetails-npwp").hide();
			$("#userassociatebrokerdetails-npwp").prop('disabled',true);
			$(".field-userassociatebrokerdetails-ktp_direktur").hide();
			$("#userassociatebrokerdetails-ktp_direktur").prop('disabled',true);
			$(".field-userassociatebrokerdetails-bank_account").hide();
			$("#userassociatebrokerdetails-bank_account").prop('disabled',true);
			<?php
		}
		else
		{
			?>
			$(".field-userbank-bank_id").hide();
			$("#userbank-bank_id").prop('disabled',true);
			$(".field-userdeveloper-developer_id").hide();
			$("#userdeveloper-developer_id").prop('disabled',true);
			$(".field-userfintech-fintech_id").hide();
			$("#userfintech-fintech_id").prop('disabled',true);
			$(".field-projectagents-project_id").hide();
			$("#projectagents-project_id").prop('disabled',true);
			$(".field-assistantupline-upline_id").hide();
			$("#assistantupline-upline_id").prop('disabled',true);
			
			//user-associate-broker-details
			$("#user-associate-broker-details").hide();
			$(".field-userassociatebrokerdetails-company_name").hide();
			$("#userassociatebrokerdetails-company_name").prop('disabled',true);
			$(".field-userassociatebrokerdetails-brand_name").hide();
			$("#userassociatebrokerdetails-brand_name").prop('disabled',true);
			$(".field-userassociatebrokerdetails-akta_perusahaan").hide();
			$("#userassociatebrokerdetails-akta_perusahaan").prop('disabled',true);
			$(".field-userassociatebrokerdetails-nib").hide();
			$("#userassociatebrokerdetails-nib").prop('disabled',true);
			$(".field-userassociatebrokerdetails-sk_menkeh").hide();
			$("#userassociatebrokerdetails-sk_menkeh").prop('disabled',true);
			$(".field-userassociatebrokerdetails-npwp").hide();
			$("#userassociatebrokerdetails-npwp").prop('disabled',true);
			$(".field-userassociatebrokerdetails-ktp_direktur").hide();
			$("#userassociatebrokerdetails-ktp_direktur").prop('disabled',true);
			$(".field-userassociatebrokerdetails-bank_account").hide();
			$("#userassociatebrokerdetails-bank_account").prop('disabled',true);
			<?php
		}
	}
	?>
	
	$("input[name='UserGroups[groupaccess_id]']").on('change',function() {
		if(this.value==4)
		{
			$(".field-userbank-bank_id").show();
			$("#userbank-bank_id").prop('disabled',false);
			$(".field-userdeveloper-developer_id").hide();
			$("#userdeveloper-developer_id").prop('disabled',true);
			$(".field-userfintech-fintech_id").hide();
			$("#userfintech-fintech_id").prop('disabled',true);
			$(".field-projectagents-project_id").hide();
			$("#projectagents-project_id").prop('disabled',true);
			$(".field-assistantupline-upline_id").hide();
			$("#assistantupline-upline_id").prop('disabled',true);
			
			//user-associate-broker-details
			$("#user-associate-broker-details").hide();
			$(".field-userassociatebrokerdetails-company_name").hide();
			$("#userassociatebrokerdetails-company_name").prop('disabled',true);
			$(".field-userassociatebrokerdetails-brand_name").hide();
			$("#userassociatebrokerdetails-brand_name").prop('disabled',true);
			$(".field-userassociatebrokerdetails-akta_perusahaan").hide();
			$("#userassociatebrokerdetails-akta_perusahaan").prop('disabled',true);
			$(".field-userassociatebrokerdetails-nib").hide();
			$("#userassociatebrokerdetails-nib").prop('disabled',true);
			$(".field-userassociatebrokerdetails-sk_menkeh").hide();
			$("#userassociatebrokerdetails-sk_menkeh").prop('disabled',true);
			$(".field-userassociatebrokerdetails-npwp").hide();
			$("#userassociatebrokerdetails-npwp").prop('disabled',true);
			$(".field-userassociatebrokerdetails-ktp_direktur").hide();
			$("#userassociatebrokerdetails-ktp_direktur").prop('disabled',true);
			$(".field-userassociatebrokerdetails-bank_account").hide();
			$("#userassociatebrokerdetails-bank_account").prop('disabled',true);
		}
		else if(this.value==5)
		{
			$(".field-userbank-bank_id").hide();
			$("#userbank-bank_id").prop('disabled',true);
			$(".field-userdeveloper-developer_id").show();
			$("#userdeveloper-developer_id").prop('disabled',false);
			$(".field-userfintech-fintech_id").hide();
			$("#userfintech-fintech_id").prop('disabled',true);
			$(".field-projectagents-project_id").hide();
			$("#projectagents-project_id").prop('disabled',true);
			$(".field-assistantupline-upline_id").hide();
			$("#assistantupline-upline_id").prop('disabled',true);
			
			//user-associate-broker-details
			$("#user-associate-broker-details").hide();
			$(".field-userassociatebrokerdetails-company_name").hide();
			$("#userassociatebrokerdetails-company_name").prop('disabled',true);
			$(".field-userassociatebrokerdetails-brand_name").hide();
			$("#userassociatebrokerdetails-brand_name").prop('disabled',true);
			$(".field-userassociatebrokerdetails-akta_perusahaan").hide();
			$("#userassociatebrokerdetails-akta_perusahaan").prop('disabled',true);
			$(".field-userassociatebrokerdetails-nib").hide();
			$("#userassociatebrokerdetails-nib").prop('disabled',true);
			$(".field-userassociatebrokerdetails-sk_menkeh").hide();
			$("#userassociatebrokerdetails-sk_menkeh").prop('disabled',true);
			$(".field-userassociatebrokerdetails-npwp").hide();
			$("#userassociatebrokerdetails-npwp").prop('disabled',true);
			$(".field-userassociatebrokerdetails-ktp_direktur").hide();
			$("#userassociatebrokerdetails-ktp_direktur").prop('disabled',true);
			$(".field-userassociatebrokerdetails-bank_account").hide();
			$("#userassociatebrokerdetails-bank_account").prop('disabled',true);
		}
		else if(this.value==6)
		{
			$(".field-userbank-bank_id").hide();
			$("#userbank-bank_id").prop('disabled',true);
			$(".field-userdeveloper-developer_id").hide();
			$("#userdeveloper-developer_id").prop('disabled',true);
			$(".field-userfintech-fintech_id").show();
			$("#userfintech-fintech_id").prop('disabled',false);
			$(".field-projectagents-project_id").hide();
			$("#projectagents-project_id").prop('disabled',true);
			$(".field-assistantupline-upline_id").hide();
			$("#assistantupline-upline_id").prop('disabled',true);
			
			//user-associate-broker-details
			$("#user-associate-broker-details").hide();
			$(".field-userassociatebrokerdetails-company_name").hide();
			$("#userassociatebrokerdetails-company_name").prop('disabled',true);
			$(".field-userassociatebrokerdetails-brand_name").hide();
			$("#userassociatebrokerdetails-brand_name").prop('disabled',true);
			$(".field-userassociatebrokerdetails-akta_perusahaan").hide();
			$("#userassociatebrokerdetails-akta_perusahaan").prop('disabled',true);
			$(".field-userassociatebrokerdetails-nib").hide();
			$("#userassociatebrokerdetails-nib").prop('disabled',true);
			$(".field-userassociatebrokerdetails-sk_menkeh").hide();
			$("#userassociatebrokerdetails-sk_menkeh").prop('disabled',true);
			$(".field-userassociatebrokerdetails-npwp").hide();
			$("#userassociatebrokerdetails-npwp").prop('disabled',true);
			$(".field-userassociatebrokerdetails-ktp_direktur").hide();
			$("#userassociatebrokerdetails-ktp_direktur").prop('disabled',true);
			$(".field-userassociatebrokerdetails-bank_account").hide();
			$("#userassociatebrokerdetails-bank_account").prop('disabled',true);
		}
		else if(this.value==7)
		{
			$(".field-userbank-bank_id").hide();
			$("#userbank-bank_id").prop('disabled',true);
			$(".field-userdeveloper-developer_id").hide();
			$("#userdeveloper-developer_id").prop('disabled',true);
			$(".field-userfintech-fintech_id").hide();
			$("#userfintech-fintech_id").prop('disabled',true);
			$(".field-projectagents-project_id").show();
			$("#projectagents-project_id").prop('disabled',false);
			$(".field-assistantupline-upline_id").hide();
			$("#assistantupline-upline_id").prop('disabled',true);
			
						//user-associate-broker-details
			$("#user-associate-broker-details").hide();
			$(".field-userassociatebrokerdetails-company_name").hide();
			$("#userassociatebrokerdetails-company_name").prop('disabled',true);
			$(".field-userassociatebrokerdetails-brand_name").hide();
			$("#userassociatebrokerdetails-brand_name").prop('disabled',true);
			$(".field-userassociatebrokerdetails-akta_perusahaan").hide();
			$("#userassociatebrokerdetails-akta_perusahaan").prop('disabled',true);
			$(".field-userassociatebrokerdetails-nib").hide();
			$("#userassociatebrokerdetails-nib").prop('disabled',true);
			$(".field-userassociatebrokerdetails-sk_menkeh").hide();
			$("#userassociatebrokerdetails-sk_menkeh").prop('disabled',true);
			$(".field-userassociatebrokerdetails-npwp").hide();
			$("#userassociatebrokerdetails-npwp").prop('disabled',true);
			$(".field-userassociatebrokerdetails-ktp_direktur").hide();
			$("#userassociatebrokerdetails-ktp_direktur").prop('disabled',true);
			$(".field-userassociatebrokerdetails-bank_account").hide();
			$("#userassociatebrokerdetails-bank_account").prop('disabled',true);

		}
		else if(this.value==8)
		{
			$(".field-userbank-bank_id").hide();
			$("#userbank-bank_id").prop('disabled',true);
			$(".field-userdeveloper-developer_id").hide();
			$("#userdeveloper-developer_id").prop('disabled',true);
			$(".field-userfintech-fintech_id").hide();
			$("#userfintech-fintech_id").prop('disabled',true);
			$(".field-projectagents-project_id").hide();
			$("#projectagents-project_id").prop('disabled',true);
			$(".field-assistantupline-upline_id").hide();
			$("#assistantupline-upline_id").prop('disabled',true);
			
						//user-associate-broker-details
			$("#user-associate-broker-details").show();
			$(".field-userassociatebrokerdetails-company_name").show();
			$("#userassociatebrokerdetails-company_name").prop('disabled',false);
			$(".field-userassociatebrokerdetails-brand_name").show();
			$("#userassociatebrokerdetails-brand_name").prop('disabled',false);
			$(".field-userassociatebrokerdetails-akta_perusahaan").show();
			$("#userassociatebrokerdetails-akta_perusahaan").prop('disabled',false);
			$(".field-userassociatebrokerdetails-nib").show();
			$("#userassociatebrokerdetails-nib").prop('disabled',false);
			$(".field-userassociatebrokerdetails-sk_menkeh").show();
			$("#userassociatebrokerdetails-sk_menkeh").prop('disabled',false);
			$(".field-userassociatebrokerdetails-npwp").show();
			$("#userassociatebrokerdetails-npwp").prop('disabled',false);
			$(".field-userassociatebrokerdetails-ktp_direktur").show();
			$("#userassociatebrokerdetails-ktp_direktur").prop('disabled',false);
			$(".field-userassociatebrokerdetails-bank_account").show();
			$("#userassociatebrokerdetails-bank_account").prop('disabled',false);

		}
		else if(this.value==9 || this.value==10)
		{
			$(".field-userbank-bank_id").hide();
			$("#userbank-bank_id").prop('disabled',true);
			$(".field-userdeveloper-developer_id").hide();
			$("#userdeveloper-developer_id").prop('disabled',true);
			$(".field-userfintech-fintech_id").hide();
			$("#userfintech-fintech_id").prop('disabled',true);
			$(".field-projectagents-project_id").hide();
			$("#projectagents-project_id").prop('disabled',true);
			$(".field-assistantupline-upline_id").show();
			$("#assistantupline-upline_id").prop('disabled',false);
			
						//user-associate-broker-details
			$("#user-associate-broker-details").hide();
			$(".field-userassociatebrokerdetails-company_name").hide();
			$("#userassociatebrokerdetails-company_name").prop('disabled',true);
			$(".field-userassociatebrokerdetails-brand_name").hide();
			$("#userassociatebrokerdetails-brand_name").prop('disabled',true);
			$(".field-userassociatebrokerdetails-akta_perusahaan").hide();
			$("#userassociatebrokerdetails-akta_perusahaan").prop('disabled',true);
			$(".field-userassociatebrokerdetails-nib").hide();
			$("#userassociatebrokerdetails-nib").prop('disabled',true);
			$(".field-userassociatebrokerdetails-sk_menkeh").hide();
			$("#userassociatebrokerdetails-sk_menkeh").prop('disabled',true);
			$(".field-userassociatebrokerdetails-npwp").hide();
			$("#userassociatebrokerdetails-npwp").prop('disabled',true);
			$(".field-userassociatebrokerdetails-ktp_direktur").hide();
			$("#userassociatebrokerdetails-ktp_direktur").prop('disabled',true);
			$(".field-userassociatebrokerdetails-bank_account").hide();
			$("#userassociatebrokerdetails-bank_account").prop('disabled',true);

		}
		else
		{
			$(".field-userbank-bank_id").hide();
			$("#userbank-bank_id").prop('disabled',true);
			$(".field-userdeveloper-developer_id").hide();
			$("#userdeveloper-developer_id").prop('disabled',true);
			$(".field-userfintech-fintech_id").hide();
			$("#userfintech-fintech_id").prop('disabled',true);
			$(".field-projectagents-project_id").hide();
			$("#projectagents-project_id").prop('disabled',true);
			$(".field-assistantupline-upline_id").hide();
			$("#assistantupline-upline_id").prop('disabled',true);
			
						//user-associate-broker-details
			$("#user-associate-broker-details").hide();
			$(".field-userassociatebrokerdetails-company_name").hide();
			$("#userassociatebrokerdetails-company_name").prop('disabled',true);
			$(".field-userassociatebrokerdetails-brand_name").hide();
			$("#userassociatebrokerdetails-brand_name").prop('disabled',true);
			$(".field-userassociatebrokerdetails-akta_perusahaan").hide();
			$("#userassociatebrokerdetails-akta_perusahaan").prop('disabled',true);
			$(".field-userassociatebrokerdetails-nib").hide();
			$("#userassociatebrokerdetails-nib").prop('disabled',true);
			$(".field-userassociatebrokerdetails-sk_menkeh").hide();
			$("#userassociatebrokerdetails-sk_menkeh").prop('disabled',true);
			$(".field-userassociatebrokerdetails-npwp").hide();
			$("#userassociatebrokerdetails-npwp").prop('disabled',true);
			$(".field-userassociatebrokerdetails-ktp_direktur").hide();
			$("#userassociatebrokerdetails-ktp_direktur").prop('disabled',true);
			$(".field-userassociatebrokerdetails-bank_account").hide();
			$("#userassociatebrokerdetails-bank_account").prop('disabled',true);

		}
	});
	
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



