<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\number\NumberControl;

/* @var $this yii\web\View */
/* @var $model app\models\UserCommissions */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-commissions-form">

    <?php $form = ActiveForm::begin(); ?>

	<div class="row bg-dark-grey">
    	<div class="col-xs-12"><h4>Commission Information :</h4></div>
    </div>
    <table id="w0" class="table table-striped table-bordered detail-view">
    <tbody>
    <tr>
        <th>Developer</th>
        <td><?= $modelProspectBookings->developer->company_name ?></td>
    </tr>
    <tr>
        <th>Project</th>
        <td><?= $modelProspectBookings->project->project_name ?></td>
    </tr>
    <tr>
        <th>Product</th>
        <td><?= $modelProspectBookings->projectProducts->product_name ?></td>
    </tr>
    <tr>
        <th>Unit</th>
        <td><?= $modelProspectBookings->product_unit ?></td>
    </tr>
    <tr>
        <th>Prospect</th>
        <td><?= $modelProspectBookings->prospect->prospect_name ?></td>
    </tr>
    <tr>
        <th>Estimated Commission Amount</th>
        <td><?= Yii::$app->AccessMod->getPriceFormat($logUserCommission['commission_amount']) ?></td>
    </tr>
    <tr>
        <th>Eligible Commission Amount</th>
        <td><?= Yii::$app->AccessMod->getPriceFormat($totalEligibleCommissionAmount) ?></td>
    </tr>
    <tr>
        <th>Commission Amount Paid</th>
        <td><?= Yii::$app->AccessMod->getPriceFormat($totalCommissionPaid) ?></td>
    </tr>
    <tr>
        <th>Remaining Commission Amount</th>
        <td><?= Yii::$app->AccessMod->getPriceFormat($logUserCommission['commission_amount']-$totalEligibleCommissionAmount-$totalCommissionPaid) ?></td>
    </tr>
    </tbody>
    </table>

    <?php //echo $form->field($modelLogUserCommission, 'commission_amount')->textInput(['type' => 'number', 'step'=>0.01])->label('Eligible Commisison Amount') ?>

    <?= $form->field($modelLogUserCommission, 'commission_amount', ['inputOptions' => ['class' => 'form-control']])
		->textInput(['maxlength' => true])
		->widget(NumberControl::classname(), [
			'maskedInputOptions' => [
				'prefix' => $_SESSION['settings']['CURRENCY_SYMBOL'].' ',
				'suffix' => '',
				'allowMinus' => false,
				'rightAlign' => false,
			],
			'options' => ['type' => 'hidden'],
		])->label('Eligible Commisison Amount');
	?>

    <?= $form->field($modelLogUserCommission, 'remarks')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

<script>
$(document).ready(function(e) {
	$("form").submit(function(e) {
		var error = '';

		if($("#logusercommission-commission_amount").val()=='')
		{
			error = 1;
			$(".field-logusercommission-commission_amount").addClass("has-error");
			$(".field-logusercommission-commission_amount .help-block").html('Eligibible commission amount cannot be blank.');
		}
		else
		{
			if($("#logusercommission-commission_amount").val()<0 || $("#logusercommission-commission_amount").val()==0)
			{
				error = 1;
				$(".field-logusercommission-commission_amount").addClass("has-error");
				$(".field-logusercommission-commission_amount .help-block").html('Eligibible commission amount must be greater than 0.');
			}
			else if($("#logusercommission-commission_amount").val()><?= $logUserCommission['commission_amount']-$totalEligibleCommissionAmount-$totalCommissionPaid ?>)
			{
				error = 1;
				$(".field-logusercommission-commission_amount").addClass("has-error");
				$(".field-logusercommission-commission_amount .help-block").html('Eligibible commission amount cannot greater than Remaining Commission Amount <?= number_format($logUserCommission['commission_amount']-$totalCommissionPaid,'2','.',',') ?>.');
			}
		}
		
		if(error.length != 0)
		e.preventDefault();
	});
});
</script>

</div>
