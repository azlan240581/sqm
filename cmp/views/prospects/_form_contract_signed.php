<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\file\FileInput;
use yii\widgets\DetailView;


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
?>

<div class="prospects-form">

    <?= DetailView::widget([
        'model' => $modelPB,
        'attributes' => [
            //'id',
			'booking_ref_no',
			[
				'label' => $modelPB->getAttributeLabel('prospect_id'),
				'value' => $modelPB->prospect['prospect_name'],
			],
			[
				'label' => $modelPB->getAttributeLabel('dedicated_agent_id'),
				'value' => $modelPB->dedicatedAgent['name'],
			],
			[
				'label' => $modelPB->getAttributeLabel('agent_id'),
				'value' => $modelPB->agent['name'],
			],
			[
				'label' => $modelPB->getAttributeLabel('member_id'),
				'value' => $modelPB->member['name'],
			],
			[
				'label' => $modelPB->getAttributeLabel('referrer_member_id'),
				'value' => $modelPB->referrerMember['name'],
			],
			[
				'label' => $modelPB->getAttributeLabel('developer_id'),
				'value' => $modelPB->developer['company_name'],
			],
			[
				'label' => $modelPB->getAttributeLabel('project_id'),
				'value' => $modelPB->project['project_name'],
			],
			[
				'label' => $modelPB->getAttributeLabel('product_id'),
				'value' => $modelPB->projectProducts['product_name'],
			],
            'product_unit',
			[
				'label' => $modelPB->getAttributeLabel('product_unit_type'),
				'value' => $modelPB->projectProductUnitTypes['type_name'],
			],
			[
				'label' => $modelPB->getAttributeLabel('building_size_sm'),
				'format' => 'raw',
				'value' => number_format($modelPB->building_size_sm).' m<sup>2</sup>',
			],
			[
				'label' => $modelPB->getAttributeLabel('land_size_sm'),
				'format' => 'raw',
				'value' => number_format($modelPB->land_size_sm).' m<sup>2</sup>',
			],
			[
				'label' => $modelPB->getAttributeLabel('product_unit_price'),
				'value' => Yii::$app->AccessMod->getPriceFormat($modelPB->product_unit_price),
			],
			[
				'label' => $modelPB->getAttributeLabel('product_unit_vat_price'),
				'value' => Yii::$app->AccessMod->getPriceFormat($modelPB->product_unit_vat_price),
			],
			'eoi_ref_no',
			[
				'label' => $modelPB->getAttributeLabel('payment_method_eoi'),
				'value' => $modelPB->lookupPaymentMethodEoi['name'],
			],
			[
				'label' => $modelPB->getAttributeLabel('booking_eoi_amount'),
				'value' => Yii::$app->AccessMod->getPriceFormat($modelPB->booking_eoi_amount),
			],
			[
            	'attribute' => 'proof_of_payment_eoi',
            	'format' => 'raw',
				'value' => call_user_func(function ($data) {
							if(Yii::$app->AccessMod->is_image($data->proof_of_payment_eoi))
							{
								$tmp = '<div class="row">';
								$tmp .= '<div class="col-md-3"><a href="'.$data->proof_of_payment_eoi.'" data-fancybox=1><img src="'.$data->proof_of_payment_eoi.'" width="200" /></a></div>';
								$tmp .= '</div>';
							}
							else
							{
								$tmp = '<div class="row">';
								$tmp .= '<div class="col-md-3"><a href="'.$data->proof_of_payment_eoi.'" target="_blank"><button class="btn btn-primary">'.$data->getAttributeLabel('proof_of_payment_eoi').'</button></a></div>';
								$tmp .= '</div>';
							}
							return $tmp;				
														
							}, $modelPB),
            ],
			[
				'label' => $modelPB->getAttributeLabel('payment_method'),
				'value' => $modelPB->lookupPaymentMethod['name'],
			],
			[
				'label' => $modelPB->getAttributeLabel('express_downpayment'),
				'value' => $modelPB->status==1? 'Yes':'No',
			],
			[
				'label' => $modelPB->getAttributeLabel('booking_amount'),
				'value' => Yii::$app->AccessMod->getPriceFormat($modelPB->booking_amount),
			],
			[
            	'attribute' => 'proof_of_payment',
            	'format' => 'raw',
				'value' => call_user_func(function ($data) {
							if(Yii::$app->AccessMod->is_image($data->proof_of_payment))
							{
								$tmp = '<div class="row">';
								$tmp .= '<div class="col-md-3"><a href="'.$data->proof_of_payment.'" data-fancybox=1><img src="'.$data->proof_of_payment.'" width="200" /></a></div>';
								$tmp .= '</div>';
							}
							else
							{
								$tmp = '<div class="row">';
								$tmp .= '<div class="col-md-3"><a href="'.$data->proof_of_payment.'" target="_blank"><button class="btn btn-primary">'.$data->getAttributeLabel('proof_of_payment').'</button></a></div>';
								$tmp .= '</div>';
							}
							return $tmp;				
														
							}, $modelPB),
            ],
            'booking_date:date',
			[
            	'attribute' => 'sp_file',
            	'format' => 'raw',
				'value' => call_user_func(function ($data) {
							if(Yii::$app->AccessMod->is_image($data->sp_file))
							{
								$tmp = '<div class="row">';
								$tmp .= '<div class="col-md-3"><a href="'.$data->sp_file.'" data-fancybox=1><img src="'.$data->sp_file.'" width="200" /></a></div>';
								$tmp .= '</div>';
							}
							else
							{
								$tmp = '<div class="row">';
								$tmp .= '<div class="col-md-3"><a href="'.$data->sp_file.'" target="_blank"><button class="btn btn-primary">'.$data->getAttributeLabel('sp_file').'</button></a></div>';
								$tmp .= '</div>';
							}
							return $tmp;				
														
							}, $modelPB),
            ],
			[
            	'attribute' => 'prospect_identity_document',
            	'format' => 'raw',
				'value' => call_user_func(function ($data) {
							if(Yii::$app->AccessMod->is_image($data->prospect_identity_document))
							{
								$tmp = '<div class="row">';
								$tmp .= '<div class="col-md-3"><a href="'.$data->prospect_identity_document.'" data-fancybox=1><img src="'.$data->prospect_identity_document.'" width="200" /></a></div>';
								$tmp .= '</div>';
							}
							else
							{
								$tmp = '<div class="row">';
								$tmp .= '<div class="col-md-3"><a href="'.$data->prospect_identity_document.'" target="_blank"><button class="btn btn-primary">'.$data->getAttributeLabel('prospect_identity_document').'</button></a></div>';
								$tmp .= '</div>';
							}
							return $tmp;				
														
							}, $model),
            ],
			[
            	'attribute' => 'tax_license',
            	'format' => 'raw',
				'value' => call_user_func(function ($data) {
							if(Yii::$app->AccessMod->is_image($data->tax_license))
							{
								$tmp = '<div class="row">';
								$tmp .= '<div class="col-md-3"><a href="'.$data->tax_license.'" data-fancybox=1><img src="'.$data->tax_license.'" width="200" /></a></div>';
								$tmp .= '</div>';
							}
							else
							{
								$tmp = '<div class="row">';
								$tmp .= '<div class="col-md-3"><a href="'.$data->tax_license.'" target="_blank"><button class="btn btn-primary">'.$data->getAttributeLabel('tax_license').'</button></a></div>';
								$tmp .= '</div>';
							}
							return $tmp;				
														
							}, $model),
            ],
            'remarks:ntext',
			[
				'label' => $modelPB->getAttributeLabel('status'),
				'value' => $modelPB->lookupBookingStatus['name'],
			],
			[
				'label'=>$modelPB->getAttributeLabel('createdby'),
				'value' => $modelPB->createdbyusername['name'],
			],
            'createdat:datetime',
			/*[
				'label'=>$modelPB->getAttributeLabel('updatedby'),
				'value' => $modelPB->updatedbyusername['name'],
			],
            'updatedat:datetime',
			[
				'label'=>$modelPB->getAttributeLabel('deletedby'),
				'value' => $modelPB->deletedbyusername['name'],
			],
            'deletedat:datetime',*/
        ],
    ]) ?>

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    
	<?php
	echo $form->field($modelPB, 'ppjb_file')->widget(FileInput::classname(), [
        'model' => $modelPB,
        'attribute' => 'ppjb_file',

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
					$modelPB->ppjb_file,
				],
				'initialPreviewConfig' => [
								[
									'caption'=>!empty($modelPB->ppjb_file)?basename(explode('-', $modelPB->ppjb_file, 2)[1]):'',
									'type'=>Yii::$app->AccessMod->is_image($modelPB->ppjb_file)?"image":"pdf",
									'url' => "/cmp/prospects/file-ppjb-delete",
									'key' => $modelPB->id,
								],
	
							],
				'layoutTemplates' => ['actionDrag'=> '','actionZoom'=> ''],
			],
	]);
	?> 

    <?= $form->field($modelPB, 'remarks')->textarea(['rows' => 6]) ?>
    
    <div class="form-group">
        <?= Html::submitButton('Process', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script>
$(document).ready(function(e) 
{
	$("form").submit(function(e) {
		var error = '';
		
		if($('#prospectbookings-ppjb_file').fileinput('getFilesCount')==0)
		{
			if(typeof $("#prospectbookings-ppjb_file").attr("value")=='undefined')
			{
				error = 'Proof Of Payment cannot be blank.';
				$(".field-prospectbookings-ppjb_file").removeClass("has-success");
				$(".field-prospectbookings-ppjb_file").addClass("has-error");
				$(".field-prospectbookings-ppjb_file .help-block").html(error);
			}
			else if($("#prospectbookings-ppjb_file").attr("value")=='')
			{
				error = 'Proof Of Payment cannot be blank.';
				$(".field-prospectbookings-ppjb_file").removeClass("has-success");
				$(".field-prospectbookings-ppjb_file").addClass("has-error");
				$(".field-prospectbookings-ppjb_file .help-block").html(error);
			}
			else
			{
				$(".field-prospectbookings-ppjb_file").removeClass("has-error");
				$(".field-prospectbookings-ppjb_file").addClass("has-success");
				$(".field-prospectbookings-ppjb_file .help-block").html('');
			}
		}
		else
		{
			$(".field-prospectbookings-ppjb_file").removeClass("has-error");
			$(".field-prospectbookings-ppjb_file").addClass("has-success");
			$(".field-prospectbookings-ppjb_file .help-block").html('');
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
</script>
