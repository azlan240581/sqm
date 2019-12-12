<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ProjectProductUnitTypesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="project-product-unit-types-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'project_id') ?>

    <?= $form->field($model, 'project_product_id') ?>

    <?= $form->field($model, 'type_name') ?>

    <?= $form->field($model, 'building_size_sm') ?>

    <?php // echo $form->field($model, 'land_size_sm') ?>

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