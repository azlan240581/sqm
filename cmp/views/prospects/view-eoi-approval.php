<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ProspectBookings */

$this->title = 'Pending EOI Approval';
$this->params['breadcrumbs'][] = 'Prospects Management';
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['pending-eoi-approval']];
$this->params['breadcrumbs'][] = 'Details';

$modelPB->remarks = '';
?>

<div class="prospect-bookings-view">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($modelPB, 'id')->hiddenInput()->label(false) ?>
    <?= $form->field($modelPB, 'prospect_id')->hiddenInput()->label(false) ?>
    <?= $form->field($modelPB, 'remarks')->textarea(['rows' => 6]) ?>

    <div class="form-group">
    	<input type="hidden" name="ProspectBookings[id]" value="<?= $model->id ?>" />
    	<input type="hidden" name="ProspectBookings[prospect_booking_id]" value="<?= $modelPB->id ?>" />
    	<input type="hidden" id="action" name="ProspectBookings[action]" value="" />
    	<input name="approve" value="Approve" type="submit" class="btn btn-primary" onclick="$('#action').val(1);" data-confirm="Are you sure you want to approve this process?" />
    	<input name="reject" value="Reject" type="submit" class="btn btn-danger" onclick="$('#action').val(0);" data-confirm="Are you sure you want to reject this process?" />
    </div>

    <?php ActiveForm::end(); ?>

    <div class="panel panel-default">
    
        <div class="panel-heading">
            <div class="row">
                <div class="col-sm-12"><h3 class="panel-title">Buyer Information</h3></div>
            </div>
        </div>
        <div class="panel-body buyer-list">
    
            <div class="buyerDetail">
            	<?php
				$i=1;
				foreach($modelPBB as $modelPBBChild)
				{
				?>
                <div class="row">
                    <div class="col-sm-1 buyerno">
                    <?= $i ?>.
                    </div>

                    <div class="col-sm-11">
                    <?= $modelPBBChild->buyer_firstname . ' ' . $modelPBBChild->buyer_lastname ?>
                    </div>
                </div>
                <?php
					$i++;
				}
				?>
            </div>

        </div>
    </div>    

    <?= DetailView::widget([
        'model' => $modelPB,
        'attributes' => [
            //'id',
			'eoi_ref_no',
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
			'booking_date_eoi:date',
			/*[
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
							$tmp = '<div class="row">';
							$tmp .= '<div class="col-md-3"><a href="'.$data->proof_of_payment.'" data-fancybox=1><img src="'.$data->proof_of_payment.'" width="200" /></a></div>';
							$tmp .= '</div>';
							return $tmp;				
														
							}, $modelPB),
            ],*/
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