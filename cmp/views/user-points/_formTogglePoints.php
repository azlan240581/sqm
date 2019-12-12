<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\UserPoints */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-points-form">

    <?php $form = ActiveForm::begin(); ?>
    
	<?php
    echo $form->field($modelLogUserPoints, 'status')->dropDownList(
            ArrayHelper::map(array(array('id'=>'2','name'=>'Addition'),array('id'=>'4','name'=>'Deduction')), 'id', 'name'),['prompt' => 'Please select']
    )->label('Action');
    ?>

    <?= $form->field($modelLogUserPoints, 'points_value')->textInput(['type' => 'number', 'min' => 0, 'value'=>number_format($modelLogUserPoints->points_value,0)]) ?>

    <?= $form->field($modelLogUserPoints, 'remarks')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Create', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
