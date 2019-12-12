<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use maksyutin\duallistbox\Widget;

/* @var $this yii\web\View */
/* @var $model app\models\ProjectProducts */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="project-products-form">

    <?php $form = ActiveForm::begin(); ?>


    <?php /*?><div style="clear:both;"><br /></div>
    <div class="panel panel-default">
        <div class="panel-heading"><strong>Product Details</strong></div>
        <div class="panel-body"><?php */?>
        
		<?php
        echo $form->field($model, 'project_id')->dropDownList(
                ArrayHelper::map($projectList, 'id', 'name'),['prompt' => 'Please select']
        );
        ?>
    
        <?= $form->field($model, 'product_name')->textInput(['maxlength' => true]) ?>
    
        <?php
        echo $form->field($model, 'product_tier')->dropDownList(
                ArrayHelper::map(Yii::$app->AccessMod->getLookupData('lookup_product_type'), 'id', 'name'),['prompt' => 'Please select']
        );
        ?>
        
        <?php
        echo $form->field($model, 'product_type_id')->dropDownList(
                ArrayHelper::map(Yii::$app->AccessMod->getLookupData('lookup_property_product_types'), 'id', 'name'),['prompt' => 'Please select']
        );
        ?>
        
        <?php /*?></div>
    </div><?php */?>
    
    <?php /*?><div style="clear:both;"><br /></div>
    <div class="panel panel-default">
        <div class="panel-heading"><strong>Product Unit Types</strong></div>
        <div class="panel-body">
        
        <div class="row">
            <div class="col-md-4">
				<?= $form->field($modelProjectProductUnitTypes, 'type_name')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-4">
				<?= $form->field($modelProjectProductUnitTypes, 'building_size_sm')->textInput(['type' => 'number', 'min'=>0, 'step'=>'0.01']) ?>
            </div>
            <div class="col-md-4">
				<?= $form->field($modelProjectProductUnitTypes, 'land_size_sm')->textInput(['type' => 'number', 'min'=>0, 'step'=>'0.01']) ?>
            </div>
        </div>
        
        </div>
    </div><?php */?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Add Product' : 'Update Product', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
