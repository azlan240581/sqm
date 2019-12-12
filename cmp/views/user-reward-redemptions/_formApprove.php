<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UserRewardRedemptions */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-reward-redemptions-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'courier_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tracking_number')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($modelLogUserRewardRedemptions, 'remarks')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
