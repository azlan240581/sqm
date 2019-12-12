<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\BankPoints */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="bank-points-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->field($modelLogBankPoints, 'points_value')->textInput(['type' => 'number', 'min' => 0, 'value'=>number_format($modelLogBankPoints->points_value,0)])->label('Credits') ?>

    <?php echo $form->field($modelLogBankPoints, 'remarks')->textarea(['rows'=>'3']); ?>

    <div class="form-group">
        <?= Html::submitButton('Topup', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
