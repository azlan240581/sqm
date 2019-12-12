<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model app\models\Users */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="users-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    
    <div style="clear:both;"><br /></div>
    <div class="panel panel-default">
        <div class="panel-heading"><strong>Associate Account</strong></div>
        <div class="panel-body">
        
			<?= $form->field($modelUsers, 'sqm_id')->textInput(['maxlength' => true])->label('Reference ID') ?>
			
			<?= $form->field($modelUsers, 'email')->textInput(['maxlength' => true]) ?>
        
             <div class="row">
                <div class="col-md-4">
					<?php echo $form->field($modelUsers, 'firstname')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-8">
					<?php echo $form->field($modelUsers, 'lastname')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
            
             <div class="row">
                <div class="col-md-4">
					<?php
                    echo $form->field($modelUsers, 'country_code')->dropDownList(
                            ArrayHelper::map($countryCodeList, 'value', 'name'),['prompt' => 'Please select']
                    );
                    ?>
                </div>
                <div class="col-md-8">
					<?= $form->field($modelUsers, 'contact_number')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
        
            <?= $form->field($modelUsers, 'dob')->widget(\yii\jui\DatePicker::classname(), [
                //'language' => 'ru',
                'dateFormat' => 'yyyy-MM-dd',
                'options' => [
                        'class' => 'form-control',
                        'readonly' => true,
                    ],
                'clientOptions' => [
                        'changeMonth' => true,
                        'yearRange' => (date('Y')-100).':'.date('Y'),
                        'changeYear' => true,
                    ],			
                    
                ])->label('Date of Birth') 
            ?>
        
            <?php
			$genderList = array(array('name'=>'Male','value'=>'Male'),array('name'=>'Female','value'=>'Female'));
            echo $form->field($modelUsers, 'gender')->dropDownList(
                    ArrayHelper::map($genderList, 'value', 'name'),['prompt' => 'Please select']
            );
            ?>
                        
        </div>
    </div>    
    
    <div class="panel panel-default">
        <div class="panel-heading"><strong>Associate Verfication Data</strong></div>
        <div class="panel-body">
        
			<?= $form->field($modelUsers, 'address_1')->textInput(['maxlength' => true]) ?>
        
            <?= $form->field($modelUsers, 'address_2')->textInput(['maxlength' => true]) ?>
        
            <?= $form->field($modelUsers, 'address_3')->textInput(['maxlength' => true]) ?>
        
            <?= $form->field($modelUsers, 'city')->textInput(['maxlength' => true]) ?>
        
            <?= $form->field($modelUsers, 'postcode')->textInput(['maxlength' => true]) ?>
        
            <?= $form->field($modelUsers, 'state')->textInput(['maxlength' => true]) ?>
        
            <?php
            echo $form->field($modelUsers, 'country')->dropDownList(
                    ArrayHelper::map($countryList, 'id', 'name'),['prompt' => 'Please select']
            )->label('Country');
            ?>

            <?= $form->field($modelUserAssociateDetails, 'id_number')->textInput(['maxlength' => true]) ?>

            <?= $form->field($modelUserAssociateDetails, 'tax_license_number')->textInput(['maxlength' => true]) ?>
            
			<?php
            echo $form->field($modelUserAssociateDetails, 'bank_id')->dropDownList(
                    ArrayHelper::map(Yii::$app->AccessMod->getLookupData('lookup_banks'), 'id', 'name'),['prompt' => 'Please select']
            );
            ?>
            
			<?= $form->field($modelUserAssociateDetails, 'account_name')->textInput(['maxlength' => true]) ?>
			
			<?= $form->field($modelUserAssociateDetails, 'account_number')->textInput(['maxlength' => true]) ?>
            
			<?php
            echo $form->field($modelUserAssociateDetails, 'domicile')->dropDownList(
                    ArrayHelper::map($domicileList, 'id', 'name'),['prompt' => 'Please select']
            );
            ?>
              
            <?php
            echo $form->field($modelUserAssociateDetails, 'occupation')->dropDownList(
                    ArrayHelper::map($occupationList, 'id', 'name'),['prompt' => 'Please select']
            );
            ?>
        
            <?php
            echo $form->field($modelUserAssociateDetails, 'industry_background')->dropDownList(
                    ArrayHelper::map($industryBackgroundList, 'id', 'name'),['prompt' => 'Please select']
            );
            ?>
        
			<?php
            echo '<label class="control-label">'.$modelUserAssociateDetails->getAttributeLabel('nricpass').'</label>';
            echo FileInput::widget([
                'model' => $modelUserAssociateDetails,
                'attribute' => 'file',
                'options' => ['accept' => 'image/*',],
                'pluginOptions' => [
                        'browseClass' => 'btn btn-primary',
                        'browseLabel' =>  'Browse Photo',
                        'showClose' => false,
                        'showUpload' => false,
                        'showCaption' => false,
                        'removeClass' => 'btn btn-danger',
                        'previewFileType' => 'image',
                        'initialPreview' => [
                            (($modelUserAssociateDetails->nricpass) ? Html::img($modelUserAssociateDetails->nricpass, ['width'=>'200']) : null), // checks the models to display the preview
                        ],
						'layoutTemplates' => ['actionDrag'=> '','actionZoom'=> '','actionDelete'=> ''],
                    ],
            ]);
            ?>
            
            <div style="clear:both;"><br /></div>
                    
			<?php
            echo '<label class="control-label">'.$modelUserAssociateDetails->getAttributeLabel('tax_license').'</label>';
            echo FileInput::widget([
                'model' => $modelUserAssociateDetails,
                'attribute' => 'file2',
                'options' => ['accept' => 'image/*',],
                'pluginOptions' => [
                        'browseClass' => 'btn btn-primary',
                        'browseLabel' =>  'Browse Photo',
                        'showClose' => false,
                        'showUpload' => false,
                        'showCaption' => false,
                        'removeClass' => 'btn btn-danger',
                        'previewFileType' => 'image',
                        'initialPreview' => [
                            (($modelUserAssociateDetails->tax_license) ? Html::img($modelUserAssociateDetails->tax_license, ['width'=>'200']) : null), // checks the models to display the preview
                        ],
						'layoutTemplates' => ['actionDrag'=> '','actionZoom'=> '','actionDelete'=> ''],
                    ],
            ]);
            ?>
            
            <div style="clear:both;"><br /></div>
                    
			<?php
            echo '<label class="control-label">'.$modelUserAssociateDetails->getAttributeLabel('bank_account').'</label>';
            echo FileInput::widget([
                'model' => $modelUserAssociateDetails,
                'attribute' => 'file3',
                'options' => ['accept' => 'image/*',],
                'pluginOptions' => [
                        'browseClass' => 'btn btn-primary',
                        'browseLabel' =>  'Browse Photo',
                        'showClose' => false,
                        'showUpload' => false,
                        'showCaption' => false,
                        'removeClass' => 'btn btn-danger',
                        'previewFileType' => 'image',
                        'initialPreview' => [
                            (($modelUserAssociateDetails->bank_account) ? Html::img($modelUserAssociateDetails->bank_account, ['width'=>'200']) : null), // checks the models to display the preview
                        ],
						'layoutTemplates' => ['actionDrag'=> '','actionZoom'=> '','actionDelete'=> ''],
                    ],
            ]);
            ?>
            
            <div style="clear:both;"><br /></div>
        
			<?php
            echo '<label class="control-label">'.$modelUserAssociateDetails->getAttributeLabel('udf1').'</label>';
            echo FileInput::widget([
                'model' => $modelUserAssociateDetails,
                'attribute' => 'file4',
                'options' => ['accept' => 'image/*',],
                'pluginOptions' => [
                        'browseClass' => 'btn btn-primary',
                        'browseLabel' =>  'Browse Photo',
                        'showClose' => false,
                        'showUpload' => false,
                        'showCaption' => false,
                        'removeClass' => 'btn btn-danger',
                        'previewFileType' => 'image',
                        'initialPreview' => [
                            (($modelUserAssociateDetails->udf1) ? Html::img($modelUserAssociateDetails->udf1, ['width'=>'200']) : null), // checks the models to display the preview
                        ],
						'layoutTemplates' => ['actionDrag'=> '','actionZoom'=> '','actionDelete'=> ''],
                    ],
            ]);
            ?>
            
            <div style="clear:both;"><br /></div>
        
        </div>
    </div>    

    <div class="form-group">
        <?= Html::submitButton('Update', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
