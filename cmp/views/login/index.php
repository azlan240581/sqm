<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to login:</p>

    <?php $form = ActiveForm::begin(array(
        'id' => 'login-form',
        'options' => array('class' => 'form-horizontal'),
        'fieldConfig' => array(
            'template' => "{label}\n<div class=\"col-sm-12\">{input}</div>\n<div class=\"col-sm-12\">{error}</div>",
            'labelOptions' => array('class' => 'col-sm-12 control-label'),
        ),
    )); ?>

        <?= $form->field($model, 'username')->textInput(array('autofocus' => true)) ?>

        <?= $form->field($model, 'password')->passwordInput() ?>

        <?= $form->field($model, 'rememberMe')->checkbox(array(
            'template' => "<div class=\"col-sm-12\">{input} {label}</div>\n<div class=\"col-sm-12\">{error}</div>",
        )) ?>

        <div class="form-group">
            <div class="col-sm-12">
                <?= Html::submitButton('Login', array('class' => 'btn btn-primary btn-login', 'name' => 'login-button')) ?>
            </div>
        </div>

    <?php ActiveForm::end(); ?>

    <div class="col-lg-offset-1" style="color:#999;">
    </div>
</div>
