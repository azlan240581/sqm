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
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
		
			[
				'label'=>'First Name',
				'value'=>$model->userFirstName->firstname,
			],
			[
				'label'=>'Last Name',
				'value'=>$model->userLastName->lastname,
			],
			[
				'label'=>'Email',
				'value'=>$model->userEmail->email,
			],
			[
				'label'=>$model->getAttributeLabel('total_commission_amount'),
				'value'=>Yii::$app->AccessMod->getPriceFormat($model->total_commission_amount),
			],
			[
				'label'=>'Eligible Commission Amount',
				'value'=>Yii::$app->AccessMod->getPriceFormat($userEligibleCommissionAmount),
			],
			[
				'label'=>'Total Commission Claimed',
				'value'=>Yii::$app->AccessMod->getPriceFormat($totalUserEligibleCommissionPaid),
			],
			[
				'label'=>$model->getAttributeLabel('status'),
				'value'=>$model->lookupUserCommissionStatus->name,
			],
			[
				'label'=>$model->getAttributeLabel('createdby'),
				'value'=>Yii::$app->AccessMod->getName($model->createdby),
			],
            'createdat:datetime',
			[
				'label'=>$model->getAttributeLabel('updatedby'),
				'value'=>Yii::$app->AccessMod->getName($model->updatedby),
			],
            'updatedat:datetime',
			
        ],
    ]) ?>


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
        <th scope="col">Developer</th>
        <th scope="col">Project</th>
        <th scope="col">Product</th>
        <th scope="col">Product Unit</th>
        <th scope="col">Prospect Name</th>
        <th scope="col">Estimate Commission Amount</th>
        <th scope="col">Eligible Commission Amount</th>
        <th scope="col">Paid Commission Amount</th>
        <th scope="col">Status</th>
        <th scope="col">Created At</th>
        <th scope="col">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i=1;
		
        foreach($logUserCommissions as $log)
        {
			?>
			<tr>
                <td><?= $i ?></td>
                <td><?= $log['developer_name'] ?></td>
                <td><?= $log['project_name'] ?></td>
                <td><?= $log['product_name'] ?></td>
                <td><?= $log['product_unit'] ?></td>
                <td><?= $log['prospect_name'] ?></td>
                <td><?= Yii::$app->AccessMod->getPriceFormat($log['commission_amount']) ?></td>
                <td><?= Yii::$app->AccessMod->getPriceFormat($log['eligible_commission_amount']) ?></td>
                <td><?= Yii::$app->AccessMod->getPriceFormat($log['paid_commission_amount']) ?></td>
                <td>
					<?php
                    switch($log['status'])
                    {
                        case 1:
							echo '<span class="label label-warning">'.'Pending'.'</span>';
                        break;
                        case 2:
							echo '<span class="label label-success">'.'Processing'.'</span>';'Processing';
                        break;
                        case 3:
                            echo '<span class="label label-danger">'.'Cancelled'.'</span>';
                        break;
                        case 4:
                            echo '<span class="label label-default">'.'Completed'.'</span>';
                        break;
                        default:
                            echo '';
                        break;
                    }
                    ?>
                </td>
                <td><?= Yii::$app->formatter->asDatetime($log['createdat'], 'long') ?></td>
                <td>
					<?php
                    switch($model->status)
                    {
                        case 1:
							echo Html::a('<button class="btn btn-sm btn-warning">View</button>&nbsp&nbsp', ['view-commission-transaction','ajaxView'=>'','id'=>$model->id,'prospect_booking_id'=>$log['prospect_booking_id']], ['class'=>'view-commission-transaction modal-button-01']);
                            if(in_array($log['status'],array(1,2)))
							echo Html::a('<button class="btn btn-sm btn-success">Eligible Commisison</button>&nbsp&nbsp', ['eligible-commission','ajaxView'=>'','id'=>$model->id,'prospect_booking_id'=>$log['prospect_booking_id']], ['class'=>'eligible-commission modal-button-01']);
                        break;
						case 2:
							echo Html::a('<button class="btn btn-sm btn-warning">View</button>&nbsp&nbsp', ['view-commission-transaction','ajaxView'=>'','id'=>$model->id,'prospect_booking_id'=>$log['prospect_booking_id']], ['class'=>'view-commission-transaction modal-button-01']);
						break;
                        case 3:
							echo Html::a('<button class="btn btn-sm btn-warning">View</button>&nbsp&nbsp', ['view-commission-transaction','ajaxView'=>'','id'=>$model->id,'prospect_booking_id'=>$log['prospect_booking_id']], ['class'=>'view-commission-transaction modal-button-01']);
                            if($log['commission_amount']>0 and in_array($log['status'],array(1,2)))
							echo Html::a('<button class="btn btn-sm btn-success">Eligible Commisison</button>&nbsp&nbsp', ['eligible-commission','ajaxView'=>'','id'=>$model->id,'prospect_booking_id'=>$log['prospect_booking_id']], ['class'=>'eligible-commission modal-button-01']);
							//echo Html::a('<button class="btn btn-sm btn-success">Pay Commission</button>&nbsp&nbsp', ['pay-commission','ajaxView'=>'','id'=>$model->id,'user_eligible_commission_id'=>$log['user_eligible_commission_id'],'prospect_booking_id'=>$log['prospect_booking_id']], ['class'=>'pay-commission modal-button-01']);
					    break;
                        case 4:
							echo Html::a('<button class="btn btn-sm btn-warning">View</button></span>&nbsp&nbsp', ['view-commission-transaction','ajaxView'=>'','id'=>$model->id,'prospect_booking_id'=>$log['prospect_booking_id']], ['class'=>'view-commission-transaction modal-button-01']);
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
