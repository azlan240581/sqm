<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UserAssociateDetails */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-associate-details-form">

    <?php $form = ActiveForm::begin(['options' =>['onsubmit'=>'return validateForm()']]); ?>
    
    <?php
	if($_SESSION['user']['groups']!=NULL and array_intersect(array(7,8,9,10),$_SESSION['user']['groups']))
	{
		?>
        <input type="hidden" class="form-control" id="associate-upline" name="Associate[upline]" value="<?php echo isset($_SESSION['invite_associate']['upline'])?$_SESSION['invite_associate']['upline']:$_SESSION['user']['id'] ?>">
        <?php
	}
	else
	{
		?>
        <div class="form-group field-associate-upline">
            <label class="control-label" for="associate-name">Upline</label>
            <select class="form-control" id="associate-upline" name="Associate[upline]" required oninvalid="validate(this);" oninput="validate(this);">
                <option value="">Please Select</option>
                <?php
                foreach($agentList as $agent)
                {
                    ?>
                    <option value="<?php echo $agent['id'] ?>" <?php echo isset($_SESSION['invite_associate']['upline'])?($_SESSION['invite_associate']['upline']==$agent['id']?'selected="selected"':''):'' ?>><?php echo $agent['name'] ?></option>
                    <?php
                }
                ?>
            </select>
            <div class="help-block"></div>
        </div>
        <?php
	}
	?>
    
    <div class="form-group field-associate-firstname">
        <label class="control-label" for="associate-firstname">First Name</label>
        <input type="text" class="form-control" id="associate-firstname" name="Associate[firstname]" value="<?php echo isset($_SESSION['invite_associate']['firstname'])?$_SESSION['invite_associate']['firstname']:'' ?>" required oninvalid="validate(this);" oninput="validate(this);">
        <div class="help-block"></div>
    </div>
        
    <div class="form-group field-associate-lastname">
        <label class="control-label" for="associate-lastname">Last Name</label>
        <input type="text" class="form-control" id="associate-lastname" name="Associate[lastname]" value="<?php echo isset($_SESSION['invite_associate']['lastname'])?$_SESSION['invite_associate']['lastname']:'' ?>" required oninvalid="validate(this);" oninput="validate(this);">
        <div class="help-block"></div>
    </div>
        
    <div class="form-group field-associate-email">
        <label class="control-label" for="associate-email">Email</label>
        <input type="text" class="form-control" id="associate-email" name="Associate[email]" value="<?php echo isset($_SESSION['invite_associate']['email'])?$_SESSION['invite_associate']['email']:'' ?>" required oninvalid="validate(this);" oninput="validate(this);">
        <div class="help-block"></div>
    </div>
    
    <div class="row">
        <div class="col-md-4">
            <div class="form-group field-associate-country_code">
                <label class="control-label" for="associate-country_code">Country Code</label>
                <select class="form-control" id="associate-country_code" name="Associate[country_code]" required oninvalid="validate(this);" oninput="validate(this);">
                <option value="">Please Select</option>
                <?php
				foreach($countryCodeList as $value)
				{
					?>
					<option value="<?= $value['value'] ?>" <?php echo isset($_SESSION['invite_associate']['country_code'])?($_SESSION['invite_associate']['country_code']==$value['value']?'selected="selected"':''):'' ?>><?= $value['name'] ?></option>;
					<?php
                }
				?>
                </select>
                <div class="help-block"></div>
            </div>
        </div>
    
        <div class="col-md-8">
            <div class="form-group field-associate-contact_no">
                <label class="control-label" for="associate-contact_no">Contact Number</label>
                <input type="text" class="form-control" id="associate-contact_no" name="Associate[contact_no]" value="<?php echo isset($_SESSION['invite_associate']['contact_no'])?$_SESSION['invite_associate']['contact_no']:'' ?>" required oninvalid="validate(this);" oninput="validate(this);">
                <div class="help-block"></div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Send Invitation', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

<script>
function validateForm()
{
	var error = false;
	
	if($("#associate-upline").val()=='')
	{
		error = true;
		$(".field-associate-upline").addClass("has-error");
		$(".field-associate-upline .help-block").html('Please select associate upline');
	}
	else
	{
		$(".field-associate-upline").removeClass("has-error");
		$(".field-associate-upline .help-block").html('');
	}
	
	if($("#associate-firstname").val()=='')
	{
		error = true;
		$(".field-associate-firstname").addClass("has-error");
		$(".field-associate-firstname .help-block").html('Please provide associate first name');
	}
	else
	{
		$(".field-associate-firstname").removeClass("has-error");
		$(".field-associate-firstname .help-block").html('');
	}
	
	if($("#associate-lastname").val()=='')
	{
		error = true;
		$(".field-associate-lastname").addClass("has-error");
		$(".field-associate-lastname .help-block").html('Please provide associate last name');
	}
	else
	{
		$(".field-associate-lastname").removeClass("has-error");
		$(".field-associate-lastname .help-block").html('');
	}
	
	if($("#associate-email").val()=='')
	{
		error = true;
		$(".field-associate-email").addClass("has-error");
		$(".field-associate-email .help-block").html('Please provide associate email');
	}
	else
	{
		var email = $("#associate-email").val();
		var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
		if (email.match(emailReg))
		{
			$(".field-associate-email").removeClass("has-error");
			$(".field-associate-email .help-block").html('');
		}
		else
		{
			error = true;
			$(".field-associate-email").addClass("has-error");
			$(".field-associate-email .help-block").html('Please provide a valid associate email');
		}
	}
	
	if($("#associate-country_code").val()=='')
	{
		error = true;
		$(".field-associate-country_code").addClass("has-error");
		$(".field-associate-country_code .help-block").html('Please select country code');
	}
	else
	{
		$(".field-associate-country_code").removeClass("has-error");
		$(".field-associate-country_code .help-block").html('');
	}
	
	if($("#associate-contact_no").val()=='')
	{
		error = true;
		$(".field-associate-contact_no").addClass("has-error");
		$(".field-associate-contact_no .help-block").html('Please provide associate contact number');
	}
	else
	{
		var mobile = $("#associate-contact_no").val();
		var mobileReg = /^[0-9]{5,20}$/;
		if (mobile.match(mobileReg))
		{
			$(".field-associate-contact_no").removeClass("has-error");
			$(".field-associate-contact_no .help-block").html('');
		}
		else
		{	
			error = true;
			$(".field-associate-contact_no").addClass("has-error");
			$(".field-associate-contact_no .help-block").html('Please provide a valid associate contact number');
		}		
	}
	
	if(error)
	return false;
	else
	return true;
}

function validate(textbox)
{
	if(textbox.name == 'Associate[upline]')
	{
		if(textbox.value == '')
		{
			$(".field-associate-upline").addClass("has-error");
			$(".field-associate-upline .help-block").html('Please select associate upline');
			textbox.setCustomValidity('Please select associate upline');
		}
		else
		{
			$(".field-associate-upline").removeClass("has-error");
			$(".field-associate-upline .help-block").html('');
			textbox.setCustomValidity('');
		}
	}
	
	if(textbox.name == 'Associate[firstname]')
	{
		if(textbox.value == '')
		{
			$(".field-associate-firstname").addClass("has-error");
			$(".field-associate-firstname .help-block").html('Please provide associate first name');
			textbox.setCustomValidity('Please provide associate first name');
		}
		else
		{
			$(".field-associate-firstname").removeClass("has-error");
			$(".field-associate-firstname .help-block").html('');
			textbox.setCustomValidity('');
		}
	}
	
	if(textbox.name == 'Associate[lastname]')
	{
		if(textbox.value == '')
		{
			$(".field-associate-lastname").addClass("has-error");
			$(".field-associate-lastname .help-block").html('Please provide associate last name');
			textbox.setCustomValidity('Please provide associate last name');
		}
		else
		{
			$(".field-associate-lastname").removeClass("has-error");
			$(".field-associate-lastname .help-block").html('');
			textbox.setCustomValidity('');
		}
	}
	
	if(textbox.name == 'Associate[email]')
	{
		var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
		
		if(textbox.value == '')
		{
			$(".field-associate-email").addClass("has-error");
			$(".field-associate-email .help-block").html('Please provide associate email');
			textbox.setCustomValidity('Please provide associate email');
		}
		else if(textbox.value != '' && emailReg.test(textbox.value)==false)
		{
			$(".field-associate-email").addClass("has-error");
			$(".field-associate-email .help-block").html('Please provide a valid associate email');
			textbox.setCustomValidity('Please provide a valid associate email');
		}
		else
		{
			$(".field-associate-email").removeClass("has-error");
			$(".field-associate-email .help-block").html('');
			textbox.setCustomValidity('');
		}
	}
	
	if(textbox.name == 'Associate[country_code]')
	{
		if(textbox.value == '')
		{
			$(".field-associate-country_code").addClass("has-error");
			$(".field-associate-country_code .help-block").html('Please select country code');
			textbox.setCustomValidity('Please select associate upline');
		}
		else
		{
			$(".field-associate-country_code").removeClass("has-error");
			$(".field-associate-country_code .help-block").html('');
			textbox.setCustomValidity('');
		}
	}
	
	if(textbox.name == 'Associate[contact_no]')
	{
		var regex_mobile = /^[0-9]{5,20}$/;

		if(textbox.value == '')
		{
			$(".field-associate-contact_no").addClass("has-error");
			$(".field-associate-contact_no .help-block").html('Please provide associate contact number');
			textbox.setCustomValidity('Please provide associate contact number');
		}
		else if(textbox.value != '' && regex_mobile.test(textbox.value)==false)
		{
			$(".field-associate-contact_no").addClass("has-error");
			$(".field-associate-contact_no .help-block").html('Please provide a valid associate contact number');
			textbox.setCustomValidity('Please provide a valid associate contact number');
		}
		else
		{
			$(".field-associate-contact_no").removeClass("has-error");
			$(".field-associate-contact_no .help-block").html('');
			textbox.setCustomValidity('');
		}
	}
}
</script>


</div>
