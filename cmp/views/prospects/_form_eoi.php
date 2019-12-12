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
$unitTypes = Yii::$app->AccessMod->getLookupData('lookup_property_product_types');
$agentProjects = in_array(7,$_SESSION['user']['groups'])?Yii::$app->AccessMod->getAgentProjectID($_SESSION['user']['id']):array();
$prospectInterestedProjects = Yii::$app->ProspectMod->getProspectInterestedProjects($model->id,false);
$interProjects = array_values(array_intersect($agentProjects,$prospectInterestedProjects));
?>

<div class="prospects-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    
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
	echo 	$form->field($modelPB, 'payment_method_eoi')->dropDownList(
			ArrayHelper::map($paymentMethods, 'id', 'name'),['prompt' => 'Please select']
			)->label($modelPB->getAttributeLabel('payment_method_eoi'));
    ?>

    <?= $form->field($modelPB, 'booking_eoi_amount')
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

	<?php
	echo $form->field($modelPB, 'proof_of_payment_eoi')->widget(FileInput::classname(), [
        'model' => $modelPB,
        'attribute' => 'proof_of_payment_eoi',

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
				//'required' => true,
				'initialPreview' => [
					$modelPB->proof_of_payment_eoi,
				],
				'initialPreviewConfig' => [
								[
									'caption'=>!empty($modelPB->proof_of_payment_eoi)?basename(explode('-', $modelPB->proof_of_payment_eoi, 2)[1]):'',
									'type'=>Yii::$app->AccessMod->is_image($modelPB->proof_of_payment_eoi)?"image":"pdf",
									'url' => "/cmp/prospects/file-eoi-delete",
									'key' => $modelPB->id,
								],
	
							],
				'layoutTemplates' => ['actionDrag'=> '','actionZoom'=> ''],
			],
	]);
	?> 

	<?= $form->field($modelPB, 'booking_date_eoi')->widget(\yii\jui\DatePicker::classname(), [
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
									'caption'=>!empty($modelPB->prospect_identity_document)?basename(explode('-', $modelPB->prospect_identity_document, 2)[1]):'',
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
				'showClose' => false,
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
									'caption'=>!empty($modelPB->tax_license)?basename(explode('-', $modelPB->tax_license, 2)[1]):'',
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
        <?= Html::submitButton($modelPB->isNewRecord ? 'Create' : 'Update', ['class' => $modelPB->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script>
$(document).ready(function(e) 
{
	$("form").submit(function(e) {
		var error = '';
		var regex_decimal =  /^([\d]+)(\.[\d]+)?$/;
		
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
		
		/*if($("#prospectbookings-eoi_ref_no").val()=='')
		{
			error = 'EOI Reference Number cannot be blank.';
			$(".field-prospectbookings-eoi_ref_no").removeClass("has-success");
			$(".field-prospectbookings-eoi_ref_no").addClass("has-error");
			$(".field-prospectbookings-eoi_ref_no .help-block").html(error);
		}
		else
		{
			$(".field-prospectbookings-eoi_ref_no").removeClass("has-error");
			$(".field-prospectbookings-eoi_ref_no").addClass("has-success");
			$(".field-prospectbookings-eoi_ref_no .help-block").html('');
		}*/

		if($("#prospectbookings-payment_method_eoi").val()=='')
		{
			error = 'Payment Method EOI cannot be blank.';
			$(".field-prospectbookings-payment_method_eoi").removeClass("has-success");
			$(".field-prospectbookings-payment_method_eoi").addClass("has-error");
			$(".field-prospectbookings-payment_method_eoi .help-block").html(error);
		}
		else
		{
			$(".field-prospectbookings-payment_method_eoi").removeClass("has-error");
			$(".field-prospectbookings-payment_method_eoi").addClass("has-success");
			$(".field-prospectbookings-payment_method_eoi .help-block").html('');
		}

		if($("#prospectbookings-booking_eoi_amount").val()=='')
		{
			error = 'Payment Method EOI cannot be blank.';
			$(".field-prospectbookings-booking_eoi_amount").removeClass("has-success");
			$(".field-prospectbookings-booking_eoi_amount").addClass("has-error");
			$(".field-prospectbookings-booking_eoi_amount .help-block").html(error);
		}
		else
		{
			if(!regex_decimal.test($("#prospectbookings-booking_eoi_amount").val()))
			{
				error = 'Booking EOI Amount must be an decimal.';
				$(".field-prospectbookings-booking_eoi_amount").removeClass("has-success");
				$(".field-prospectbookings-booking_eoi_amount").addClass("has-error");
				$(".field-prospectbookings-booking_eoi_amount .help-block").html(error);
			}
			else
			{
				$(".field-prospectbookings-booking_eoi_amount").removeClass("has-error");
				$(".field-prospectbookings-booking_eoi_amount").addClass("has-success");
				$(".field-prospectbookings-booking_eoi_amount .help-block").html('');
			}
		}
		
		if($('#prospectbookings-proof_of_payment_eoi').fileinput('getFilesCount')==0)
		{
			if(typeof $("#prospectbookings-proof_of_payment_eoi").attr("value")=='undefined')
			{
				error = 'Proof Of Payment EOI cannot be blank.';
				$(".field-prospectbookings-proof_of_payment_eoi").removeClass("has-success");
				$(".field-prospectbookings-proof_of_payment_eoi").addClass("has-error");
				$(".field-prospectbookings-proof_of_payment_eoi .help-block").html(error);
			}
			else if($("#prospectbookings-proof_of_payment_eoi").attr("value")=='')
			{
				error = 'Proof Of Payment EOI cannot be blank.';
				$(".field-prospectbookings-proof_of_payment_eoi").removeClass("has-success");
				$(".field-prospectbookings-proof_of_payment_eoi").addClass("has-error");
				$(".field-prospectbookings-proof_of_payment_eoi .help-block").html(error);
			}
			else
			{
				$(".field-prospectbookings-proof_of_payment_eoi").removeClass("has-error");
				$(".field-prospectbookings-proof_of_payment_eoi").addClass("has-success");
				$(".field-prospectbookings-proof_of_payment_eoi .help-block").html('');
			}
		}
		else
		{
			$(".field-prospectbookings-proof_of_payment_eoi").removeClass("has-error");
			$(".field-prospectbookings-proof_of_payment_eoi").addClass("has-success");
			$(".field-prospectbookings-proof_of_payment_eoi .help-block").html('');
		}

		if($("#prospectbookings-booking_date_eoi").val()=='')
		{
			error = 'Booking Date EOI cannot be blank.';
			$(".field-prospectbookings-booking_date_eoi").removeClass("has-success");
			$(".field-prospectbookings-booking_date_eoi").addClass("has-error");
			$(".field-prospectbookings-booking_date_eoi .help-block").html(error);
		}
		else
		{
			$(".field-prospectbookings-booking_date_eoi").removeClass("has-error");
			$(".field-prospectbookings-booking_date_eoi").addClass("has-success");
			$(".field-prospectbookings-booking_date_eoi .help-block").html('');
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
