<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Prospects */

$this->title = $model->prospect_name;
$this->params['breadcrumbs'][] = 'Prospects Management';
$this->params['breadcrumbs'][] = ['label' => 'My Associate Prospects', 'url' => ['my-associate-prospects']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="prospects-view">

    <?php /*?><h1><?= Html::encode($this->title) ?></h1><?php */?>

    <p>
		<?= Html::a('<span class="glyphicon glyphicon-share"></span> Share', ['share-prospect', 'id' => $model->id, 'ajaxView' => '', 'action' => Yii::$app->controller->action->id], ['class'=>'btn btn-md btn-primary share modal-button-01','style'=>'margin:0;','title'=>'Share Prospect']) ?>
    	<button class="btn btn-primary" onclick="window.history.back()">Back</button>
        <?php /*?><?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?><?php */?>
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
        <th scope="col">Action(s)</th>
        <th scope="col">Remarks</th>
        <th scope="col">UDF</th>
        <th scope="col">Log Created By</th>
        <th scope="col">Log Created At</th>
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
            <td><?php echo $log['prospect_history_name'] ?></td>
            <td><?php echo $log['remarks'] ?></td>
            <td><?php echo Html::a(Html::img($log['udf1'], ['width'=>'100']),$log['udf1'], ['data-fancybox'=>true]) ?></td>
            <td><?php echo $log['createdbyname'] ?></td>
            <td><?php echo Yii::$app->formatter->asDatetime($log['createdat'], 'long') ?></td>
            <td></td>
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
	$('.share').click(function (){
		$('#modal-id-01').modal('show');
		$('#modal-id-01').find('#modal-content-01').load($(this).attr('value'));
		$('#modal-id-01').find('#modal-header-01').html("<?= 'Share Prospect: '.$model->prospect_name.' ('.$model->prospect_contact_number.')' ?>");
	});
});
</script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.6/dist/jquery.fancybox.min.css" />
<script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.6/dist/jquery.fancybox.min.js"></script>