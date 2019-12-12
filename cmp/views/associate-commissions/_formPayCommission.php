<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UserCommissions */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-commissions-form">

    <?php $form = ActiveForm::begin(); ?>

	<div class="row bg-dark-grey">
    	<div class="col-xs-12"><h4>Eligible Commission Information :</h4></div>
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
        <th>Eligible Commission Amount</th>
        <td><?= Yii::$app->AccessMod->getPriceFormat($modelUserEligibleCommissions->commission_eligible_amount) ?></td>
    </tr>
    </tbody>
    </table>

    <?= $form->field($modelLogUserCommission, 'remarks')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
