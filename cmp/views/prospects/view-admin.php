<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Prospects */

$this->title = $model->prospect_name;
$this->params['breadcrumbs'][] = 'Prospects Management';
$this->params['breadcrumbs'][] = ['label' => 'List', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="prospects-view">

    <?php /*?><h1><?= Html::encode($this->title) ?></h1><?php */?>

    <p>
    	<button class="btn btn-primary" onclick="window.history.back()">Back</button>
        <?php
	    /*if(count($logProspectHistory)!=0)
		{
			$histories = array_column($logProspectHistory,'history_id');
			if(count(array_intersect($histories, array(7,10,13,17,18))) == 0)
    		echo Html::a('Drop Interest', ['drop-interest', 'id' => $model->id], ['class' => 'btn btn-danger drop-interest modal-button-01']);
		}*/
		?>
    </p>

    
	<div class="row bg-dark-grey">
    	<div class="col-xs-12"><h4>Prospect Information:</h4></div>
    </div>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
			[
				'label'=>$model->getAttributeLabel('agent_name'),
				'value' => $model->agent->name,
			],
			[
				'label'=>$model->getAttributeLabel('member_name'),
				'value' => $model->member->name,
			],
            'prospect_name',
            'prospect_email:email',
			[
				'label'=>$model->getAttributeLabel('prospect_contact_number'),
				'value' => '+'.$model->prospect_contact_number,
			],
			[
				'label' => $model->getAttributeLabel('prospect_purpose_of_buying'),
				'value' => $model->lookupPurposeOfBuying['name'],
			],
			/*[
				'label' => $model->getAttributeLabel('how_prospect_know_us'),
				'value' => $model->lookupHowYouKnowAboutUs['name'],
			],
            'prospect_age',*/
			'prospect_dob:date',
			[
				'label' => $model->getAttributeLabel('prospect_marital_status'),
				'value' => $model->lookupMaritalStatus['name'],
			],
			[
				'label' => $model->getAttributeLabel('prospect_occupation'),
				'value' => $model->lookupOccupation['name'],
			],
			[
				'label' => $model->getAttributeLabel('prospect_domicile'),
				'value' => $model->lookupDomicile['name'],
			],
			[
            	'attribute' => 'prospect_identity_document',
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
            	'format' => 'raw',
				'value' => call_user_func(function ($data) {
							$tmp = '<div class="row">';
							$tmp .= '<div class="col-md-3"><a href="'.$data->tax_license.'" data-fancybox=1><img src="'.$data->tax_license.'" width="200" /></a></div>';
							$tmp .= '</div>';
							return $tmp;				
														
							}, $model),
            ],
            //'remarks:ntext',
			[
				'label'=>$model->getAttributeLabel('status'),
				'value' => $model->lookupProspectStatus['name'],
			],
			/*[
				'label'=>$model->getAttributeLabel('createdby'),
				'value' => $model->createdbyusername['name'],
			],
            'createdat:datetime',
			[
				'label'=>$model->getAttributeLabel('updatedby'),
				'value' => $model->updatedbyusername['name'],
			],
            'updatedat:datetime',
			[
				'label'=>$model->getAttributeLabel('deletedby'),
				'value' => $model->deletedbyusername['name'],
			],
            'deletedat:datetime',*/
        ],
    ]) ?>

	<br />

    <div class="row bg-dark-grey">
        <div class="col-xs-12"><h4>Booking Transactions</h4></div>
    </div>
    <table id="w1" class="table table-striped table-bordered detail-view">
    <?php
	$bookingTransactions = !$bookingTransactions?array():$bookingTransactions;

    if(count($bookingTransactions)==0)
    echo '<tbody><tr><td>No results found.</td></tr></tbody>';
    else
    {
    ?>
    <thead>
        <tr>
        <th scope="col">#</th>
        <th scope="col">Project</th>
        <th scope="col">Reference No</th>
        <th scope="col">Prospect</th>
        <th scope="col">Buyer Name</th>
        <th scope="col">Status</th>
        <th scope="col">Created By</th>
        <th scope="col">Created At</th>
        <th scope="col">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i=1;
        foreach($bookingTransactions as $booking)
        {
        ?>
        <tr>
            <th scope="row"><?php echo $i ?>.</th>
            <td><?php echo $booking->project['project_name'] ?></td>
            <td><?php echo $booking->ref_no ?></td>
            <td><?php echo $booking->prospect['prospect_name'] ?></td>
            <td>
            <?php
            foreach($booking->prospectBookingBuyers as $buyer)
			{
				echo $buyer->buyer_firstname.' '.$buyer->buyer_lastname.'<br>';
			}
			?>
            </td>
            <td><?php echo $booking->lookupBookingStatus['name'] ?></td>
            <td><?php echo $booking->createdbyusername['name'] ?></td>
            <td><?php echo Yii::$app->formatter->asDatetime($booking->createdat, 'long') ?></td>
            <td>
			<?php
			switch($booking->status)
			{
				default:
					echo Html::a('<button class="btn btn-sm btn-warning">View</button>&nbsp&nbsp', ['view-full-booking','ajaxView'=>'','id'=>$model->id,'prospect_booking_id'=>$booking->id], ['class'=>'contract-signed-view modal-button-01']);
					if($booking->status!=12)
					{
						echo Html::a('<button class="btn btn-sm btn-primary">Edit</button>&nbsp&nbsp', ['edit-full-booking','ajaxView'=>'','id'=>$model->id,'prospect_booking_id'=>$booking->id], ['class'=>'book-update modal-button-01']);
						echo Html::a('<button class="btn btn-sm btn-danger">Cancel</button>&nbsp&nbsp', ['cancel-booking-full','ajaxView'=>'','id'=>$model->id,'prospect_booking_id'=>$booking->id], ['class'=>'cancel-booking modal-button-01']);
					}
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
    
    <br />
    
    <div class="row bg-dark-grey">
        <div class="col-xs-12"><h4>Log History</h4></div>
    </div>

    <table id="w1" class="table table-striped table-bordered detail-view">
    <?php
    if(count($logProspectHistory)==0)
    echo '<tbody><tr><td>No results found.</td></tr></tbody>';
    else
    {
    ?>
    <thead>
        <tr>
        <th scope="col">#</th>
        <th scope="col">Project</th>
        <th scope="col">Log(s)</th>
        <th scope="col">Remarks</th>
        <th scope="col">Created By</th>
        <th scope="col">Created At</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i=1;
        foreach($logProspectHistory as $log)
        {
        ?>
        <tr>
            <th scope="row"><?php echo $i ?>.</th>
            <td><?php echo $log['project_name'] ?></td>
            <td>
			<?php echo $log['prospect_history_name']
			. 
			(!empty($log['appointment_at']) && $log['history_id'] == 3?'<div>Date: '.date("M j, Y",strtotime($log['appointment_at'])).'<br>Time: '.date("g:i A",strtotime($log['appointment_at'])).'<br>Location: '.$log['appointment_location'].'</div>':'') 
			. 
			(!empty($log['level_of_interest']) && $log['history_id'] == 4?'<div>Interest: '.$log['level_of_interest_name'].'</div><div>Site Visit: '.($log['site_visit']==1?'Yes':'No').'</div>':'') 
			. 
			(!empty($log['bookingid']) && $log['history_id'] == 5?'<div>Booking ID ('.$log['bookingid'].')'.'</div>':'')
			?>
            </td>
            <td><?php echo $log['remarks'] ?></td>
            <?php /*?><td><?php echo Html::a(Html::img($log['udf1'], ['width'=>'100']),$log['udf1'], ['data-fancybox'=>true]) ?></td><?php */?>
            <td><?php echo $log['createdbyname'] ?></td>
            <td><?php echo Yii::$app->formatter->asDatetime($log['createdat'], 'long') ?></td>
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
	$('.followup').click(function (){
		$('#modal-id-01').modal('show');
		$('#modal-id-01').find('#modal-content-01').load($(this).attr('value'));
		$('#modal-id-01').find('#modal-header-01').html("<?= 'Follow Up: '.$model->prospect_name.' ('.$model->prospect_contact_number.')' ?>");
	});

	$('.appointment').click(function (){
		$('#modal-id-01').modal('show');
		$('#modal-id-01').find('#modal-content-01').load($(this).attr('value'));
		$('#modal-id-01').find('#modal-header-01').html("<?= 'Appointment Schedule: '.$model->prospect_name.' ('.$model->prospect_contact_number.')' ?>");
	});

	$('.levelinterest').click(function (){
		$('#modal-id-01').modal('show');
		$('#modal-id-01').find('#modal-content-01').load($(this).attr('value'));
		$('#modal-id-01').find('#modal-header-01').html("<?= 'Level of Interest: '.$model->prospect_name.' ('.$model->prospect_contact_number.')' ?>");
	});

	$('.eoi').click(function (){
		$('#modal-id-01').modal('show');
		$('#modal-id-01').find('#modal-content-01').load($(this).attr('value'));
		$('#modal-id-01').find('#modal-header-01').html("<?= 'EOI: '.$model->prospect_name.' ('.$model->prospect_contact_number.')' ?>");
	});

	$('.eoi-update').click(function (){
		$('#modal-id-01').modal('show');
		$('#modal-id-01').find('#modal-content-01').load($(this).attr('value'));
		$('#modal-id-01').find('#modal-header-01').html("<?= 'EOI: '.$model->prospect_name.' ('.$model->prospect_contact_number.')' ?>");
	});

	$('.eoi-book').click(function (){
		$('#modal-id-01').modal('show');
		$('#modal-id-01').find('#modal-content-01').load($(this).attr('value'));
		$('#modal-id-01').find('#modal-header-01').html("<?= 'EOI to Booking: '.$model->prospect_name.' ('.$model->prospect_contact_number.')' ?>");
	});

	$('.eoi-view').click(function (){
		$('#modal-id-01').modal('show');
		$('#modal-id-01').find('#modal-content-01').load($(this).attr('value'));
		$('#modal-id-01').find('#modal-header-01').html("<?= 'EOI Details: '.$model->prospect_name.' ('.$model->prospect_contact_number.')' ?>");
	});

	$('.book-view').click(function (){
		$('#modal-id-01').modal('show');
		$('#modal-id-01').find('#modal-content-01').load($(this).attr('value'));
		$('#modal-id-01').find('#modal-header-01').html("<?= 'Booking Details: '.$model->prospect_name.' ('.$model->prospect_contact_number.')' ?>");
	});

	$('.book-update').click(function (){
		$('#modal-id-01').modal('show');
		$('#modal-id-01').find('#modal-content-01').load($(this).attr('value'));
		$('#modal-id-01').find('#modal-header-01').html("<?= 'Booking: '.$model->prospect_name.' ('.$model->prospect_contact_number.')' ?>");
	});

	$('.book').click(function (){
		$('#modal-id-01').modal('show');
		$('#modal-id-01').find('#modal-content-01').load($(this).attr('value'));
		$('#modal-id-01').find('#modal-header-01').html("<?= 'Booking: '.$model->prospect_name.' ('.$model->prospect_contact_number.')' ?>");
	});

	$('.update-contract-signed').click(function (){
		$('#modal-id-01').modal('show');
		$('#modal-id-01').find('#modal-content-01').load($(this).attr('value'));
		$('#modal-id-01').find('#modal-header-01').html("<?= 'Contract Signed: '.$model->prospect_name.' ('.$model->prospect_contact_number.')' ?>");
	});

	$('.contract-signed-update').click(function (){
		$('#modal-id-01').modal('show');
		$('#modal-id-01').find('#modal-content-01').load($(this).attr('value'));
		$('#modal-id-01').find('#modal-header-01').html("<?= 'Contract Signed: '.$model->prospect_name.' ('.$model->prospect_contact_number.')' ?>");
	});

	$('.contract-signed-view').click(function (){
		$('#modal-id-01').modal('show');
		$('#modal-id-01').find('#modal-content-01').load($(this).attr('value'));
		$('#modal-id-01').find('#modal-header-01').html("<?= 'Contract Signed Details: '.$model->prospect_name.' ('.$model->prospect_contact_number.')' ?>");
	});

	$('.share').click(function (){
		$('#modal-id-01').modal('show');
		$('#modal-id-01').find('#modal-content-01').load($(this).attr('value'));
		$('#modal-id-01').find('#modal-header-01').html("<?= 'Share Prospect: '.$model->prospect_name.' ('.$model->prospect_contact_number.')' ?>");
	});

	$('.cancel-booking').click(function (){
		$('#modal-id-01').modal('show');
		$('#modal-id-01').find('#modal-content-01').load($(this).attr('value'));
		$('#modal-id-01').find('#modal-header-01').html("<?= 'Cancel Booking for Prospect: '.$model->prospect_name.' ('.$model->prospect_contact_number.')' ?>");
	});
});
</script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.6/dist/jquery.fancybox.min.css" />
<script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.6/dist/jquery.fancybox.min.js"></script>