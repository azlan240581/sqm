<?php
function httpRequest($url,$data,$method)
{
	$ch = curl_init();
	
	if($method=='GET')
	{
		curl_setopt($ch, CURLOPT_URL, $url . '?' . $data); 
	}
	elseif($method=='POST')
	{
		curl_setopt($ch, CURLOPT_URL, $url); 
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_HTTPHEADER,array('Content-type: multipart/form-data;charset=UTF-8','Accept: text/html'));
	}
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_TIMEOUT, '60');
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION ,1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,false);
	//curl_setopt($ch, CURLOPT_PORT,80);
	
	$content = curl_exec($ch);
	
	if(strlen(curl_error($ch)))
	$content = curl_error($ch);
	
	return $content;
}

if(count($_POST)!=0)
{
	//initialize
	$error = '';
	$tmpurl = (isset($_SERVER['HTTPS'])?'https':'http').'://'.$_SERVER['HTTP_HOST'].'/cmp/server/api/member-redeem-rewards';
	$fields['uuid'] = $_POST['uuid'];
	$fields['debug_mode'] = $_POST['debug_mode'];
	$fields['rewardIDList'] = implode(',',$_POST['rewardIDList']);
	$fields['firstname'] = $_POST['firstname'];
	$fields['lastname'] = $_POST['lastname'];
	$fields['email'] = $_POST['email'];
	$fields['country_code'] = $_POST['country_code'];
	$fields['contact_number'] = $_POST['contact_number'];
	$fields['address_1'] = $_POST['address_1'];
	$fields['address_2'] = $_POST['address_2'];
	$fields['address_3'] = $_POST['address_3'];
	$fields['city'] = $_POST['city'];
	$fields['postcode'] = $_POST['postcode'];
	$fields['state'] = $_POST['state'];
	$fields['country_id'] = $_POST['country_id'];
	
	if(!strlen($error))
	$response = json_decode(httpRequest($tmpurl,$fields,'POST'));
}

$rewards = json_decode(httpRequest((isset($_SERVER['HTTPS'])?'https':'http').'://'.$_SERVER['HTTP_HOST'].'/cmp/server/api/member-get-rewards-list',array('uuid'=>'7D61C3EF-4588-2C38-2CDD-EA4B7B98116C'),'POST'));
$rewards = $rewards->rewards;

$countries = json_decode(httpRequest((isset($_SERVER['HTTPS'])?'https':'http').'://'.$_SERVER['HTTP_HOST'].'/cmp/server/api/lookup-country-list',array('site_password'=>'sqm@H$3pqp'),'POST'));
$countries = $countries->data;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.js"></script>
<title>Member Get Rewards List</title>
</head>

<body>
<div class="container">
<h2>Member Redeem Rewards</h2>
<p>Redeem rewards.</p>
<p><strong>URL : <?= (isset($_SERVER['HTTPS'])?'https':'http').'://'.$_SERVER['HTTP_HOST'].'/cmp/server/api/member-redeem-rewards' ?></strong></p>

<form id="test" name="test" method="post" enctype="multipart/form-data">
<input type="hidden" name="debug_mode" value="true" />

<br />

<div class="form-group">
<label for="uuid">UUID:</label>
<input type="text" class="form-control" id="uuid" name="uuid">
</div>

<br />
<br />

<div class="form-group">
<label for="rewardIDList">Reward :</label>
<select class="form-control" id="rewardIDList" name="rewardIDList[]" multiple="multiple">
<?php
foreach($rewards as $reward)
{
?>
<option value="<?= $reward->id ?>"><?= $reward->name ?></option>
<?php
}
?>
</select>
</div>

<div class="form-group">
<label for="firstname">First name :</label>
<input type="text" class="form-control" id="firstname" name="firstname">
</div>

<div class="form-group">
<label for="lastname">Last name :</label>
<input type="text" class="form-control" id="lastname" name="lastname">
</div>

<div class="form-group">
<label for="email">Email :</label>
<input type="text" class="form-control" id="email" name="email">
</div>

<div class="form-group">
<label for="country_code">Contact No:</label>
<div class="row">
<div class="col-xs-4">
<select class="form-control" id="country_code" name="country_code">
<option value="62">+62</option>
<option value="60">+60</option>
<option value="65">+65</option>
</select>
</div>
<div class="col-xs-8">
<input type="text" class="form-control" id="contact_number" name="contact_number">
</div>
</div>
</div>

<div class="form-group">
<label for="address_1">Address 1 :</label>
<input type="text" class="form-control" id="address_1" name="address_1">
</div>

<div class="form-group">
<label for="address_2">Address 2 :</label>
<input type="text" class="form-control" id="address_2" name="address_2">
</div>

<div class="form-group">
<label for="address_3">Address 3 :</label>
<input type="text" class="form-control" id="address_3" name="address_3">
</div>

<div class="form-group">
<label for="city">City :</label>
<input type="text" class="form-control" id="city" name="city">
</div>

<div class="form-group">
<label for="postcode">Postcode :</label>
<input type="text" class="form-control" id="postcode" name="postcode">
</div>

<div class="form-group">
<label for="state">State :</label>
<input type="text" class="form-control" id="state" name="state">
</div>

<div class="form-group">
<label for="country_id">Country :</label>
<select class="form-control" id="country_id" name="country_id">
<option value=""></option>
<?php
foreach($countries as $country)
{
?>
<option value="<?= $country->id ?>"><?= $country->name ?></option>
<?php
}
?>
</select>
</div>

<br />
<br />

<div class="form-group">
<button type="submit" class="btn btn-primary">Process</button>
</div>

</form>
</div>

<script>
$('.datepicker').datepicker({
    format: 'yyyy-mm-dd',
});
</script>
</body>
</html>
