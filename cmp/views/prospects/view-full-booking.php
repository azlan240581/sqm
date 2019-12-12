<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\ProspectBookings */

$this->title = $modelPB->id;
$this->params['breadcrumbs'][] = ['label' => 'Prospect Bookings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="prospect-bookings-view">

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
				'visible' => !empty($modelPB->building_size_sm)?true:false,
				'format' => 'raw',
				'value' => number_format($modelPB->building_size_sm).' m<sup>2</sup>',
			],
			[
				'label' => $modelPB->getAttributeLabel('land_size_sm'),
				'visible' => !empty($modelPB->land_size_sm)?true:false,
				'format' => 'raw',
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
				'visible' => !empty($modelPB->proof_of_payment_eoi)?true:false,
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
				'label' => $modelPB->getAttributeLabel('booking_date_eoi'),
				'format' => 'date',
				'visible' => !empty($modelPB->booking_date_eoi)?true:false,
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
			[
				'label' => $modelPB->getAttributeLabel('booking_date'),
				'format' => 'date',
				'visible' => !empty($modelPB->booking_date)?true:false,
				'value' => $modelPB->booking_date,
			],
			[
            	'attribute' => 'sp_file',
				'visible' => !empty($modelPB->sp_file)?true:false,
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
            	'attribute' => 'ppjb_file',
				'visible' => !empty($modelPB->ppjb_file)?true:false,
            	'format' => 'raw',
				'value' => call_user_func(function ($data) {
							if(Yii::$app->AccessMod->is_image($data->ppjb_file))
							{
								$tmp = '<div class="row">';
								$tmp .= '<div class="col-md-3"><a href="'.$data->ppjb_file.'" data-fancybox=1><img src="'.$data->ppjb_file.'" width="200" /></a></div>';
								$tmp .= '</div>';
							}
							else
							{
								$tmp = '<div class="row">';
								$tmp .= '<div class="col-md-3"><a href="'.$data->ppjb_file.'" target="_blank"><button class="btn btn-primary">'.$data->getAttributeLabel('ppjb_file').'</button></a></div>';
								$tmp .= '</div>';
							}
							return $tmp;				
														
							}, $modelPB),
            ],
			[
            	'attribute' => 'prospect_identity_document',
				'visible' => !empty($model->prospect_identity_document)?true:false,
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
				'visible' => !empty($model->tax_license)?true:false,
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
			[
				'label' => $modelPB->getAttributeLabel('cancel_ref_no'),
				'visible' => !empty($modelPB->cancel_ref_no)?true:false,
				'value' => $modelPB->cancel_ref_no,
			],
			[
            	'attribute' => 'cancellation_attachment',
				'visible' => !empty($model->cancellation_attachment)?true:false,
            	'format' => 'raw',
				'value' => call_user_func(function ($data) {
							if(empty($data->cancellation_attachment))
							return $data->cancellation_attachment;
					
							if(Yii::$app->AccessMod->is_image($data->cancellation_attachment))
							{
								$tmp = '<div class="row">';
								$tmp .= '<div class="col-md-3"><a href="'.$data->cancellation_attachment.'" data-fancybox=1><img src="'.$data->cancellation_attachment.'" width="200" /></a></div>';
								$tmp .= '</div>';
							}
							else
							{
								$tmp = '<div class="row">';
								$tmp .= '<div class="col-md-3"><a href="'.$data->cancellation_attachment.'" target="_blank"><button class="btn btn-primary">'.$data->getAttributeLabel('cancellation_attachment').'</button></a></div>';
								$tmp .= '</div>';
							}
							return $tmp;				
														
							}, $modelPB),
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

</div>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.6/dist/jquery.fancybox.min.css" />
<script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.6/dist/jquery.fancybox.min.js"></script>