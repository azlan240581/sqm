<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\LogProspectHistorySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="log-prospect-history-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'prospect_id') ?>

    <?= $form->field($model, 'prospect_booking_id') ?>

    <?= $form->field($model, 'history_id') ?>

    <?= $form->field($model, 'udf1') ?>

    <?php // echo $form->field($model, 'udf2') ?>

    <?php // echo $form->field($model, 'udf3') ?>

    <?php // echo $form->field($model, 'remarks') ?>

    <?php // echo $form->field($model, 'createdby') ?>

    <?php // echo $form->field($model, 'createdat') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
