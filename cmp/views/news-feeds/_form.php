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

/* @var $this yii\web\View */
/* @var $model app\models\NewsFeeds */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="news-feeds-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    
    <div style="clear:both;"><br /></div>
    <div class="panel panel-default">
        <div class="panel-heading"><strong>News Feed Details</strong></div>
        <div class="panel-body">

		<?php
        echo $form->field($model, 'category_id')->dropDownList(
                ArrayHelper::map($lookupNewsFeedCategoryList, 'id', 'name'),['prompt' => 'Please select','disabled'=>($_SESSION['user']['action']=='create'?FALSE:TRUE)]
        )->label('Category');
        ?>
    
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
        ])->label($model->getAttributeLabel('file').' <span style="font-weight:normal;">(Max Size:10MB; File Format:png,jpg,jpeg; Width:'.$_SESSION['settings']['NEWS_FEED_MEDIA_THUMB_IMAGE_WIDTH'].'px * Height:'.$_SESSION['settings']['NEWS_FEED_MEDIA_THUMB_IMAGE_HEIGHT'].'px)</span>');
        ?>
    
        <?php
        echo $form->field($model, 'product_id')->dropDownList(
                ArrayHelper::map($propertyProductList, 'id', 'name'),['prompt' => 'Please select']
        )->label('Product');
        ?>
            
        
        <div class="form-group field-newsfeeds-promotion_date_range" style="display: block;">
            <label class="control-label" for="newsfeeds-promotion_date_range">Promotion Period</label>
			<?=
            DateRangePicker::widget([
                'model'=>$model,
                'attribute'=>'promotion_date_range',
                'convertFormat'=>true,
                'readonly'=>true,
                'pluginOptions'=>[
                    'locale'=>[
                        'format'=>'Y-m-d H:i:s',
                        'cancelLabel' => 'Clear',
                    ],
                ],
                'options' => [
                    'class' => 'form-control',
                ],
                'pluginEvents' => [
                            'apply.daterangepicker' => 'function(ev, picker) {
                                    if($(this).val() == "") {
                                        $(this).val(picker.startDate.format(picker.locale.format) + picker.locale.separator +
                                        picker.endDate.format(picker.locale.format)).trigger("change");
                                    }
                                }',
                                'show.daterangepicker' => 'function(ev, picker) {
                                    picker.container.find(".ranges").off("mouseenter.daterangepicker", "li");
                                        if($(this).val() == "") {
                                        picker.container.find(".ranges .active").removeClass("active");
                                    }
                                }',
                                'cancel.daterangepicker' => 'function(ev, picker) {
                                    if($(this).val() != "") {
                                        $(this).val("").trigger("change");
                                    }
                                }'
                ],
            ])	
            ?>
            <div class="help-block"></div>
        </div>        
        
        <?php /*?>
        <?= $form->field($model, 'promotion_start_date')->widget(\yii\jui\DatePicker::classname(), [
            'dateFormat' => 'yyyy-MM-dd',
            'options' => ['class' => 'form-control',],
            ])
        ?>
    
        <?= $form->field($model, 'promotion_end_date')->widget(\yii\jui\DatePicker::classname(), [
            'dateFormat' => 'yyyy-MM-dd',
            'options' => ['class' => 'form-control',],
            ])
        ?>
        <?php */?>
        
        <?= $form->field($model, 'promotion_terms_conditions')->widget(TinyMce::className(), [
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
    
        <?= $form->field($model, 'event_at')->widget(DateTimePicker::classname(), [
            'options' => [
                'placeholder' => 'Select event date and time ...',
                'class' => 'form-control',
                'readonly' => true,
            ],
            'convertFormat' => true,
            'pluginOptions' => [
                'autoclose' => true,
                'format' => 'yyyy-MM-dd H:i',
                'startDate' => date('Y-m-d H:i',time()),
                'todayHighlight' => true
            ]
        ]);?>
    
        <?= $form->field($model, 'event_location')->textarea(['rows' => 6]) ?>
    
        <?= $form->field($model, 'event_location_longitude')->textInput(['maxlength' => true]) ?>
    
        <?= $form->field($model, 'event_location_latitude')->textInput(['maxlength' => true]) ?>
    
        <?php /*?><label class="control-label">Collaterals</label>
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
    
        <div style="clear:both;"><br /></div><?php */?>
    
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
			<div class="panel-heading"><strong>News Feed Media</strong></div>
			<div class="panel-body">
    
            <?php
            echo $form->field($modelNewsFeedMedias, 'file')->widget(FileInput::classname(), [
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
                            (($modelNewsFeedMedias->thumb_image) ? Html::img($modelNewsFeedMedias->thumb_image, ['width'=>200]) : NULL), // checks the models to display the preview
                        ],
                    ],
            ])->label('Thumb Image <span style="font-weight:normal;">(Max Size:10MB; File Format:png,jpg,jpeg; Width:'.$_SESSION['settings']['NEWS_FEED_MEDIA_THUMB_IMAGE_WIDTH'].'px * Height:'.$_SESSION['settings']['NEWS_FEED_MEDIA_THUMB_IMAGE_HEIGHT'].'px)</span>');
            ?>
        
            <?= $form->field($modelNewsFeedMedias, 'media_title')->textInput(['maxlength' => true]) ?>
        
            <?php
            echo $form->field($modelNewsFeedMedias, 'image')->widget(FileInput::classname(), [
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
                            (($modelNewsFeedMedias->media_value) ? Html::img($modelNewsFeedMedias->media_value, ['width'=>200]) : NULL), // checks the models to display the preview
                        ],
                    ],
            ])->label('Image <span style="font-weight:normal;">(Max Size:10MB; File Format:png,jpg,jpeg; Width:800px * Height:600px)</span>');
            ?>
                
            <?= $form->field($modelNewsFeedMedias, 'sort')->textInput(['type' => 'number', 'min'=>0]) ?>
        
            <?php //echo $form->field($modelNewsFeedMedias, 'published')->radioList([1 => 'Yes', 0 => 'No'],['itemOptions' => ['labelOptions' => ['class' => 'col-md-1']]]) ?>    
        
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
function getCollaterals(projectid)
{
	$.ajax({url: "/cmp/news-feeds/create?get_collateral_list="+projectid, dataType: "json", success: function(result){
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

function getPropertyProducts(projectid)
{
	$.ajax({url: "/cmp/news-feeds/create?get_property_product_list="+projectid, dataType: "json", success: function(result){
		$("#newsfeeds-product_id").empty();
		$("#newsfeeds-product_id").attr("aria-invalid","true");
		$("#newsfeeds-product_id").append('<option value="">Please select</option>');
		if(result.length != 0)
		{
			for(var i=0;i<result.length;i++)
			{
				$("#newsfeeds-product_id").append('<option value="'+result[i]['id']+'">'+result[i]['name']+'</option>');
			}
		}
		else
		{
			$("#newsfeeds-product_id").append('<option value="">Please Select</option>');
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
	//promotion field
	$(".field-newsfeeds-product_id").hide();
	$("#newsfeeds-product_id").prop('disabled',true);
	$(".field-newsfeeds-promotion_date_range").hide();
	$("#newsfeeds-promotion_date_range").prop('disabled',true);
	//$(".field-newsfeeds-promotion_start_date").hide();
	//$("#newsfeeds-promotion_start_date").prop('disabled',true);
	//$(".field-newsfeeds-promotion_end_date").hide();
	//$("#newsfeeds-promotion_end_date").prop('disabled',true);
	$(".field-newsfeeds-promotion_terms_conditions").hide();
	$("#newsfeeds-promotion_terms_conditions").prop('disabled',true);
	//event field
	$(".field-newsfeeds-event_at").hide();
	$("#newsfeeds-event_at").prop('disabled',true);
	$(".field-newsfeeds-event_location").hide();
	$("#newsfeeds-event_location").prop('disabled',true);
	$(".field-newsfeeds-event_location_longitude").hide();
	$("#newsfeeds-event_location_longitude").prop('disabled',true);
	$(".field-newsfeeds-event_location_latitude").hide();
	$("#newsfeeds-event_location_latitude").prop('disabled',true);
	
	$("#newsfeeds-category_id").change(function() {
		if(this.value==2)
		{
			//promotion field
			$(".field-newsfeeds-product_id").show();
			$("#newsfeeds-product_id").prop('disabled',false);
			$(".field-newsfeeds-promotion_date_range").show();
			$("#newsfeeds-promotion_date_range").prop('disabled',false);
			//$(".field-newsfeeds-promotion_start_date").show();
			//$("#newsfeeds-promotion_start_date").prop('disabled',false);
			//$(".field-newsfeeds-promotion_end_date").show();
			//$("#newsfeeds-promotion_end_date").prop('disabled',false);
			$(".field-newsfeeds-promotion_terms_conditions").show();
			$("#newsfeeds-promotion_terms_conditions").prop('disabled',false);
			//event field
			$(".field-newsfeeds-event_at").hide();
			$("#newsfeeds-event_at").prop('disabled',true);
			$(".field-newsfeeds-event_location").hide();
			$("#newsfeeds-event_location").prop('disabled',true);
			$(".field-newsfeeds-event_location_longitude").hide();
			$("#newsfeeds-event_location_longitude").prop('disabled',true);
			$(".field-newsfeeds-event_location_latitude").hide();
			$("#newsfeeds-event_location_latitude").prop('disabled',true);
		}
		else if(this.value==3)
		{
			//promotion field
			$(".field-newsfeeds-product_id").hide();
			$("#newsfeeds-product_id").prop('disabled',true);
			$(".field-newsfeeds-promotion_date_range").hide();
			$("#newsfeeds-promotion_date_range").prop('disabled',true);
			//$(".field-newsfeeds-promotion_start_date").hide();
			//$("#newsfeeds-promotion_start_date").prop('disabled',true);
			//$(".field-newsfeeds-promotion_end_date").hide();
			//$("#newsfeeds-promotion_end_date").prop('disabled',true);
			$(".field-newsfeeds-promotion_terms_conditions").hide();
			$("#newsfeeds-promotion_terms_conditions").prop('disabled',true);
			//event field
			$(".field-newsfeeds-event_at").show();
			$("#newsfeeds-event_at").prop('disabled',false);
			$(".field-newsfeeds-event_location").show();
			$("#newsfeeds-event_location").prop('disabled',false);
			$(".field-newsfeeds-event_location_longitude").show();
			$("#newsfeeds-event_location_longitude").prop('disabled',false);
			$(".field-newsfeeds-event_location_latitude").show();
			$("#newsfeeds-event_location_latitude").prop('disabled',false);
		}
		else
		{
			//promotion field
			$(".field-newsfeeds-product_id").hide();
			$("#newsfeeds-product_id").prop('disabled',true);
			$(".field-newsfeeds-promotion_date_range").hide();
			$("#newsfeeds-promotion_date_range").prop('disabled',true);
			//$(".field-newsfeeds-promotion_start_date").hide();
			//$("#newsfeeds-promotion_start_date").prop('disabled',true);
			//$(".field-newsfeeds-promotion_end_date").hide();
			//$("#newsfeeds-promotion_end_date").prop('disabled',true);
			$(".field-newsfeeds-promotion_terms_conditions").hide();
			$("#newsfeeds-promotion_terms_conditions").prop('disabled',true);
			//event field
			$(".field-newsfeeds-event_at").hide();
			$("#newsfeeds-event_at").prop('disabled',true);
			$(".field-newsfeeds-event_location").hide();
			$("#newsfeeds-event_location").prop('disabled',true);
			$(".field-newsfeeds-event_location_longitude").hide();
			$("#newsfeeds-event_location_longitude").prop('disabled',true);
			$(".field-newsfeeds-event_location_latitude").hide();
			$("#newsfeeds-event_location_latitude").prop('disabled',true);
		}
	});

	$("#newsfeeds-project_id").change(function() {
		getCollaterals(this.value);
		getPropertyProducts(this.value);
	});	
	
	<?php
	if(count($projectList)==1)
	{
		?>
		getCollaterals(<?php echo $projectList[0]['id'] ?>);
		<?php
	}
	?>
	
	<?php
	if($model->category_id != NULL)
	{
		if($model->category_id==2)
		{
			?>
			//promotion field
			$(".field-newsfeeds-product_id").show();
			$("#newsfeeds-product_id").prop('disabled',false);
			$(".field-newsfeeds-promotion_date_range").show();
			$("#newsfeeds-promotion_date_range").prop('disabled',false);
			//$(".field-newsfeeds-promotion_start_date").show();
			//$("#newsfeeds-promotion_start_date").prop('disabled',false);
			//$(".field-newsfeeds-promotion_end_date").show();
			//$("#newsfeeds-promotion_end_date").prop('disabled',false);
			$(".field-newsfeeds-promotion_terms_conditions").show();
			$("#newsfeeds-promotion_terms_conditions").prop('disabled',false);
			<?php
		}
		elseif($model->category_id==3)
		{
			?>
			//event field
			$(".field-newsfeeds-event_at").show();
			$("#newsfeeds-event_at").prop('disabled',false);
			$(".field-newsfeeds-event_location").show();
			$("#newsfeeds-event_location").prop('disabled',false);
			$(".field-newsfeeds-event_location_longitude").show();
			$("#newsfeeds-event_location_longitude").prop('disabled',false);
			$(".field-newsfeeds-event_location_latitude").show();
			$("#newsfeeds-event_location_latitude").prop('disabled',false);
			<?php
		}
		else
		{
			?>
			//promotion field
			$(".field-newsfeeds-product_id").hide();
			$("#newsfeeds-product_id").prop('disabled',true);
			$(".field-newsfeeds-promotion_date_range").hide();
			$("#newsfeeds-promotion_date_range").prop('disabled',true);
			//$(".field-newsfeeds-promotion_start_date").hide();
			//$("#newsfeeds-promotion_start_date").prop('disabled',true);
			//$(".field-newsfeeds-promotion_end_date").hide();
			//$("#newsfeeds-promotion_end_date").prop('disabled',true);
			$(".field-newsfeeds-promotion_terms_conditions").hide();
			$("#newsfeeds-promotion_terms_conditions").prop('disabled',true);
			//event field
			$(".field-newsfeeds-event_at").hide();
			$("#newsfeeds-event_at").prop('disabled',true);
			$(".field-newsfeeds-event_location").hide();
			$("#newsfeeds-event_location").prop('disabled',true);
			$(".field-newsfeeds-event_location_longitude").hide();
			$("#newsfeeds-event_location_longitude").prop('disabled',true);
			$(".field-newsfeeds-event_location_latitude").hide();
			$("#newsfeeds-event_location_latitude").prop('disabled',true);
			<?php
		}
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




