<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use yii\base\ErrorException;
use kartik\number\NumberControl;

/*** initialize ***/
$data = array();
$data['error'] = '';
$request = array();
$request['server'] = json_encode($_SERVER);
$request['get'] = json_encode($_GET);
$request['post'] = json_encode($_POST);
$inputs = array();

//validate
if(!strlen($data['error']) and empty($_REQUEST['site_password']))
$data['error'] = '0001-Invalid request';
else
{
	if($_REQUEST['site_password'] != $_SESSION['settings']['SITE_PASSWORD'])
	$data['error'] = '0002-Invalid request';
}

if(!empty($data['error']))
echo $data['error'];
else
{
?>
<style>
.help-block {
	font-size:12px;
}
</style>
<div class="container">
    <h2>Loan Basics</h2>
    <form name="process" action="" onSubmit="return false;">
    <table class="table table-hover">
        <tbody>
        <tr>
            <td>Property Value:</td>
            <td>
            <div class="product_unit_price">
            <div class="input-group">
            <span class="input-group-addon">Rp</span>
            <?= NumberControl::widget([
                    'name' => 'product_unit_price',
                    'options' => ['type' => 'hidden'],
					'maskedInputOptions' => [
						'allowMinus' => false,
						'rightAlign' => false,
					],
                ]);
            ?>
            </div>
            <span class="help-block hidden"></span>
            </div>
            </td>
        </tr>
        <tr>
            <td>Down Payment (%):</td>
            <td>
            <div class="down_payment_percent">
            <div class="input-group ">
            <span class="input-group-addon">%</span>
            <input id="down_payment_percent" name="down_payment_percent" class="form-control" type="text" min="1" value="10" pattern="^((?:[1-9]|[1-9][0-9])|(?:[1-9]|[1-9][0-9])(\.\d+)|100)$" oninvalid="setCustomValidity('Please enter a valid value. The valid values must be greater than 1 and below 100')" onchange="try{setCustomValidity('')}catch(e){}">
            </div>
            <span class="help-block hidden"></span>
            </div>
            </td>
        </tr>
        <tr>
            <td>Down Payment (Rp):</td>
            <td>
            <div class="down_payment_amount">
            <div class="input-group">
            <span class="input-group-addon">Rp</span>
            <?= NumberControl::widget([
                    'name' => 'down_payment_amount',
                    'options' => ['type' => 'hidden'],
					'displayOptions' => ['readonly'=>true],
					'maskedInputOptions' => [
						'allowMinus' => false,
						'rightAlign' => false,
					],
                ]);
            ?>
            </div>
            <span class="help-block hidden"></span>
            </div>
            </td>
        </tr>
        <tr>
            <td>Principal:</td>
            <td>
            <div class="principal">
            <div class="input-group">
            <span class="input-group-addon">Rp</span>
            <?= NumberControl::widget([
                    'name' => 'principal',
                    'options' => ['type' => 'hidden'],
					//'displayOptions' => ['readonly'=>true],
					'maskedInputOptions' => [
						'allowMinus' => false,
						'rightAlign' => false,
					],
                ]);
            ?>
            </div>
            <span class="help-block hidden"></span>
            </div>
            </td>
        </tr>
        <tr>
            <td>Interest Rate:</td>
            <td>
            <div class="interest_percent">
            <div class="input-group">
            <span class="input-group-addon">%</span>
            <input id="interest_percent" name="interest_percent" class="form-control" type="text" min="5" max="20" value="10" pattern="^((?:[5-9]|1[0-9]|20)|(?:[5-9]|1[0-9]|20)(\.\d+))$" oninvalid="setCustomValidity('Please enter a valid value. The valid values is between 5 and 20')" onchange="try{setCustomValidity('')}catch(e){}">
            </div>
            <span class="help-block hidden"></span>
            </div>
            </td>
        </tr>
        <tr>
            <td>Years:</td>
            <td>
            <div class="loan_years">
            <input id="loan_years" name="loan_years" class="form-control" type="number" min="1" max="10">
            <span class="help-block hidden"></span>
            </div>
            </td>
        </tr>
        <tr>
            <td>Monthly Installment:</td>
            <td>
            <div class="monthly_installment">
            <div class="input-group">
            <span class="input-group-addon">Rp</span>
            <?= NumberControl::widget([
                    'name' => 'monthly_installment',
                    'options' => ['type' => 'hidden'],
					'displayOptions' => ['readonly'=>true],
					'maskedInputOptions' => [
						'allowMinus' => false,
						'rightAlign' => false,
					],
                ]);
            ?>
            </div>
            <span class="help-block hidden"></span>
            </div>
            </td>
        </tr>
        <tr><td colspan="2"></td></tr>
        </tbody>
    </table>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12" align="center">
        <button class="btn btn-success calculate">Calculate</button>
        <button class="btn btn-success" type="reset">Reset</button>
        </div>
    </div>
    </form>
</div>
<?php
}
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
//product_unit_price
//down_payment_percent
//down_payment_amount
//principal
//interest_percent
//loan_years
//monthly_installment

function validate()
{
	var error ='';
	var regexDP = /^((?:[1-9]|[1-9][0-9])|(?:[1-9]|[1-9][0-9])(\.\d+)|100)$/; 
	var regexIR = /^((?:[5-9]|1[0-9]|20)|(?:[5-9]|1[0-9]|20)(\.\d+))$/; 
	
	if(!regexDP.test($("[name='down_payment_percent']").val()))
	{
		error = 'Please enter a valid value. The valid values must be greater than 1 and below 100';
		$(".down_payment_percent").removeClass("has-success");
		$(".down_payment_percent").addClass("has-error");
		$(".down_payment_percent .help-block").html(error);
		$(".down_payment_percent .help-block").removeClass('hidden');
		$(".down_payment_percent").focus();
	}
	else
	{
		$(".down_payment_percent").removeClass("has-error");
		$(".down_payment_percent").addClass("has-success");
		$(".down_payment_percent .help-block").html('');
		$(".down_payment_percent .help-block").addClass('hidden');
	}

	if(!regexIR.test($("[name='interest_percent']").val()))
	{
		error = 'Please enter a valid value. The valid values is between 5 and 20';
		$(".interest_percent").removeClass("has-success");
		$(".interest_percent").addClass("has-error");
		$(".interest_percent .help-block").html(error);
		$(".interest_percent .help-block").removeClass('hidden');
		$(".interest_percent").focus();
	}
	else
	{
		$(".interest_percent").removeClass("has-error");
		$(".interest_percent").addClass("has-success");
		$(".interest_percent .help-block").html('');
		$(".interest_percent .help-block").addClass('hidden');
	}
	
	if(error.length==0)
	return true;
	else
	return false;
}

$(document).ready(function(){
	$(document).on("change", "#w0-disp,input[name='down_payment_percent'],input[name='interest_percent']",function(){
		setTimeout(function(){
			if(validate())
			{
				if($("[name='product_unit_price']").val()!='' && $("[name='down_payment_percent']").val()!='')
				{
					$("#w1-disp").val($("[name='product_unit_price']").val() * $("[name='down_payment_percent']").val() / 100);
					$("#w1-disp").trigger("blur");
					
					$("#w2-disp").val($("[name='product_unit_price']").val() - $("[name='down_payment_amount']").val());
					$("#w2-disp").trigger("blur");
				}
			}
		}, 100);
	});

	/*$(document).on("blur", "#w1-disp",function(){
		setTimeout(function(){
			if($("[name='product_unit_price']").val()!='' && $("[name='down_payment_amount']").val()!='')
			{
				$("[name='down_payment_percent']").val($("[name='down_payment_amount']").val() / $("[name='product_unit_price']").val() * 100);
			}
		}, 100);
	});*/

	$(document).on("change", "#w2-disp",function(){
		setTimeout(function(){
			if(validate())
			{
				if($("[name='down_payment_percent']").val()!='')
				{
					$("#w0-disp").val($("[name='principal']").val() / (1-($("[name='down_payment_percent']").val() / 100)));
					$("#w0-disp").trigger("blur");
	
					$("#w1-disp").val($("[name='product_unit_price']").val() * $("[name='down_payment_percent']").val() / 100);
					$("#w1-disp").trigger("blur");
				}
			}
		}, 100);
	});
	
	$(document).on("click", ".calculate",function(){
		setTimeout(function(){
			
			var error = '';
			
			if($("#w0-disp").val()=='')
			{
				error = 'Please insert Property Value';
				$(".product_unit_price").removeClass("has-success");
				$(".product_unit_price").addClass("has-error");
				$(".product_unit_price .help-block").html(error);
				$(".product_unit_price .help-block").removeClass('hidden');
				$(".product_unit_price").focus();
			}
			else
			{
				$(".product_unit_price").removeClass("has-error");
				$(".product_unit_price").addClass("has-success");
				$(".product_unit_price .help-block").html('');
				$(".product_unit_price .help-block").addClass('hidden');
			}

			if($("#down_payment_percent").val()=='')
			{
				error = 'Please insert Down Payment (%)';
				$(".down_payment_percent").removeClass("has-success");
				$(".down_payment_percent").addClass("has-error");
				$(".down_payment_percent .help-block").html(error);
				$(".down_payment_percent .help-block").removeClass('hidden');
				$(".down_payment_percent").focus();
			}
			else
			{
				$(".down_payment_percent").removeClass("has-error");
				$(".down_payment_percent").addClass("has-success");
				$(".down_payment_percent .help-block").html('');
				$(".down_payment_percent .help-block").addClass('hidden');
			}

			if($("#interest_percent").val()=='')
			{
				error = 'Please insert Interest Rate';
				$(".interest_percent").removeClass("has-success");
				$(".interest_percent").addClass("has-error");
				$(".interest_percent .help-block").html(error);
				$(".interest_percent .help-block").removeClass('hidden');
				$(".interest_percent").focus();
			}
			else
			{
				$(".interest_percent").removeClass("has-error");
				$(".interest_percent").addClass("has-success");
				$(".interest_percent .help-block").html('');
				$(".interest_percent .help-block").addClass('hidden');
			}


			if($("#loan_years").val()=='')
			{
				error = 'Please insert Years';
				$(".loan_years").removeClass("has-success");
				$(".loan_years").addClass("has-error");
				$(".loan_years .help-block").html(error);
				$(".loan_years .help-block").removeClass('hidden');
				$(".loan_years").focus();
			}
			else
			{
				$(".loan_years").removeClass("has-error");
				$(".loan_years").addClass("has-success");
				$(".loan_years .help-block").html('');
				$(".loan_years .help-block").addClass('hidden');
			}
			
			if(error.length == 0)
			{
				$("#w3-disp").val($("[name='principal']").val()*((($("[name='interest_percent']").val()/100/12)*((1+($("[name='interest_percent']").val()/100/12))**($("[name='loan_years']").val()*12)))/(((1+($("[name='interest_percent']").val()/100/12))**($("[name='loan_years']").val()*12))-1)))
				$("#w3-disp").trigger("blur");
			}
			
		}, 100);
	});
});
</script>