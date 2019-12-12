<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\file\FileInput;
use kartik\number\NumberControl;

/* @var $this yii\web\View */
/* @var $model app\models\Prospects */
/* @var $form yii\widgets\ActiveForm */

$paymentMethods = Yii::$app->AccessMod->getLookupData('lookup_payment_method');
$agentProjects = Yii::$app->AccessMod->getAgentProjectID($_SESSION['user']['id']);
$prospectInterestedProjects = Yii::$app->ProspectMod->getProspectInterestedProjects($model->id,false);
$interProjects = array_values(array_intersect($agentProjects,$prospectInterestedProjects));

if(!$modelPB->isNewRecord)
$productids = Yii::$app->GeneralMod->getProjectProductsByProjectID(array($modelPB->project_id));
else
$productids = array();

if(empty($modelPB->product_id))
$unitTypes = array();
else
$unitTypes = Yii::$app->GeneralMod->getUnitTypesByProductID(array($modelPB->product_id));

$vat_percent = (!empty($modelPB->product_unit_vat_price) and !empty($modelPB->product_unit_price))?($modelPB->product_unit_vat_price/$modelPB->product_unit_price*100):5;
$modelPB->product_unit_vat_price = number_format($modelPB->product_unit_vat_price,2,'.','');
?>

<div class="prospects-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

	<?php
	if($modelPB->isNewRecord)
	{
		$eoiBookings = Yii::$app->ProspectMod->getProspectBookings($model->id,false,array('status'=>3));
		
		if($eoiBookings)
		{
		echo 	$form->field($modelPB, 'id')->dropDownList(
				ArrayHelper::map($eoiBookings, 'id', 'eoi_ref_no'),['prompt' => 'Please select']
				)->label("Booking EOI");
		}
	}
	?>
    
     <div class="panel panel-default">
    
        <div class="panel-heading">
            <div class="row">
                <div class="col-sm-8"><h3 class="panel-title">Buyer Information</h3></div>
                <div class="col-sm-4" align="right"><button type="button" class="addBuyerDetail" onclick="cloneBuyer();"><span class="glyphicon glyphicon-plus"></span></button></div>
            </div>
        </div>
        <div class="panel-body buyer-list">
    
			<?php
            $i=1;
            foreach($modelPBB as $modelPBBChild)
            {
            ?>
            <div class="buyerDetail">
                <div class="row">
                    <div class="col-sm-1 buyerno" style="padding-top:24px;">
                    <?= $i ?>.
                    </div>

                    <div class="col-sm-5">
                    <?= $form->field($modelPBBChild, 'buyer_firstname[]')->textInput(['maxlength' => true, 'value' => $modelPBBChild->buyer_firstname]) ?>
                    </div>

                    <div class="col-sm-5">
                    <?= $form->field($modelPBBChild, 'buyer_lastname[]')->textInput(['maxlength' => true, 'value' => $modelPBBChild->buyer_lastname]) ?>
                    </div>
    
                    <div class="col-sm-1 buyer-remove" style="padding-top:24px;">
                    <?php
					if($i!=1)
					echo '<button name="buyer_remove" type="button" class="btn btn-danger" title="Remove" onclick="$(this).closest(\'.buyerDetail\').remove();"><span class="glyphicon glyphicon-remove"></span></button>';
					?>
                    </div>
                </div>
            </div>
			<?php
                $i++;
            }
            ?>

        </div>
    </div>    
   
    <?php
	if(count($interProjects)==1)
	{
		$modelPB->project_id = $interProjects[0];
    	echo $form->field($modelPB, 'project_id')->hiddenInput()->label(false); 
		$productids = Yii::$app->GeneralMod->getProjectProductsByProjectID(array($modelPB->project_id));
	}
	else
	{
		$projects = Yii::$app->GeneralMod->getProjectList(array('project_id'=>$interProjects));
		echo 	$form->field($modelPB, 'project_id')->dropDownList(
				ArrayHelper::map($projects, 'id', 'project_name')
				)->label($modelPB->getAttributeLabel('project_id'));
	}
	?>

	<?php
	echo 	$form->field($modelPB, 'product_id')->dropDownList(
	ArrayHelper::map($productids, 'id', 'product_name'),['prompt' => 'Please select']
	)->label($modelPB->getAttributeLabel('product_id'));
    ?>

    <?= $form->field($modelPB, 'product_unit')->textInput(['maxlength' => true]) ?>

	<?php
	echo 	$form->field($modelPB, 'product_unit_type')->dropDownList(
			ArrayHelper::map($unitTypes, 'id', 'type_name'),['prompt' => 'Please select']
			)->label($modelPB->getAttributeLabel('product_unit_type'));
    ?>

	<?= $form->field($modelPB, 'building_size_sm', 
		[
            'template' => '{label}
						  <div class="input-group">
			              {input}<span class="input-group-addon">m<sup>2</sup></span></div>{error}{hint}'
        ])->textInput(['maxlength' => true])
		->widget(NumberControl::classname(), [
			'maskedInputOptions' => [
				'prefix' => '',
				'suffix' => '',
				'allowMinus' => false,
				'rightAlign' => false,
			],
			'options' => ['type' => 'hidden'],
		]);
	?>    

	<?= $form->field($modelPB, 'land_size_sm', 
		[
            'template' => '{label}
						  <div class="input-group">
			              {input}<span class="input-group-addon">m<sup>2</sup></span></div>{error}{hint}'
        ])->textInput(['maxlength' => true])
		->widget(NumberControl::classname(), [
			'maskedInputOptions' => [
				'prefix' => '',
				'suffix' => '',
				'allowMinus' => false,
				'rightAlign' => false,
			],
			'options' => ['type' => 'hidden'],
		]);
	?>    

    <?= $form->field($modelPB, 'product_unit_price', ['inputOptions' => ['class' => 'form-control', 'value' => !empty($modelPB->product_unit_price)?number_format($modelPB->product_unit_price,2,'.',''):'']])
		->textInput(['maxlength' => true])
		->widget(NumberControl::classname(), [
			'maskedInputOptions' => [
				'prefix' => $_SESSION['settings']['CURRENCY_SYMBOL'].' ',
				'suffix' => '',
				'allowMinus' => false,
				'rightAlign' => false,
			],
			'options' => ['type' => 'hidden'],
		]);
	?>

	<?= $form->field($modelPB, 'product_unit_vat_price', 
		[
            'template' => '{label}
						  <div class="input-group">
						  <input id="vat_percent" type="number" min="5" max="20" class="form-control" placeholder="VAT percent" value="'.$vat_percent.'">
			              <span class="input-group-addon"><i class="fa fa-percent"></i></span>{input}</div>{error}{hint}'
        ])->textInput(['maxlength' => true,'readonly'=> 'readonly']);
	?>    

	<?php
	echo 	$form->field($modelPB, 'payment_method')->dropDownList(
			ArrayHelper::map($paymentMethods, 'id', 'name'),['prompt' => 'Please select']
			)->label($modelPB->getAttributeLabel('payment_method'));
    ?>

    <?= $form->field($modelPB, 'booking_amount')->textInput(['maxlength' => true])
		->widget(NumberControl::classname(), [
			'maskedInputOptions' => [
				'prefix' => $_SESSION['settings']['CURRENCY_SYMBOL'].' ',
				'suffix' => '',
				'allowMinus' => false,
				'rightAlign' => false,
			],
			'options' => ['type' => 'hidden'],
		]);
	?>

	<?php
	echo $form->field($modelPB, 'proof_of_payment')->widget(FileInput::classname(), [
        'model' => $modelPB,
        'attribute' => 'proof_of_payment',
		'options' => [
				'accept' => 'image/*',
				'multiple' => false,
		],
		'pluginOptions' => [
				'browseClass' => 'btn btn-primary',
				'browseLabel' =>  'Browse Photo',
				'showUpload' => false,
				'showCaption' => false,
				'showClose' => false,
				'removeClass' => 'btn btn-danger',
				'previewFileType' => 'any',
				'initialPreviewAsData'=>true,
				//'required' => true,
				'initialPreview' => [
					$modelPB->proof_of_payment,
				],
				'initialPreviewConfig' => [
								[
									'caption'=>!empty($modelPB->proof_of_payment)?basename(explode('-', $modelPB->proof_of_payment, 2)[1]):'',
									'type'=>Yii::$app->AccessMod->is_image($modelPB->proof_of_payment)?"image":"pdf",
									'url' => "/cmp/prospects/file-eoi-delete",
									'key' => $modelPB->id,
								],
	
							],
				'layoutTemplates' => ['actionDrag'=> '','actionZoom'=> ''],
			],
	]);
	?> 

	<?= $form->field($modelPB, 'booking_date')->widget(\yii\jui\DatePicker::classname(), [
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
            
        ]) 
    ?>

	<?php
	echo $form->field($modelPB, 'sp_file')->widget(FileInput::classname(), [
        'model' => $modelPB,
        'attribute' => 'sp_file',

		'options' => [
				'accept' => 'image/*',
				'multiple' => false,
		],
		'pluginOptions' => [
				'browseClass' => 'btn btn-primary',
				'browseLabel' =>  'Browse Photo',
				'showUpload' => false,
				'showCaption' => false,
				'showClose' => false,
				'removeClass' => 'btn btn-danger',
				'previewFileType' => 'any',
				'initialPreviewAsData'=>true,
				//'required' => true,
				'initialPreview' => [
					$modelPB->sp_file,
				],
				'initialPreviewConfig' => [
								[
									'caption'=>!empty($modelPB->sp_file)?basename(explode('-', $modelPB->sp_file, 2)[1]):'',
									'type'=>Yii::$app->AccessMod->is_image($modelPB->sp_file)?"image":"pdf",
									'url' => "/cmp/prospects/file-sp-delete",
									'key' => $modelPB->id,
								],
	
							],
				'layoutTemplates' => ['actionDrag'=> '','actionZoom'=> ''],
			],
	]);
	?> 

	<?php
	echo $form->field($model, 'prospect_identity_document')->widget(FileInput::classname(), [
        'model' => $model,
        'attribute' => 'prospect_identity_document',

		'options' => [
				'accept' => 'image/*',
				'multiple' => false,
		],
		'pluginOptions' => [
				'browseClass' => 'btn btn-primary',
				'browseLabel' =>  'Browse Photo',
				'showUpload' => false,
				'showClose' => false,
				'showCaption' => false,
				'removeClass' => 'btn btn-danger',
				'previewFileType' => 'any',
				'initialPreviewAsData'=>true,
				//'required'=> true,
				'initialPreview' => [
					$model->prospect_identity_document,
				],
				'initialPreviewConfig' => [
								[
									'caption'=>!empty($model->prospect_identity_document)?basename(explode('-', $model->prospect_identity_document, 2)[1]):'',
									'type'=>Yii::$app->AccessMod->is_image($model->prospect_identity_document)?"image":"pdf",
									'url' => "/cmp/prospects/file-identity-document-delete",
									'key' => $model->id,
								],
	
							],
				'layoutTemplates' => ['actionDrag'=> '','actionZoom'=> ''],
			],
	]);
	?> 

	<?php
	echo $form->field($model, 'tax_license')->widget(FileInput::classname(), [
        'model' => $model,
        'attribute' => 'tax_license',

		'options' => [
				'accept' => 'image/*',
				'multiple' => false,
		],
		'pluginOptions' => [
				'browseClass' => 'btn btn-primary',
				'browseLabel' =>  'Browse Photo',
				'showUpload' => false,
				'showCaption' => false,
				'removeClass' => 'btn btn-danger',
				'previewFileType' => 'any',
				'initialPreviewAsData'=>true,
				//'required'=> true,
				'initialPreview' => [
					$model->tax_license,
				],
				'initialPreviewConfig' => [
								[
									'caption'=>!empty($model->tax_license)?basename(explode('-', $model->tax_license, 2)[1]):'',
									'type'=>Yii::$app->AccessMod->is_image($model->tax_license)?"image":"pdf",
									'url' => "/cmp/prospects/file-tax-license-delete",
									'key' => $model->id,
								],
	
							],
				'layoutTemplates' => ['actionDrag'=> '','actionZoom'=> ''],
			],
	]);
	?> 

    <?= $form->field($modelPB, 'remarks')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($modelPB->isNewRecord ? 'Booking' : 'Update Booking', ['class' => $modelPB->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script>
$(document).ready(function(e) 
{
	$("form").submit(function(e) {
		var error = '';
		var regex_decimal =  /^([\d]+)(\.[\d]+)?$/;
		var regex_float =  /^([\d]+)(\.[\d]+)?$/;
		
		$("input[name='ProspectBookingBuyers[buyer_firstname][]']").each(function() 
		{
			if(this.value == '')
			{
				error = 'First Name cannot be blank.';
				$(this).closest('.field-prospectbookingbuyers-buyer_firstname ').removeClass("has-success");
				$(this).closest('.field-prospectbookingbuyers-buyer_firstname ').addClass("has-error");
				$(this).parent().find('.help-block').html(error);
			}
			else
			{
				$(this).closest('.field-prospectbookingbuyers-buyer_firstname ').removeClass("has-error");
				$(this).closest('.field-prospectbookingbuyers-buyer_firstname ').addClass("has-success");
				$(this).parent().find('.help-block').html('');
			}
		});

		$("input[name='ProspectBookingBuyers[buyer_lastname][]']").each(function() 
		{
			if(this.value == '')
			{
				error = 'Last Name cannot be blank.';
				$(this).closest('.field-prospectbookingbuyers-buyer_lastname ').removeClass("has-success");
				$(this).closest('.field-prospectbookingbuyers-buyer_lastname ').addClass("has-error");
				$(this).parent().find('.help-block').html(error);
			}
			else
			{
				$(this).closest('.field-prospectbookingbuyers-buyer_lastname ').removeClass("has-error");
				$(this).closest('.field-prospectbookingbuyers-buyer_lastname ').addClass("has-success");
				$(this).parent().find('.help-block').html('');
			}
		});
		
		if($("#prospectbookings-product_id").val()=='')
		{
			error = 'Product cannot be blank.';
			$(".field-prospectbookings-product_id").removeClass("has-success");
			$(".field-prospectbookings-product_id").addClass("has-error");
			$(".field-prospectbookings-product_id .help-block").html(error);
		}
		else
		{
			$(".field-prospectbookings-product_id").removeClass("has-error");
			$(".field-prospectbookings-product_id").addClass("has-success");
			$(".field-prospectbookings-product_id .help-block").html('');
		}

		if($("#prospectbookings-product_unit").val()=='')
		{
			error = 'Unit Details cannot be blank.';
			$(".field-prospectbookings-product_unit").removeClass("has-success");
			$(".field-prospectbookings-product_unit").addClass("has-error");
			$(".field-prospectbookings-product_unit .help-block").html(error);
		}
		else
		{
			$(".field-prospectbookings-product_unit").removeClass("has-error");
			$(".field-prospectbookings-product_unit").addClass("has-success");
			$(".field-prospectbookings-product_unit .help-block").html('');
		}

		if($("#prospectbookings-product_unit_type").val()=='')
		{
			error = 'Unit Type cannot be blank.';
			$(".field-prospectbookings-product_unit_type").removeClass("has-success");
			$(".field-prospectbookings-product_unit_type").addClass("has-error");
			$(".field-prospectbookings-product_unit_type .help-block").html(error);
		}
		else
		{
			$(".field-prospectbookings-product_unit_type").removeClass("has-error");
			$(".field-prospectbookings-product_unit_type").addClass("has-success");
			$(".field-prospectbookings-product_unit_type .help-block").html('');
		}

		if($("#prospectbookings-building_size_sm").val()=='')
		{
			error = 'Building Size SM cannot be blank.';
			$(".field-prospectbookings-building_size_sm").removeClass("has-success");
			$(".field-prospectbookings-building_size_sm").addClass("has-error");
			$(".field-prospectbookings-building_size_sm .help-block").html(error);
		}
		else
		{
			if(!regex_float.test($("#prospectbookings-building_size_sm").val()))
			{
				error = 'Building Size SM must be a floating number.';
				$(".field-prospectbookings-building_size_sm").removeClass("has-success");
				$(".field-prospectbookings-building_size_sm").addClass("has-error");
				$(".field-prospectbookings-building_size_sm .help-block").html(error);
			}
			else
			{
				$(".field-prospectbookings-building_size_sm").removeClass("has-error");
				$(".field-prospectbookings-building_size_sm").addClass("has-success");
				$(".field-prospectbookings-building_size_sm .help-block").html('');
			}
		}

		if($("#prospectbookings-land_size_sm").val()=='')
		{
			error = 'Land Size SM cannot be blank.';
			$(".field-prospectbookings-land_size_sm").removeClass("has-success");
			$(".field-prospectbookings-land_size_sm").addClass("has-error");
			$(".field-prospectbookings-land_size_sm .help-block").html(error);
		}
		else
		{
			if(!regex_float.test($("#prospectbookings-land_size_sm").val()))
			{
				error = 'Land Size SM must be a floating number.';
				$(".field-prospectbookings-land_size_sm").removeClass("has-success");
				$(".field-prospectbookings-land_size_sm").addClass("has-error");
				$(".field-prospectbookings-land_size_sm .help-block").html(error);
			}
			else
			{
				$(".field-prospectbookings-land_size_sm").removeClass("has-error");
				$(".field-prospectbookings-land_size_sm").addClass("has-success");
				$(".field-prospectbookings-land_size_sm .help-block").html('');
			}
		}

		if($("#prospectbookings-product_unit_price").val()=='')
		{
			error = 'Unit Price cannot be blank.';
			$(".field-prospectbookings-product_unit_price").removeClass("has-success");
			$(".field-prospectbookings-product_unit_price").addClass("has-error");
			$(".field-prospectbookings-product_unit_price .help-block").html(error);
		}
		else
		{
			if(!regex_decimal.test($("#prospectbookings-product_unit_price").val()))
			{
				error = 'Unit Price must be an decimal.';
				$(".field-prospectbookings-product_unit_price").removeClass("has-success");
				$(".field-prospectbookings-product_unit_price").addClass("has-error");
				$(".field-prospectbookings-product_unit_price .help-block").html(error);
			}
			else
			{
				$(".field-prospectbookings-product_unit_price").removeClass("has-error");
				$(".field-prospectbookings-product_unit_price").addClass("has-success");
				$(".field-prospectbookings-product_unit_price .help-block").html('');
			}
		}

		if($("#prospectbookings-payment_method").val()=='')
		{
			error = 'Payment Method EOI cannot be blank.';
			$(".field-prospectbookings-payment_method").removeClass("has-success");
			$(".field-prospectbookings-payment_method").addClass("has-error");
			$(".field-prospectbookings-payment_method .help-block").html(error);
		}
		else
		{
			$(".field-prospectbookings-payment_method").removeClass("has-error");
			$(".field-prospectbookings-payment_method").addClass("has-success");
			$(".field-prospectbookings-payment_method .help-block").html('');
		}

		if($("#prospectbookings-booking_amount").val()=='')
		{
			error = 'Payment Method cannot be blank.';
			$(".field-prospectbookings-booking_amount").removeClass("has-success");
			$(".field-prospectbookings-booking_amount").addClass("has-error");
			$(".field-prospectbookings-booking_amount .help-block").html(error);
		}
		else
		{
			if(!regex_decimal.test($("#prospectbookings-booking_amount").val()))
			{
				error = 'Booking Amount must be an decimal.';
				$(".field-prospectbookings-booking_amount").removeClass("has-success");
				$(".field-prospectbookings-booking_amount").addClass("has-error");
				$(".field-prospectbookings-booking_amount .help-block").html(error);
			}
			else
			{
				$(".field-prospectbookings-booking_amount").removeClass("has-error");
				$(".field-prospectbookings-booking_amount").addClass("has-success");
				$(".field-prospectbookings-booking_amount .help-block").html('');
			}
		}
		
		if($('#prospectbookings-proof_of_payment').fileinput('getFilesCount')==0)
		{
			if(typeof $("#prospectbookings-proof_of_payment").attr("value")=='undefined')
			{
				error = 'Proof Of Payment cannot be blank.';
				$(".field-prospectbookings-proof_of_payment").removeClass("has-success");
				$(".field-prospectbookings-proof_of_payment").addClass("has-error");
				$(".field-prospectbookings-proof_of_payment .help-block").html(error);
			}
			else if($("#prospectbookings-proof_of_payment").attr("value")=='')
			{
				error = 'Proof Of Payment cannot be blank.';
				$(".field-prospectbookings-proof_of_payment").removeClass("has-success");
				$(".field-prospectbookings-proof_of_payment").addClass("has-error");
				$(".field-prospectbookings-proof_of_payment .help-block").html(error);
			}
			else
			{
				$(".field-prospectbookings-proof_of_payment").removeClass("has-error");
				$(".field-prospectbookings-proof_of_payment").addClass("has-success");
				$(".field-prospectbookings-proof_of_payment .help-block").html('');
			}
		}
		else
		{
			$(".field-prospectbookings-proof_of_payment").removeClass("has-error");
			$(".field-prospectbookings-proof_of_payment").addClass("has-success");
			$(".field-prospectbookings-proof_of_payment .help-block").html('');
		}

		if($('#prospectbookings-sp_file').fileinput('getFilesCount')==0)
		{
			if(typeof $("#prospectbookings-sp_file").attr("value")=='undefined')
			{
				error = 'SP File cannot be blank.';
				$(".field-prospectbookings-sp_file").removeClass("has-success");
				$(".field-prospectbookings-sp_file").addClass("has-error");
				$(".field-prospectbookings-sp_file .help-block").html(error);
			}
			else if($("#prospectbookings-sp_file").attr("value")=='')
			{
				error = 'Proof Of Payment cannot be blank.';
				$(".field-prospectbookings-sp_file").removeClass("has-success");
				$(".field-prospectbookings-sp_file").addClass("has-error");
				$(".field-prospectbookings-sp_file .help-block").html(error);
			}
			else
			{
				$(".field-prospectbookings-sp_file").removeClass("has-error");
				$(".field-prospectbookings-sp_file").addClass("has-success");
				$(".field-prospectbookings-sp_file .help-block").html('');
			}
		}
		else
		{
			$(".field-prospectbookings-sp_file").removeClass("has-error");
			$(".field-prospectbookings-sp_file").addClass("has-success");
			$(".field-prospectbookings-sp_file .help-block").html('');
		}

		if($("#prospectbookings-booking_date").val()=='')
		{
			error = 'Booking Date cannot be blank.';
			$(".field-prospectbookings-booking_date").removeClass("has-success");
			$(".field-prospectbookings-booking_date").addClass("has-error");
			$(".field-prospectbookings-booking_date .help-block").html(error);
		}
		else
		{
			$(".field-prospectbookings-booking_date").removeClass("has-error");
			$(".field-prospectbookings-booking_date").addClass("has-success");
			$(".field-prospectbookings-booking_date .help-block").html('');
		}

		if($('#prospects-prospect_identity_document').fileinput('getFilesCount')==0)
		{
			if(typeof $("#prospects-prospect_identity_document").attr("value")=='undefined')
			{
				error = 'Identity Document cannot be blank.';
				$(".field-prospects-prospect_identity_document").removeClass("has-success");
				$(".field-prospects-prospect_identity_document").addClass("has-error");
				$(".field-prospects-prospect_identity_document .help-block").html(error);
			}
			else if($("#prospects-prospect_identity_document").attr("value")=='')
			{
				error = 'Identity Document cannot be blank.';
				$(".field-prospects-prospect_identity_document").removeClass("has-success");
				$(".field-prospects-prospect_identity_document").addClass("has-error");
				$(".field-prospects-prospect_identity_document .help-block").html(error);
			}
			else
			{
				$(".field-prospects-prospect_identity_document").removeClass("has-error");
				$(".field-prospects-prospect_identity_document").addClass("has-success");
				$(".field-prospects-prospect_identity_document .help-block").html('');
			}
		}
		else
		{
			$(".field-prospects-prospect_identity_document").removeClass("has-error");
			$(".field-prospects-prospect_identity_document").addClass("has-success");
			$(".field-prospects-prospect_identity_document .help-block").html('');
		}


		if($('#prospects-tax_license').fileinput('getFilesCount')==0)
		{
			if(typeof $("#prospects-tax_license").attr("value")=='undefined')
			{
				error = 'Tax License cannot be blank.';
				$(".field-prospects-tax_license").removeClass("has-success");
				$(".field-prospects-tax_license").addClass("has-error");
				$(".field-prospects-tax_license .help-block").html(error);
			}
			else if($("#prospects-tax_license").attr("value")=='')
			{
				error = 'Tax License cannot be blank.';
				$(".field-prospects-tax_license").removeClass("has-success");
				$(".field-prospects-tax_license").addClass("has-error");
				$(".field-prospects-tax_license .help-block").html(error);
			}
			else
			{
				$(".field-prospects-tax_license").removeClass("has-error");
				$(".field-prospects-tax_license").addClass("has-success");
				$(".field-prospects-tax_license .help-block").html('');
			}
		}
		else
		{
			$(".field-prospects-tax_license").removeClass("has-error");
			$(".field-prospects-tax_license").addClass("has-success");
			$(".field-prospects-tax_license .help-block").html('');
		}


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

function getBooking(bookingid)
{
	$.ajax({url: "/cmp/prospects/eoi-booking?ajaxView=&id="+<?= $model->id ?>+"&prospect_booking_id="+bookingid, dataType: "html", success: function(result){
		//alert(JSON.stringify(result));
		
		$(".modal-body").html(result);
	}});
}

function getProducts(projectid)
{
	$.ajax({url: "/cmp/prospects/create-booking?id="+<?= $model->id ?>+"&project_id="+projectid, dataType: "json", success: function(result){
		//alert(JSON.stringify(result));
		
		$("#prospectbookings-product_id").empty();
		$("#prospectbookings-product_id").attr("aria-invalid","true");
		$("#prospectbookings-product_id").append('<option value="">Please select</option>');
		if(result.length != 0)
		{
			for(var i=0;i<result.length;i++)
			{
				//alert(result[i]['id'] + ' : ' + result[i]['contact_person']);
				$("#prospectbookings-product_id").append('<option value="'+result[i]['id']+'">'+result[i]['title']+'</option>');
			}
		}
		else
		{
			$("#prospectbookings-product_id").append('<option value=""></option>');
		}
	}});
}

function getUnitTypes(productid)
{
	$.ajax({url: "/cmp/prospects/create-booking?id="+<?= $model->id ?>+"&product_id="+productid, dataType: "json", success: function(result){
		//alert(JSON.stringify(result));
		
		$("#prospectbookings-product_unit_type").empty();
		$("#prospectbookings-product_unit_type").attr("aria-invalid","true");
		$("#prospectbookings-product_unit_type").append('<option value="">Please select</option>');
		if(result.length != 0)
		{
			for(var i=0;i<result.length;i++)
			{
				$("#prospectbookings-product_unit_type").append('<option value="'+result[i]['id']+'">'+result[i]['type_name']+'</option>');
			}
		}
		else
		{
			$("#prospectbookings-product_unit_type").append('<option value=""></option>');
		}
	}});
}

$(document).ready(function(e) {
    $("#prospectbookings-id").change(function(e) {
        getBooking(this.value);
    });

    $("#prospectbookings-project_id").change(function(e) {
        getProducts(this.value);
    });

    $("#prospectbookings-product_id").change(function(e) {
        getUnitTypes(this.value);
    });

	$(document).on("blur change", "#prospectbookings-product_unit_price,#vat_percent",function(){
		var regex_decimal =  /^([\d]+)(\.[\d]{1,2})?$/;

		if(!regex_decimal.test($("#prospectbookings-product_unit_price").val()))
		$("#prospectbookings-product_unit_price").val('');
		
		if($("#prospectbookings-product_unit_price").val()!='' && $("#vat_percent").val())
		{
			var vat = $("#prospectbookings-product_unit_price").val()*$("#vat_percent").val()/100;
			$("#prospectbookings-product_unit_vat_price").val(vat)
		}
	});

	setTimeout(function(){ 
	$("#prospectbookings-product_unit_price-disp").trigger("blur");
	}, 500);
});

function cloneBuyer()
{
	if($(".buyer-remove").length < <?= $_SESSION['settings']['PROSPECT_BUYERS_LIMIT'] ?>)
	{
		var tmp = $(".buyerDetail").eq(0).clone();
		$(".buyer-list").append(tmp);
		$("input[name='ProspectBookingBuyers[buyer_firstname][]']").eq($("input[name='ProspectBookingBuyers[buyer_firstname][]']").length-1).val('');
		$("input[name='ProspectBookingBuyers[buyer_lastname][]']").eq($("input[name='ProspectBookingBuyers[buyer_lastname][]']").length-1).val('');
		$(".buyerno").eq($(".buyerno").length-1).html($(".buyerno").length+'.');
		$(".buyer-remove").eq($(".buyer-remove").length-1).html('<button name="buyer_remove" type="button" class="btn btn-danger" title="Remove" onclick="$(this).closest(\'.buyerDetail\').remove();"><span class="glyphicon glyphicon-remove"></span></button>');
	}
}


</script>
