<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model app\models\UserAssociateDetails */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="log-associate-approval-form">

    <?php $form = ActiveForm::begin(); ?>

	<?php
    echo $form->field($modelLogAssociateApproval, 'status')->dropDownList(
            ArrayHelper::map($lookupAssociateApprovalStatusList, 'id', 'name'),['prompt' => 'Please select']
    );
    ?>

    <?= $form->field($modelLogAssociateApproval, 'remarks')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Create', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
