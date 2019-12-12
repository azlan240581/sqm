<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ProspectsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="prospects-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'agent_id') ?>

    <?= $form->field($model, 'member_id') ?>

    <?= $form->field($model, 'prospect_name') ?>

    <?= $form->field($model, 'prospect_email') ?>

    <?php // echo $form->field($model, 'prospect_contact_number') ?>

    <?php // echo $form->field($model, 'prospect_purpose_of_buying') ?>

    <?php // echo $form->field($model, 'how_prospect_know_us') ?>

    <?php // echo $form->field($model, 'prospect_age') ?>

    <?php // echo $form->field($model, 'prospect_marital_status') ?>

    <?php // echo $form->field($model, 'prospect_occupation') ?>

    <?php // echo $form->field($model, 'prospect_identity_document') ?>

    <?php // echo $form->field($model, 'tax_license') ?>

    <?php // echo $form->field($model, 'remarks') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'createdby') ?>

    <?php // echo $form->field($model, 'createdat') ?>

    <?php // echo $form->field($model, 'updatedby') ?>

    <?php // echo $form->field($model, 'updatedat') ?>

    <?php // echo $form->field($model, 'deletedby') ?>

    <?php // echo $form->field($model, 'deletedat') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
