<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\UserCommissions */

$this->title = 'Commission : '.$model->userFirstName->firstname.' '.$model->userLastName->lastname;
$this->params['breadcrumbs'][] = 'Commission Management';
$this->params['breadcrumbs'][] = ['label' => 'Account Manager Commission List', 'url' => ['/account-manager-commissions']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-commissions-view">
    <p>
    </p>

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
        <td><?= Yii::$app->AccessMod->getPriceFormat($estimateCommission['commission_amount']-($userEligibleCommissionAmount+$totalCommissionPaid)) ?></td>
    </tr>
    <tr>
        <th>Eligible Commission Amount</th>
        <td><?= Yii::$app->AccessMod->getPriceFormat($userEligibleCommissionAmount) ?></td>
    </tr>
    <tr>
        <th>Paid Commission Amount</th>
        <td><?= Yii::$app->AccessMod->getPriceFormat($totalCommissionPaid) ?></td>
    </tr>
    </tbody>
    </table>


    <div class="row bg-dark-grey">
        <div class="col-xs-12"><h4>Commission Transaction</h4></div>
    </div>
    <table id="w1" class="table table-striped table-bordered detail-view">
    <?php
    if(count($logUserCommissions)==0)
    echo '<tbody><tr><td>No results found.</td></tr></tbody>';
    else
    {
    ?>
    <thead>
        <tr>
        <th scope="col">#</th>
        <th scope="col">Commission Amount</th>
        <th scope="col">Remarks</th>
        <th scope="col">Status</th>
        <th scope="col">Created By</th>
        <th scope="col">Created At</th>
        <th scope="col">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i=1;
		
        foreach($logUserCommissions as $key=>$log)
        {
			?>
			<tr>
                <td><?= $i ?></td>
                <td><?= Yii::$app->AccessMod->getPriceFormat($log['commission_amount']) ?></td>
                <td><?= $log['remarks'] ?></td>
                <td>
					<?php
                    switch($log['status'])
                    {
                        case 1:
							echo 'Estimated';
                        break;
                        case 2:
                            echo 'Eligible';
                        break;
                        case 3:
                            echo 'Cancelled';
                        break;
                        case 4:
                            echo 'Claimed';
                        break;
                        default:
                            echo '';
                        break;
                    }
                    ?>
                </td>
                <td><?= $log['createdbyName'] ?></td>
                <td><?= Yii::$app->formatter->asDatetime($log['createdat'], 'long') ?></td>
                <td>
					<?php
                    switch($log['status'])
                    {
						case 2:
							//echo Html::a('<button class="btn btn-sm btn-success">Pay</button>&nbsp&nbsp', ['pay-commission','ajaxView'=>'','id'=>$model->id,'user_eligible_commission_id'=>$log['user_eligible_commission_id'],'prospect_booking_id'=>$log['prospect_booking_id']], ['class'=>'pay-commission modal-button-01']);
							//echo Html::a('<button class="btn btn-sm btn-danger">Cancel</button>&nbsp&nbsp', ['pay-commission','ajaxView'=>'','id'=>$model->id,'user_eligible_commission_id'=>$log['user_eligible_commission_id'],'prospect_booking_id'=>$log['prospect_booking_id']], ['class'=>'pay-commission modal-button-01']);
							echo Html::a('<button class="btn btn-sm btn-success">Pay</button>&nbsp&nbsp', ['pay-eligible-commission','id'=>$model->id,'prospect_booking_id'=>$log['prospect_booking_id'],'user_eligible_commission_id'=>$log['user_eligible_commission_id']]);
							echo Html::a('<button class="btn btn-sm btn-danger">Cancel</button>&nbsp&nbsp', ['cancel-eligible-commission','id'=>$model->id,'prospect_booking_id'=>$log['prospect_booking_id'],'user_eligible_commission_id'=>$log['user_eligible_commission_id']]);
                        break;
                        default:
                            echo '<span class="glyphicon glyphicon-minus"></span>';
                        break;
                    }
                    ?>
                </td>
			</tr>
			<?php
            $i++;
        }
        ?>
    </tbody>
    <?php
    }
    ?>
    </table>

</div>
<?php
Modal::begin([
	'header' => '<h4 id="modal-header-01"></h4>',
	'id' => 'modal-id-01',
	'size' => 'modal-lg',
	'clientOptions' => ['backdrop' => false, 'keyboard' => false],
	]);
	echo '<div id="modal-content-01"></div>';
Modal::end();
?>
<script>
$(function(){
	$('.view-commission-transaction').click(function (){
		$('#modal-id-01').modal('show');
		$('#modal-id-01').find('#modal-content-01').load($(this).attr('value'));
		$('#modal-id-01').find('#modal-header-01').html("<?= 'Commission Transaction: '.$model->userFirstName->firstname.' '.$model->userLastName->lastname ?>");
	});
	$('.eligible-commission').click(function (){
		$('#modal-id-01').modal('show');
		$('#modal-id-01').find('#modal-content-01').load($(this).attr('value'));
		$('#modal-id-01').find('#modal-header-01').html("<?= 'Eligible Commission: '.$model->userFirstName->firstname.' '.$model->userLastName->lastname ?>");
	});
	$('.pay-commission').click(function (){
		$('#modal-id-01').modal('show');
		$('#modal-id-01').find('#modal-content-01').load($(this).attr('value'));
		$('#modal-id-01').find('#modal-header-01').html("<?= 'Pay Commission: '.$model->userFirstName->firstname.' '.$model->userLastName->lastname ?>");
	});
});
</script>

</div>
