<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ProspectBookings */

$this->title = $modelPB->id;
$this->params['breadcrumbs'][] = ['label' => 'Prospect Bookings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$modelPB->remarks = '';
?>
<div class="prospect-bookings-view">

    <?= DetailView::widget([
        'model' => $modelPB,
        'attributes' => [
            //'id',
			[
				'label' => $modelPB->getAttributeLabel('cancel_ref_no'),
				'visible' => !empty($modelPB->cancel_ref_no)?true:false,
				'value' => $modelPB->cancel_ref_no,
			],
			[
            	'attribute' => 'cancellation_attachment',
            	'format' => 'raw',
				'value' => call_user_func(function ($data) {
							if(empty($data->cancellation_attachment))
							return $data->cancellation_attachment;
					
							$tmp = '<div class="row">';
							$tmp .= '<div class="col-md-3"><a href="'.$data->cancellation_attachment.'" data-fancybox=1><img src="'.$data->cancellation_attachment.'" width="200" /></a></div>';
							$tmp .= '</div>';
							return $tmp;				
														
							}, $modelPB),
            ],
        ],
    ]) ?>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($modelPB, 'remarks')->textarea(['rows' => 6]) ?>

    <div class="form-group">
    	<input type="hidden" name="ProspectBookings[id]" value="<?= $model->id ?>" />
    	<input type="hidden" name="ProspectBookings[prospect_booking_id]" value="<?= $modelPB->id ?>" />
    	<input type="hidden" id="action" name="ProspectBookings[action]" value="" />
    	<input name="approve" value="Approve" type="submit" class="btn btn-primary" onclick="$('#action').val(1);" data-confirm="Are you sure you want to approve this process?" />
    	<input name="reject" value="Reject" type="submit" class="btn btn-danger" onclick="$('#action').val(0);" data-confirm="Are you sure you want to reject this process?" />
    </div>

    <?php ActiveForm::end(); ?>

    <?= DetailView::widget([
        'model' => $modelPB,
        'attributes' => [
            //'id',
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
				'visible' => !empty($modelPB->product_id)?true:false,
				'value' => $modelPB->projectProducts['product_name'],
			],
			[
				'label' => $modelPB->getAttributeLabel('product_unit'),
				'visible' => !empty($modelPB->product_unit)?true:false,
				'value' => $modelPB->product_unit,
			],
			[
				'label' => $modelPB->getAttributeLabel('product_unit_type'),
				'visible' => !empty($modelPB->product_unit_type)?true:false,
				'value' => $modelPB->projectProductUnitTypes['type_name'],
			],
			[
				'label' => $modelPB->getAttributeLabel('building_size_sm'),
				'format' => 'raw',
				'visible' => !empty($modelPB->building_size_sm)?true:false,
				'value' => number_format($modelPB->building_size_sm).' m<sup>2</sup>',
			],
			[
				'label' => $modelPB->getAttributeLabel('land_size_sm'),
				'format' => 'raw',
				'visible' => !empty($modelPB->land_size_sm)?true:false,
				'value' => number_format($modelPB->land_size_sm).' m<sup>2</sup>',
			],
			[
				'label' => $modelPB->getAttributeLabel('product_unit_price'),
				'visible' => !empty($modelPB->product_unit_price)?true:false,
				'value' => Yii::$app->AccessMod->getPriceFormat($modelPB->product_unit_price),
			],
			[
				'label' => $modelPB->getAttributeLabel('product_unit_vat_price'),
				'visible' => !empty($modelPB->product_unit_vat_price)?true:false,
				'value' => Yii::$app->AccessMod->getPriceFormat($modelPB->product_unit_vat_price),
			],
			[
				'label' => $modelPB->getAttributeLabel('eoi_ref_no'),
				'visible' => !empty($modelPB->eoi_ref_no)?true:false,
				'value' => $modelPB->eoi_ref_no,
			],
			[
				'label' => $modelPB->getAttributeLabel('payment_method_eoi'),
				'visible' => !empty($modelPB->payment_method_eoi)?true:false,
				'value' => $modelPB->lookupPaymentMethodEoi['name'],
			],
			[
				'label' => $modelPB->getAttributeLabel('booking_eoi_amount'),
				'visible' => !empty($modelPB->booking_eoi_amount)?true:false,
				'value' => Yii::$app->AccessMod->getPriceFormat($modelPB->booking_eoi_amount),
			],
			[
            	'attribute' => 'proof_of_payment_eoi',
            	'format' => 'raw',
				'visible' => !empty($modelPB->proof_of_payment_eoi)?true:false,
				'value' => call_user_func(function ($data) {
							$tmp = '<div class="row">';
							$tmp .= '<div class="col-md-3"><a href="'.$data->proof_of_payment_eoi.'" data-fancybox=1><img src="'.$data->proof_of_payment_eoi.'" width="200" /></a></div>';
							$tmp .= '</div>';
							return $tmp;				
														
							}, $modelPB),
            ],
			[
				'label' => $modelPB->getAttributeLabel('booking_date_eoi'),
				'visible' => !empty($modelPB->booking_date_eoi)?true:false,
				'format' => 'date',
				'value' => $modelPB->booking_date_eoi,
			],
			[
				'label' => $modelPB->getAttributeLabel('booking_ref_no'),
				'visible' => !empty($modelPB->booking_ref_no)?true:false,
				'value' => $modelPB->booking_ref_no,
			],
			[
				'label' => $modelPB->getAttributeLabel('payment_method'),
				'visible' => !empty($modelPB->payment_method)?true:false,
				'value' => $modelPB->lookupPaymentMethod['name'],
			],
			[
				'label' => $modelPB->getAttributeLabel('express_downpayment'),
				'visible' => !empty($modelPB->express_downpayment)?true:false,
				'value' => $modelPB->status==1? 'Yes':'No',
			],
			[
				'label' => $modelPB->getAttributeLabel('booking_amount'),
				'visible' => !empty($modelPB->booking_amount)?true:false,
				'value' => Yii::$app->AccessMod->getPriceFormat($modelPB->booking_amount),
			],
			[
            	'attribute' => 'proof_of_payment',
				'visible' => !empty($modelPB->proof_of_payment)?true:false,
            	'format' => 'raw',
				'value' => call_user_func(function ($data) {
							$tmp = '<div class="row">';
							$tmp .= '<div class="col-md-3"><a href="'.$data->proof_of_payment.'" data-fancybox=1><img src="'.$data->proof_of_payment.'" width="200" /></a></div>';
							$tmp .= '</div>';
							return $tmp;				
														
							}, $modelPB),
            ],
			[
				'label' => $modelPB->getAttributeLabel('booking_date'),
				'visible' => !empty($modelPB->booking_date)?true:false,
				'format' => 'date',
				'value' => $modelPB->booking_date,
			],
			[
            	'attribute' => 'sp_file',
				'visible' => !empty($modelPB->sp_file)?true:false,
            	'format' => 'raw',
				'value' => call_user_func(function ($data) {
							$tmp = '<div class="row">';
							$tmp .= '<div class="col-md-3"><a href="'.$data->sp_file.'" data-fancybox=1><img src="'.$data->sp_file.'" width="200" /></a></div>';
							$tmp .= '</div>';
							return $tmp;				
														
							}, $modelPB),
            ],
			[
            	'attribute' => 'ppjb_file',
				'visible' => !empty($modelPB->ppjb_file)?true:false,
            	'format' => 'raw',
				'value' => call_user_func(function ($data) {
							$tmp = '<div class="row">';
							$tmp .= '<div class="col-md-3"><a href="'.$data->ppjb_file.'" data-fancybox=1><img src="'.$data->ppjb_file.'" width="200" /></a></div>';
							$tmp .= '</div>';
							return $tmp;				
														
							}, $modelPB),
            ],
			[
            	'attribute' => 'prospect_identity_document',
				'visible' => !empty($model->prospect_identity_document)?true:false,
            	'format' => 'raw',
				'value' => call_user_func(function ($data) {
							$tmp = '<div class="row">';
							$tmp .= '<div class="col-md-3"><a href="'.$data->prospect_identity_document.'" data-fancybox=1><img src="'.$data->prospect_identity_document.'" width="200" /></a></div>';
							$tmp .= '</div>';
							return $tmp;				
														
							}, $model),
            ],
			[
            	'attribute' => 'tax_license',
				'visible' => !empty($model->tax_license)?true:false,
            	'format' => 'raw',
				'value' => call_user_func(function ($data) {
							$tmp = '<div class="row">';
							$tmp .= '<div class="col-md-3"><a href="'.$data->tax_license.'" data-fancybox=1><img src="'.$data->tax_license.'" width="200" /></a></div>';
							$tmp .= '</div>';
							return $tmp;				
														
							}, $model),
            ],
            'remarks:ntext',
			/*[
				'label' => $modelPB->getAttributeLabel('status'),
				'value' => $modelPB->lookupBookingStatus['name'],
			],*/
			[
				'label'=>$modelPB->getAttributeLabel('createdby'),
				'value' => $modelPB->createdbyusername['name'],
			],
            'createdat:datetime',
			/*[
				'label'=>$modelPB->getAttributeLabel('updatedby'),
				'value' => $modelPB->updatedbyusername['name'],
			],
            'updatedat:datetime',*/
			/*[
				'label'=>$modelPB->getAttributeLabel('deletedby'),
				'value' => $modelPB->deletedbyusername['name'],
			],
            'deletedat:datetime',*/
        ],
    ]) ?>

</div>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.6/dist/jquery.fancybox.min.css" />
<script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.6/dist/jquery.fancybox.min.js"></script>


<script>
$(document).ready(function(e) 
{
	$("form").submit(function(e) {
		var error = '';

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