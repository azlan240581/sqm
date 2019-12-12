<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use maksyutin\duallistbox\Widget;
use jlorente\remainingcharacters\RemainingCharacters;
use dosamigos\tinymce\TinyMce;

/* @var $this yii\web\View */
/* @var $model app\models\UserMessages */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-messages-form">

    <?php $form = ActiveForm::begin(); ?>

	<?php echo '<label class="control-label">Associate</label>'; ?>
    <br />
    <div class="col-md-12">
    <?php
    echo Widget::widget([
        'model' => $modelUserMessages,
        'attribute' => 'user_id',
        'title' => 'Members',
        'data' => $memberListBox,
        'data_id'=> 'id',
        'data_value'=> 'name',
        'lngOptions' => [
            'warning_info' => 'Are you sure you want to move this many items?
        Doing so can cause your browser to become unresponsive.',
            'search_placeholder' => 'Search Associate',
            'showing' => ' - total',
            'available' => 'Available',
            'selected' => 'Selected'
        ]
      ]);
    ?>
    </div>
    
    <div style="clear:both;"><br /></div>

    <?= $form->field($modelUserMessages, 'subject')->textInput(['maxlength' => true]) ?>

    <?= $form->field($modelUserMessages, 'message')->textarea(['rows' => 6]) ?>
   
	<?= $form->field($modelUserMessages, 'long_message')->widget(TinyMce::className(), [
        'options' => ['rows' => 20],
        'language' => 'en',
        'clientOptions' => [
            'plugins' => [
                "advlist autolink lists link charmap print preview anchor",
                "searchreplace visualblocks code fullscreen",
                "insertdatetime media table contextmenu paste"
            ],
            'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
        ]
    ]);?>

    <div class="form-group">
        <?= Html::submitButton('Send', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
