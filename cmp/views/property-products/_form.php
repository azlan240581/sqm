<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use maksyutin\duallistbox\Widget;
use dosamigos\tinymce\TinyMce;
use kato\DropZone;
use kartik\file\FileInput;
use yii\helpers\Url;
use kartik\datetime\DateTimePicker;
use kartik\daterange\DateRangePicker;
use kartik\number\NumberControl;

/* @var $this yii\web\View */
/* @var $model app\models\PropertyProducts */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="property-products-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <div style="clear:both;"><br /></div>
    <div class="panel panel-default">
        <div class="panel-heading"><strong>Property Product Details</strong></div>
        <div class="panel-body">

		<?php
        if(count($projectList)==1)
        {
            echo $form->field($model, 'project_id')->hiddenInput(['value'=> $projectList[0]['id']])->label(false);
        }
        else
        {
            echo $form->field($model, 'project_id')->dropDownList(
                    ArrayHelper::map($projectList, 'id', 'project_name'),['prompt' => 'Please select','disabled'=>($_SESSION['user']['action']=='create'?FALSE:TRUE)]
            )->label('Project');
        }
        ?>
        
        <?php
        echo $form->field($model, 'project_product_id')->dropDownList(
                ArrayHelper::map($projectProductList, 'id', 'name'),['prompt' => 'Please select']
        )->label('Project Product');
        ?>
    
        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    
        <?= $form->field($model, 'permalink')->textInput(['maxlength' => true]) ?>
    
        <?= $form->field($model, 'summary')->textarea(['rows' => 6,'maxlength' => 80]) ?>
    
        <?= $form->field($model, 'description')->widget(TinyMce::className(), [
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
    
        <?php
        echo $form->field($model, 'file')->widget(FileInput::classname(), [
            'options' => [
                    'accept' => 'image/*',
            ],
            'pluginOptions' => [
                    'browseClass' => 'btn btn-primary',
                    'browseLabel' =>  'Browse Photo',
                    'showUpload' => false,
                    'showCaption' => false,
                    'showClose' => false,
                    'removeClass' => 'btn btn-danger',
                    'previewFileType' => 'image',
                    'initialPreview' => [
                        (($model->thumb_image) ? Html::img($model->thumb_image, ['width'=>200]) : NULL), // checks the models to display the preview
                    ],
                    'layoutTemplates' => ['actionDrag'=> '','actionZoom'=> '','actionDelete'=> ''],
                ],
        ])->label($model->getAttributeLabel('file').' <span style="font-weight:normal;">(Max Size:10MB; File Format:png,jpg,jpeg; Width:'.$_SESSION['settings']['PRODUCT_MEDIA_THUMB_IMAGE_WIDTH'].'px * Height:'.$_SESSION['settings']['PRODUCTS_MEDIA_THUMB_IMAGE_HEIGHT'].'px)</span>');
        ?>
    
        <?php
        echo $form->field($model, 'product_type')->dropDownList(
			ArrayHelper::map($propertyProductTypeList, 'id', 'name'),['prompt' => 'Please select']
        );
        ?>
    
        <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>
    
        <?= $form->field($model, 'latitude')->textInput(['maxlength' => true]) ?>
    
        <?= $form->field($model, 'longitude')->textInput(['maxlength' => true]) ?>
    
        <?php //echo $form->field($model, 'price')->textInput(['type' => 'number', 'min'=>0]) ?>
    
		<?= $form->field($model, 'price', ['inputOptions' => ['class' => 'form-control']])
            ->textInput(['maxlength' => true])
            ->widget(NumberControl::classname(), [
                'maskedInputOptions' => [
                    'prefix' => $_SESSION['settings']['CURRENCY_SYMBOL'].' ',
                    'suffix' => '',
                    'allowMinus' => false,
                    'rightAlign' => false,
                ],
                'options' => ['type' => 'hidden'],
            ]);
        ?>
    
        <?php //echo $form->field($model, 'building_size')->textInput(['type' => 'number', 'min'=>0]) ?>
    
        <?php //echo $form->field($model, 'land_size')->textInput(['type' => 'number', 'min'=>0]) ?>
    
		<?= $form->field($model, 'building_size', 
            [
                'template' => '{label}
                              <div class="input-group">
                              {input}<span class="input-group-addon">m<sup>2</sup></span></div>{error}{hint}'
            ])->textInput(['maxlength' => true])
            ->widget(NumberControl::classname(), [
                'maskedInputOptions' => [
                    'prefix' => '',
                    'suffix' => '',
                    'allowMinus' => false,
                    'rightAlign' => false,
                ],
                'options' => ['type' => 'hidden'],
            ]);
        ?>    
    
        <?= $form->field($model, 'land_size', 
            [
                'template' => '{label}
                              <div class="input-group">
                              {input}<span class="input-group-addon">m<sup>2</sup></span></div>{error}{hint}'
            ])->textInput(['maxlength' => true])
            ->widget(NumberControl::classname(), [
                'maskedInputOptions' => [
                    'prefix' => '',
                    'suffix' => '',
                    'allowMinus' => false,
                    'rightAlign' => false,
                ],
                'options' => ['type' => 'hidden'],
            ]);
        ?>    
    
        <?= $form->field($model, 'total_floor')->textInput(['type' => 'number', 'min'=>0]) ?>
    
        <?= $form->field($model, 'bedroom')->textInput(['type' => 'number', 'min'=>0]) ?>
    
        <?= $form->field($model, 'bathroom')->textInput(['type' => 'number', 'min'=>0]) ?>
        
        <?= $form->field($model, 'parking_lot')->textInput(['type' => 'number', 'min'=>0]) ?>
    
        <label class="control-label">Collaterals</label>
        <br />
        <div class="col-md-12">
        <?php
        echo Widget::widget([
            'model' => $model,
            'attribute' => 'collaterals_id',
            'title' => 'Collateral',
            'data' => $collateralObj,
            'data_id'=> 'id',
            'data_value'=> 'name',
            'lngOptions' => [
                'warning_info' => 'Are you sure you want to move this many items?
            Doing so can cause your browser to become unresponsive.',
                'search_placeholder' => 'Search Collateral',
                'showing' => ' - total',
                'available' => 'Available',
                'selected' => 'Selected'
            ]
          ]);
        ?>
        </div>
    
        <div style="clear:both;"><br /></div>
    
        <?php /*?>
        <?= $form->field($model, 'published_date_start')->widget(\yii\jui\DatePicker::classname(), [
            //'language' => 'ru',
            'dateFormat' => 'yyyy-MM-dd',
            'options' => ['class' => 'form-control','readonly' => true],
            ])->label('Publish Start Date') 
        ?>
    
        <?= $form->field($model, 'published_date_end')->widget(\yii\jui\DatePicker::classname(), [
            //'language' => 'ru',
            'dateFormat' => 'yyyy-MM-dd',
            'options' => ['class' => 'form-control'],
            ])->label('Publish End Date') 
        ?>
        <?php */?>
        
        </div>
    </div>    
    
    <?php
	if($_SESSION['user']['action']=='create')
	{
		?>
		<div class="panel panel-default">
			<div class="panel-heading"><strong>Property Product Media</strong></div>
			<div class="panel-body">
	
			<?php
			echo $form->field($modelPropertyProductMedias, 'file')->widget(FileInput::classname(), [
				'options' => [
						'accept' => 'image/*',
				],
				'pluginOptions' => [
						'browseClass' => 'btn btn-primary',
						'browseLabel' =>  'Browse Photo',
						'showUpload' => false,
						'showCaption' => false,
						'removeClass' => 'btn btn-danger',
						'previewFileType' => 'image',
						'initialPreview' => [
							(($modelPropertyProductMedias->thumb_image) ? Html::img($modelPropertyProductMedias->thumb_image, ['width'=>200]) : NULL), // checks the models to display the preview
						],
					],
			])->label('Thumb Image <span style="font-weight:normal;">(Max Size:10MB; File Format:png,jpg,jpeg; Width:'.$_SESSION['settings']['PRODUCT_MEDIA_THUMB_IMAGE_WIDTH'].'px * Height:'.$_SESSION['settings']['PRODUCTS_MEDIA_THUMB_IMAGE_HEIGHT'].'px)</span>');
			?>
		
			<?= $form->field($modelPropertyProductMedias, 'media_title')->textInput(['maxlength' => true]) ?>
		
			<?php
			echo $form->field($modelPropertyProductMedias, 'image')->widget(FileInput::classname(), [
				'options' => [
						'accept' => 'image/*',
				],
				'pluginOptions' => [
						'browseClass' => 'btn btn-primary',
						'browseLabel' =>  'Browse Photo',
						'showUpload' => false,
						'showCaption' => false,
						'removeClass' => 'btn btn-danger',
						'previewFileType' => 'image',
						'initialPreview' => [
							(($modelPropertyProductMedias->media_value) ? Html::img($modelPropertyProductMedias->media_value, ['width'=>200]) : NULL), // checks the models to display the preview
						],
					],
			])->label('Image <span style="font-weight:normal;">(Max Size:10MB; File Format:png,jpg,jpeg; Width:800px * Height:600px)</span>');
			?>
				
			<?= $form->field($modelPropertyProductMedias, 'sort')->textInput(['type' => 'number', 'min'=>0]) ?>
		
			<div style="clear:both;"><br /></div>
		
			</div>
		</div> 
        <?php
	}
	?>
       
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script>
function getProjectProducts(projectid)
{
	$.ajax({url: "/cmp/property-products/create?get_project_product_list="+projectid, dataType: "json", success: function(result){
		$("#propertyproducts-project_product_id").empty();
		$("#propertyproducts-project_product_id").attr("aria-invalid","true");
		$("#propertyproducts-project_product_id").append('<option value="">Please select</option>');
		if(result.length != 0)
		{
			for(var i=0;i<result.length;i++)
			{
				$("#propertyproducts-project_product_id").append('<option value="'+result[i]['id']+'">'+result[i]['name']+'</option>');
			}
		}
		else
		{
			$("#propertyproducts-project_product_id").append('<option value="">Please Select</option>');
		}
	}});
}

function getCollaterals(projectid)
{
	$.ajax({url: "/cmp/property-products/create?get_collateral_list="+projectid, dataType: "json", success: function(result){
		$(".unselected").empty();
		$(".selected").empty();
		if(result.length != 0)
		{
			for(var i=0;i<result.length;i++)
			{
				$(".unselected").append('<option value="'+result[i]['id']+'">'+result[i]['name']+'</option>');
			}
		}
		else
		{
			$(".unselected").empty();
			$(".selected").empty();
		}
	}});
}

function getPermalink(attr)
{
	var response = true;
	
	if(attr.length == 0)
	return response;
	
	$.ajax({url: "/cmp/<?= Yii::$app->controller->id ?>/create?title="+attr<?php echo !empty($model->id)?'+"&id='.$model->id.'"':''; ?>, async: false, dataType: "json", success: function(result){
		//alert(result);
		$("#<?= str_replace('-','',Yii::$app->controller->id) ?>-permalink").val(result);
	}});
}

function checkPermalink(attr)
{
	var response = true;
	
	if(attr.length == 0)
	return response;
	
	$.ajax({url: "/cmp/<?= Yii::$app->controller->id ?>/create?permalink="+attr<?php echo !empty($model->id)?'+"&id='.$model->id.'"':''; ?>, async: false, dataType: "json", success: function(result){
		//alert(JSON.stringify(result));
		if(result == false)
		{
			setTimeout(function() {
				$(".field-<?= str_replace('-','',Yii::$app->controller->id) ?>-permalink").removeClass("has-success");
				$(".field-<?= str_replace('-','',Yii::$app->controller->id) ?>-permalink").addClass("has-error");
				$(".field-<?= str_replace('-','',Yii::$app->controller->id) ?>-permalink .help-block").html("Permalink is already exist.");
			},250);
			response = false;
		}
		else
		{
			response = true;
		}
	}});
	
	return response;
}

$(document).ready(function(e) {
	$("#propertyproducts-project_id").change(function() {
		getProjectProducts(this.value);
		getCollaterals(this.value);
	});
	
	<?php
	if(count($projectList)==1)
	{
		?>
		getProjectProducts(<?php echo $projectList[0]['id'] ?>);
		getCollaterals(<?php echo $projectList[0]['id'] ?>);
		<?php
	}
	?>
	
	$("form").submit(function(e) {
		var error = '';
		if(error.length == 0 && $("#<?= str_replace('-','',Yii::$app->controller->id) ?>-permalink").val().length != 0)
		{
			if(!checkPermalink($("#<?= str_replace('-','',Yii::$app->controller->id) ?>-permalink").val()))
			error = 1;
		}
		if(error.length != 0)
		e.preventDefault();
	});
	
    $("#<?= str_replace('-','',Yii::$app->controller->id) ?>-title").blur(function(e)
	{
		if($("#<?= str_replace('-','',Yii::$app->controller->id) ?>-permalink").val()=='')
		getPermalink(this.value);
    });
	
    $("#<?= str_replace('-','',Yii::$app->controller->id) ?>-permalink").blur(function(e)
	{
		var permalink = this.value.toLowerCase();
		permalink = permalink.toLowerCase();
		permalink = permalink.replace(/[^a-z0-9\s]/gi, ' ');
		permalink = permalink.replace( /\s\s+/g, ' ' );
		permalink = permalink.trim();
		permalink = permalink.replace(/ /g,"-");
		$("#<?= str_replace('-','',Yii::$app->controller->id) ?>-permalink").val(permalink);
		checkPermalink(permalink);
    });
});
</script>




