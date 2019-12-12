<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use maksyutin\duallistbox\Widget;

/* @var $this yii\web\View */
/* @var $model app\models\GroupListsTopics */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="group-lists-topics-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'topic_name')->textInput(['maxlength' => true, 'readonly'=>$model->id==1?true:false]) ?>

    <?php 
	echo $form->field($model, 'status')->radioList([1 => 'Active', 0 => 'Inactive'],['itemOptions' => ['labelOptions' => ['class' => 'col-md-1'], 'disabled'=>$model->id==1?true:false]]) 
	?>
    
    <div style="clear:both;"><br /></div>
    
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'name' => 'topic', 'value'=>1]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
